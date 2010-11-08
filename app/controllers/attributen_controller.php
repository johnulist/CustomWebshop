<?php
    /**
     * Controller voor producteigenschappen
     *
     * Beheer van eigenschappen (Attributen) van een product,
     * deze kunnen tzt eventueel opgedeeld worden in meerdere
     * sets van attributen.
     */
    class AttributenController extends AppController
    {
            var $name = 'Attributen';
            var $uses = array('Attributenset');
            
            /**
             * Toont een overzicht van attributensets
             */
            function admin_index()
            {
                $this->paginate = array(
                    'contain' => array('Attribuut')
                );
                $this->data = $this->Paginate('Attributenset');
            }

            /**
             * Toevoegen en bewerken van een attributenset
             *
             * @param integer $set_id ID van de te bewerken set, of NULL voor nieuw
             */
            function admin_set_bewerken($set_id = null)
            {
                $this->Attributenset->id = $set_id;

                if(!empty($this->data))
                {
                    if($this->Attributenset->saveAll($this->data))
                    {
                        $this->Session->setFlash('Attributenset opgeslagen', array('flash_succes'));
                        $this->redirect('/admin/attributen/');
                    }
                    else
                    {
                        $this->Session->setFlash('Opslaan mislukt', array('flash_error'));
                    }
                }
                elseif(!is_null($set_id))
                {
                    $this->Attributenset->contain('Attribuut');
                    $this->data = $this->Attributenset->read();
                }
            }

            function admin_set_verwijderen($set_id)
            {
                $this->Attributenset->delete($set_id);
                $this->redirect('/admin/attributen/');
            }
    }
?>
