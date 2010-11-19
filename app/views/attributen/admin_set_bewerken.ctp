<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>

<div class="block-titel">Attributenset bewerken</div>

<div id="cta">
	<button class="save" onclick="document.formulier.submit();"><span>Opslaan</span></button>
	<button class="cancel" onclick="location.href='<?php echo $html->url('/admin/attributen/'); ?>'; return false;"><span>Annuleren</span></button>
</div>

<ul id="tabs"></ul>

<?php
    echo $form->create('Attributenset', array('class' => 'blok-dataform', 'name' => 'formulier', 'url' => array('action' => 'set_bewerken', 'controller' => 'attributen', 'prefix' => 'admin')));
    echo $form->hidden('Attributenset.id');
    echo $form->input('Attributenset.naam', array('label' => 'Naam set'));

    if(!empty($this->data))
    {
        foreach($this->data['Attribuut'] as $i => $attribuut)
        {
            echo $form->hidden("Attribuut.$i.id");
            echo $form->hidden("Attribuut.$i.naam");
            echo $form->input("Attribuut.$i.opties", array('label' => $attribuut['naam']));
        }
    }

    echo '<div id="nieuw_attr" class="input divider"><label><a href="javascript:nieuw_attr()">Attribuut toevoegen</a></label></div>';

    echo $form->end();
?>

<script type="text/javascript">

    var nextAttr = <?php echo count($this->data['Attribuut']); ?>;

    function nieuw_attr()
    {
        var attr = prompt("Wat is de naam van het attribuut?", "");

        if(attr != '' && attr != null)
        {
            var attrHtml = '<input type="hidden" id="Attribuut' + nextAttr + 'Naam" value="' + attr + '" name="data[Attribuut][' + nextAttr + '][naam]">';
            var attrHtml = attrHtml + '<input type="hidden" id="Attribuut' + nextAttr + 'Id" value="" name="data[Attribuut][' + nextAttr + '][id]">';
            var attrHtml = attrHtml + '<div class="input text"><label for="Attribuut' + nextAttr + 'Opties">' + attr + '</label><input id="Attribuut' + nextAttr + 'Opties" type="text" value="" name="data[Attribuut][' + nextAttr + '][opties]" /></div>';

            $("#nieuw_attr").before(attrHtml);
            $("#Attribuut" + nextAttr + "Opties").focus();
            nextAttr++;
        }
    }


</script>