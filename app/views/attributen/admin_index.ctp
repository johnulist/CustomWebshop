<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Attributensets</div>
<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/attributen/set_bewerken/'); ?>';"><span>Attributenset toevoegen</span></button>
</div>
<ul id="tabs"></ul>
<div class="tab_container">
    <table class="lijst" width="100%">
        <tr>
            <th>Set</th>
            <th>Attributen</th>
            <th colspan="3">Opties</th>
        </tr>
        <?php
            foreach($this->data as $set)
            {
                $attributen = Set::extract('/Attribuut/naam', $set);
                
                print '<tr class="' . $cw->cycle() . '">';
                print '<td class="onderwerp">' . $set['Attributenset']['naam'] . '</td>';
                print '<td>' . implode($attributen,",") . '</td>';
                print '<td class="optie-cell">' . $html->link($html->image('dashboard/icons/71.png'), '/admin/attributen/set_bewerken/' . $set['Attributenset']['id'], array('escape' => false)) . '</td>';
                print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/attributen/set_verwijderen/' . $set['Attributenset']['id'], array('escape' => false), 'Weet je zeker dat je deze set wilt verwijderen?') . '</td>';
                print '</tr>';
            }
        ?>
    </table>
</div>