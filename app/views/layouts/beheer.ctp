<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
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
	    print "<meta name='robots' content='noindex,nofollow' />\n";

        /* @todo: Content-Languague localegevoelig */
        print "<meta http-equiv='Content-Language' content='nl' />\n";
        print "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n";

        // Overige header tags
        print "<link rel='shortcut icon' href='/img/favicon.ico' type='image/ico' />\n";
        print $html->css('reset')."\n";
        print $html->css('colorbox')."\n";
        print $html->css('beheer')."\n";
	?>

	<!-- javascript -->
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript">google.load("jquery", "1.3");</script>
	<?php echo $scripts_for_layout; ?>
</head>

<body>

    <div id="beheercontainer">

        <div id="header">
            <h1 id="site_title">Dashboard <?php echo $params['siteNaam']; ?></h1>

            <div id="login_info">
                <?php echo $html->link($params['gebruiker']['emailadres'], '/gebruikers/profiel/'); ?>
                <?php echo $html->link(__('Uitloggen', true), '/gebruikers/uitloggen/'); ?>
                <?php echo $html->link(__('Naar de shop', true), '/', array('target' => '_blank')); ?>
            </div>

            <div id="nav"><?php echo $this->element('admin/nav'); ?></div>

            <div class="clear"></div>
        </div>

        <div id="body">

            <div id="navgradient"></div>

            <div id="main">
                <div id="content">
                    <div id="contentmargin" class="block">
                        <?php echo $content_for_layout; ?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div id="links">
                <?php echo $this->element('admin/groepen'); ?>
            </div>
        </div>
        <div id="footer">
            Custom Webshop
        </div>
    </div>

	<?php echo $this->element('sql_dump'); ?>

</body>

</html>