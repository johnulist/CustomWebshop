<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Gebruikers</div>
<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/gebruikers/bewerken/'); ?>';"><span>Gebruiker toevoegen</span></button>
</div>
<ul id="tabs"></ul>
<div class="tab_container">
    <form method="post" action="<?php echo $this->here; ?>">
    <table class="lijst" width="100%">
        <tr>
            <th>Naam</th>
            <th>Bedrijf</th>
            <th>Emailadres</th>
            <th>Telefoonnummer</th>
            <th colspan="2">Opties</th>
        </tr>
        <tr class="filter">
            <td><input type="text" name="data[Filter][naam]" value="<?php echo @$naam; ?>" /></td>
            <td><input type="text" name="data[Filter][bedrijf]" value="<?php echo @$bedrijf; ?>" /></td>
            <td colspan="2">
            <td colspan="2" class="submit"><input type="submit" value="Filter" />
        </tr>
        <?php
            foreach($this->data as $gebruiker)
            {
                print '<tr class="' . $cw->cycle() . '">';
                print '<td class="onderwerp">' . $html->link($gebruiker['Gebruiker']['contactpersoon'], '/admin/gebruikers/bewerken/' . $gebruiker['Gebruiker']['id']) . '</td>';
                print '<td>' . $gebruiker['Gebruiker']['bedrijfsnaam'] . '</td>';
                print '<td>' . $gebruiker['Gebruiker']['emailadres'] . '</td>';
                print '<td>' . $gebruiker['Gebruiker']['telefoon'] . '</td>';
                print '<td class="optie-cell">' . $html->link($html->image('dashboard/icons/71.png'), '/admin/gebruikers/bewerken/' . $gebruiker['Gebruiker']['id'], array('escape' => false)) . '</td>';
                print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/gebruikers/verwijderen/' . $gebruiker['Gebruiker']['id'], array('escape' => false), 'Weet je zeker dat je deze gebruiker wilt verwijderen?') . '</td>';
                print '</tr>';
            }
        ?>
    </table>
    </form>
</div>