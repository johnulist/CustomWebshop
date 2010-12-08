<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<h1>U bent geregistreerd!</h1>
<p>Bedankt voor uw registratie! U kunt nu inloggen om uw bestellingen en profiel te kunnen bekijken.</p>
<p><?php echo $html->link('Naar het inlogformulier &raquo;', '/gebruikers/inloggen/', array('escape' => false)); ?>