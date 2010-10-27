<?php
 class MerkFixture extends CakeTestFixture {
      var $name = 'Merk';

      var $fields = array(
          'id' => array('type' => 'integer', 'key' => 'primary'),
          'merk' => 'string',
          'created' => 'datetime',
          'updated' => 'datetime'
      );
      var $records = array(
          array ('id' => 1, 'merk' => 'Adidas', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'),
          array ('id' => 2, 'merk' => 'Nike', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'),
          array ('id' => 3, 'merk' => 'Reebok', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31')
      );
 }
 ?>