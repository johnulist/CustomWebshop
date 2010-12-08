<div class="block-titel">Banners</div>

<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/banners/bewerken/'); ?>';"><span>Banner toevoegen</span></button>
</div>

<ul id="tabs"></ul>

<div class="tab_container">


<table class="lijst" width="100%">

	<tr>
        <th>Afbeelding</th>
        <th>URL</th>
		<th class="last" colspan="4">opties</th>
	</tr>

	<?php
		foreach($this->data as $i => $banner)
		{
			print "<tr class='" . $cw->cycle() . "'>";
			print "<td>" . $html->link($image->resizeAndCrop($banner['Banner']['afbeelding'], 200, 100), '/admin/banners/bewerken/' . $banner['Banner']['id'], array('escape' => false)) ."</td>";
            print "<td width='100%'>" . $html->link($banner['Banner']['url'],$banner['Banner']['url']) . "</td>";
            
            print "<td nowrap='nowrap' class='optie-cell'>";
			print $html->link($html->image('dashboard/icons/71.png', array('alt' => 'bewerken')), '/admin/banners/bewerken/'.$banner['Banner']['id'], array('escape' => false), null, false);
            print "</td>";

            print "<td class='optie-cell'>" . $html->link($html->image('dashboard/icons/3.png', array('alt' => 'omhoog')), '/admin/banners/omhoog/' . $banner['Banner']['id'], array('escape' => false, 'title' => 'Verplaats deze banner')) . "</td>";
			print "<td class='optie-cell'>" . $html->link($html->image('dashboard/icons/4.png', array('alt' => 'omlaag')), '/admin/banners/omlaag/' . $banner['Banner']['id'], array('escape' => false, 'title' => 'Verplaats deze banner')) . "</td>";
			print '<td class="optie-cell last">' . $html->link($html->image('dashboard/icons/12.png'), '/admin/banners/verwijderen/' . $banner['Banner']['id'], array('escape' => false), 'Weet je zeker dat je deze banner wilt verwijderen?') . '</td>';

            print "</tr>\n";
		}
	?>

</table>

</div>