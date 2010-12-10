<?php
    header('Content-type: application/json');
    // PhpDoc Comments for code completion in views */
    /* @var $this View */
    /* @var $html HtmlHelper */
    /* @var $javascript JavascriptHelper */
    echo json_encode($this->data);
?>