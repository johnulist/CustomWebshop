<?php
    /**
     * Controller voor producten
     */
    class FacturenController extends AppController
    {
        var $uses = array('Bestelling');
        var $name = 'Facturen';

        function beforeFilter()
        {
            parent::beforeFilter();
        }

        /**
         * Toont een lijst met bestellingen van de ingelogde
         * gebruiker.
         */
        function index()
        {
            $this->data = $this->Bestelling->find('all', array(
                'conditions' => array(
                    'Bestelling.gebruiker_id' => $this->Auth->user('id'),
                ),
                'order' => 'Bestelling.besteldatum DESC'
            ));

            $this->params['linkerblokken'][] = 'gebruikersmenu';
        }

        function pdf($bestelling_id)
        {
            $this->Bestelling->contain(array(
                'Gebruiker',
                'Bestelregel' => array(
                    'Product'
                ),
                'Bestelstatus',
                'Levermethode',
                'Betaalmethode'
            ));

            $this->data = $this->Bestelling->read(null, $bestelling_id);

            if($this->data['Bestelling']['gebruiker_id'] !== $this->Auth->user('id') && !$this->isBeheerder())
            {
                $this->Session->setFlash("U heeft geen toegang tot deze bestelling");
                $this->redirect('/bestellingen/');
            }

            $this->layout = 'pdf';
        }

        function details($bestelling_id)
        {
            $this->Bestelling->contain(array(
                'Gebruiker',
                'Bestelregel' => array(
                    'Product'
                ),
                'Bestelstatus',
                'Levermethode',
                'Betaalmethode'
            ));
        
            $this->data = $this->Bestelling->read(null, $bestelling_id);

            if($this->data['Bestelling']['gebruiker_id'] !== $this->Auth->user('id'))
            {
                $this->Session->setFlash("U heeft geen toegang tot deze bestelling");
                $this->redirect('/bestellingen/');
            }

            $this->params['linkerblokken'][] = 'gebruikersmenu';
        }

        /**
         * Toont facturen op basis van enkele filters
         */
        function admin_index()
        {
            $conditions = array('Bestelling.factuurdatum IS NOT NULL');

            // Tijdfilter
            $start = (isset($this->data['Filter']['start']) && !empty($this->data['Filter']['start']) ? date("Y-m-d", strtotime($this->data['Filter']['start'])) : date("Y-01-01"));
            $einde = (isset($this->data['Filter']['einde']) && !empty($this->data['Filter']['einde']) ? date("Y-m-d", strtotime($this->data['Filter']['einde'])) : date("Y-12-31"));
            $conditions[] = "Bestelling.factuurdatum >= '$start'";
            $conditions[] = "Bestelling.factuurdatum <= '$einde'";

            // Voldaan & Niet-voldaan
            if(isset($this->data['Filter']['isBetaald']) && $this->data['Filter']['isBetaald'] != '' && in_array($this->data['Filter']['isBetaald'], array(0,1)))
            {
                $conditions[] = "Bestelling.isBetaald = '" . $this->data['Filter']['isBetaald'] . "'";
            }

            // ID
            if(isset($this->data['Filter']['factuurnummer']) && !empty($this->data['Filter']['factuurnummer']))
            {
                $factuurnummer = intval($this->data['Filter']['factuurnummer']);
                $conditions[] = "Bestelling.factuurnummer LIKE '%$factuurnummer%'";
            }
            
            $this->paginate = array(
                'order' => 'Bestelling.factuurdatum DESC',
                'contain' => 'Gebruiker',
                'conditions' => $conditions,
                'limit' => 25
            );
            $this->data = $this->Paginate('Bestelling');

            $this->set(compact('start','einde'));
        }

        function admin_bewerken($bestelling_id)
        {
            $this->Bestelling->contain(array(
                'Gebruiker',
                'Bestelregel' => array(
                    'Product'
                ),
                'Bestelstatus',
                'Levermethode',
                'Betaalmethode'
            ));
        
            $this->data = $this->Bestelling->read(null, $bestelling_id);
            $this->set('levermethoden', $this->Bestelling->Levermethode->find('list'));
            $this->set('betaalmethoden', $this->Bestelling->Betaalmethode->find('list'));
            $this->set('relaties', $this->Bestelling->Gebruiker->find('list'));
        }

        /**
         * Verwijdert een bestelling uit de database.
         *
         * @param integer $bestelling_id ID van de te verwijderen bestelling
         */
        function admin_verwijderen($bestelling_id)
        {
            if($this->Bestelling->delete($bestelling_id))
            {
                $this->Session->setFlash(__('De bestelling is verwijderd', true), 'flash_succes');
            }
            else
            {
                $this->Session->setFlash(__('De bestelling kon niet worden verwijderd', true), 'flash_error');
            }

            $this->redirect('/admin/bestellingen/');
        }
    }
?>
