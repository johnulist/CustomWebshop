<?php
    class Productvariant extends AppModel
    {
        var $name = 'Productvariant';
        var $useTable = 'productvarianten';
        var $actsAs = array('Slug' => array('separator' => '-', 'overwrite' => true, 'label' => 'naam'));

        // Relaties met andere modellen
        var $belongsTo = array('Product');
    }
 ?>