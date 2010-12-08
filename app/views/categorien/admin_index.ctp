<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Categorien</div>


<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/categorien/bewerken/'); ?>'"><span>Categorie toevoegen</span></button>
</div>

<ul id="tabs"></ul>

<div class="tab_container">
<table width='100%' class="lijst">

	<thead>
		<tr>
			<th>Categorie</th>
            <th>Aantal producten</th>
			<th colspan="4">Opties</th>
		</tr>
	</thead>

	<?php
		printNested($this->data, $html, array('level' => 0));
		function printNested($children, &$html, $options)
		{
			foreach($children as $categorie)
			{
				print "<tr class='nested-row-" . $options['level'] . "'>";

                print "<td class='nested-cell'>" . $categorie['Categorie']['naam'] . "</td>";
                print "<td>" . $categorie['Categorie']['count_producten'] . "</td>";
				print "<td class='optie-cell'>" . $html->link($html->image('dashboard/icons/71.png', array('alt' => 'bewerken')), '/admin/categorien/bewerken/' . $categorie['Categorie']['id'], array('escape' => false, 'title' => 'Bewerk deze pagina')) . "</td>";
				print "<td class='optie-cell'>" . $html->link($html->image('dashboard/icons/3.png', array('alt' => 'omhoog')), '/admin/categorien/omhoog/' . $categorie['Categorie']['id'], array('escape' => false, 'title' => 'Verplaats deze pagina')) . "</td>";
				print "<td class='optie-cell'>" . $html->link($html->image('dashboard/icons/4.png', array('alt' => 'omlaag')), '/admin/categorien/omlaag/' . $categorie['Categorie']['id'], array('escape' => false, 'title' => 'Verplaats deze pagina')) . "</td>";
				print "<td class='optie-cell'>" . $html->link($html->image('dashboard/icons/12.png', array('alt' => 'verwijderen')), '/admin/categorien/verwijderen/' . $categorie['Categorie']['id'], array('escape' => false, 'title' => 'Verwijder deze pagina'), "Weet je zeker dat je de categorie '".str_replace('&nbsp;','',$categorie['Categorie']['naam'])."' en alle onderliggende pagina's wilt verwijderen?") . "</td>";
				print "</tr>";

				if(count($categorie['children']) > 0)
				{
					$options['level']++;
					printNested($categorie['children'], $html, $options);
					$options['level']--;
				}
			}
		}
	?>

</table>
</div>