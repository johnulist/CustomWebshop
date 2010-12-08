<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<?php
	echo $javascript->link('tiny_mce/tiny_mce.js', array('inline' => false));
	echo $javascript->link('jquery.tabs.js', array('inline' => false));
	echo $form->create('Pagina', array('class' => 'blok-dataform', 'name' => 'formulier', 'url' => array('action' => $this->action, 'controller' => 'paginas', 'prefix' => 'admin')));
?>

<div class="block-titel">Pagina toevoegen</div>

<div id="cta">
	<button class="save" onclick="document.formulier.submit();';"><span>Opslaan</span></button>
	<button class="cancel" onclick="location.href='<?php echo $html->url('/admin/paginas/'); ?>'; return false;"><span>Annuleren</span></button>
</div>

<ul id="tabs">
	<li class="firsttab"></li>
	<li><a href="#tab_pagina">Algemeen</a></li>
	<li><a href="#tab_seo">SEO</a></li>
</ul>

<script type="text/javascript">
	tinyMCE.init({

		// General options
		mode : "textareas",
		editor_selector : "mceEditor",
		plugins : "paste",
		theme : "advanced",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_buttons3_add : "pastetext,pasteword,selectall",

		height: "500",
        width: "700",

		// CMS die op tekstpaginas van toepassing is
		content_css : "<?php echo $html->url('/css/default.css'); ?>",

    });
</script>

<div class="tab_container">

	<div id="tab_pagina" class="tab_content">
		<?php
			echo $form->input('Pagina.titel');
			echo $form->input('Pagina.parent_id', array('options' => $lijst_paginas, 'empty' => false, 'escape' => false, 'label' => 'Valt onder'));
			echo $form->input('Pagina.gepubliceerd', array('options' => array(0 => 'nee', 1 => 'ja'), 'selected' => 1));
			echo $form->input('Pagina.content', array('class' => 'mceEditor', 'type' => 'textarea', 'label' => 'Inhoud'));
		?>
	</div>

	<div id="tab_seo" class="tab_content">
		<?php
			echo $form->input('Pagina.meta_title', array('type' => 'text', 'label' => 'SEO titel'));
			echo $form->input('Pagina.meta_keywords', array('type' => 'text', 'label' => 'SEO trefwoorden'));
			echo $form->input('Pagina.meta_description', array('type' => 'text', 'label' => 'SEO omschrijving'));
		?>
	</div>

</div>

</form>