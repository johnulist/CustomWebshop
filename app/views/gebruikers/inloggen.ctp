<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<h1><?php __('Inloggen'); ?></h1>
<?php
    echo $form->create('Gebruiker', array('url' => array('action' => 'inloggen', 'controller' => 'gebruikers')));
    echo $form->input('Gebruiker.emailadres', array('label' => __('Emailadres', true)));
    echo $form->input('Gebruiker.wachtwoord', array('type' => 'password', 'label' => __('Wachtwoord', true)));
    echo $form->submit(__('Inloggen', true));
?>