<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */

    echo $form->hidden("Bestelling.verzendkosten_btw");

    echo '<table width="100%" id="winkelwagen-inhoud">';
    echo '<tr class="ww-list-th"><th>Aantal</th><th>Product</th><th>Prijs</th><th>Totaal (excl.)</th></tr>';

    $btw = array(0 => 0, 6 => 0, 19 => 0);
    $btw_totaal = 0;
    foreach($this->data['Bestelregel'] as $i => $regel)
    {
        $btw[$regel['Product']['btw']] += $regel['totaal_btw'];
        $btw_totaal += $regel['totaal_btw'];

        print $form->hidden("Bestelregel.$i.id", array('value' => $regel['id'])) . "\n";
        print $form->hidden("Bestelregel.$i.btw_percentage", array('value' => $regel['btw_percentage'])) . "\n";
        print '<tr class="' . $cw->cycle() . ' ww-list-item">';

            // titel
            print '<td class="wli-aantal">' . $form->text("Bestelregel.$i.aantal", array('value' => $regel['aantal'])) . '</td>';
            print '<td class="wli-titel">' .  $regel['Product']['naam'] . '</td>';
            print '<td class="wli-aantal">' . $number->currency($regel['prijs_excl']) . '</td>';
            print '<td class="wli-aantal">' . $form->text("Bestelregel.$i.totaal_excl", array('value' => $regel['totaal_excl'])) . '</td>';

        print '</tr>' . "\n";
    }

    print '<tr id="nieuwproduct"><td colspan="4"><a href="#" id="addBestelregel" onclick="alert(\'deze functie is nog niet actief\'); return false;">product toevoegen</a></td></tr>';

    if($btw_totaal != $this->data['Bestelling']['subtotaal_btw'])
    {
        print '<tr><td colspan="4"><b>Let op! De BTW over de producten komt niet overeen met de totale BTW! Nu herberekenen.</b></td></tr>';
    }

    echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">Subtotaal</td><td>' . $number->currency($this->data['Bestelling']['subtotaal_excl']) . '</td></tr>';

    if(!empty($this->data['Bestelling']['verzendkosten_excl']))
    {
        echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">Verzendkosten</td><td>' . $number->currency($this->data['Bestelling']['verzendkosten_excl']) . '</td></tr>';
        
        foreach($btw as $percentage => $bedrag)
        {
            if($bedrag > 0)
            {
                echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">BTW ' . $percentage . '%</td><td>' . $number->currency($bedrag) . '</td></tr>';
            }
        }
        echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">Totaal</td><td>' . $number->currency($this->data['Bestelling']['totaal_incl']) . '</td></tr>';
    }
    else
    {
        echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">BTW</td><td>' . $number->currency($this->data['Bestelling']['btw_bedrag']) . '</td></tr>';
        echo '<tr class="ww-totalen"><td colspan="2"><td class="ww-totalen-label">Totaal</td><td>' . $number->currency($this->data['Bestelling']['totaal_incl']) . '</td></tr>';
    }



    echo '</table>';
?>