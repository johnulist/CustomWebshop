<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Merk toevoegen</div>

<div id="cta">
	<button class="save" onclick="document.formulier.submit();"><span>Opslaan</span></button>
	<button class="cancel" onclick="location.href='<?php echo $html->url('/admin/merken/'); ?>'; return false;"><span>Annuleren</span></button>
</div>

<ul id="tabs"></ul>

<?php
    echo $form->create('Merk', array('class' => 'blok-dataform', 'name' => 'formulier', 'url' => array('action' => 'bewerken', 'controller' => 'merken', 'prefix' => 'admin')));
    echo $form->hidden('Merk.id');
    echo $form->input('Merk.naam');
    echo $form->input('Merk.flagToonInMenu', array('label' => 'Tonen in menu', 'options' => array(1 => 'ja', 0 => 'nee')));
    echo $form->end();
?>