<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Gebruiker bewerken</div>

<div id="cta">
	<button class="save" onclick="document.formulier.submit();"><span>Opslaan</span></button>
	<button class="cancel" onclick="location.href='<?php echo $html->url('/admin/gebruikers/'); ?>'; return false;"><span>Annuleren</span></button>
</div>

<ul id="tabs">
	<li class="firsttab"></li>
	<li><a href="#tab_algemeen">Algemene gegevens</a></li>
    <li><a href="#tab_adres">Adressen</a></li>
    <li><a href="#tab_bank">Financi&euml;el</a></li>
    <li><a href="#tab_zakelijk">Zakelijke gegevens</a></li>
    <li><a href="#tab_bestellingen">Bestellingen (<?php echo count($this->data['Bestelling']); ?>)</a></li>
    <li><a href="#tab_facturen">Facturen (<?php echo count($this->data['Factuur']); ?>)</a></li>
</ul>

<?php
    // Custom Javascript
	echo $javascript->link('tiny_mce/tiny_mce.js', array('inline' => false));
	echo $javascript->link('jquery.tabs.js', array('inline' => false));

    // Begin formulier
    echo $form->create('Gebruiker', array('class' => 'blok-dataform', 'name' => 'formulier', 'url' => array('action' => $this->action, 'controller' => 'gebruikers', 'prefix' => 'admin')));
    echo '<div class="tab_container">';

    // Tab algemeen
    echo '<div id="tab_algemeen" class="tab_content">';
    echo $form->input('Gebruiker.contactpersoon');
    echo $form->input('Gebruiker.voorkeurstaal', array('options' => $params['siteLocales']));
    echo $form->input('Gebruiker.telefoon');
    echo $form->input('Gebruiker.mobiel');
    echo $form->input('Gebruiker.fax');
    echo $form->input('Gebruiker.emailadres');
    echo $form->input('Gebruiker.wachtwoord_invoeren', array('type' => 'password', 'required' => false));
    echo $form->input('Gebruiker.wachtwoord_herhalen', array('type' => 'password'));
    echo $form->input('Gebruiker.isBeheerder', array('label' => 'Toegangsniveau', 'options' => array(0 => 'Klant', 1 => 'Beheerder')));
    echo '</div>';

     // Tab bedrijf
    echo '<div id="tab_zakelijk" class="tab_content">';
    echo $form->input('Gebruiker.bedrijfsnaam');
    echo $form->input('Gebruiker.kvknummer');
    echo $form->input('Gebruiker.btwnummer');
    echo '</div>';

    // Tab fincancieel
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

    echo '<div id="tab_bestellingen" class="tab_content">';
    ?>
        <table class="lijst" width="100%">
            <tr>
                <th>Bestellingnummer</th>
                <th>Besteldatum</th>
                <th>Bedrag</th>
                <th>Status</th>
                <th colspan="2">Opties</th>
            </tr>
            <?php
                foreach($this->data['Bestelling'] as $bestelling)
                {
                    print '<tr class="' . $cw->cycle() . '">';
                    print '<td>' . $html->link($bestelling['id'], '/admin/bestellingen/bewerken/' . $bestelling['id']) . '</td>';
                    print '<td>' . $cw->datum($bestelling['besteldatum'], "%d-%m-%Y") . '</td>';
                    print '<td>' . $number->currency($bestelling['totaal_incl']) . '</td>';
                    print '<td>' . $bestelling['huidige_status'] . '</td>';
                    print '<td class="optie-cell">' . $html->link($html->image('dashboard/icons/71.png'), '/admin/bestellingen/bewerken/' . $bestelling['id'], array('escape' => false)) . '</td>';
                    print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/bestellingen/verwijderen/' . $bestelling['id'], array('escape' => false), 'Weet je zeker dat je deze bestelling wilt verwijderen?') . '</td>';
                    print '</tr>';
                }
            ?>
        </table>
    <?php
    echo '</div>';

    echo '<div id="tab_facturen" class="tab_content">';
    ?>
        <table class="lijst" width="100%">
            <tr>
                <th>Factuurnummer</th>
                <th>Factuurdatum</th>
                <th>Bedrag</th>
                <th>Voldaan</th>
                <th>Status</th>
                <th colspan="2">Opties</th>
            </tr>
            <?php
                foreach($this->data['Factuur'] as $bestelling)
                {
                    print '<tr class="' . $cw->cycle() . '">';
                    print '<td>' . $html->link($bestelling['factuurnummer'], '/admin/bestellingen/bewerken/' . $bestelling['id']) . '</td>';
                    print '<td>' . $cw->datum($bestelling['factuurdatum'], "%d-%m-%Y") . '</td>';
                    print '<td>' . $number->currency($bestelling['totaal_incl']) . '</td>';
                    print '<td>' . ($bestelling['isBetaald'] ? 'ja' : 'nee') . '</td>';
                    print '<td>' . $bestelling['huidige_status'] . '</td>';
                    print '<td class="optie-cell">' . $html->link($html->image('dashboard/icons/71.png'), '/admin/bestellingen/bewerken/' . $bestelling['id'], array('escape' => false)) . '</td>';
                    print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/bestellingen/verwijderen/' . $bestelling['id'], array('escape' => false), 'Weet je zeker dat je deze bestelling wilt verwijderen?') . '</td>';
                    print '</tr>';
                }
            ?>
        </table>
    <?php
    echo '</div>';

    // Einde formulier
    echo '</div>';
?>

<script type="text/javascript">

    $(document).ready(function(){
       $("#GebruikerWachtwoordInvoeren, #GebruikerWachtwoordHerhalen").val('');
    });

</script>