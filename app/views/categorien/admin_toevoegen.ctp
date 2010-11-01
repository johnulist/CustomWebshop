<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Categorie toevoegen</div>
<?php
    echo $form->create('Categorie', array('class' => 'blok-dataform', 'url' => array('action' => 'toevoegen', 'controller' => 'categorien', 'prefix' => 'admin')));
    echo $form->input('Categorie.naam');
    echo $form->input('Categorie.omschrijving');
    echo $form->input('Categorie.parent_id', array('label' => 'Bovenliggende categorie', 'options' => $lijst_categorien, 'empty' => '= kies parent of laat leeg =', 'escape' => false));
    echo $form->submit('Toevoegen');
?>