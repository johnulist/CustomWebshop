<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div id="winkelwagen">
    <div id="account">
        <?php
            if($params['isIngelogd'])
            {
                echo 'Welkom ' . $html->link($params['gebruiker']['contactpersoon'], '/gebruikers/dashboard/');
            }
            else
            {
                echo $html->link('Inloggen', '/gebruikers/inloggen/');
                echo ' | ';
                echo $html->link('Aanmelden', '/gebruikers/registreren/');
            }
        ?>
    </div>
    <h3>Winkelwagen</h3>
    <div id="inhoud">Items: <?php echo $params['winkelwagen']['aantal']; ?> | Totaal: <?php echo $number->currency($params['winkelwagen']['totaal']); ?></div>
</div>