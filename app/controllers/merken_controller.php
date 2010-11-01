<?php
    /**
     * Controller voor producten
     */
    class MerkenController extends AppController
    {
        var $uses = array('Merk');
        var $name = 'Merken';

        function beforeFilter()
        {
            parent::beforeFilter();
        }

        /**
         * Beheer van merken
         */
        function admin_index()
        {
            $this->paginate = array(
                'order' => 'Merk.naam ASC',
                'limit' => 50
            );
            $this->data = $this->paginate('Merk');
        }

        /**
         * Een nieuw merk toevoegen
         */
        function admin_bewerken($merk_id = null)
        {
            if(!empty($this->data))
            {
                $this->Merk->create();
                $this->Merk->id = $merk_id;
                if($this->Merk->save($this->data))
                {
                    $this->Session->setFlash('Het merk is succesvol opgeslagen', 'flash_success');
                    $this->redirect('/admin/merken/');
                }
                else
                {
                    $this->Session->setFlash('Er is een fout opgetreden bij het opslaan', 'flash_error');
                }
            }
            elseif(!is_null($merk_id))
            {
                $this->data = $this->Merk->read(null, $merk_id);
            }
        }
    }
?>
