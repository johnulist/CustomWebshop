<?php
    class CategorieFixture extends CakeTestFixture
    {
        var $name = 'Categorie';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'naam' => 'string',
            'slug' => 'string',
            'meta_keywords' => 'string',
            'meta_title' => 'string',
            'meta_description' => 'string',
            'omschrijving' => 'text',
            'lft' => 'integer',
            'rght' => 'integer',
            'parent_id' => 'integer',
            'created' => 'datetime',
            'modified' => 'datetime'
        );

        var $records = array(
            array ('id' => 1, 'naam' => 'Sportschoenen', 'created' => '2007-03-18 10:39:23', 'modified' => '2007-03-18 10:41:31'),
            array ('id' => 2, 'naam' => 'T-Shirts', 'created' => '2007-03-18 10:41:23', 'modified' => '2007-03-18 10:43:31'),
            array ('id' => 3, 'naam' => 'Spijkerbroeken', 'created' => '2007-03-18 10:43:23', 'modified' => '2007-03-18 10:45:31')
        );
    }
 ?>