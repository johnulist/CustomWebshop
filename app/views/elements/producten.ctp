<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */

    // titel
    echo '<h1 id="pli-titel">' . $categorie . '</h1>';

    // aantal producten
    echo '<h2 id="prod_count">(' . $paginator->counter(array('format' => '%count%')) . ' producten)' . '</h2>';

    foreach($data as $product)
    {
        print '<div class="product-list-item list-item-' . $cw->cycle() . '">';

            // afbeelding
            print '<div class="pli-afbeelding">';
            if(count($product['Productafbeelding']) > 0)
            {
                print $html->link($image->resize($product['Productafbeelding'][0]['bestandsnaam'], 120, 90), '/producten/details/' . $product['Product']['slug'] . '/' . $product['Product']['id'], array('escape' => false));
            }
            print '</div>';

            // titel
            print '<div class="pli-titel">' . $html->link($product['Product']['naam'], '/producten/details/' . $product['Product']['slug'] . '/' . $product['Product']['id']) . '</div>';

            // knoppen
            print '<div class="pli-btn-bestel">' . $html->link('bestellen','/producten/bestellen/' . $product['Product']['id'], array('escape' => false)) . '</div>';
            print '<div class="pli-btn-details">' . $html->link('details','/producten/details/' . $product['Product']['slug'] . '/' . $product['Product']['id'] , array('escape' => false)) . '</div>';

            // van-prijs en voor-prijs tonen indien een aanbieding, anders alleen verkoopprijs
            if(!is_null($product['Product']['aanbiedingsprijs']) && $product['Product']['aanbiedingsprijs'] < $product['Product']['verkoopprijs'])
            {
                print '<div class="pli-van-prijs">' . $number->currency($product['Product']['verkoopprijs']) . '</div>';
                print '<div class="pli-voor-prijs">' . $number->currency($product['Product']['aanbiedingsprijs']) . '</div>';
            }
            else
            {
                print '<div class="pli-voor-prijs">' . $number->currency($product['Product']['verkoopprijs']) . '</div>';
            }

        print '<div class="clear"></div>';
        print '</div>';
    }

    echo $paginator->numbers();
?>