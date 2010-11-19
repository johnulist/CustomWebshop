<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Bestellingen</div>
<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/bestellingen/bewerken/'); ?>';"><span>Bestelling toevoegen</span></button>
</div>
<ul id="tabs"></ul>
<div class="tab_container">
    <table class="lijst" width="100%">
        <tr>
            <th>Bestellingnummer</th>
            <th>Klant</th>
            <th>Bedrag</th>
            <th>Status</th>
            <th colspan="2">Opties</th>
        </tr>
        <?php
            foreach($this->data as $bestelling)
            {
                print '<tr class="' . $cw->cycle() . '">';
                print '<td>' . $bestelling['Bestelling']['id'] . '</td>';
                print '<td class="onderwerp">' . $html->link($bestelling['Gebruiker']['contactpersoon'], '/admin/gebruikers/overzicht/' . $bestelling['Gebruiker']['id']) . '</td>';
                print '<td>' . $number->currency($bestelling['Bestelling']['totaal_incl']) . '</td>';
                print '<td>' . $bestelling['Bestelling']['huidige_status'] . '</td>';
                print '<td class="optie-cell">' . $html->link($html->image('dashboard/icons/71.png'), '/admin/bestellingen/bewerken/' . $bestelling['Bestelling']['id'], array('escape' => false)) . '</td>';
                print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/bestellingen/verwijderen/' . $bestelling['Bestelling']['id'], array('escape' => false), 'Weet je zeker dat je deze gebruiker wilt verwijderen?') . '</td>';
                print '</tr>';
            }
        ?>
    </table>
</div>