<?php
    class BestellingFixture extends CakeTestFixture
    {
        var $name = 'Bestelling';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'created' => 'datetime',
            'updated' => 'datetime'
        );

        var $records = array(
            array ('id' => 1, 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'),
            array ('id' => 2, 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'),
            array ('id' => 3, 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31')
        ); 
    }
 ?>