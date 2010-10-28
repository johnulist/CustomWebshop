<?php
    class GebruikerFixture extends CakeTestFixture
    {
        var $name = 'Gebruiker';
        var $import = array('model' => 'Gebruiker');

        var $records = array(
            1 => array(
                'id' => '1',
                'bedrijfsnaam'          => 'Custom Webwinkel',
                'contactpersoon'        => 'Mattijs Meiboom',
                'factuuradres'          => 'Stockholmstraat 2e',
                'f_postcode'            => '9723BC',
                'f_plaats'              => 'Groningen',
                'f_land'                => 'Nederland',
                'afleveradres'          => 'Stockholmstraat 2e',
                'a_postcode'            => '9723BC',
                'a_plaats'              => 'Groningen',
                'a_land'                => 'Nederland',
                'voorkeurstaal'         => 'dut',
                'voorkeursvaluta'       => 'EUR',
                'kvknummer'             => '1088252',
                'btwnummer'             => 'NL110339381B01',
                'bank_rekeningnummer'   => '1347.70.854 ',
                'bank_tenaamstelling'   => 'Customwebsite',
                'bank_plaats'           => 'Groningen',
                'www'                   => 'http://www.customwebsite.nl',
                'telefoon'              => '0507520161',
                'mobiel'                => '0653895448',
                'fax'                   => null,
                'korting'               => '0',
                'emailadres'            => 'mattijs@customwebsite.nl',
                'wachtwoord'            => '',
                'isBeheerder'           => '1',
                'created'               => '2010-10-28 14:12:31',
                'modified'              => '2010-10-28 14:12:31'
            )
        );
    }
 ?>