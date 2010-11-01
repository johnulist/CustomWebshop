<?php
    class Instelling extends AppModel
    {
        var $useTable = 'instellingen';

        /**
         * Laadt algemene configuratie uit de database
         * in de shop.
         */
        function load()
        {
            $instellingen = $this->find('all');

			foreach ($instellingen as $variabele)
			{
			 	Configure::write($variabele['Instelling']['key'], $variabele['Instelling']['value']);
			}
        }
    }
?>