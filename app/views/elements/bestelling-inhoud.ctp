<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */

    echo $form->hidden("Levermethode.btw");

    echo '<table width="100%" id="winkelwagen-inhoud">';
    echo '<tr class="ww-list-th"><th width="150">Aantal</th><th width="150">Artikelcode</th><th>Product</th><th width="150">Prijs</th><th width="150">Totaal (excl.)</th><th width="150"></th></tr>';

    $btw = array(0 => 0, 6 => 0, 19 => 0);
    $btw_totaal = 0;
    foreach($this->data['Bestelregel'] as $i => $regel)
    {
        $regel['totaal_btw'] = $regel['totaal_btw'] * (1 - ($this->data['Bestelling']['korting_percentage'] / 100));
        $btw[$regel['Product']['btw']] += $regel['totaal_btw'];
        $btw_totaal += $regel['totaal_btw'];

        print $form->hidden("Bestelregel.$i.id", array('value' => $regel['id'])) . "\n";
        print $form->hidden("Bestelregel.$i.btw_percentage", array('value' => $regel['btw_percentage'])) . "\n";
        print '<tr class="' . $cw->cycle() . ' ww-list-item">';

            // titel
            print '<td class="wli-aantal">' . $form->text("Bestelregel.$i.aantal", array('value' => $regel['aantal'])) . '</td>';
            print '<td class="wli-titel">' .  $regel['Product']['productcode'] . '</td>';
            print '<td class="wli-titel">' .  $regel['Product']['naam'] . '</td>';
            print '<td class="wli-aantal">' . $number->currency($regel['prijs_excl']) . '</td>';
            print '<td class="wli-aantal">' . $form->text("Bestelregel.$i.totaal_excl", array('value' => $regel['totaal_excl'])) . '</td>';
            print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/bestellingen/regel_verwijderen/' . $regel['id'], array('escape' => false), 'Weet je zeker dat je deze regel wilt verwijderen?') . '</td>';
            
        print '</tr>' . "\n";
    }

    print '<tr id="nieuwproduct"><td colspan="6"><a href="#" id="addBestelregel">nieuw product toevoegen</a></td></tr>';

    if(round($btw_totaal, 2) != round($this->data['Bestelling']['subtotaal_btw'], 2))
    {
        print '<tr><td colspan="3"><b>Let op! De BTW over de producten komt niet overeen met de totale BTW! (' . $btw_totaal . ' != ' . $this->data['Bestelling']['subtotaal_btw'] . ')</b></td><td></td></tr>';
    }

    echo '<tr class="ww-totalen"><td colspan="3"></td><td class="ww-totalen-korting">Korting (excl.)</td><td>' . $form->text('Bestelling.korting_excl') . '</td><td></td></tr>';
    echo '<tr class="ww-totalen"><td colspan="3"></td><td class="ww-totalen-label">Subtotaal</td><td>' . $number->currency($this->data['Bestelling']['subtotaal_excl']) . '</td><td></td></tr>';

    if(!empty($this->data['Bestelling']['verzendkosten_excl']))
    {
        $btw[19] += $this->data['Bestelling']['verzendkosten_btw'];
        echo '<tr class="ww-totalen"><td colspan="3"></td><td class="ww-totalen-label">Verzendkosten (excl.)</td><td>' . $number->currency($this->data['Bestelling']['verzendkosten_excl']) . '</td><td></td></tr>';
        echo '<tr><td colspan="6">&nbsp;</td></tr>';

        foreach($btw as $percentage => $bedrag)
        {
            if($bedrag > 0)
            {
                echo '<tr class="ww-totalen"><td colspan="3"></td><td class="ww-totalen-label">BTW ' . $percentage . '%</td><td>' . $number->currency($bedrag) . '</td><td></td></tr>';
            }
        }
    }
    else
    {
        echo '<tr><td colspan="6">&nbsp;</td></tr>';
        echo '<tr class="ww-totalen"><td colspan="3"></td><td class="ww-totalen-label">BTW</td><td>' . $number->currency($this->data['Bestelling']['btw_bedrag']) . '</td><td></td></tr>';
    }

    echo '<tr class="ww-totalen"><td colspan="3"></td><td class="ww-totalen-label">Totaal</td><td>' . $number->currency($this->data['Bestelling']['totaal_incl']) . '</td><td></td></tr>';

    echo '</table>';
?>

<?php echo $html->script('jquery.colorbox-min', array('inline' => false)); ?>
<script type="text/javascript">

    $(document).ready(function(){
        $('#addBestelregel').colorbox({opacity: 0.4,href:"<?php echo $html->url('/admin/bestellingen/nieuw_product/' . $this->data['Bestelling']['id']); ?>"});
    });

</script>