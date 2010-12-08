<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Bestelling #<?php echo $this->data['Bestelling']['id']; ?></div>
<div id="cta">
	<button class="save" onclick="document.formulier.submit();"><span>Factureren</span></button>
	<button class="cancel" onclick="location.href='<?php echo $html->url('/admin/bestellingen/'); ?>'; return false;"><span>Annuleren</span></button>
</div>
<ul id="tabs"></ul>
<div class="tab_container">

    <?php
         echo $form->create('Gebruiker', array('class' => 'blok-dataform', 'name' => 'formulier', 'url' => array('action' => $this->action, 'controller' => 'bestellingen', 'prefix' => 'admin', $this->data['Bestelling']['id'])));

         echo $form->input('Bestelling.factuurnummer');
         echo $form->input('Bestelling.email_klant', array('options' => array(1 => 'Per email versturen naar de klant', 0 => 'Nu niet versturen'), 'label' => 'Factuur'));

         echo $form->end();
    ?>

</div>