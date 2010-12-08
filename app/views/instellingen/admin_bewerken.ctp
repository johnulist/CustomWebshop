<?php
	echo $form->create('Instelling', array('url' => '/admin/instellingen/bewerken/' . $this->data['Instelling']['id'], 'class' => 'blok-dataform'));
?>

<div class="block-titel">Instelling bewerken</div>

<div id="cta">
	<button class="add" onclick="document.addform.submit();"><span>Opslaan</span></button>
	<button class="add" onclick="location.href='/admin/instellingen/'; return false;"><span>Annuleren</span></button>
</div>

<ul id="tabs">
	<li class="active"><a href="#tab_pagina">Algemeen</a></li>
</ul>

<div class="tab_container">

<?php
	echo '<h3>' . $this->data['Instelling']['key'] . '</h3>';
	echo '<p>' . $this->data['Instelling']['omschrijving'] . '</p>';
    
	echo $form->input('Instelling.value', array('type' => 'textarea', 'label' => 'Waarde', 'style' => 'height: 300px; width: 600px;'));
?>

</div>
</form>