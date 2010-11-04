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

        function afterFind($results, $primary)
        {
            // Itereren over producten
            foreach ($results as $key => $val)
            {
                // Controleren of we een product kunnen vinden
                if (isset($val['Product']))
                {
                    $results[$key]['Product']['prijs'] = (empty($val['Product']['aanbiedingsprijs']) ? $val['Product']['verkoopprijs'] : $val['Product']['aanbiedingsprijs']);
                }
            }

            return $results;
        }
    }
 ?>