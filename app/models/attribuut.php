<?php
    class Attribuut extends AppModel
    {
        var $useTable = 'attributen';
        var $belongsTo = array('Attributenset' => array('foreignKey' => 'attributenset_id'));
    }
?>