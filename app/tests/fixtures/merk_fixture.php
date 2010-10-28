<?php
 class MerkFixture extends CakeTestFixture {
      var $name = 'Merk';

      var $fields = array(
          'id' => array('type' => 'integer', 'key' => 'primary'),
          'naam' => 'string',
          'slug' => 'string',
          'created' => 'datetime',
          'modified' => 'datetime'
      );
      var $records = array(
          array ('id' => 1, 'merk' => 'Adidas', 'slug' => 'adidas', 'created' => '2007-03-18 10:39:23', 'modified' => '2007-03-18 10:41:31'),
          array ('id' => 2, 'merk' => 'Nike', 'slug' => 'nike', 'created' => '2007-03-18 10:41:23', 'modified' => '2007-03-18 10:43:31'),
          array ('id' => 3, 'merk' => 'Reebok', 'slug' => 'reebok', 'created' => '2007-03-18 10:43:23', 'modified' => '2007-03-18 10:45:31')
      );
 }
?>