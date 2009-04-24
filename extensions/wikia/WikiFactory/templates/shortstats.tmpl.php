<table class="filehistory">
	<tr>
		<th>date</th>
		<th>how many</th>
	</tr>
<?php foreach( $stats as $row ): ?>
	<tr>
		<td><?php echo $row->date ?></td>
		<td><?php echo $row->count ?></td>
	</tr>
<?php endforeach; ?>
</table>
