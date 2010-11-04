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
        }

        function inloggen()
        {
            
        }

        function registreren()
        {

        }

        function dashboard()
        {

        }



        /**
         * Beheer van klanten
         */
        function admin_index()
        {
            $this->paginate = array(
                'order' => 'Gebruiker.contactpersoon ASC',
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
            elseif(!is_null($gebruiker_id))
            {
                $this->data = $this->Gebruiker->read(null, $gebruiker_id);
            }
        }
    }
?>
