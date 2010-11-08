<?php
    class Attributenset extends AppModel
    {
        var $useTable = 'attributensets';
        var $displayField = 'naam';
        
        var $hasMany = array('Attribuut' => array('foreignKey' => 'attributenset_id'));
    }
?>