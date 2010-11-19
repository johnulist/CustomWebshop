<?php
    /**
     * Controller voor producten
     */
    class BestellingenController extends AppController
    {
        var $uses = array('Bestelling');
        var $name = 'Bestellingen';

        function beforeFilter()
        {
            parent::beforeFilter();
        }

        function admin_index()
        {
            $this->data = $this->Bestelling->find('all', array(
                'order' => 'Bestelling.created DESC',
                'contain' => 'Gebruiker'
            ));
        }
    }
?>
