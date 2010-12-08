<?php
// PhpDoc Comments for code completion in views */
/* @var $this View */
/* @var $html HtmlHelper */
/* @var $javascript JavascriptHelper */
?>
<div class="block-titel">Teksten</div>


<div id="cta">
	<button class="add" onclick="location.href='<?php echo $html->url('/admin/paginas/toevoegen/'); ?>';"><span>Pagina toevoegen</span></button>
</div>

<ul id="tabs"></ul>

<div class="tab_container">
<table width='100%' class="lijst">

	<thead>
		<tr>
			<th>pagina</th>
			<th>url</th>
			<th colspan="4">opties</th>
		</tr>
	</thead>

	<?php
		printNested($this->data, $html, array('controller' => 'paginas', 'level' => 0));
		function printNested($children, &$html, $options)
		{
			foreach($children as $pagina)
			{
				print "<tr class='nested-row-" . $options['level'] . "'>";
				print "<td class='nested-cell'>";
				print $html->link($pagina['Pagina']['titel'], array('controller' => $options['controller'], 'action' => 'bewerken', $pagina['Pagina']['id']), array('escape' => false));
				print "</td><td>";
				print $html->link('/p' . $pagina['Pagina']['url'], '/p' . $pagina['Pagina']['url'], array('escape' => false));
				print "</td>";

				print "<td class='optie-cell'>" . $html->link($html->image('dashboard/icons/71.png', array('alt' => 'bewerken')), '/admin/paginas/bewerken/' . $pagina['Pagina']['id'], array('escape' => false, 'title' => 'Bewerk deze pagina')) . "</td>";
				print "<td class='optie-cell'>" . $html->link($html->image('dashboard/icons/3.png', array('alt' => 'omhoog')), '/admin/paginas/omhoog/' . $pagina['Pagina']['id'], array('escape' => false, 'title' => 'Verplaats deze pagina')) . "</td>";
				print "<td class='optie-cell'>" . $html->link($html->image('dashboard/icons/4.png', array('alt' => 'omlaag')), '/admin/paginas/omlaag/' . $pagina['Pagina']['id'], array('escape' => false, 'title' => 'Verplaats deze pagina')) . "</td>";
				print "<td class='optie-cell last'>" . $html->link($html->image('dashboard/icons/12.png', array('alt' => 'verwijderen')), '/admin/paginas/verwijderen/' . $pagina['Pagina']['id'], array('escape' => false, 'title' => 'Verwijder deze pagina'), "Weet je zeker dat je pagina '".str_replace('&nbsp;','',$pagina['Pagina']['titel'])."' en alle onderliggende pagina's wilt verwijderen?") . "</td>";
				print "</tr>";

				if(count($pagina['children']) > 0)
				{
					$options['level']++;
					printNested($pagina['children'], $html, $options);
					$options['level']--;
				}
			}
		}
	?>

</table>
</div>