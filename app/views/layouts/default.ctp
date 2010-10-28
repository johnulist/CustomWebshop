<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
        // SEO
        print "<title>" . $params['meta_title'] . "</title>\n";
        print "<meta name='keywords' content=\"" . $params['meta_keywords'] . "\" />\n";
        print "<meta name='description' content=\"" . $params['meta_description'] . "\" />\n";

        // Algemene META-tags
        print "<meta name='author' content='Mattijs Meiboom, mattijs@customwebsite.nl' />\n";
        print "<meta name='author' content='Patrick de Vos, patrick@customwebsite.nl' />\n";
        print "<meta name='copyright' content='Custom website, ".date("Y")."' />\n";
	    print "<meta name='revisit-after' content='5 days' />\n";

        /* @todo: Content-Languague localegevoelig */
        print "<meta http-equiv='Content-Language' content='nl' />\n";
        print "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n";

        // Overige header tags
        print "<link rel='shortcut icon' href='/img/favicon.ico' type='image/ico' />\n";
        print $html->css('reset')."\n";
        print $html->css('basic')."\n";
        print $html->css('formstables')."\n";
        print $html->css('beheer')."\n";
	?>

	<!-- javascript -->
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript">google.load("jquery", "1.3");</script>
	<?php echo $scripts_for_layout; ?>
</head>

<body>

	<!-- Container met afgeronde hoeken, omvat de hele site -->
	<div id="sitecontainer">


        <div id="contentcontainer">
            <div id="side"></div>
            <div id="flash"><?php echo $session->flash(); ?></div>
            <div id="content"><?php echo $content_for_layout; ?></div>
            <div class="clear"></div>
        </div>
        
        <div id="footer"></div>

    </div>

	<?php echo $this->element('sql_dump'); ?>
    <?php /* @todo google analytics */ ?>
</body>

</html>