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
        print $html->css('basic')."\n";
        print $html->css('twee-960')."\n";
        print $html->css('default')."\n";
        print $html->css('colorbox')."\n";
        print $html->css('formstables')."\n";
        print $html->css('megamenu')."\n";
	?>

	<!-- javascript -->
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript">google.load("jquery", "1.3");</script>
    
    <?php echo $javascript->link('jquery.hoverIntent.minified.js'); ?>
	<?php echo $scripts_for_layout; ?>
</head>

<body>

    <div id="header">
        <h1 id="logo"><?php echo $html->link($params['siteNaam'],'/'); ?></h1>
        <?php echo $this->element('winkelwagen'); ?>
        <div class="clear"></div>
    </div><!-- end header -->

    <div id="sitecontainer"><!-- sets background to white and creates full length leftcol-->

        <?php echo $this->element('megamenu'); ?>

        <div id="container"><!-- sets background to white and creates full length rightcol-->

            <div id="columns"><!-- begin main content area -->

                <div id="links"><!-- begin leftcol -->
                    <?php
                        foreach($params['linkerblokken'] as $element)
                        {
                            echo $this->element($element);
                        }
                    ?>
                </div><!-- end leftcol -->

                <div id="rechts"><!-- begin rightcol -->
                    <p>This is the right column</p>
                </div><!-- end righttcol -->

                <div id="content"><!-- begin centercol -->

                    <div id="flash"><?php echo $this->Session->flash(); ?></div>

                    <?php echo $content_for_layout; ?>
                    <div class="clear"></div>
                </div><!-- end centercol -->
                <div class="clear"></div>
            </div><!-- end columns area -->

            <div id="footer"><!-- begin footer -->
                <p>&copy; Custom Webwinkel 2010</p>
            </div><!-- end footer -->

        </div><!-- end container -->

    </div><!-- end sitecontainer -->


	<?php echo $this->element('sql_dump'); ?>

    <?php
        echo $analytics = Configure::read('Site.analytics');
    ?>

</body>

</html>