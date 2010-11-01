<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Varianten op <?php echo $product['Product']['naam']; ?></div>
<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/producten/variant_bewerken/'); ?>';"><span>Variant toevoegen</span></button>
</div>
<ul id="tabs"></ul>
<div class="tab_container">
    <table class="lijst" width="100%">
        <tr>
            <th>Productcode</th>
            <th>Variant</th>
            <th colspan="3">Opties</th>
        </tr>
        <?php
            foreach($this->data as $variant)
            {
                print '<tr class="' . $cw->cycle() . '">';
                print '<td>' . $variant['Productvariant']['productcode'] . '</td>';
                print '<td class="onderwerp">' . $product['Productvariant']['naam'] . '</td>';
                print '<td class="optie-cell">' . $html->link($html->image('dashboard/icons/71.png'), '/admin/producten/variant_bewerken/' . $variant['Productvariant']['id'], array('escape' => false)) . '</td>';
                print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/producten/variant_verwijderen/' . $variant['Productvariant']['id'], array('escape' => false), 'Weet je zeker dat je deze variant wilt verwijderen?') . '</td>';
                print '</tr>';
            }
        ?>
    </table>
</div>