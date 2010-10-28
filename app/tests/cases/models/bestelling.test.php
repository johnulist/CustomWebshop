<?php
    App::import('Model','Bestelling');

    class BestellingTestCase extends CakeTestCase
    {
        var $fixtures = array( 'app.bestelling' );

        /**
         * Voorbeeld test, niet van toepassing
         */
        function testPublished()
        {
            $this->Bestelling =& ClassRegistry::init('Bestelling');

            $result = $this->Bestelling->published(array('id', 'title'));
            $expected = array(
                array('Article' => array( 'id' => 1, 'title' => 'First Article' )),
                array('Article' => array( 'id' => 2, 'title' => 'Second Article' )),
                array('Article' => array( 'id' => 3, 'title' => 'Third Article' ))
            );

            $this->assertEqual($result, $expected);
        }
    }
?>