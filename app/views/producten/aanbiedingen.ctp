<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<?php
    if(isset($banners) && count($banners) > 0)
    {
        echo $this->element('carousel');
    }

    echo $this->element('producten', array(
        'categorie' => 'Aanbiedingen',
        'data' => $this->data
    ));
?>