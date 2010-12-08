<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div id="merkenfilter">
    <h3>Merken</h3>
    <ul id="pli-merken">
    <?php
        foreach($merken as $merk)
        {
            print '<li>' . $html->link($merk['Merk']['naam'], '/producten/zoeken/merk:' . $merk['Merk']['slug']) . '</li>';
        }
    ?>
    </ul>
</div>