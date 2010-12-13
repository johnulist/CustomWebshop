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
    <li><a href="#tab_attributen">Maten &amp; voorraad</a></li>
    <li><a href="#tab_prijs">Prijs</a></li>
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

    // Ook te koop met, inclusief filter
    echo '<div class="input select"><label for="ProductOoktekoopmet">Ook te koop met</label>';
    echo '<div class="nested"><span>Zoeken in de lijst: <input type="text" id="product-zoekveld"/></span><br /><br />';
    echo '<select name="ooktekoopids[]" size="10"  multiple="true" id="ooktekoopmet">';
	foreach($ooktekoop as $id => $product)
    {
        $selected = (in_array($id, $ooktekoopids) ? ' selected' : '');
        print "<option value='$id'$selected>$product</option>\n";
    }
    echo '</select></div>';
    echo '<div class="clear"></div></div>';
    
    echo '</div>';

    // Tab attributen
    echo '<div id="tab_attributen" class="tab_content">';

    echo '<h2>Algemeen</h2>';
    echo $form->input('Product.voorraad', array('style' => 'width: 50px;'));
    echo $form->input('Product.levertijd', array('style' => 'width: 50px;', 'after' => $form->select('Product.levereenheid', array('weken' => 'weken', 'dagen' => 'dagen'), 'dag', array('empty' => false))));

    echo '<h2>Varianten</h2>';
    echo '<table class="lijst" width="100%">
            <tr>
                <th>Maat</th>
                <th>Voorraad</th>
                <th>Levertijd</th>
                <th>Prijs</th>
                <th>Opties</th>
            </tr>';

    // minimaal 5 invulvelden, meer indien alle vijf ingevuld
    $varianten = array();
    $max = max(count($varianten) + 1, 5);
    for($i = 0; $i <= $max; $i++)
    {
        print '<tr id="voorraad-rij-' . $i . '" class="' . $cw->cycle() . '">';
        print '<td><input type="hidden" name="varianten_id[' . $i . ']" value="' . @$varianten[$i]['id'] . '" /><input type="text" name="varianten_naam[' . $i . ']" value="' . @$varianten[$i]['naam'] . '" /></td>';
        print '<td><input type="text" name="varianten_voorraad[' . $i . ']" value="' . @$varianten[$i]['voorraad'] . '" /></td>';
        print '<td><input type="text" name="varianten_levertijd[' . $i . ']" value="' . @$varianten[$i]['levertijd'] . '" /></td>';
        print '<td><input type="text" name="varianten_prijs[' . $i . ']" value="' . @$varianten[$i]['prijs'] . '" /></td>';
        print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '#', array('escape' => false), 'NYI - Weet je zeker dat je deze variant wilt verwijderen?') . '</td>';
        print '</tr>';
    }

    echo '</table>';
    //echo $form->input('Product.attributenset_id', array('options' => $attributensets, 'empty' => __('- kies een set -', true)));
    echo '</div>';

    // Tab prijs en voorraad
    echo '<div id="tab_prijs" class="tab_content">';
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

    $(document).ready(function(){

        // Filter activeren voor 'ook te koop met'
		$("#product-zoekveld").keypress(zoekenTimeout);
		$("#product-zoekveld").change(zoeken);
	});

	function zoekenTimeout()
	{
		setTimeout("zoeken()", 100);
	}

	function zoeken(){
		searchVal = new String($("#product-zoekveld").val()).toLowerCase();
		$("#ooktekoopmet option").each(function(){
			var elemCont = new String($(this).html());
			elemCont = elemCont.toLowerCase();
			if (elemCont.indexOf(searchVal) == -1 && !this.selected)
			{
				$(this).addClass('invisible');
			}
            else
            {
				$(this).removeClass('invisible');
			}
		});
	}
</script>