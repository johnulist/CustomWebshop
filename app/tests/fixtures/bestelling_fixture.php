<?php
    class BestellingFixture extends CakeTestFixture
    {
        var $name = 'Bestelling';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'gebruiker_id' => 'integer',
            'huidige_status' => 'string',
            'factuurnummer' => 'string',
            'besteldatum' => 'datetime',
            'betaalmethode' => 'string',
            'betaalcode' => 'string',
            'isBetaald' => 'integer',
            'betaaldatum' => 'datetime',
            'btw_percentage' => 'integer',
            'factuuradres' => 'string',
            'afleveradres' => 'string',
            'aflevermethode' => 'string',
            'aflevercode' => 'string',
            'opmerkingen' => 'text',
            'subtotaal_excl' => 'float',
            'korting_excl' => 'float',
            'verzendkosten_excl' => 'float',
            'totaal_excl' => 'float',
            'btw_bedrag' => 'float',
            'totaal_incl' => 'float',
            'created' => 'datetime',
            'modified' => 'datetime'
        );

        var $records = array(

        ); 
    }
 ?>