<?php
    class Bestelling extends AppModel
    {
        var $useTable = 'bestellingen';
        var $belongsTo = array('Gebruiker');
        
        function stuurBevestigingsmail($bestelling_id)
        {
            $this->contain('Gebruiker');
            $data = $this->read(null, $bestelling_id);
            
            // simpele mailing nog
            mail($data['Gebruiker']['emailadres'], "Bevestiging van uw bestelling", "Allerlei data");
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
                    'betaalmethode'         => $winkelwagen['betaling']['methode']['betaalmethode'],
                    'factuuradres'          => $gebruiker['factuuradres'] . ', ' . $gebruiker['f_postcode'] . ', ' . $gebruiker['f_plaats'],
                    'afleveradres'          => $winkelwagen['levering']['adres'] . ', ' . $winkelwagen['levering']['postcode'] . ' ' . $winkelwagen['levering']['plaats'],
                    'aflevermethode'        => $winkelwagen['levering']['methode']['levermethode'],
                    'subtotaal_excl'        => $winkelwagen['totaal'],
                    'korting_excl'          => 0,
                    'verzendkosten_excl'    => $winkelwagen['verzendkosten_excl'],
                    'totaal_excl'           => $winkelwagen['totaal'] + $winkelwagen['verzendkosten_excl'],
                    'btw_bedrag'            => $winkelwagen['btw_totaal'],
                    'totaal_incl'           => $winkelwagen['totaal'] + $winkelwagen['btw_totaal'] + $winkelwagen['verzendkosten_excl']
                )
            );
            
            // Opslaan en terugkoppelen
            if($this->save($data))
            {
                return $this->getLastInsertId();
            }
            else
            {
                return false;
            }
        }
    }
?>