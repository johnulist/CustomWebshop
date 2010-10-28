<?php
    class BestelregelFixture extends CakeTestFixture
    {
        var $name = 'Bestelregel';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'bestelling_id' => 'integer',
            'product_id' => 'integer',
            'productvariant_id' => 'integer',
            'btw_percentage' => 'integer',
            'aantal' => 'float',
            'prijs_excl' => 'float',
            'totaal_excl' => 'float',
            'btw_bedrag' => 'float',
            'totaal_incl' => 'float',
            'created' => 'datetime',
            'modified' => 'datetime'
        );

        var $records = array(

        );
    }
 ?>