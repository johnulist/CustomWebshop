<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Merk toevoegen</div>
<?php
    echo $form->create('Merk', array('class' => 'blok-dataform', 'url' => array('action' => 'bewerken', 'controller' => 'merken', 'prefix' => 'admin')));
    echo $form->hidden('Merk.id');
    echo $form->input('Merk.naam');
    echo $form->submit('Opslaan');
?>