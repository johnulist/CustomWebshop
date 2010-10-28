<?php
    class ProductFixture extends CakeTestFixture
    {
        var $name = 'Product';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'naam' => 'string',
            'slug' => 'string',
            'omschrijving_kort' => 'string',
            'omschrijving_lang' => 'text',
            'zie_ook' => 'string',
            'productcode' => 'string',
            'verkoopprijs' => 'float',
            'inkoopprijs' => 'float',
            'aanbiedingsprijs' => 'float',
            'btw' => 'integer',
            'afbeelding' => 'string',
            'voorraad' => 'integer',
            'levertijd' => 'integer',
            'merk_id' => 'integer',
            'meta_keywords' => 'string',
            'meta_description' => 'string',
            'meta_title' => 'string',
            'aantal_keer_verkocht' => 'integer',
            'created' => 'datetime',
            'modified' => 'datetime'
        );

        var $records = array(

        );
    }
 ?>