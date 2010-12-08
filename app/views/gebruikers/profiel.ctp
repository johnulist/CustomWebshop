<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Profiel bewerken</div>

<?php
    // Begin formulier
    echo $form->create('Gebruiker', array('url' => array('action' => 'profiel', 'controller' => 'gebruikers')));

    // Tab algemeen
    echo '<div id="tab_algemeen" class="tab_content">';
    echo $form->input('Gebruiker.contactpersoon');
    echo $form->input('Gebruiker.voorkeurstaal', array('options' => $params['siteLocales']));
    echo $form->input('Gebruiker.telefoon');
    echo $form->input('Gebruiker.mobiel');
    echo $form->input('Gebruiker.fax');
    echo $form->input('Gebruiker.emailadres');
    echo '</div>';

     // Tab bedrijf
    echo '<div id="tab_zakelijk" class="tab_content">';
    echo $form->input('Gebruiker.bedrijfsnaam');
    echo $form->input('Gebruiker.kvknummer');
    echo $form->input('Gebruiker.btwnummer');
    echo '</div>';

    // Tab financieel
    echo '<div id="tab_bank" class="tab_content">';
    echo $form->input('Gebruiker.bank_rekeningnummer');
    echo $form->input('Gebruiker.bank_tenaamstelling');
    echo $form->input('Gebruiker.bank_plaats');
    echo $form->input('Gebruiker.korting');
    echo $form->input('Gebruiker.voorkeursvaluta');
    echo '</div>';

    // Tab adres
    echo '<div id="tab_adres" class="tab_content">';
    echo '<h3>Factuuradres</h3>';
    echo $form->input('Gebruiker.factuuradres');
    echo $form->input('Gebruiker.f_postcode');
    echo $form->input('Gebruiker.f_plaats');
    echo $form->input('Gebruiker.f_land');
    echo '<h3>Afleveradres</h3>';
    echo $form->input('Gebruiker.afleveradres');
    echo $form->input('Gebruiker.a_postcode');
    echo $form->input('Gebruiker.a_plaats');
    echo $form->input('Gebruiker.a_land');
    echo '</div>';

    echo $form->end('Opslaan');
?>