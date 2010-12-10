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
            if(!is_null($this->id))
            {
                // Update regel in bestelling voor bestaande bestellingen
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

                    $this->Bestelregel->save($regel['Bestelregel']);
                }
            }
            else
            {
                $data['Bestelling']['huidige_status'] = 'Bestelling toegevoegd';
                $data['Bestelling']['verzendkosten_excl'] = (empty($data['Bestelling']['verzendkosten_excl']) ? 0 : $data['Bestelling']['verzendkosten_excl']);
            }

            $levermethode = $this->Levermethode->read(null, $data['Bestelling']['levermethode_id']);
            $data['Bestelling']['verzendkosten_btw'] = $data['Bestelling']['verzendkosten_excl'] * ($levermethode['Levermethode']['btw'] / 100);
            if($data['Bestelling']['isBetaald'] == 0)
            {
                $data['Bestelling']['betaaldatum'] = null;
            }
            if($this->save($data) && $this->updateTotaal($this->id))
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

        /**
         * Voegt een nieuw product toe aan een bestelling en update het totaal.
         * Er kan niet een bestaand product worden toegevoegd, ivm mogelijke prijs-
         * afwijkingen. Dit kan via het bewerken van de bestelling zelf.
         *
         * @param integer $bestelling_id
         * @param integer $product_id
         * @return boolean true indien succesvol toegevoegd, false otherwise
         */
        function productToevoegen($bestelling_id, $product_id, $asAjax = false)
        {
            // Controleren of het product al in de bestelling staat
            if(0 < $this->Bestelregel->find('count', array('conditions' => array('Bestelregel.product_id' => $product_id, 'Bestelregel.bestelling_id' => $bestelling_id))))
            {
                if($asAjax)
                {
                    return 'Het gekozen product is al aanwezig in de bestelling.';
                }
                else
                {
                    return false;
                }
            }
            else
            {
                // Data samenstellen
                $product = $this->Bestelregel->Product->read(null, $product_id);
                $data = array('Bestelregel' => array(
                    'bestelling_id' => $bestelling_id,
                    'product_id' => $product_id,
                    'btw_percentage' => $product['Product']['btw'],
                    'aantal' => 1,
                    'prijs_excl' => $product['Product']['prijs'],
                    'btw_bedrag' => $product['Product']['btw_bedrag'],
                    'totaal_excl' => $product['Product']['prijs'],
                    'totaal_btw' => $product['Product']['btw_bedrag'],
                    'totaal_incl' => $product['Product']['prijs'] + $product['Product']['btw_bedrag'],
                ));

                // Opslaan
                $this->Bestelregel->create();
                if($this->Bestelregel->save($data))
                {
                    return $this->updateTotaal($bestelling_id, $asAjax);
                }
                else
                {
                    if($asAjax)
                    {
                        return 'Er is een fout ontstaan bij het opslaan.';
                    }
                    else
                    {
                        return false;
                    }
                }
            }
        }

        /**
         * Herberekent het totaal van de producten op basis van de bestelregels,
         * en verwerkt dit in het eindtotaal van de bestelling.
         *
         * @param integer $bestelling_id
         * @return boolean true indien succesvol, false otherwise
         */
        function updateTotaal($bestelling_id, $asAjax = false)
        {
            $this->id = $bestelling_id;
            $this->contain('Bestelregel');
            $bestelling = $this->read();

            $data['Bestelling'] = array(
                'subtotaal_excl' => 0,
                'subtotaal_btw' => 0,
                'korting_excl' => $bestelling['Bestelling']['korting_excl'],
                'verzendkosten_excl' => $bestelling['Bestelling']['verzendkosten_excl'],
                'verzendkosten_btw' => $bestelling['Bestelling']['verzendkosten_btw'],
                'totaal_excl' => $bestelling['Bestelling']['verzendkosten_excl'],
                'btw_bedrag' => $bestelling['Bestelling']['verzendkosten_btw'],
                'totaal_incl' => $bestelling['Bestelling']['verzendkosten_excl'] + $bestelling['Bestelling']['verzendkosten_btw']
            );

            foreach($bestelling['Bestelregel'] as $regel)
            {
                $data['Bestelling']['subtotaal_excl'] += $regel['totaal_excl'];
                $data['Bestelling']['subtotaal_btw'] += $regel['totaal_btw'];
                $data['Bestelling']['btw_bedrag'] += $regel['totaal_btw'];

                $data['Bestelling']['totaal_excl'] += $regel['totaal_excl'];
                $data['Bestelling']['totaal_incl'] += $regel['totaal_incl'];
            }

            // Korting verwerken
            $ratio = ($data['Bestelling']['subtotaal_excl'] > 0 ? $data['Bestelling']['korting_excl'] / $data['Bestelling']['subtotaal_excl'] : 0);
            $data['Bestelling']['korting_percentage'] = round(100 * $ratio, 2);
            $data['Bestelling']['totaal_excl'] = $data['Bestelling']['totaal_excl'] - $data['Bestelling']['korting_excl'];
            $data['Bestelling']['subtotaal_excl'] = $data['Bestelling']['subtotaal_excl'] - $data['Bestelling']['korting_excl'];

            // BTW korting naar verhouding van btw/subtotaal, dit ivm mogelijk verschillende tarieven in bestelling
            $data['Bestelling']['korting_btw'] = round($data['Bestelling']['subtotaal_btw'] * $ratio, 2);
            $data['Bestelling']['subtotaal_btw'] = round($data['Bestelling']['subtotaal_btw'] - $data['Bestelling']['korting_btw'], 2);
            $data['Bestelling']['korting_incl'] = $data['Bestelling']['korting_excl'] + $data['Bestelling']['korting_btw'];
            $data['Bestelling']['totaal_incl'] = $data['Bestelling']['totaal_incl'] - $data['Bestelling']['korting_incl'];
            $data['Bestelling']['btw_bedrag'] = $data['Bestelling']['btw_bedrag'] - $data['Bestelling']['korting_btw'];

            if($this->save($data))
            {
                if($asAjax)
                {
                    return 'OK';
                }
                else
                {
                    return true;
                }
            }
            else
            {
                if($asAjax)
                {
                    return 'Er is een fout ontstaan bij het bijwerken van het totaal.';
                }
                else
                {
                    return false;
                }
            }
        }
    }
?>