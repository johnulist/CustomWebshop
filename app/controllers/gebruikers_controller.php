<?php
    /**
     * Controller voor producten
     */
    class GebruikersController extends AppController
    {
        var $uses = array();
        var $name = 'Gebruikers';

        function beforeFilter()
        {
            parent::beforeFilter();
            $this->Auth->allow('registreren');
        }

        function inloggen()
        {
            
        }
        
        function profiel()
        {
            $this->params['linkerblokken'][] = 'gebruikersmenu';
        }

        function uitloggen()
        {
            $this->redirect($this->Auth->logout());
        }

        function registreren()
        {
            if(!empty($this->data))
            {
                // Opslaan (incl. validatie)
                $this->hashWachtwoorden();
                $this->Gebruiker->create();
                if($this->Gebruiker->save($this->data))
                {
                    $this->render('geregistreerd');
                }
                else
                {
                    $this->Session->setFlash(__("Er is iets misgegaan bij uw registratie. Controleer het formulier op fouten.", true), 'flash_error');
                }
            }
        }

        function hashWachtwoorden()
        {
            if(!empty($this->data['Gebruiker']['wachtwoord_invoeren']))
            {
                $this->data['Gebruiker']['wachtwoord_invoeren'] = $this->Auth->password($this->data['Gebruiker']['wachtwoord_invoeren']);
                $this->data['Gebruiker']['wachtwoord_herhalen'] = $this->Auth->password($this->data['Gebruiker']['wachtwoord_herhalen']);
            }
        }

        function dashboard()
        {
            $this->params['linkerblokken'][] = 'gebruikersmenu';
        }

        /**
         * Overzichtspagina voor beheerder
         */
        function admin_dashboard()
        {
            $this->loadModel('Bestelling');
            
            $bestellingen = $this->Bestelling->find('all', array(
                'conditions' => array(
                    "Bestelling.besteldatum >= '" . date("Y-m-01") . "'"
                )
            ));
        
            $omzet = 0;
            $graph_betaald = $graph_bestellingen = array_combine(range(1, date("t")), array_fill(0,date("t"),0));
            
            foreach($bestellingen as $bestelling)
            {
                // Aantallen per dag bijhoudeh
                $dag = date("j", strtotime($bestelling['Bestelling']['besteldatum']));

                if($bestelling['Bestelling']['isBetaald'])
                {
                    $graph_betaald[$dag]++;
                }
                
                $omzet += $bestelling['Bestelling']['totaal_incl'];
                $graph_bestellingen[$dag]++;
            }

            $openstaand = $this->Bestelling->find('all', array(
                'conditions' => array(
                    "Bestelling.factuurdatum IS NOT NULL",
                    "Bestelling.isBetaald" => 0
                )
            ));

            $debetsaldo = 0;
            foreach($openstaand as $factuur)
            {
                $debetsaldo += $factuur['Bestelling']['totaal_incl'];
            }
            $openstaand = count($openstaand);

            $this->set(compact('bestellingen','omzet','openstaand','debetsaldo','graph_bestellingen', 'graph_betaald'));
        }

        function admin_ajax_adres($gebruiker_id)
        {
            $this->data = $this->Gebruiker->read(null, $gebruiker_id);
            $this->layout = 'ajax';
        }

        /**
         * Beheer van klanten
         */
        function admin_index()
        {
            $conditions = array();

            // Code
            if(isset($this->data['Filter']['naam']) && !empty($this->data['Filter']['naam']))
            {
                $naam = mysql_escape_string($this->data['Filter']['naam']);
                $conditions[] = "Gebruiker.contactpersoon LIKE '%$naam%'";
                $this->set('naam', $naam);
            }

            if(isset($this->data['Filter']['bedrijf']) && !empty($this->data['Filter']['bedrijf']))
            {
                $bedrijf = mysql_escape_string($this->data['Filter']['bedrijf']);
                $conditions[] = "Gebruiker.bedrijfsnaam LIKE '%$bedrijf%'";
                $this->set('bedrijf', $bedrijf);
            }

            $this->paginate = array(
                'order' => 'Gebruiker.contactpersoon ASC',
                'conditions' => $conditions,
                'limit' => 50
            );

            $this->data = $this->paginate('Gebruiker');
        }

        /**
         * Toont een overzicht van een gebruiker
         *
         * @param integer $gebruiker_id ID van de te tonen gebruiker
         */
        function admin_overzicht($gebruiker_id)
        {

        }

        function admin_bewerken($gebruiker_id = null)
        {
            if(!empty($this->data))
			{
                $this->Gebruiker->create();
                $this->data['Gebruiker']['id'] = $gebruiker_id;

				if($this->Gebruiker->save($this->data))
                {
                    $this->Session->setFlash('De gebruiker is succesvol toegevoegd', 'flash_success');
                    $this->redirect('/admin/gebruikers/');
                }
                else
                {
                    $this->Session->setFlash('Er is een fout opgetreden bij het opslaan', 'flash_error');
                }
            }

            if(!is_null($gebruiker_id))
            {
                $this->Gebruiker->contain(array('Bestelling','Factuur'));
                $this->data = $this->Gebruiker->read(null, $gebruiker_id);
            }
        }
    }
?>
