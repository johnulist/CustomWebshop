<div class="block-titel">Instellingen</div>


<ul id="tabs"></ul>

<div class="tab_container">


<table class="lijst" width="100%">

	<tr>
		<th><?php echo $paginator->sort('Parameter','key'); ?></th>
		<th><?php echo $paginator->sort('Waarde','value'); ?></th>
		<th><?php echo $paginator->sort('omschrijving'); ?></th>
		<th class="last">opties</th>
	</tr>

	<?php
		$altrow = 1;
		foreach($this->data as $instelling)
		{
			print "<tr>";
			print "<td>".$instelling['Instelling']['key']."</td>";
			print "<td>".$instelling['Instelling']['value']."</td>";
			print "<td>".$instelling['Instelling']['omschrijving']."</td>";
			print "<td nowrap='nowrap' class='last'>";
			print $html->link($html->image('dashboard/icons/71.png', array('alt' => 'bewerken')), '/admin/instellingen/bewerken/'.$instelling['Instelling']['id'], array('escape' => false), null, false);
			print "</td>";
			print "</tr>\n";
		}
	?>

</table>

</div>