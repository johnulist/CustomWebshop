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
            print '<td class="wli-titel">' .  $product['product']['naam'] . '</td>';
            print '<td class="wli-aantal">' . $number->currency($product['product']['prijs']) . '</td>';
            print '<td class="wli-aantal">' . $number->currency(($product['aantal'] * $product['product']['prijs'])) . '</td>';

        print '</tr>';
    }

    echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">Subtotaal</td><td>' . $number->currency($params['winkelwagen']['totaal']) . '</td></tr>';
    
    if(isset($params['winkelwagen']['verzendkosten_excl']))
    {
        echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">Verzendkosten</td><td>' . $number->currency($params['winkelwagen']['verzendkosten_excl']) . '</td></tr>';
        echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">BTW</td><td>' . $number->currency($params['winkelwagen']['btw_totaal']) . '</td></tr>';
        echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">Totaal</td><td>' . $number->currency($params['winkelwagen']['totaal'] + $params['winkelwagen']['btw_totaal'] + $params['winkelwagen']['verzendkosten_excl']) . '</td></tr>';
    }
    else
    {
        echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">BTW</td><td>' . $number->currency($params['winkelwagen']['btw']) . '</td></tr>';
        echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">Totaal</td><td>' . $number->currency($params['winkelwagen']['totaal'] + $params['winkelwagen']['btw']) . '</td></tr>';
    }
    
    

    echo '</table>';
?>