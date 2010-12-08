<?php
    /**
     * Controller voor producten
     */
    class BestellingenController extends AppController
    {
        var $uses = array('Bestelling');
        var $name = 'Bestellingen';
        var $components = array('Pdf');

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
                    'Bestelling.gebruiker_id' => $this->Auth->user('id')
                ),
                'order' => 'Bestelling.besteldatum DESC'
            ));

            $this->params['linkerblokken'][] = 'gebruikersmenu';
        }

        function pdf($bestelling_id)
		{
            if($debug = false)
            {
                $this->data = $this->requestAction('/bestellingen/pdfcontent/' . $bestelling_id, array('return'));
                $this->layout = 'pdf';
                $this->render('pdfcontent');
            }
            else
            {
                Configure::write('debug', 0);
                $this->Pdf->render('/bestellingen/pdfcontent/' . $bestelling_id);
                exit;
            }

            return;
		}
        
        function pdfcontent($bestelling_id)
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

        function admin_index()
        {
            $conditions = array('Bestelling.factuurdatum IS NULL');

            // Tijdfilter
            $start = (isset($this->data['Filter']['start']) && !empty($this->data['Filter']['start']) ? date("Y-m-d", strtotime($this->data['Filter']['start'])) : date("Y-01-01"));
            $einde = (isset($this->data['Filter']['einde']) && !empty($this->data['Filter']['einde']) ? date("Y-m-d", strtotime($this->data['Filter']['einde'])) : date("Y-12-31"));
            $conditions[] = "Bestelling.besteldatum >= '$start'";
            $conditions[] = "Bestelling.besteldatum <= '$einde'";

            // ID
            if(isset($this->data['Filter']['bestellingnummer']) && !empty($this->data['Filter']['bestellingnummer']))
            {
                $bestelling_id = intval($this->data['Filter']['bestellingnummer']);
                $conditions[] = "Bestelling.id LIKE '%$bestelling_id%'";
            }

            $this->paginate = array(
                'order' => 'Bestelling.created DESC',
                'contain' => 'Gebruiker',
                'conditions' => $conditions,
                'limit' => 25
            );
            $this->data = $this->Paginate('Bestelling');
            $this->set(compact('start','einde'));
        }

        function admin_bewerken($bestelling_id)
        {
            $this->Bestelling->id = $bestelling_id;

            if(!empty($this->data))
            {
                if($this->Bestelling->saveFromBeheer($this->data))
                {
                    $this->Session->setFlash("Bestelling opgeslagen");
                }
                else
                {
                    $this->Session->setFlash("Er is iets foutgegaan bij het opslaan");
                }
            }

            // Data uitgebreid laden
            $this->Bestelling->contain(array(
                'Gebruiker',
                'Bestelregel' => array(
                    'Product'
                ),
                'Bestelstatus',
                'Levermethode',
                'Betaalmethode'
            ));
            $this->data = $this->Bestelling->read();
            
            // Lijsten voor bewerken
            $this->set('levermethoden', $this->Bestelling->Levermethode->find('list'));
            $this->set('verzendkosten', $this->Bestelling->Levermethode->find('list', array('fields' => array('id', 'verzendkosten_excl'))));
            $this->set('betaalmethoden', $this->Bestelling->Betaalmethode->find('list'));
            $this->set('relaties', $this->Bestelling->Gebruiker->find('list'));
        }

        function admin_verzenden($bestelling_id)
        {
            if(!empty($this->data))
            {
                $this->Bestelling->stuurBevestigingsMail($bestelling_id, $this->data);
                $this->redirect('/admin/bestellingen/bewerken/' . $bestelling_id);
            }
            
            $this->Bestelling->contain('Gebruiker');
            $this->data = $this->Bestelling->read(null, $bestelling_id);
        }

        function admin_factureren($bestelling_id)
        {
            if(!empty($this->data))
            {
                if($this->Bestelling->factureren($bestelling_id, $this->data['Bestelling']['factuurnummer'], $this->data['Bestelling']['email_klant']))
                {
                    $this->Session->setFlash('De bestelling is gefactureerd','flash_succes');
                    $this->redirect('/admin/bestellingen/');
                }
                else
                {
                    $this->Session->setFlash('De bestelling kon niet worden gefactureerd','flash_error');
                }
            }
            else
            {
                $this->data = $this->Bestelling->read(null, $bestelling_id);
            }

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
