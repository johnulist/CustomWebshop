<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<h1>Registreren</h1>

<p>Met onderstaand formulier kunt u zich aanmelden voor een account in onze webshop. Met uw eigen account kunt u ten alle tijde de status van bestellingen terugvinden.</p>

<?php
    // Begin formulier
    echo $form->create('Gebruiker', array('class' => 'frontend-form', 'url' => array('action' => 'registreren', 'controller' => 'gebruikers')));

    // Tab algemeen
    echo '<div id="tab_algemeen" class="tab_content">';
    echo '<h2>Accountgegevens</h2>';
    echo $form->input('Gebruiker.contactpersoon', array('label' => 'Voor- en achternaam'));
    echo $form->input('Gebruiker.bedrijfsnaam', array('label' => 'Bedrijfsnaam (optioneel)'));
    echo $form->input('Gebruiker.emailadres');
    echo $form->input('Gebruiker.wachtwoord_invoeren', array('type' => 'password', 'label' => 'Wachtwoord'));
    echo $form->input('Gebruiker.wachtwoord_herhalen', array('type' => 'password', 'label' => 'Wachtwoord herhalen'));

    echo $form->input('Gebruiker.mobiel');
    echo $form->input('Gebruiker.telefoon', array('label' => 'Telefoon (vast)'));
    
    echo '</div>';

    // Tab adres
    echo '<div id="tab_adres" class="tab_content">';
    echo '<h2>Factuuradres</h2>';
    echo '<p>Geef hieronder eventueel een factuuradres op. Alle facturen worden standaard ook per email verstuurd.</p>';
    echo $form->input('Gebruiker.factuuradres');
    echo $form->input('Gebruiker.f_postcode', array('label' => 'Postcode'));
    echo $form->input('Gebruiker.f_plaats', array('label' => 'Plaats'));

    echo '<h2>Afleveradres</h2>';
    echo '<p>Geef hieronder eventueel een adres op als voorkeursadres voor bestellingen. U kunt bij het plaatsen van een bestelling hier indien gewenst van afwijken.</p>';
    echo $form->input('Gebruiker.afleveradres');
    echo $form->input('Gebruiker.a_postcode', array('label' => 'Postcode'));
    echo $form->input('Gebruiker.a_plaats', array('label' => 'Plaats'));
    echo '</div>';

    echo $form->end('Opslaan');
?>

<script type="text/javascript">

    $(document).ready(function(){

       $("#GebruikerWachtwoordInvoeren, #GebruikerWachtwoordHerhalen").val('');

    });

</script>