<?php
    class InstellingFixture extends CakeTestFixture
    {
        var $name = 'Instelling';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'key' => 'string',
            'value' => 'string',
            'created' => 'datetime',
            'updated' => 'datetime'
        );

        var $records = array(
            
        );
    }
 ?>