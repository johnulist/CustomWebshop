<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */

    echo $form->create('Product', array('class' => 'blok-dataform', 'id' => 'ajaxPost', 'name' => 'formulier', 'url' => '/admin/bestellingen/nieuw_product/' . $bestelling_id));
?>

<div style="text-align: left;">
<table>
   <tr><th colspan="2">Zoek een product om toe te voegen. Prijs en aantal kunnen in de winkelwagen zelf worden aangepast.</th></tr>
   <tr><td id="errorDiv" style="color: #900; font-weight: bold;" colspan="2">&nbsp;</td></tr>
   <tr><th colspan="2">Toevoegen obv. artikelcode</th></tr>
   <tr><td>Code</td><td><?php echo $form->text('Product.artikelcode'); ?></td></tr>
   <tr><th colspan="2">Toevoegen obv. naam</th></tr>
   <tr><td>Product</td><td><?php echo $form->select('Product.id', $lijst_producten, null, array('escape' => false, 'empty' => '= kies een product =')); ?></td></tr>
   <tr><td><?php echo $form->submit('Toevoegen'); ?></td><td></td></tr>
</table>
</div>

</form>

<script type="text/javascript">
    $("#ajaxPost").submit(function(){

        var product_id   = $("#ProductId").val();
        var product_code = $("#ProductArtikelcode").val();

        $.post("<?php echo $html->url('/admin/bestellingen/nieuw_product/' . $bestelling_id); ?>", { product: product_id, code: product_code }, function(data){
            if(data == "OK")
            {
                alert("Het product is succesvol toegevoegd");
                document.location.href = "<?php echo $html->url('/admin/bestellingen/bewerken/' . $bestelling_id); ?>";
            }
            else
            {
                $("#errorDiv").html(data);
                //$("#errorDiv").html("Er is een fout opgetreden bij het toevoegen. Controleer de invoer.");
            }
        });

        return false;
    });

</script>