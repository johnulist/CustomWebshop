<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block groepen">
	<div class="block-titel">Menu</div>
	<ul>
		<li><?php echo $html->link($html->image('dashboard/groups/contentman48.gif', array('alt' => 'Bestellingen')) . '<span>Bestellingen</span>', '/admin/bestellingen/', array('escape' => false)); ?></li>
		<li><?php echo $html->link($html->image('dashboard/groups/fileman48.png', array('alt' => 'Klanten')) . '<span>Klanten</span>', '/admin/gebruikers/', array('escape' => false)); ?></li>
		<li><?php echo $html->link($html->image('dashboard/groups/news48.png', array('alt' => 'Producten')) . '<span>Producten</span>', '/admin/producten/', array('escape' => false)); ?></li>

        <li><?php echo $html->link($html->image('dashboard/groups/news48.png', array('alt' => 'Productattributen')) . '<span>Attributensets</span>', '/admin/attributen/', array('escape' => false)); ?></li>

		<li><?php echo $html->link($html->image('dashboard/groups/imgman48.gif', array('alt' => 'Merken')) . '<span>Merken</span>', '/admin/merken/', array('escape' => false)); ?></li>
		<li><?php echo $html->link($html->image('dashboard/groups/videoman.png', array('alt' => 'Categori&euml;n')) . '<span>Categori&euml;n</span>', '/admin/categorien/', array('escape' => false)); ?></li>
		<li><?php echo $html->link($html->image('dashboard/groups/statman48.png', array('alt' => 'Templates')) . '<span>Templates</span>', '/', array('escape' => false)); ?></li>

	</ul>
	<div class="clear"></div>
</div>

<div class="block groepen">
	<div class="block-titel">Website instellingen</div>
	<ul>
		<li><?php echo $html->link($html->image('dashboard/groups/users_two_48.png', array('alt' => 'Gebruikers')) . '<span>Gebruikers</span>', '/admin/gebruikers/', array('escape' => false)); ?></li>
		<li><?php echo $html->link($html->image('dashboard/groups/spanner_48.png', array('alt' => 'Instellingen')) . '<span>Instellingen</span>', '/admin/instellingen/', array('escape' => false)); ?></li>
		<li><?php echo $html->link($html->image('dashboard/groups/globe-icon_normal.jpg', array('alt' => 'Toon website')) . '<span>Website</span>', '/', array('escape' => false, 'target' => '_blank')); ?></li>
	</ul>
	<div class="clear"></div>
</div>