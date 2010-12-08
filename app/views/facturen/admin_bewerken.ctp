<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Factuur #<?php echo $this->data['Bestelling']['factuurnummer']; ?></div>
<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/bestellingen/bewerken/' . $this->data['Bestelling']['id']); ?>';"><span>Bewerken</span></button>
    <button class="add" onclick="location.href='<?php echo $html->url('/bestellingen/pdf/' . $this->data['Bestelling']['id']); ?>';"><span>PDF</span></button>
    <button class="add" onclick="location.href='<?php echo $html->url('/admin/bestellingen/verzenden/' . $this->data['Bestelling']['id']); ?>';"><span>Verzenden</span></button>
    <button class="save" onclick="document.formulier.submit();"><span>Opslaan</span></button>
</div>
<ul id="tabs"></ul>
<div class="tab_container">

    <div id="bestelling-overzicht">
        <form class="blok-dataform" name="formulier" method="post" action="<?php echo $this->here; ?>">
        <div id="bd-status">
            <?php echo $this->data['Bestelling']['huidige_status']; ?>
            <div id="bd-status-geschiedenis">
                <ul>
                <?php 
                    foreach($this->data['Bestelstatus'] as $status)
                    {
                        print '<li>' . $cw->datum($status['created']) . ': ' . $status['status'] . '</li>';
                    }
                ?>
                </ul>
            </div>
        </div>

        <div id="bd-summary">

            <?php
                if(!empty($this->data['Bestelling']['factuurnummer']))
                {
                    print '<div id="bd-factuurnummer">' . $form->input('Bestelling.factuurnummer') . '</div>';
                }
                else
                {
                    print '<div id="bd-factureren">' . $html->link('Nu factureren','/admin/bestellingen/factureren/' . $this->data['Bestelling']['id']) . '</div>';
                }
            ?>

            <div id="bd-besteldatum">Besteld op: <span><?php echo $cw->datum($this->data['Bestelling']['besteldatum']); ?></span></div>

        </div>

        <div id="bd-betaling">

            <div id="bd-klant">
                <?php echo $form->input('Bestelling.relatie_id', array('options' => $relaties)); ?>
            </div>

            <div id="bd-factuuradres">
                <?php echo $form->input('Bestelling.factuuradres', array('rows' => 3)); ?>
            </div>

            <div id="bd-betaalmethode"><?php print $form->input('Bestelling.betaalmethode_id', array('options' => $betaalmethoden)); ?></span></div>

        </div>

        <div id="bd-levering">

            <div id="bd-aflevermethode"><?php print $form->input('Bestelling.levermethode_id', array('options' => $levermethoden)); ?></div>

            <div id="bd-afleveradres">
                <?php print $form->input('Bestelling.afleveradres', array('rows' => 3)); ?>
            </div>

        </div>

        <?php echo $this->element('bestelling-inhoud'); ?>
        </form>
    </div>

</div>