<?php
    class Bestelregel extends AppModel
    {
        var $useTable = 'bestelregels';
        var $belongsTo = array(
                            'Bestelling' => array('foreignKey' => 'bestelling_id'),
                            'Product' => array('foreignKey' => 'product_id')
                        );
    }
?>