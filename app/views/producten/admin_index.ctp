<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Producten</div>
<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/producten/bewerken/'); ?>';"><span>Product toevoegen</span></button>
</div>
<ul id="tabs"></ul>
<div class="tab_container">
    <table class="lijst" width="100%">
        <tr>
            <th>Productcode</th>
            <th>Product</th>
            <th>Merk</th>
            <th colspan="3">Opties</th>
        </tr>
        <?php
            foreach($this->data as $product)
            {
                print '<tr class="' . $cw->cycle() . '">';
                print '<td>' . $product['Product']['productcode'] . '</td>';
                print '<td class="onderwerp">' . $product['Product']['naam'] . '</td>';
                print '<td>' . $product['Merk']['naam'] . '</td>';
                print '<td class="optie-cell">' . $html->link($html->image('dashboard/icons/71.png'), '/admin/producten/bewerken/' . $product['Product']['id'], array('escape' => false)) . '</td>';
                print '<td class="optie-cell">' . $html->link($html->image('dashboard/icons/33.png'), '/admin/producten/varianten/' . $product['Product']['id'], array('escape' => false)) . '</td>';
                print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/producten/verwijderen/' . $product['Product']['id'], array('escape' => false), 'Weet je zeker dat je dit product wilt verwijderen?') . '</td>';
                print '</tr>';
            }
        ?>
    </table>
</div>