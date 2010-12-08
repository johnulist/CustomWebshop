<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div id="gebruikersmenu">
    <h3>Mijn Shop</h3>
    <ul>
        <li><?php echo $html->link('Mijn bestellingen', '/bestellingen/'); ?></li>
        <li><?php echo $html->link('Profiel', '/gebruikers/profiel/'); ?></li>

        <?php
            if($params['gebruiker']['isBeheerder'])
            {
                print '<li>' . $html->link('Beheer', '/admin/') . '</li>';
            }
        ?>
        <li><?php echo $html->link('Uitloggen', '/gebruikers/uitloggen/'); ?></li>
    </ul>
</div>