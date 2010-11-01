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
