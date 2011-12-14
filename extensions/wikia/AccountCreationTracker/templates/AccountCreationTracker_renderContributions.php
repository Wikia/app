<table class="wikitable">
	<thead>
		<th>wiki_id</th>
		<th>page_id</th>
		<th>rev_id</th>
		<th>user_id</th>
		<th>page_ns</th>
		<th>is_content</th>
		<th>is_redirect</th>
		<th>ip</th>
		<th>rev_timestamp</th>
		<th>event_type</th>
		<th>event_date</th>
	</thead>
	<tbody>
	<? foreach( $contributions as $key=>$row ): ?>
	<tr>
		<td><?= $row['wiki_id'] ?></td>
		<td><?= $row['page_id'] ?></td>
		<td><?= $row['rev_id'] ?></td>
		<td><?= $row['user_id'] ?></td>
		<td><?= $row['page_ns'] ?></td>
		<td><?= $row['is_content'] ?></td>
		<td><?= $row['is_redirect'] ?></td>
		<td><?= $row['ip'] ?></td>
		<td><?= $row['rev_timestamp'] ?></td>
		<td><?= $row['event_type'] ?></td>
		<td><?= $row['event_date'] ?></td>
	</tr>
	<? endforeach; ?>
	</tbody>
</table>