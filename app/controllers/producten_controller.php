<?php
    /**
     * Controller voor producten
     */
    class ProductenController extends AppController 
    {
        var $uses = array();
        var $name = 'Producten';

        function beforeFilter()
        {
            parent::beforeFilter();
            $this->Auth->allow('toon_via_slug');
        }

        /**
         * Toont een overzicht van producten in een categorie,
         * waarbij de categorie wordt gebaseerd op de url in
         * combinatie met de opgeslagen slugs.
         */
        function toon_via_slug()
        {

        }
    }
?>
