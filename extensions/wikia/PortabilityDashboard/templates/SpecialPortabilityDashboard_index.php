<table>
	<thead>
		<th>1</th>
		<th>2</th>
		<th>3</th>
		<th>4</th>
		<th>5</th>
	</thead>
	<tbody>
	<? foreach( $list as $item ): ?>
		<tr>
			<td><?= $item['wiki_id'] ?></td>
			<td><?= $item['portability'] ?></td>
			<td><?= $item['infobox_portability'] ?></td>
			<td><?= $item['traffic'] ?></td>
			<td><?= $item['migration_impact'] ?></td>
		</tr>
	<? endforeach ?>
	</tbody>
</table>
