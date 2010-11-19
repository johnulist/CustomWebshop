<?php
    /**
     * Controller voor producten
     */
    class ProductenController extends AppController 
    {
        var $uses = array('Product');
        var $name = 'Producten';

        // speciaal voor producten:
        public $paginate = array(
            'Product' => array(
                'limit' => 20,
                'contain' => array('Merk','Productafbeelding'),
                'order' => 'Product.verkoopprijs ASC',
                'joins' => array(
                    0 => array(
                        'table' => 'categorien_producten',
                        'alias' => 'CategorieProduct',
                        'type' => 'inner',
                        'conditions'=> array('CategorieProduct.product_id = Product.id')
                    ),
                    1 => array(
                        'table' => 'categorien',
                        'alias' => 'Categorie',
                        'type' => 'inner',
                        'conditions'=> array(
                            'Categorie.id = CategorieProduct.categorie_id',
                            'Categorie.id' => 1
                        )
                    )
                )
            )
        );

        public $sortOrders = array(
            'prijs_oplopend' => array('label' => 'Prijs oplopend', 'query' => 'Product.verkoopprijs ASC'),
            'prijs_aflopend' => array('label' => 'Prijs aflopend', 'query' => 'Product.verkoopprijs DESC'),
            'merk_oplopend'  => array('label' => 'Merk oplopend',  'query' => 'Merk.naam ASC'),
            'merk_aflopend'  => array('label' => 'Merk aflopend',  'query' => 'Merk.naam DESC')
        );

        public $sortOrder = 'prijs_oplopend';


        function beforeFilter()
        {
            parent::beforeFilter();
            $this->Auth->allow('toon_via_slug','aanbiedingen','details','bestellen');
        }

        /**
         * Toont een overzicht van producten in een categorie,
         * waarbij de categorie wordt gebaseerd op de url in
         * combinatie met de opgeslagen slugs.
         */
        function toon_via_slug()
        {
            $parent_id = null;
            foreach($this->params['pass'] as $slug)
            {
                $categorie = $this->Categorie->find('first', array(
                    'conditions' => array(
                        'Categorie.parent_id' => $parent_id,
                        'Categorie.slug' => $slug
                    )
                ));

                if(!empty($categorie))
                {
                    $parent_id = $categorie["Categorie"]['id'];
                }
            }

            // Sort aanpassen indien van toepassing
            if(isset($this->params['form']['sort']) && array_key_exists($this->params['form']['sort'], $this->sortOrders))
            {
                $this->sortOrder = $this->params['form']['sort'];
            }

            // Join aanpassen
            $this->paginate['Product']['order'] = $this->sortOrders[$this->sortOrder]['query'];
            $this->paginate['Product']['joins'][1]['conditions']['Categorie.id'] = $parent_id;
            $this->data = $this->paginate('Product');

            // Pad naar categorie
            $path = $this->Categorie->getPath($parent_id);
            $merken = $this->Categorie->getMerken($parent_id);
            $children = $this->Categorie->children($parent_id, true);
            $this->params['linkerblokken'][] = 'categoriefilter'; 
            
            $this->set('path', $path);
            $this->set('categorie',  $categorie);
            $this->set('merken', $merken);
            $this->set('children', $children);
            $this->set('sortOrders', $this->sortOrders);
            $this->set('sortOrder',  $this->sortOrder);
        }

        /**
         * Toont een overzicht van producten die in de aanbieding
         * zijn. Indien er slides actief zijn wordt ook de slider
         * hierboven getoond.
         */
        function aanbiedingen()
        {
            $this->paginate['Product'] = array(
                'conditions' => array(
                    'Product.aanbiedingsprijs IS NOT NULL',
                    'Product.voorraad >' => 0,
                    'Product.beschikbaar' => 1
                ),
                'contain' => array('Merk','Productafbeelding'),
                'order' => 'Product.aanbiedingsprijs ASC',
                'limit' => 9
            );

            $this->data = $this->paginate('Product');
        }

        /**
         * Voegt een product toe aan de winkelwagen van een bezoeker
         * en update de totalen in de winkelwagen.
         *
         * @param integer $product_id
         */
        function bestellen($product_id, $variant_id = null)
        {
            // proberen het product toe te voegen
            if($this->_plaatsInWinkelwagen($product_id, $variant_id))
            {
                $this->Session->setFlash(__('SUCCES_TOEVOEGEN_WINKELWAGEN', true), 'flash_succes');
            }
            else
            {
                $this->Session->setFlash(__('ERROR_TOEVOEGEN_WINKELWAGEN', true), 'flash_error');
            }

            $this->redirect('/winkelwagen/');
        }

        /**
         * Toont een detailpagina van een product
         *
         * @param <type> $slug          Slug voor SEO-redenen
         * @param <type> $product_id    Het ID van het te tonen product
         */
        function details($slug, $product_id)
        {
            $this->Product->contain(array('Productafbeelding','Merk','Categorie'));
            $this->data = $this->Product->read(null, $product_id);
        }


        /**
         * Beheer van producten
         */
        function admin_index()
        {
            $this->paginate = array(
                'order' => 'Product.naam ASC',
                'limit' => 50,
                'contain' => 'Merk'
            );
            $this->data = $this->paginate('Product');
        }

        function admin_bewerken($product_id = null)
        {
            if(!empty($this->data))
			{
                $this->Product->create();
                $this->data['Product']['id'] = $product_id;
                
				if($this->Product->save($this->data) && $this->Product->checkUpload($this->data))
                {
                    $this->Session->setFlash('Het product is succesvol toegevoegd', 'flash_success');
                    $this->redirect('/admin/producten/');
                }
                else
                {
                    $this->Session->setFlash('Er is een fout opgetreden bij het opslaan', 'flash_error');
                }
            }
            elseif(!is_null($product_id))
            {
                $this->Product->contain('Categorie','Productafbeelding');
                $this->data = $this->Product->read(null, $product_id);
            }

            // lijst met merken en categorien voor de dropdown
            $merken         = $this->Product->Merk->find('list', array('order' => 'Merk.naam ASC'));
            $attributensets = $this->Product->Attributenset->find('list', array('order' => 'Attributenset.naam ASC'));
            $categorien     = $this->Product->Categorie->getSelectList();
            $this->set(compact('merken','categorien','attributensets'));
        }

        /**
         * Verwijdert een afbeelding en het bestand op de server.
         * 
         * @param integer $afbeelding_id Het ID van de te verwijderen afbeelding
         */
        function admin_afbeelding_verwijderen($afbeelding_id)
        {
            $afbeelding = $this->Product->Productafbeelding->read(null, $afbeelding_id);
            if($this->Product->Productafbeelding->delete($afbeelding_id))
            {
                if($this->Product->verwijderBestand($afbeelding['Productafbeelding']['bestandsnaam']))
                {
                    $this->Session->setFlash("De afbeelding is verwijderd", "flash_succes");
                }
                else
                {
                    $this->Session->setFlash("De afbeelding is verwijderd uit de database, maar niet van de server", "flash_error");
                }
            }
            else
            {
                $this->Session->setFlash("De afbeelding kon niet worden verwijderd", "flash_error");
            }
            
            $this->redirect('/admin/producten/bewerken/' . $afbeelding['Productafbeelding']['product_id'] . '#tab_afbeeldingen');
        }

        /**
         * Toont een lijst met varianten op een product
         *
         * @param <type> $product_id
         */
        function admin_varianten($product_id)
        {
            $this->data = $this->Product->Productvariant->find('all');
        }
    }
?>