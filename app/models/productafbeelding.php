<?php
    class Productafbeelding extends AppModel
    {
        var $name = 'Productafbeelding';
        var $useTable = 'productafbeeldingen';
        
        // Relaties met andere modellen
        var $belongsTo = array('Product');
    }
 ?>