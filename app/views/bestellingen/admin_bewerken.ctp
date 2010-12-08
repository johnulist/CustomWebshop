<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Bestelling #<?php echo $this->data['Bestelling']['id']; ?></div>
<div id="cta">

    <button class="back" onclick="location.href='<?php echo $html->url('/admin/bestellingen/'); ?>'; return false;"><span>Terug</span></button>
    <button class="" onclick="location.href='<?php echo $html->url('/bestellingen/pdf/' . $this->data['Bestelling']['id']); ?>';"><span>PDF</span></button>
    <button class="" onclick="location.href='<?php echo $html->url('/admin/bestellingen/verzenden/' . $this->data['Bestelling']['id']); ?>';"><span>Verzenden</span></button>

    <?php if($this->data['Bestelling']['factuurnummer'] == null): ?>
    <button class="" onclick="location.href='<?php echo $html->url('/admin/bestellingen/factureren/' . $this->data['Bestelling']['id']); ?>';"><span>Factureren</span></button>
    <?php endif; ?>
    
    <button class="save" onclick="document.formulier.submit();"><span>Opslaan</span></button>
    
</div>
<ul id="tabs">
    <li class="firsttab"></li>
	<li><a href="#tab_algemeen">Algemeen</a></li>
    <li><a href="#tab_levering">Levering</a></li>
    <li><a href="#tab_betaling">Betaling</a></li>
    <li><a href="#tab_geschiedenis">Details</a></li>
</ul>

<?php
    // Custom Javascript
	echo $javascript->link('tiny_mce/tiny_mce.js', array('inline' => false));
	echo $javascript->link('jquery.tabs.js', array('inline' => false));

    // Begin formulier
    echo $form->create('Bestelling', array('class' => 'blok-dataform', 'name' => 'formulier', 'url' => array('action' => $this->action, 'controller' => 'bestellingen', 'prefix' => 'admin')));
    echo '<div class="tab_container">';
