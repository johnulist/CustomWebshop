<?php
    /**
     * Controller voor producten
     */
    class PaginasController extends AppController
    {
        var $uses = array('Pagina');
        var $name = 'Paginas';

        function beforeFilter()
        {
            parent::beforeFilter();
        }

        function toon_via_url()
		{
            // zoeken mbv de url, nadat we '/p' losknippen.
            $this->data = $this->Pagina->findByUrl(substr($this->params['url']['url'], 1));

            // meta
			$this->params['meta_title'] = (empty($this->data['Pagina']['meta_title']) ? $this->params['meta_title'] : $this->data['Pagina']['meta_title']);
			$this->params['meta_keywords'] = (empty($this->data['Pagina']['meta_keywords']) ? $this->params['meta_keywords'] : $this->data['Pagina']['meta_keywords']);
			$this->params['meta_description'] = (empty($this->data['Pagina']['meta_description']) ? $this->params['meta_description'] : $this->data['Pagina']['meta_description']);
		}

        /**
		 * Lijst met paginas in het systeem
		 */
		function admin_index()
		{
			$this->loadModel('Pagina');
			$this->data = $this->Pagina->getAllThreaded();
		}

        /**
		 * Functie voor het toevoegen van een nieuwe pagina.
		 */
		function admin_toevoegen()
		{
			$this->loadModel('Pagina');

			if(!empty($this->data))
			{
				$this->data['Pagina']['administrator_id'] = $this->Auth->user('id');

				if($this->Pagina->save($this->data))
				{
					$this->redirect('/admin/paginas/');
				}
			}

			$this->set('lijst_paginas', $this->Pagina->getListThreaded());
		}

		/**
		 * Functie voor het bewerken van een bestaande pagina.
		 */
		function admin_bewerken($pagina_id)
		{
			$this->loadModel('Pagina');
			$this->Pagina->id = $pagina_id;
			if(!empty($this->data))
			{
				$this->Pagina->create();
				$this->data['Pagina']['id'] = $pagina_id;

				if($this->Pagina->save($this->data))
				{
					$this->redirect('/admin/paginas/');
				}
			}
			else
			{
				$this->data = $this->Pagina->read();
			}

			$this->set('lijst_paginas', $this->Pagina->getListThreaded($pagina_id));
		}

		/**
		 * Volgorde van paginas aanpassen (TreeBehaviour)
		 */
		function admin_omhoog($pagina_id)
		{
			$this->loadModel('Pagina');
			$this->Pagina->moveUp($pagina_id);
			$this->redirect('/admin/paginas/');
		}
		/**
		 * Volgorde van paginas aanpassen (TreeBehaviour)
		 *
		 * @param integer $admin_id Het ID van de pagina die omhoog moet in de volgorde
		 */
		function admin_omlaag($pagina_id)
		{
			$this->loadModel('Pagina');
			$this->Pagina->moveDown($pagina_id);
			$this->redirect('/admin/paginas/');
		}
		/**
		 * Pagina verwijderen
		 *
		 * @param integer $admin_id Het ID van de pagina die omlaag moet in de volgorde
		 */
		function admin_verwijderen($pagina_id)
		{
			$this->loadModel('Pagina');
			$this->Pagina->delete($pagina_id);
			$this->redirect('/admin/paginas/');
		}
    }
?>