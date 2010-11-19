<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>

<?php
    echo $form->create('Bestelling', array('url' => array('action' => 'betalen', 'controller' => 'winkelwagen')));
    echo $form->hidden('Form.verzonden', array('value' => 1));

    echo '<h1>Betaalmethode</h1>';
    echo '<p>Kies de door u gewenste betaalmethode.</p>';
    foreach($this->data as $betaalmethode)
    {
        echo '<div class="clear"></div>';
        echo '<input type="radio" name="betaalmethode" value="' . $betaalmethode['Betaalmethode']['id'] . '" />';
        echo $betaalmethode['Betaalmethode']['betaalmethode'];
    }

    echo $form->submit('Verder');
?>