?>

    <div id="tab_algemeen" class="tab_content">

        <table width="100%">
            <tr>
                <td nowrap='nowrap'>Naam</td><td><?php echo $form->select('Bestelling.gebruiker_id', $relaties, null, array('style' => 'width: 300px;', 'onchange' => "$('.adresveld').val('')"), false); ?></td>
                <td nowrap='nowrap'>Klantnummer</td><td nowrap><?php echo $this->data['Gebruiker']['id']; ?></td>
            </tr>
            <tr>
                <td nowrap='nowrap'>Bedrijf</td><td><?php echo $this->data['Gebruiker']['bedrijfsnaam']; ?></td>
                <?php if($this->data['Bestelling']['factuurnummer'] == null): ?>
                <td nowrap='nowrap'>Factuurnummer&nbsp;&nbsp;</td><td nowrap='nowrap'><?php echo $html->link('Nu factureren','/admin/bestellingen/factureren/' . $this->data['Bestelling']['id']); ?></td>
                <?php else: ?>
                <td nowrap='nowrap'>Factuurnummer&nbsp;&nbsp;</td><td nowrap='nowrap'><?php echo $form->text('Bestelling.factuurnummer'); ?></td>
                <?php endif; ?>
            </tr>
            <tr>
                <td nowrap='nowrap' valign='top'>Factuuradres</td>
                <td><?php echo $this->data['Bestelling']['factuuradres_adres']; ?>, <?php echo $this->data['Bestelling']['factuuradres_postcode']; ?>, <?php echo $this->data['Bestelling']['factuuradres_plaats']; ?></td>
                <?php if($this->data['Bestelling']['factuurdatum'] == null): ?>
                <td nowrap='nowrap' valign='top'>Factuurdatum</td><td nowrap='nowrap' valign='top'></td>
                <?php else: ?>
                <td nowrap='nowrap' valign='top'>Factuurdatum</td><td nowrap='nowrap' valign='top'><?php echo $cw->datum($this->data['Bestelling']['factuurdatum']); ?></td>
                <?php endif; ?>
            </tr>
            <tr>
                <td>Afleveradres</td>
                <td><?php if($this->data['Levermethode']['flagMetAdres']) echo $this->data['Bestelling']['afleveradres_adres']; ?>, <?php echo $this->data['Bestelling']['afleveradres_postcode']; ?>, <?php echo $this->data['Bestelling']['afleveradres_plaats']; ?></td>
                <td nowrap='nowrap' valign='top'>Bestelnummer</td><td nowrap='nowrap' valign='top'><?php echo $this->data['Bestelling']['id']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td nowrap='nowrap'>Besteldatum</td><td nowrap='nowrap' valign='top'><?php echo $cw->datum($this->data['Bestelling']['besteldatum']); ?></td>
            </tr>
        </table>

        <br /><br />

        <?php echo $this->element('bestelling-inhoud'); ?>
        
    </div>

    <div id="tab_geschiedenis" class="tab_content">

        <table>
            <tr><th colspan="2">Opmerkingen</th></tr>
            <tr><td colspan="2"><?php echo $form->textarea("Bestelling.opmerkingen", array('rows' => 10, 'cols' => 60)); ?></td></tr>
            <tr><th colspan="2">Geschiedenis</th></tr>
            <?php
                foreach($this->data['Bestelstatus'] as $status)
                {
                    print '<tr><td>' . $cw->datum($status['created']) . '</td><td>' . $status['status'] . '</td><td colspan="4"></td></tr>';
                }
            ?>
        </table>

    </div>

    <div id="tab_levering" class="tab_content">

        <table>
            <tr>
                <td nowrap='nowrap'>Verzendmethode</td><td><?php print $form->input('Bestelling.levermethode_id', array('label' => false, 'div' => false, 'options' => $levermethoden)); ?></td>
                <td></td>
            </tr>
            <tr>
                <td>Trackingcode</td>
                <td><?php echo $form->input('Bestelling.trackingcode', array('label' => false, 'div' => false)); ?></td>
                <td>o.a. bij verzending via TNT</td>
            </tr>
            <tr>
                <td>Verzendkosten</td>
                <td><?php echo $form->input('Bestelling.verzendkosten_excl', array('label' => false, 'div' => false)); ?>
                <td>excl. <?php echo $this->data['Levermethode']['btw']; ?>% BTW</td>
            </tr>
            <tr>
                <td nowrap='nowrap' valign='top'>Afleveradres</td>
                <td><?php echo $form->input('Bestelling.afleveradres_adres', array('label' => false, 'div' => false)); ?></td>
                <td></td>
            </tr>
            <tr>
                <td nowrap='nowrap' valign='top'>Postcode</td>
                <td><?php echo $form->input('Bestelling.afleveradres_postcode', array('label' => false, 'div' => false)); ?></td>
                <td></td>
            </tr>
            <tr>
                <td nowrap='nowrap' valign='top'>Plaats</td>
                <td><?php echo $form->input('Bestelling.afleveradres_plaats', array('label' => false, 'div' => false)); ?></td>
                <td></td>
            </tr>
        </table>

    </div>

    <div id="tab_betaling" class="tab_content">

        <table>
            <tr>
                <td nowrap='nowrap'>Betaalmethode</td><td><?php print $form->input('Bestelling.betaalmethode_id', array('label' => false, 'div' => false, 'options' => $betaalmethoden)); ?></td>
                <td></td>
            </tr>
            <tr>
                <td nowrap='nowrap'>Betaalstatus</td><td><?php print $form->input('Bestelling.isBetaald', array('label' => false, 'div' => false, 'options' => array(0 => 'nog niet betaald', 1 => 'betaald'))); ?></td>
                <td></td>
            </tr>
            <tr>
                <td nowrap='nowrap' valign='top'>Factuuradres</td>
                <td><?php echo $form->input('Bestelling.factuuradres_adres', array('label' => false, 'div' => false)); ?></td>
                <td></td>
            </tr>
            <tr>
                <td nowrap='nowrap' valign='top'>Postcode</td>
                <td><?php echo $form->input('Bestelling.factuuradres_postcode', array('label' => false, 'div' => false)); ?></td>
                <td></td>
            </tr>
            <tr>
                <td nowrap='nowrap' valign='top'>Plaats</td>
                <td><?php echo $form->input('Bestelling.factuuradres_plaats', array('label' => false, 'div' => false)); ?></td>
                <td></td>
            </tr>
        </table>

    </div>

</div>
</form>

<script type="text/javascript">

    var verzendkosten = [];
    <?php
        foreach($verzendkosten as $methode_id => $kosten)
        {
            echo "verzendkosten[$methode_id] = $kosten;\n";
        }
    ?>

    $(document).ready(function(){

        $('#BestellingLevermethodeId').bind('change', function(){
            var selected = $('#BestellingLevermethodeId').val();
            $('#BestellingVerzendkostenExcl').val(verzendkosten[selected]);
        });

    });

    

</script>