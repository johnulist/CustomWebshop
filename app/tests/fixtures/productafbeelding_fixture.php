<?php
    class ProductafbeeldingFixture extends CakeTestFixture
    {
        var $name = 'Productafbeelding';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'product_id' => 'integer',
            'productvariant_id' => 'integer',
            'isHoofdafbeelding' => 'integer',
            'created' => 'datetime',
            'modified' => 'datetime'
        );

        var $records = array(

        );
    }
 ?>