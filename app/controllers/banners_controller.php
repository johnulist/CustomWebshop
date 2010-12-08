<?php
    /**
     * Controller voor producten
     */
    class BannersController extends AppController
    {
        var $uses = array('Banner');
        var $name = 'Banners';

        function beforeFilter()
        {
            parent::beforeFilter();
        }

        /**
         * Beheer van categorien
         */
        function admin_index()
        {
            $this->data = $this->Banner->find('all', array(
                'order' => 'Banner.lft ASC'
            ));
        }

        /**
         * Toevoegen van een categorie
         */
        function admin_bewerken($banner_id = null)
        {
            if(!empty($this->data))
			{
                $this->data['Banner']['id'] = $banner_id;
                $this->Banner->create();
				if($this->Banner->save($this->data) && $this->Banner->checkUpload($this->data))
                {
                    $this->Session->setFlash('De banner is succesvol toegevoegd', 'flash_success');
                    $this->redirect('/admin/banners/');
                }
                else
                {
                    $this->Session->setFlash('Er is een fout opgetreden bij het opslaan', 'flash_error');
                }
			}
            else
            {
                $this->data = $this->Banner->read(null, $banner_id);
            }
        }

        /**
		 * Volgorde van paginas aanpassen (TreeBehaviour)
		 */
		function admin_omhoog($banner_id)
		{
			$this->Banner->moveUp($banner_id);
			$this->redirect('/admin/banners/');
		}
		/**
		 * Volgorde van paginas aanpassen (TreeBehaviour)
		 *
		 * @param integer $pagina_id Het ID van de pagina die omhoog moet in de volgorde
		 */
		function admin_omlaag($banner_id)
		{
			$this->Banner->moveDown($banner_id);
			$this->redirect('/admin/banners/');
		}
    }
?>