<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<h1>Mijn bestellingen</h1>

<table class="lijst" width="100%">
    <tr>
        <th>Bestellingnummer</th>
        <th>Bedrag</th>
        <th>Status</th>
        <th>Opties</th>
    </tr>
    <?php
        foreach($this->data as $bestelling)
        {
            print '<tr class="' . $cw->cycle() . '">';
            print '<td>' . $html->link('Bestelling #' . $bestelling['Bestelling']['id'], '/bestellingen/details/' . $bestelling['Bestelling']['id']) . '</td>';
            print '<td>' . $number->currency($bestelling['Bestelling']['totaal_incl']) . '</td>';
            print '<td>' . $bestelling['Bestelling']['huidige_status'] . '</td>';
            print '<td class="optie-cell">' . $html->link($html->image('dashboard/mime/page_white_acrobat.png'), '/bestellingen/pdf/' . $bestelling['Bestelling']['id'], array('escape' => false)) . '</td>';
            print '</tr>';
        }
    ?>
</table>