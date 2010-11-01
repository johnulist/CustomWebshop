<?php
    /**
     * Controller voor producten
     */
    class CategorienController extends AppController
    {
        var $uses = array('Categorie');
        var $name = 'Categorien';

        function beforeFilter()
        {
            parent::beforeFilter();
        }

        /**
         * Beheer van categorien
         */
        function admin_index()
        {
            $this->data = $this->Categorie->getAllThreaded();
        }

        /**
         * Toevoegen van een categorie
         */
        function admin_toevoegen()
        {
            if(!empty($this->data))
			{
                $this->Categorie->create();
				if($this->Categorie->save($this->data))
                {
                    $this->Session->setFlash('De categorie is succesvol toegevoegd', 'flash_success');
                    $this->redirect('/admin/categorien/');
                }
                else
                {
                    $this->Session->setFlash('Er is een fout opgetreden bij het opslaan', 'flash_error');
                }
			}

			$this->set('lijst_categorien', $this->Categorie->getSelectList());
        }

        /**
		 * Volgorde van paginas aanpassen (TreeBehaviour)
		 */
		function admin_omhoog($categorie_id)
		{
			$this->Categorie->moveUp($categorie_id);
			$this->redirect('/admin/categorien/');
		}
		/**
		 * Volgorde van paginas aanpassen (TreeBehaviour)
		 *
		 * @param integer $pagina_id Het ID van de pagina die omhoog moet in de volgorde
		 */
		function admin_omlaag($categorie_id)
		{
			$this->Categorie->moveDown($categorie_id);
			$this->redirect('/admin/categorien/');
		}
    }
?>
