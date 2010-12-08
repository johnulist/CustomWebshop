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
    <form method="post" action="<?php echo $this->here; ?>">
    <table class="lijst" width="100%">
        <tr>
            <th>Productcode</th>
            <th>Product</th>
            <th>Merk</th>
            <th>Tonen in shop?</th>
            <th colspan="3">Opties</th>
        </tr>
        <tr class="filter">
            <td><input size="10" type="text" name="data[Filter][productcode]" value="<?php echo @$code; ?>" /></td>
            <td><input type="text" name="data[Filter][product]" value="<?php echo @$product; ?>" /></td>
            <td><input type="text" name="data[Filter][merk]" value="<?php echo @$merk; ?>"/></td>
            <td>
                <select name="data[Filter][beschikbaar]">
                    <option value="">beide</option>
                    <option value="1">ja</option>
                    <option value="0">nee</option>
                </select>
            </td>
            <td colspan="3" class="submit"><input type="submit" value="Filter" />
        </tr>
        <?php
            foreach($this->data as $product)
            {
                print '<tr class="' . $cw->cycle() . '">';
                print '<td width="140" nowrap="nowrap">' . $product['Product']['productcode'] . '</td>';
                print '<td class="onderwerp">' . $html->link($product['Product']['naam'], '/admin/producten/bewerken/' . $product['Product']['id'], array('escape' => false)) . '</td>';
                print '<td nowrap="nowrap">' . $product['Merk']['naam'] . '</td>';
                print '<td>' . ($product['Product']['beschikbaar'] ? 'ja' : 'nee') . '</td>';
                print '<td nowrap="nowrap" class="optie-cell">' . $html->link($html->image('dashboard/icons/71.png'), '/admin/producten/bewerken/' . $product['Product']['id'], array('escape' => false)) . '</td>';
                print '<td nowrap="nowrap" class="optie-cell">' . $html->link($html->image('dashboard/icons/33.png'), '/admin/producten/varianten/' . $product['Product']['id'], array('escape' => false)) . '</td>';
                print '<td nowrap="nowrap" class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/producten/verwijderen/' . $product['Product']['id'], array('escape' => false), 'Weet je zeker dat je dit product wilt verwijderen?') . '</td>';
                print '</tr>';
            }
        ?>
    </table>
    </form>
</div>