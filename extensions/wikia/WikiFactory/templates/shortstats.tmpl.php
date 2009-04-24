<h2>
	Wikis created daily:
</h2>
<table class="filehistory">
	<tr>
		<th>date</th>
		<th>total</th>
		<th>active</th>
		<th>disabled</th>
		<th>redirected</th>
	</tr>
<?php foreach( $stats as $date => $row ): ?>
	<tr>
		<td><?php echo $date ?></td>
		<td><?php echo isset( $row->total ) ? $row->total : 0; ?></td>
		<td><?php echo isset( $row->active ) ? $row->active : 0; ?></td>
		<td><?php echo isset( $row->disabled ) ? $row->disabled : 0; ?></td>
		<td><?php echo isset( $row->redirected ) ? $row->redirected : 0; ?></td>
	</tr>
<?php endforeach; ?>
</table>
