<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Facturen</div>
<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/facturen/bewerken/'); ?>';"><span>Factuur toevoegen</span></button>
</div>
<ul id="tabs"></ul>

<div class="tab_container">
    <form method="post" action="<?php echo $this->here; ?>">
    <table class="lijst" width="100%">
        <tr>
            <th><?php echo $paginator->sort('Factuurnummer', 'Bestelling.factuurnummer'); ?></th>
            <th><?php echo $paginator->sort('Factuurdatum', 'Bestelling.factuurdatum'); ?></th>
            <th>Klant</th>
            <th>Bedrijf</th>
            <th><?php echo $paginator->sort('Bedrag', 'Bestelling.totaal_incl'); ?></th>
            <th><?php echo $paginator->sort('Voldaan', 'Bestelling.isBetaald'); ?></th>
            <th>Status</th>
            <th colspan="3">Opties</th>
        </tr>
        <tr class="filter">
            <td><input size="6" type="text" name="data[Filter][factuurnummer]" /></td>
            <td colspan="4">
                van <input type="text" name="data[Filter][start]" value="<?php echo @$cw->datum($start, "%d-%m-%Y"); ?>" />
                tot <input type="text" name="data[Filter][einde]" value="<?php echo @$cw->datum($einde, "%d-%m-%Y"); ?>" />
            </td>
            <td colspan="2">
                <select name="data[Filter][isBetaald]">
                    <option value="">beide</option>
                    <option value="1">voldaan</option>
                    <option value="0">niet voldaan</option>
                </select>
            </td>
            <td colspan="3" class="submit"><input type="submit" value="Filter" />
        </tr>
        <?php
            foreach($this->data as $bestelling)
            {
                $overtijdClass = ($bestelling['Bestelling']['isOverTijd'] ? ' over-tijd' : '');
                
                print '<tr class="' . $cw->cycle() . $overtijdClass . '">';
                print '<td>' . $html->link($bestelling['Bestelling']['factuurnummer'], '/admin/bestellingen/bewerken/' . $bestelling['Bestelling']['id']) . '</td>';
                print '<td>' . $cw->datum($bestelling['Bestelling']['factuurdatum'], "%d-%m-%Y") . '</td>';
                print '<td class="onderwerp">' . $html->link($bestelling['Gebruiker']['contactpersoon'], '/admin/gebruikers/bewerken/' . $bestelling['Gebruiker']['id']) . '</td>';
                print '<td>' . $bestelling['Gebruiker']['bedrijfsnaam'] . '</td>';
                print '<td>' . $number->currency($bestelling['Bestelling']['totaal_incl']) . '</td>';

                // Voldaan? Indien niet voldaan en overtijd: link naar herinnering
                print '<td>';
                if($bestelling['Bestelling']['isBetaald'])
                {
                    print 'ja';
                }
                else
                {
                    print 'nee';
                    if($bestelling['Bestelling']['isOverTijd'])
                    {
                        print ' ';
                        print $html->link($html->image('dashboard/icons/email_go.png', array('alt' => 'herinnering')),'/admin/facturen/herinnering/' . $bestelling['Bestelling']['id'], array('escape' => false, 'title' => 'Stuur een herinnering'));
                    }
                }
                print "</td>";


                print '<td>' . $bestelling['Bestelling']['huidige_status'] . '</td>';
                print '<td class="optie-cell">' . $html->link($html->image('dashboard/icons/71.png'), '/admin/bestellingen/bewerken/' . $bestelling['Bestelling']['id'], array('escape' => false)) . '</td>';
                print '<td class="optie-cell">' . $html->link($html->image('dashboard/mime/page_white_acrobat.png'), '/bestellingen/pdf/' . $bestelling['Bestelling']['id'], array('escape' => false)) . '</td>';
                print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/facturen/verwijderen/' . $bestelling['Bestelling']['id'], array('escape' => false), 'Weet je zeker dat je deze gebruiker wilt verwijderen?') . '</td>';
                print '</tr>';
            }
        ?>
    </table>
    </form>
</div>