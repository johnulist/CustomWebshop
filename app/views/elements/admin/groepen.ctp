<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block groepen">
	<div class="block-titel">Menu</div>
	<ul>

		<li><?php echo $html->link($html->image('dashboard/groups/icon-48x48-os_window_2.gif', array('alt' => 'Producten')) . 'Producten', '/admin/producten/', array('escape' => false)); ?></li>
        <li><?php echo $html->link($html->image('dashboard/groups/icon_cart.png', array('alt' => 'Bestellingen')) . 'Bestellingen', '/admin/bestellingen/', array('escape' => false)); ?></li>
        <li><?php echo $html->link($html->image('dashboard/icons/coins.png', array('alt' => 'Facturen')) . 'Facturen', '/admin/facturen/', array('escape' => false)); ?></li>
        <li><?php echo $html->link($html->image('dashboard/groups/user.png', array('alt' => 'Klanten')) . 'Klanten', '/admin/gebruikers/', array('escape' => false)); ?></li>

        <li><?php echo $html->link($html->image('dashboard/groups/features_menus.png', array('alt' => 'Categori&euml;n')) . 'Categori&euml;n', '/admin/categorien/', array('escape' => false)); ?></li>
        <li><?php echo $html->link($html->image('dashboard/groups/seo48.jpg', array('alt' => 'Merken')) . 'Merken', '/admin/merken/', array('escape' => false)); ?></li>
        
        
		

        <li><?php echo $html->link($html->image('dashboard/groups/icon-48x48-tools.gif', array('alt' => 'Productattributen')) . 'Attributen', '/admin/attributen/', array('escape' => false)); ?></li>
		<li><?php echo $html->link($html->image('dashboard/groups/icon_newsletter.png', array('alt' => 'Templates')) . 'Templates', '/', array('escape' => false)); ?></li>
        <li><?php echo $html->link($html->image('dashboard/icons/icon-slideshow.png', array('alt' => 'Banners')) . 'Banners', '/admin/banners/', array('escape' => false)); ?></li>

        <li><?php echo $html->link($html->image('dashboard/icons/accessories-text-editor.png', array('alt' => 'Teksten')) . 'Teksten', '/admin/paginas/', array('escape' => false)); ?></li>
        <li><?php echo $html->link($html->image('dashboard/groups/menus.png', array('alt' => 'Menus')) . 'Menus', '/admin/menus/', array('escape' => false)); ?></li>

	</ul>
	<div class="clear"></div>
</div>

<div class="block groepen">
	<div class="block-titel">Website instellingen</div>
	<ul>
		<li><?php echo $html->link($html->image('dashboard/groups/users_two_48.png', array('alt' => 'Gebruikers')) . 'Gebruikers', '/admin/gebruikers/', array('escape' => false)); ?></li>
		<li><?php echo $html->link($html->image('dashboard/groups/spanner_48.png', array('alt' => 'Instellingen')) . 'Instellingen', '/admin/instellingen/', array('escape' => false)); ?></li>
		<li><?php echo $html->link($html->image('dashboard/groups/globe-icon_normal.jpg', array('alt' => 'Toon website')) . 'Website', '/', array('escape' => false, 'target' => '_blank')); ?></li>
	</ul>
	<div class="clear"></div>
</div>