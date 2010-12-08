<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Merken</div>
<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/merken/toevoegen/'); ?>';"><span>Merk toevoegen</span></button>
</div>
<ul id="tabs"></ul>
<div class="tab_container">
    <table class="lijst" width="100%">
        <tr>
            <th>Merk</th>
            <th>Tonen in menu?</th>
            <th colspan="2">Opties</th>
        </tr>
        <?php
            foreach($this->data as $merk)
            {
                print '<tr class="' . $cw->cycle() . '">';
                print '<td>' . $merk['Merk']['naam'] . '</td>';
                print '<td>' . ($merk['Merk']['flagToonInMenu'] ? 'ja' : 'nee') . '</td>';
                print '<td class="optie-cell">' . $html->link($html->image('dashboard/icons/71.png'), '/admin/merken/bewerken/' . $merk['Merk']['id'], array('escape' => false)) . '</td>';
                print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/merken/verwijderen/' . $merk['Merk']['id'], array('escape' => false), 'Weet je zeker dat je dit merk wilt verwijderen?') . '</td>';
                print '</tr>';
            }
        ?>
    </table>
</div>