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
    }
 ?>