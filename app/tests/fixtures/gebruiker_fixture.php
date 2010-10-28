<?php
    class GebruikerFixture extends CakeTestFixture
    {
        var $name = 'Gebruiker';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'created' => 'datetime',
            'updated' => 'datetime'
        );

        var $records = array(

        );
    }
 ?>