<h1>Bestelling ontvangen</h1>
<p>Bedankt voor uw bestelling. Er is een bevestigingsmail verstuurd naar <?php echo $this->data['Gebruiker']['emailadres']; ?> met daarin de details van de bestelling.</p>

<?php
    if($this->data['Betaalmethode']['key'] == 'overboeking')
    {
        print '<p>Melding voor overboekingprocedure</p>';
    }
    elseif($this->data['Betaalmethode']['key'] == 'machtiging')
    {
        print '<p>Melding voor machtiging</p>';
    }
?>