<?php
    class Bestelstatus extends AppModel
    {
        var $useTable = 'bestelstatussen';
        var $belongsTo = array('Bestelling' => array('foreignKey' => 'bestelling_id'));
    }
?>