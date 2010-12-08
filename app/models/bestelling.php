<?php
    class Bestelling extends AppModel
    {
        /* Tabel en relaties */
        var $useTable  = 'bestellingen';
        var $belongsTo = array(
                            'Gebruiker',
                            'Levermethode' => array('foreignKey' => 'levermethode_id'),
                            'Betaalmethode' => array('foreignKey' => 'betaalmethode_id')
                         );

        var $hasMany   = array(
                            'Bestelregel' => array('foreignKey' => 'bestelling_id'),
                            'Bestelstatus' => array('foreignKey' => 'bestelling_id', 'order' => 'Bestelstatus.created ASC')
                         );

        function stuurBevestigingsmail($bestelling_id, $opties = array())
        {
            // Defaults laden via bestelling
            $this->contain('Gebruiker');
            $data = $this->read(null, $bestelling_id);

            // Data invullen, uit parameters en bestelling
            $to      = (isset($opties['Gebruiker']['emailadres']) ? $opties['Gebruiker']['emailadres'] : $data['Gebruiker']['emailadres']);
            $mail    = (isset($opties['Bevestiging']['bericht']) ? $opties['Bevestiging']['bericht']   : "DEFAULT BERICHT");
            $subject = "Bevestiging van uw bestelling met bestelnummer #$bestelling_id";
            $headers = null;
            
            mail($to, $subject, $mail, $headers);
        }

        function afterFind($results, $primary)
        {
            // Itereren over bestellingen indien directe toegang
            if($primary)
            {
                foreach ($results as $key => $val)
                {
                    // Controleren of we een product kunnen vinden
                    if (isset($val['Bestelling']))
                    {
                        if(!is_null($val['Bestelling']['factuurdatum']))
                        {
                            if(!is_null($val['Bestelling']['factuurtermijn']))
                            {
                                $termijn_in_dagen = $val['Bestelling']['factuurtermijn'];
                                $uiterste_betaaldatum = strtotime($val['Bestelling']['factuurdatum']) + (24 * 3600 * $termijn_in_dagen);
                                $results[$key]['Bestelling']['isOverTijd'] = $uiterste_betaaldatum < time();
                            }
                            else
                            {
                                $results[$key]['Bestelling']['isOverTijd'] = false;
                            }
                        }
                        else
                        {
                            $results[$key]['Bestelling']['isOverTijd'] = null;
                        }
                    }
                }
            }

            return $results;
        }

        function factureren($bestelling_id, $factuurnummer, $stuurEmail = true)
        {
            $this->id = $bestelling_id;

            // Status, nummer en factuuradtum instellen
            $data = array(
                'Bestelling' => array(
                    'id' => $bestelling_id,
                    'huidige_status' => 'bestelling gefactureerd',
                    'factuurdatum' => date('Y-m-d'),
                    'factuurnummer' => $factuurnummer
                ),
                'Bestelstatus' => array
                (
                    'status' => 'bestelling gefactureerd',
                    'bestelling_id' => $bestelling_id
                )
            );
            
            if($this->saveAll($data))
            {
                if($stuurEmail)
                {
                    $this->stuurBevestigingsmail($this->id);
                }

                return true;
            }
            else
            {
                return false;
            }
        }

        function saveFromBeheer($data)
        {
            // Totalen opnieuw berekenen obv bestelregels
            $data['Bestelling']['subtotaal_excl'] = 0;
            $data['Bestelling']['subtotaal_btw']  = 0;
            
            // Update regel in bestelling
            foreach($data['Bestelregel'] as $regel)
            {
                // Reset eerdere save
                $this->Bestelregel->create();
                $this->Bestelregel->id = $regel['id'];

                // BTW toepassen
                $regel = array(
                    'Bestelregel' => array
                    (
                        'id' => $regel['id'],
                        'aantal' => $regel['aantal'],
                        'totaal_excl' => $regel['totaal_excl'],
                        'totaal_btw' => ($regel['totaal_excl'] * ($regel['btw_percentage'] / 100)),
                        'totaal_incl' => ($regel['totaal_excl'] * ((100 + $regel['btw_percentage']) / 100)),

                    )
                );

                // Totalen bestelling bijwerken
                $data['Bestelling']['subtotaal_excl'] += $regel['Bestelregel']['totaal_excl'];
                $data['Bestelling']['subtotaal_btw']  += $regel['Bestelregel']['totaal_btw'];

                $this->Bestelregel->save($regel['Bestelregel']);
            }

            // Verzendkosten meerekenen
            $data['Bestelling']['btw_bedrag']  = $data['Bestelling']['subtotaal_btw'] + $data['Bestelling']['verzendkosten_btw'];
            $data['Bestelling']['totaal_excl'] = $data['Bestelling']['subtotaal_excl'] + $data['Bestelling']['verzendkosten_excl'];
            $data['Bestelling']['totaal_incl'] = $data['Bestelling']['totaal_excl'] + $data['Bestelling']['btw_bedrag'];
            
            if($this->save($data))
            {
                // Opslaan status
                $this->Bestelstatus->create();
                $this->Bestelstatus->save(array('Bestelstatus' => array
                (
                    'status' => 'bestelling gewijzigd via beheer',
                    'bestelling_id' => $this->id
                )));

                return true;
            }
            else
            {
                return false;
            }
            
            return true;
        }
        
        /**
         * Slaat een bestelling op op basis van de 
         * inhoud van de winkelwagen.
         *
         * @params array $params   De parameters in de sessie
         * @return mixed           ID van de nieuwe bestelling, of false
         */
        function saveFromWinkelwagen($params)
        {
            // Model resetten
            $this->create();
            
            // Data voorbereiden
            $winkelwagen = $params['winkelwagen'];
            $gebruiker   = $params['gebruiker'];
            
            // Data samenvoegen
            $data = array
            (
                'Bestelling' => array
                (
                    'gebruiker_id'          => $gebruiker['id'],
                    'huidige_status'        => 'bestelling geplaatst',
                    'besteldatum'           => date('Y-m-d'),
                    'betaalmethode_id'      => $winkelwagen['betaling']['methode']['id'],
                    'factuuradres_adres'   => $gebruiker['factuuradres'],
                    'factuuradres_postcode' => $gebruiker['f_postcode'],
                    'factuuradres_plaats'   => $gebruiker['f_plaats'],
                    'afleveradres_adres'   => $winkelwagen['levering']['adres'],
                    'afleveradres_postcode' => $winkelwagen['levering']['postcode'],
                    'afleveradres_plaats'   => $winkelwagen['levering']['plaats'],
                    'levermethode_id'       => $winkelwagen['levering']['methode']['id'],
                    'subtotaal_excl'        => $winkelwagen['totaal'],
                    'subtotaal_btw'         => $winkelwagen['subtotaal_btw'],
                    'korting_excl'          => 0,
                    'verzendkosten_excl'    => $winkelwagen['verzendkosten_excl'],
                    'verzendkosten_btw'     => $winkelwagen['verzendkosten_btw'],
                    'totaal_excl'           => $winkelwagen['totaal'] + $winkelwagen['verzendkosten_excl'],
                    'btw_bedrag'            => $winkelwagen['btw_totaal'],
                    'totaal_incl'           => $winkelwagen['totaal'] + $winkelwagen['btw_totaal'] + $winkelwagen['verzendkosten_excl']
                ),
                'Bestelstatus' => array
                (
                    0 => array(
                        'status'                => 'bestelling geplaatst'
                    )
                )
            );
            
            // Producten als bestelregel toevoegen
            $i = 0;
            foreach($winkelwagen['producten'] as $product_id => $product)
            {
                $data['Bestelregel'][$i] = array
                (
                    'product_id' => $product_id,
                    'btw_percentage' => $product['product']['btw'],
                    'aantal' => $product['aantal'],
                    'prijs_excl' => $product['product']['prijs'],
                    'btw_bedrag' => $product['product']['btw_bedrag'],

                    'totaal_excl' => $product['product']['prijs'] * $product['aantal'],
                    'totaal_btw' => $product['product']['btw_bedrag'] * $product['aantal'],
                    'totaal_incl' => ($product['product']['prijs'] + $product['product']['btw_bedrag']) * $product['aantal']
                );

                $i++;
            }
            
            // Opslaan en terugkoppelen
            if($this->saveAll($data))
            {
                return $this->id;
            }
            else
            {
                return false;
            }
        }
    }
?>