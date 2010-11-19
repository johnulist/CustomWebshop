<?php
    // @TODO CounterCache controle
    class Categorie extends AppModel
    {
        var $name = 'Categorie';
        var $useTable = 'categorien';
        var $displayField = 'naam';
        var $actsAs = array(
            'Tree',
            'CounterCacheHabtm',
            'Slug' => array('separator' => '-', 'overwrite' => true, 'label' => 'naam')
        );

        var $hasAndBelongsToMany  = array(
            'Product' => array(
                'joinTable' => 'categorien_producten',
                'foreignKey' => 'categorie_id',
                'associationForeignKey' => 'product_id',
                'unique' => true
            )
        );

        /**
         * Laadt een array in met de benodigde info voor het
         * opbouwen van de navigatie middels categorien
         */
        function getNavigatieData()
        {
            $data = $this->find('threaded', array(
                'order' => 'Categorie.lft ASC'
            ));

            return $data;
        }
        
        function getMerken($categorie_id)
        {
            $merk_ids = $this->query("SELECT distinct(merk_id) FROM producten p, categorien_producten pc WHERE p.id = pc.product_id AND pc.categorie_id IN (SELECT id FROM `categorien` WHERE lft > 2 AND rght < 9)");
            $merken   = $this->Product->Merk->find('list', array(
                'conditions' => array(
                    'Merk.id' => Set::extract('/p/merk_id', $merk_ids)
                ),
                'fields' => array('slug','naam')
            ));
            
            return $merken;
        }
    }
 ?>