<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */

    echo '<table id="winkelwagen-inhoud">';
    echo '<tr class="ww-list-th"><th>Aantal</th><th>Product</th><th>Prijs</th><th>Totaal</th></tr>';

    foreach($params['winkelwagen']['producten'] as $product_id => $product)
    {
        print '<tr class="' . $cw->cycle() . ' ww-list-item">';

            // titel
            print '<td class="wli-aantal">' . $product['aantal'] . '</td>';
            print '<td class="wli-titel">' . $product['product']['naam'] . '</td>';
            print '<td class="wli-aantal">' . $product['product']['prijs'] . '</td>';
            print '<td class="wli-aantal">' . ($product['aantal'] * $product['product']['prijs']) . '</td>';

        print '</tr>';
    }
    echo '</table>';
?>