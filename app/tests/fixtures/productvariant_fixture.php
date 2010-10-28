<?php
    class ProductvariantFixture extends CakeTestFixture
    {
        var $name = 'Productvariant';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'variant' => 'string',
            'verkoopprijs' => 'float',
            'inkoopprijs' => 'float',
            'aanbiedingsprijs' => 'float',
            'voorraad' => 'integer',
            'levertijd' => 'integer',
            'product_id' => 'integer',
            'aantal_keer_verkocht' => 'integer',
            'created' => 'datetime',
            'modified' => 'datetime'
        );

        var $records = array(

        );
    }
 ?>