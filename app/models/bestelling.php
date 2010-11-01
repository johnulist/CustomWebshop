<?php
    class Bestelling extends AppModel
    {
        var $useTable = 'bestellingen';
        var $belongsTo = array('Gebruiker');
    }
?>