<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>

<?php
    echo $form->create('Bestelling', array('url' => array('action' => 'bevestigen', 'controller' => 'winkelwagen')));

    echo '<h1>Bestelling bevestigen</h1>';
    echo '<p>U staat op het punt om de onderstaande bestelling te plaatsen. Controleer de getoonde informatie en kies voor <i>Bestelling plaatsen</i> om uw bestelling af te ronden.</p>';
    echo $this->element('winkelwagen-inhoud');

    echo $form->input('Bestelling.akkoord', array('type' => 'checkbox', 'label' => 'Ik ga akkoord met de algemene voorwaarden'));
    echo $form->submit('Bestelling plaatsen');
?>