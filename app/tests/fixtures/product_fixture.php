<?php
    class ProductFixture extends CakeTestFixture
    {
        var $name = 'Product';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'created' => 'datetime',
            'updated' => 'datetime'
        );

        var $records = array(

        );
    }
 ?>