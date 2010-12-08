<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>

<?php
    echo $form->create('Bestelling', array('url' => array('action' => 'verzenden', 'controller' => 'winkelwagen')));

    echo '<h2>Levermethode</h2>';
    echo '<p>Kies de door u gewenste levermethode. Indien u de bestelling wilt laten verzenden kunt u hieronder het afleveradres aangeven.</p>';
    foreach($this->data as $levermethode)
    {
        echo '<div class="clear"></div>';
        echo '<input type="radio" name="levermethode" value="' . $levermethode['Levermethode']['id'] . '" />';
        echo $levermethode['Levermethode']['levermethode'];
    }
    
    echo '<div id="afleveradres">';
    echo '<h2>Afleveradres</h2>';
    echo $form->input('Bestelling.adres', array('value' => $params['gebruiker']['afleveradres']));
    echo $form->input('Bestelling.postcode', array('value' => $params['gebruiker']['a_postcode']));
    echo $form->input('Bestelling.plaats', array('value' => $params['gebruiker']['a_plaats']));
    echo '</div>';



    echo $form->submit('Verder');
?>