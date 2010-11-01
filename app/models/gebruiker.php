<?php
    class Gebruiker extends AppModel
    {
        var $useTable = 'gebruikers';
        var $hasMany = array('Bestelling' => array('counterCache' => 'count_bestellingen'));
    }
?>