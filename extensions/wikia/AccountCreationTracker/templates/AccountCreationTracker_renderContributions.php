<table>
	<? foreach( $contributions as $key=>$row ): ?>
		<? if( $key == 0): ?>
			<thead>
				<tr>
					<? foreach( $row as $field=>$val ): ?>
					<th><?= $field ?></th>
					<? endforeach; ?>
				</tr>
			</thead>
		<? endif ?>
		<? if( count($contributions)>0 && $key == 0): ?>
			<tbody>
		<? endif; >
		<tr>
			<? foreach( $row as $field=>$val ): ?>
			<td><?= $val ?></td>
			<? endforeach; ?>
		</tr>
	<? endforeach; ?>
	<? if( count($contributions)>0 ): ?>
	</tbody>
	<? endif; >
</table>