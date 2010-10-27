<?php
    class CategorieFixture extends CakeTestFixture
    {
        var $name = 'Categorie';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'categorie' => 'string',
            'lft' => 'integer',
            'rght' => 'integer',
            'parent_id' => 'integer',
            'created' => 'datetime',
            'updated' => 'datetime'
        );

        var $records = array(
            array ('id' => 1, 'categorie' => 'Sportschoenen', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'),
            array ('id' => 2, 'categorie' => 'T-Shirts', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'),
            array ('id' => 3, 'categorie' => 'Spijkerbroeken', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31')
        );
    }
 ?>