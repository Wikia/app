<div class="wikia-mailer-log">
	<table>
		<tr><th>ID</th><th>Created</th><th>Wiki</th><th>To</th><th>Subject</th><th>Attempted</th><th>Transmitted</th><th>Error</th></tr>
		<?php foreach ($records as $row): ?>
		<tr><td><?= $row['id'] ?></td><td><?= $row['created'] ?></td><td><?= $row['wiki_name'] ?></td><td><?= $row['to'] ?></td><td><?= $row['subject'] ?></td><td>---</td><td><?= $row['transmitted'] ?></td><td><?= $row['error_msg'] ?></td></tr>
		<?php endforeach; ?>
	</table>
</div>