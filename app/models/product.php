<?php
    class Product extends AppModel
    {
        var $name = 'Product';
        var $useTable = 'producten';
        var $actsAs = array(
            'Slug' => array('separator' => '-', 'overwrite' => true, 'label' => 'naam'),
            'CounterCacheHabtm'
        );

        // Relaties met andere modellen
        var $belongsTo = array('Merk');
        var $hasMany = array('Productvariant' => array('foreignKey' => 'product_id'));
        var $hasAndBelongsToMany = array(
            'Categorie' => array(
                'joinTable' => 'categorien_producten',
                'foreignKey' => 'product_id',
                'associationForeignKey' => 'categorie_id',
                'unique' => true
            )
        );
    }
 ?>