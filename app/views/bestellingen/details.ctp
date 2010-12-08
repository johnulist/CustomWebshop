<div id="bestelling-overzicht">

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
                print '<div id="bd-factuurnummer">Factuurnummer: <span>' . $this->data['Bestelling']['factuurnummer'] . '</span></div>';
            }
            else
            {
                print '<div id="bd-factureren">' . $html->link('Nu factureren','/admin/bestellingen/factureren/' . $this->data['Bestelling']['id']) . '</div>';
            }
        ?>

        <div id="bd-besteldatum">Besteld op: <span><?php echo $cw->datum($this->data['Bestelling']['besteldatum']); ?></span></div>

    </div>

    <div id="bd-betaling">

        <div id="bd-factuuradres">
            <?php print nl2br($this->data['Bestelling']['factuuradres']); ?>
        </div>

        <div id="bd-betaalmethode">Betaalmethode: <span><?php echo $this->data['Betaalmethode']['betaalmethode']; ?></span></div>

    </div>

    <div id="bd-levering">

        <div id="bd-aflevermethode">Aflevermethode: <span><?php echo $this->data['Levermethode']['levermethode']; ?></span></div>

        <?php
            if($this->data['Levermethode']['flagMetAdres'])
            {
                print '<div id="bd-afleveradres">';
                print nl2br($this->data['Bestelling']['afleveradres']);
                print '</div>';
            }
        ?>

    </div>

    <?php echo $this->element('bestelling-inhoud'); ?>

</div>