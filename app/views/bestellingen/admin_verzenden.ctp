<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Bestellingmail verzenden</div>

<div id="cta">
	<button class="save" onclick="document.formulier.submit();"><span>Verzenden</span></button>
	<button class="cancel" onclick="location.href='<?php echo $html->url('/admin/bestellingen/bewerken/' . $this->data['Bestelling']['id']); ?>'; return false;"><span>Annuleren</span></button>
</div>

<ul id="tabs">
</ul>

<p>U staat op het punt om een emailbericht te versturen met daarbij een overzicht van deze bestelling. Wijzig indien van toepassing hieronder de begeleidende tekst voor de bestelling.</p>
<?php
    echo $form->create('Bestelling', array('class' => 'blok-dataform', 'name' => 'formulier', 'url' => array('action' => 'verzenden', 'controller' => 'bestellingen', 'prefix' => 'admin', $this->data['Bestelling']['id'])));
    echo $form->hidden('Bestelling.id');
    echo $form->input('Gebruiker.emailadres');
    echo $form->input('Bevestiging.bericht', array('type' => 'textarea', 'label' => 'Verzendbericht'));
    echo $form->end();
?>