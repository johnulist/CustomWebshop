<?php
    class Merk extends AppModel
    {
        var $name = 'Merk';
        var $actsAs = array('Slug' => array('separator' => '-', 'overwrite' => true, 'label' => 'naam'));
        var $useTable = 'merken';
        var $displayField = 'naam';

        var $hasMany = array(
            'Product' => array(
                'counterCache' => 'count_producten'
            )
        );
    }
 ?>