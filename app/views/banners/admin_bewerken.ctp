<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Banner bewerken</div>

<div id="cta">
	<button class="add" onclick="document.formulier.submit();"><span>Opslaan</span></button>
	<button class="add" onclick="location.href='/admin/banners/'; return false;"><span>Annuleren</span></button>
</div>

<ul id="tabs">
	
</ul>

<div class="tab_container">

    <p>Kies een bestand om toe te voegen aan de lijst met banners. Alle actieve banners worden gebruikt in de diaafbeelding op de voorpagina van de webshop.</p>

    <?php
        echo $form->create('Banner', array('class' => 'blok-dataform', 'type' => 'file', 'name' => 'formulier', 'url' => array('action' => $this->action, 'controller' => 'banners', 'prefix' => 'admin')));
        echo $form->input('Banner.file', array('type' => 'file'));
        echo $form->input('Banner.url');
        echo $form->input('Banner.tekst');
        echo $form->input('Banner.actief', array('options' => array(1 => 'ja', 0 => 'nee')));
        echo $form->end();
    ?>

</div>
</form>