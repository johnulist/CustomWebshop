<table width='100%'>
	<tr><td colspan='6'><font color='#ffffff'>.</font></td></tr>


	<?php if($this->data['Gebruiker']['bedrijfsnaam'] != ''): ?>

	<!-- KLANT BEDRIJF ADRES EN GEGEVENS -->
	<tr>
		<td colspan='4'><?php echo $this->data['Gebruiker']['bedrijfsnaam']; ?></td>
		<td>Klantnummer:</td><td><?php echo $this->data['Gebruiker']['id']; ?></td>
	</tr>
	<tr>
		<td colspan='4'>t.a.v. <?php echo $this->data['Gebruiker']['contactpersoon']; ?></td>
		<td>Bestelnummer:</td><td><?php echo $this->data['Bestelling']['id']; ?></td>
	</tr>
	<tr>
		<td colspan='4'><?php echo $this->data['Bestelling']['factuuradres_adres']; ?></td>
		<?php if(!is_null($this->data['Bestelling']['factuurdatum'])): ?>
		<td>Factuurdatum:</td><td><?php echo date("d.m.Y", strtotime($this->data['Bestelling']['factuurdatum'])); ?></td>
		<?php else: ?>
		<td></td><td></td>
		<?php endif; ?>
	</tr>
	<tr>
		<td colspan='4'><?php echo $this->data['Bestelling']['factuuradres_postcode']; ?> <?php echo $this->data['Bestelling']['factuuradres_plaats']; ?></td>
		<?php if(!is_null($this->data['Bestelling']['factuurnummer'])): ?>
		<td>Factuurnummer:</td><td><?php echo $this->data['Bestelling']['factuurnummer']; ?></td>
		<?php else: ?>
		<td></td><td></td>
		<?php endif; ?>
	</tr>

	<?php else: ?>

	<!-- KLANT ADRES EN GEGEVENS -->
	<tr>
		<td colspan='4'><?php echo $this->data['Gebruiker']['contactpersoon']; ?></td>
		<td>Klantnummer:</td><td><?php echo $this->data['Gebruiker']['id']; ?></td>
	</tr>
	<tr>
		<td colspan='4'><?php echo $this->data['Bestelling']['factuuradres_adres']; ?></td>
		<td>Bestelnummer:</td><td><?php echo $this->data['Bestelling']['id']; ?></td>
	</tr>
	<tr>
		<td colspan='4'><?php echo $this->data['Gebruiker']['factuuradres_postcode']; ?> <?php echo $this->data['Gebruiker']['factuuradres_plaats']; ?></td>
		<?php if(!is_null($this->data['Bestelling']['factuurdatum'])): ?>
		<td>Factuurdatum:</td><td><?php echo date("d.m.Y", strtotime($this->data['Bestelling']['factuurdatum'])); ?></td>
		<?php else: ?>
		<td></td><td></td>
		<?php endif; ?>
	</tr>
	<tr>
		<td colspan='4'></td>
		<?php if(!is_null($this->data['Bestelling']['factuurnummer'])): ?>
		<td>Factuurnummer:</td><td><?php echo $this->data['Bestelling']['factuurnummer']; ?></td>
		<?php else: ?>
		<td></td><td></td>
		<?php endif; ?>
	</tr>

	<?php endif; ?>



    <tr><td colspan='6'><br /></td></tr>
</table>

<h3>Factuur</h3>

<br />

<table width='100%'>

    <tr>
    	<td nowrap='nowrap'><b>Artikelomschrijving</b><font color='#ffffff'>sssssssssssssssssssssss</font></td>
    	<td><b>Aantal</b></td>
    	<td><b>BTW%</b></td>
    	<td nowrap align='right'><b>Prijs p/s</b></td>
    	<td nowrap align='right'><b>Totaalbedrag</b></td>
    </tr>

    <?php
		$verzendkosten = 0;
		$btw = array(0 => 0, 6 => 0, 19 => 0);
        $btw_totaal = 0;
        
        foreach($this->data['Bestelregel'] as $i => $regel)
        {
            $btw[$regel['Product']['btw']] += $regel['totaal_btw'];
            $btw_totaal += $regel['totaal_btw'];

            print '<tr>';

                // titel
                print '<td class="wli-aantal">' . $regel['aantal'] . '</td>';
                print '<td class="wli-titel">' .  $regel['Product']['naam'] . '</td>';
                print '<td class="wli-aantal">' . $number->currency($regel['prijs_excl']) . '</td>';
                print '<td class="wli-aantal">' . $number->currency($regel['totaal_excl']) . '</td>';

            print '</tr>' . "\n";
        }

    ?>

    <tr><td colspan='5'><font color='#ffffff'>.</font></td></tr>

    <tr><td colspan='4' align='right'>Subtotaal</td><td align='right'><?php echo $number->currency($this->data['Bestelling']['subtotaal_excl']); ?></td></tr>
    <tr><td colspan='4' align='right'>Verzendkosten</td><td align='right'><?php echo $number->currency($this->data['Bestelling']['verzendkosten_excl']); ?></td></tr>
    <?php
    	$totaalbtw = 0;
    	foreach($btw as $percentage => $bedrag)
    	{
    		$totaalbtw += $bedrag;
    		print "<tr><td colspan='4' align='right'>BTW $percentage%</td><td align='right'>&euro;".$number->precision($bedrag, 2)."</td></tr>\n";
    	}
    ?>
    
    <tr><td colspan='4' align='right'><b>Totaalbedrag</b></td><td align='right'><?php echo $number->currency($this->data['Bestelling']['totaal_incl']); ?></td></tr>
    <tr><td colspan='5'><font color='#ffffff'>.</font></td></tr>

    <tr><td colspan='5'>Verzendmethode: <?php echo $this->data['Levermethode']['levermethode']; ?></td></tr>
    <tr><td colspan='5'>Betaalwijze: <?php echo $this->data['Betaalmethode']['betaalmethode']; ?></td></tr>
</table>


<?php
	print "<h3>Opmerkingen</h3>";
    print nl2br($this->data['Bestelling']['opmerkingen']);
?>

<br />