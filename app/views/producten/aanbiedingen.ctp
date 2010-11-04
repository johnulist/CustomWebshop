<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<?php
    if(isset($slides) && count($slides) > 0)
    {
        echo $this->element('slider');
    }

    echo $this->element('producten', array(
        'categorie' => 'Aanbiedingen',
        'data' => $this->data
    ));
?>