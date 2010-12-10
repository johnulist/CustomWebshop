<?php
    /**
     * Controller voor producten
     */
    class BestellingenController extends AppController
    {
        var $uses = array('Bestelling');
        var $name = 'Bestellingen';
        var $components = array('Pdf','Email');

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

        function admin_bewerken($bestelling_id = null)
        {
            $this->Bestelling->id = $bestelling_id;
            
            if(!empty($this->data))
            {
                if($this->Bestelling->saveFromBeheer($this->data))
                {
                    $this->Session->setFlash("Bestelling opgeslagen");
                    $this->redirect('/admin/bestellingen/bewerken/' . $this->Bestelling->id);
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
            $this->set('relaties', $this->Bestelling->Gebruiker->find('list', array('order' => 'Gebruiker.contactpersoon ASC')));
        }

        /**
         * Toevoegen van een product aan een bestaande bestelling, dit
         * gebeurt middels een popup, dus geen extra layout.
         * Een product dat al in de bestelling aanwezig is kan niet via
         * deze weg worden toegevoegd.
         *
         * @param integer $bestelling_id
         */
        function admin_nieuw_product($bestelling_id)
        {
            $this->layout = 'ajax';
            $this->loadModel('Product');
            $this->loadModel('Bestelling');
            
            if(isset($this->params['form']['product']) || isset($this->params['form']['code']))
            {
                if(is_numeric($this->params['form']['product']))
                {
                    $msg = $this->Bestelling->productToevoegen($bestelling_id, $this->params['form']['product'], $ajax = true);
                    echo $msg;
                    exit;
                }
                elseif(!empty($this->params['form']['code']))
                {
                    $product = $this->Product->findByProductcode(mysql_escape_string($this->params['form']['code']));
                    if(!empty($product))
                    {
                        $msg = $this->Bestelling->productToevoegen($bestelling_id, $product['Product']['id'], $ajax = true);
                    }
                    else
                    {
                        $msg = "Er is geen product gevonden met de opgegeven code.";
                    }
                    echo $msg;
                    exit;
                }
                else
                {
                    echo "Vul een productcode in of kies een product.";
                    exit;
                }
            }

            $producten = $this->Product->find('all');
            $al_geselecteerd = $this->Bestelling->Bestelregel->find('all', array('conditions' => array('Bestelregel.bestelling_id' => $bestelling_id)));
            $lijst_producten = array();

            foreach($producten as $product)
            {
                $lijst_producten[$product['Product']['id']] = $product['Product']['naam'] . " (&euro;" . $product['Product']['prijs'] . ")";
            }

            foreach($al_geselecteerd as $regel)
            {
                unset($lijst_producten[$regel['Bestelregel']['product_id']]);
            }

            $this->set('bestelling_id', $bestelling_id);
            $this->set('lijst_producten', $lijst_producten);
        }

        /**
         * Verwijdert een product uit een bestelling, en herberekent
         * het totaal.
         * 
         * @param <type> $bestelling_id
         * @param <type> $product_id
         */
        function admin_regel_verwijderen($bestelregel_id)
        {
            // Bestelling zoeken
            $regel = $this->Bestelling->Bestelregel->read(null, $bestelregel_id);
            $bestelling_id = $regel['Bestelregel']['bestelling_id'];

            // Verwijderen en herberekenen
            $this->Bestelling->Bestelregel->delete($bestelregel_id);
            $this->Bestelling->updateTotaal($bestelling_id);

            // Terug naar bewerken
            $this->redirect('/admin/bestellingen/bewerken/' . $bestelling_id);
        }

        function admin_verzenden($bestelling_id)
        {
            if(!empty($this->data))
            {
                $this->__mailPdf($bestelling_id);
                $this->redirect('/admin/bestellingen/bewerken/' . $bestelling_id);
            }
            
            $this->Bestelling->contain('Gebruiker');
            $this->data = $this->Bestelling->read(null, $bestelling_id);
        }

        /**
         * Versturen van een PDF met een kopie van een factuur
         * of bestelling.
         *
         * @param integer $bestelling_id 
         */
        function __mailPdf($bestelling_id)
        {
            // Data laden
            $this->Bestelling->id = $bestelling_id;
            $bestelling = $this->Bestelling->read();

            // Gaat het om een bestelling of factuur?
			if(empty($bestelling['Bestelling']['factuurnummer']))
			{
				$type = 'bestelling';
				$subject = 'Overzicht van uw bestelling op ' . $this->params['siteNaam'];
				$filename = "Bestelling $bestelling_id.pdf";
			}
			else
			{
				$nummer = $bestelling['Bestelling']['factuurnummer'];
				$type = 'factuur';
				$subject = 'Factuur van uw bestelling op ' . $this->params['siteNaam'];
				$filename = "Factuur $nummer.pdf";
			}

            $to = $this->data['Gebruiker']['emailadres'];
            $from = Configure::read('Site.afzendAdres');
            $this->set('bestelling', $bestelling);
            $this->set('type', $type);

            // Algemene instellingen
            $this->Email->sendAs = 'html';
            $this->Email->from = $this->params['siteNaam'] . ' <' . $from . '>';
            $this->Email->template = $type;
            $this->Email->to = $to;
            $this->Email->subject = $subject;
            $this->Email->bcc = array($from);

            // PDF opslaan voor bijlage
            $this->Pdf->save("/bestellingen/pdfcontent/$bestelling_id/", $filename, $type);
            $fileatt = ROOT . "/app/pdf/$type/" . $filename;
            $this->Email->attachments = array($fileatt);

             // Send the message
            $ok = $this->Email->send();
            $this->Session->setFlash("PDF verzonden naar $to", 'flash_success');
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
