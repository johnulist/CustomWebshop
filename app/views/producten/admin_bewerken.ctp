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
    <li><a href="#tab_prijs">Prijs &amp; voorraad</a></li>
	<li><a href="#tab_seo">SEO</a></li>
    <li><a href="#tab_afbeeldingen">Afbeeldingen</a></li>
</ul>

<?php
    // Custom Javascript
	echo $javascript->link('tiny_mce/tiny_mce.js', array('inline' => false));
	echo $javascript->link('jquery.tabs.js', array('inline' => false));

    // Begin formulier
    echo $form->create('Product', array('class' => 'blok-dataform', 'name' => 'formulier', 'url' => array('action' => $this->action, 'controller' => 'producten', 'prefix' => 'admin')));
    echo '<div class="tab_container">';

    // Tab algemeen
    echo '<div id="tab_algemeen" class="tab_content">';
    echo $form->input('Product.productcode');
    echo $form->input('Product.naam');
    echo $form->input('Product.omschrijving_kort');
    echo $form->input('Product.omschrijving_lang');
    echo $form->input('Product.merk_id', array('options' => $merken));
    echo $form->input('Categorie', array('type' => 'select', 'multiple' => true, 'options' => $categorien, 'escape' => false));
    echo '</div>';

    // Tab prijs en voorraad
    echo '<div id="tab_prijs" class="tab_content">';
    echo $form->input('Product.voorraad');
    echo $form->input('Product.levertijd');
    echo $form->input('Product.verkoopprijs');
    echo $form->input('Product.inkoopprijs');
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
    echo '</div>';

    // Einde formulier
    echo '</div>';
?>