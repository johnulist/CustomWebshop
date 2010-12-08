<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Product toevoegen</div>

<div id="cta">
	<button class="save" onclick="document.formulier.submit();"><span>Opslaan</span></button>
	<button class="cancel" onclick="location.href='<?php echo $html->url('/admin/producten/'); ?>'; return false;"><span>Annuleren</span></button>
</div>

<ul id="tabs">
	<li class="firsttab"></li>
	<li><a href="#tab_algemeen">Algemeen</a></li>
    <li><a href="#tab_attributen">Attributen</a></li>
    <li><a href="#tab_prijs">Prijs &amp; voorraad</a></li>
	<li><a href="#tab_seo">SEO</a></li>
    <li><a href="#tab_afbeeldingen">Afbeeldingen</a></li>
</ul>

<?php
    // Custom Javascript
	echo $javascript->link('tiny_mce/tiny_mce.js', array('inline' => false));
	echo $javascript->link('jquery.tabs.js', array('inline' => false));

    // Begin formulier
    echo $form->create('Product', array('class' => 'blok-dataform', 'name' => 'formulier', 'url' => array('action' => $this->action, 'controller' => 'producten', 'prefix' => 'admin'), 'type' => 'file'));
    echo '<div class="tab_container">';

    // Tab algemeen
    echo '<div id="tab_algemeen" class="tab_content">';
    echo $form->input('Product.productcode');
    echo $form->input('Product.naam');
    echo $form->input('Product.beschikbaar', array('options' => array(0 => 'nee', 1 => 'ja'), 'label' => 'Toon in shop?'));
    echo $form->input('Product.merk_id', array('options' => $merken));
    echo $form->input('Categorie', array('type' => 'select', 'multiple' => true, 'options' => $categorien, 'escape' => false));
    
    echo $form->input('Product.omschrijving_kort', array('type' => 'textarea', 'style' => 'height: 200px; width: 500px;'));
    echo $form->input('Product.omschrijving_lang', array('type' => 'textarea', 'style' => 'height: 600px; width: 500px;'));
    
    echo '</div>';

    // Tab attributen
    echo '<div id="tab_attributen" class="tab_content">';
    echo $form->input('Product.attributenset_id', array('options' => $attributensets, 'empty' => __('- kies een set -', true)));
    echo '</div>';

    // Tab prijs en voorraad
    echo '<div id="tab_prijs" class="tab_content">';
    echo $form->input('Product.voorraad');
    echo $form->input('Product.levertijd', array('style' => 'width: 50px;', 'after' => $form->select('Product.levereenheid', array('weken' => 'weken', 'dagen' => 'dagen'), 'dag', array('empty' => false))));
    echo $form->input('Product.inkoopprijs');
    echo $form->input('Product.verkoopprijs');
    echo $form->input('Product.aanbiedingsprijs');
    echo $form->input('Product.btw', array('value' => 19));
    echo '</div>';

    // Tab SEO
    echo '<div id="tab_seo" class="tab_content">';
    echo $form->input('Product.meta_title');
    echo $form->input('Product.meta_keywords');
    echo $form->input('Product.meta_description');
    echo '</div>';

    // Tab afbeeldingen
    echo '<div id="tab_afbeeldingen" class="tab_content">';
    echo $form->input('Afbeelding.data', array('label' => 'Upload een afbeelding', 'type' => 'file'));

    if(isset($this->data['Productafbeelding']))
    {
        foreach($this->data['Productafbeelding'] as $afbeelding)
        {
            echo '<div class="afbeelding">';
            echo $image->resizeAndCrop($afbeelding['bestandsnaam'], 200, 150);
            echo $html->link('als hoofdafbeelding', '/admin/producten/hoofdafbeelding/' . $afbeelding['id'], array('class' => 'hoofd', 'escape' => false));
            echo $html->link('verwijderen', '/admin/producten/afbeelding_verwijderen/' . $afbeelding['id'], array('class' => 'del', 'escape' => false), 'Weet je zeker dat je deze afbeelding wilt verwijderen?');
            echo '</div>';
        }        
    }
    
    echo '</div>';

    // Einde formulier
    echo '</div>';
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