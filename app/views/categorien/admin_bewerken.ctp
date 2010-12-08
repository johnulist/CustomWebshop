<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Categorie toevoegen</div>

<div id="cta">
	<button class="save" onclick="document.formulier.submit();"><span>Opslaan</span></button>
	<button class="cancel" onclick="location.href='<?php echo $html->url('/admin/categorien/'); ?>'; return false;"><span>Annuleren</span></button>
</div>

<ul id="tabs">
	<li class="firsttab"></li>
	<li><a href="#tab_algemeen">Algemeen</a></li>
    <li><a href="#tab_seo">SEO</a></li>
</ul>



<?php
    // custom javascript
    echo $javascript->link('tiny_mce/tiny_mce.js', array('inline' => false));
	echo $javascript->link('jquery.tabs.js', array('inline' => false));

    echo $form->create('Categorie', array('class' => 'blok-dataform', 'name' => 'formulier', 'url' => array('action' => 'bewerken', 'controller' => 'categorien', 'prefix' => 'admin')));
    echo '<div class="tab_container">';

    // Tab algemeen
    echo '<div id="tab_algemeen" class="tab_content">';
    echo $form->input('Categorie.naam');
    echo $form->input('Categorie.parent_id', array('label' => 'Bovenliggende categorie', 'options' => $lijst_categorien, 'empty' => '= kies parent of laat leeg =', 'escape' => false));
    echo $form->input('Categorie.omschrijving');
    
    echo '</div>';

    // Tab SEO
    echo '<div id="tab_seo" class="tab_content">';
    echo $form->input('Categorie.meta_title');
    echo $form->input('Categorie.meta_keywords');
    echo $form->input('Categorie.meta_description');
    echo '</div>';

    echo '</div>';
    echo $form->end();
?>

<script type="text/javascript">
    tinyMCE.init({
        theme : "advanced",
        mode : "textareas",
        plugins : "ibrowser",
        content_css : "<?php echo $html->url('/css/default.css'); ?>",
        theme_advanced_toolbar_location : 'top',
        theme_advanced_buttons3_add : "ibrowser",
        theme_advanced_toolbar_align : "left",
        convert_urls : false
    });
</script>