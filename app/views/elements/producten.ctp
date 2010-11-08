<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */

    // titel en aantal producten
    echo '<h1>' . $categorie . '</h1>';
    echo '<h2 id="prod_count">(' . $paginator->counter(array('format' => '%count%')) . ' producten)' . '</h2>';
    
    foreach($data as $product)
    {
        print '<div class="product-list-item">';

            // titel
            print '<div class="pli-titel">' . $product['Product']['naam'] . '</div>';

            // afbeelding
            if(count($product['Productafbeelding']) > 0)
            {
                print '<div class="pli-afbeelding">' . $image->resize($product['Productafbeelding'][0]['bestandsnaam'], 120, 90) . '</div>';
            }

            // van-prijs en voor-prijs tonen indien een aanbieding, anders alleen verkoopprijs
            if(!is_null($product['Product']['aanbiedingsprijs']) && $product['Product']['aanbiedingsprijs'] < $product['Product']['verkoopprijs'])
            {
                print '<div class="pli-van-prijs">' . $product['Product']['verkoopprijs'] . '</div>';
                print '<div class="pli-voor-prijs">' . $product['Product']['aanbiedingsprijs'] . '</div>';
            }
            else
            {
                print '<div class="pli-voor-prijs">' . $product['Product']['verkoopprijs'] . '</div>';
            }

            // knoppen
            print '<div class="pli-btn-bestel">' . $html->link('bestellen','/producten/bestellen/' . $product['Product']['id'], array('escape' => false)) . '</div>';
            print '<div class="pli-btn-details">' . $html->link('details','/producten/details/' . $product['Product']['slug'] . '/' . $product['Product']['id'] , array('escape' => false)) . '</div>';

        print '</div>';
    }

    echo $paginator->numbers();
?>