<?php
    /**
     * Controller voor producten
     */
    class InstellingenController extends AppController
    {
        var $uses = array('Instelling');
        var $name = 'Instellingen';

        function beforeFilter()
        {
            parent::beforeFilter();
        }

        function admin_index()
		{
			$this->data = $this->Paginate('Instelling');
		}

		function admin_bewerken($instelling_id)
		{
    		$this->Instelling->id = $instelling_id;
			if(!empty($this->data))
			{
				$this->Instelling->save($this->data);
				$this->redirect('/admin/instellingen/');
			}
			else
			{
				$this->data = $this->Instelling->read();
			}
		}
    }
?>
