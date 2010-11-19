<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>

<div id="product-details">

    <h1 id="product-titel"><?php echo $this->data['Product']['naam']; ?></h1>

    <div id="product-linkerkolom">

        <div id="product-afbeelding">
            <?php
                if(count($this->data['Productafbeelding']) > 0)
                {
                    print $html->link($image->resize($this->data['Productafbeelding'][0]['bestandsnaam'], 288, round(288 * 0.75)), '/img/' . $this->data['Productafbeelding'][0]['bestandsnaam'], array('escape' => false, 'class' => 'fancybox', 'rel' => 'imggroup'));
                }
            ?>
        </div>

        <div id="product-afbeelding-meer">
            <?php
                if(count($this->data['Productafbeelding']) > 1)
                {
                    foreach($this->data['Productafbeelding'] as $afbeelding)
                    {
                        print $html->link($image->resize($afbeelding['bestandsnaam'], 90, 90), '/img/' . $afbeelding['bestandsnaam'], array('escape' => false, 'rel' => 'imggroup', 'class' => 'fancybox'));
                    }
                }
            ?>
        </div>

    </div>

    <div id="product-rechterkolom">

        <div id="product-details">

            <p class="product-omschrijving-kort"><?php echo $this->data['Product']['omschrijving_kort']; ?></p>
            <p class="product-merk">Merk: <?php echo $this->data['Merk']['naam']; ?></p>
            <p class="product-categorie">Categorie: 
                <?php
                    foreach($this->data['Categorie'] as $categorie)
                    {
                        echo $categorie['naam'] . ', ';
                    }
                ?>
            </p>

        </div>

        <div id="product-prijs">
            <span class="actuele-prijs"><?php echo $number->currency($this->data['Product']['prijs']); ?></span>
        </div>

        <div id="product-voorraad">
            <p>
            <?php
                if($this->data['Product']['voorraad'] <= 0)
                {
                    print 'Dit product is momenteel niet op voorraad.';
                }
                elseif($this->data['Product']['voorraad'] <= 5)
                {
                    print 'Dit product is momenteel beperkt leverbaar.';
                }

                if(!empty($this->data['Product']['levertijd']))
                {
                    print ' De levertijd voor dit product bedraagt ongeveer ';
                    print $this->data['Product']['levertijd'];
                    print ' dagen.';
                }
            ?>
            </p>
        </div>

        <div id="product-bestel">
            <?php
                echo $form->create('Product', array('url' => array('action' => 'bestellen', 'controller' => 'producten', $this->data['Product']['id'])));
                echo $form->end('Bestellen');
            ?>
        </div>

    </div>

    <div id="product-breed"><?php echo $this->data['Product']['omschrijving_lang']; ?></div>

</div>

<?php echo $html->script('jquery.fancybox-1.3.4.pack', array('inline' => false)); ?>
<script type="text/javascript">

    $(document).ready(function(){
        $("a.fancybox").fancybox(

        );
    });

</script>