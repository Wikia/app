<div>
	<table class="wikitable sortable">
		<tr>
			<?php foreach ($th as $field): ?>
				<th><?= htmlspecialchars($field); ?></th>
			<?php endforeach; ?>
		</tr>
	<?php foreach ($data as $row): ?>
		<tr>
			<?php foreach ($row as $field): ?>
				<td><?= htmlspecialchars($field); ?></td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
	</table>
</div>
