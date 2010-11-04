<?php
    /**
     * Controller voor producten
     */
    class ProductenController extends AppController 
    {
        var $uses = array('Product');
        var $name = 'Producten';

        function beforeFilter()
        {
            parent::beforeFilter();
            $this->Auth->allow('toon_via_slug');
        }

        /**
         * Toont een overzicht van producten in een categorie,
         * waarbij de categorie wordt gebaseerd op de url in
         * combinatie met de opgeslagen slugs.
         */
        function toon_via_slug()
        {

        }

        /**
         * Toont een overzicht van producten die in de aanbieding
         * zijn. Indien er slides actief zijn wordt ook de slider
         * hierboven getoond.
         */
        function aanbiedingen()
        {
            $this->paginate = array(
                'conditions' => array(
                    'Product.aanbiedingsprijs IS NOT NULL',
                    'Product.voorraad >' => 0,
                    'Product.beschikbaar' => 1
                ),
                'order' => 'Product.aanbiedingsprijs ASC',
                'limit' => 9
            );
            $this->data = $this->Paginate('Product');
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
                $this->Session->setFlash(__('SUCCES_TOEVOEGEN_WINKELWAGEN'), 'flash_succes');
            }
            else
            {
                $this->Session->setFlash(__('ERROR_TOEVOEGEN_WINKELWAGEN'), 'flash_error');
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
                
				if($this->Product->save($this->data))
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
                $this->Product->contain('Categorie');
                $this->data = $this->Product->read(null, $product_id);
            }

            // lijst met merken en categorien voor de dropdown
            $merken     = $this->Product->Merk->find('list', array('order' => 'Merk.naam ASC'));
            $categorien = $this->Product->Categorie->getSelectList();
            $this->set(compact('merken','categorien'));
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
