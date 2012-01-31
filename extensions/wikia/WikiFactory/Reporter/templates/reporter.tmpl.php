<div>
	<h2>Variable</h2>
	<table class="WikiaTable">
		<tr>
			<th>id</th>
			<th>name</th>
			<th>group</th>
			<th>type</th>
		</tr>
		<tr>
			<td><?php print $variable->cv_variable_id; ?></td>
			<td><?php print $variable->cv_name; ?></td>
			<td><?php print "<span style='border-bottom: 1px dotted gray;' title='{$variable->cv_variable_group}'>{$variable->var_group}</span>"; ?></td>
			<td><?php print $variable->cv_variable_type; ?></td>
		</tr>
		<tr>
			<td colspan='4'><?php print $variable->cv_description; ?></td>
		</tr>
	</table>
</div>
<div>
<h2>Summary</h2>
	<div style="max-height: 300px; overflow: auto;">
	<ul><?php foreach ($acv as $var=>$num): ?>
		<li><?php $wie_url = $wie_base . "&likeValue=". rawurlencode($var);
			print "<a href=\"{$wie_url}\" title='search wikis with this value'>{$sprites['search']}</a>";
			print " {$num}: {$var}"; ?></li>
	<?php endforeach; ?></ul>
	</div>
</div>

<div>
	<h2>Values</h2>
<?php if($limit_message)
{
	print $limit_message;
}
?>
	<table class="WikiaTable sortable">
		<tr>
			<?php foreach ($th as $field): ?>
				<th><?php print htmlspecialchars($field); ?></th>
			<?php endforeach; ?>
				<th class="unsortable"></th>
		</tr>
	<?php foreach ($data as $row): ?>
		<tr>
			<?php foreach ($row as $field): ?>
				<td><?php print htmlspecialchars($field); ?></td>
			<?php endforeach; ?>
				<td><a href="<?php print "{$wf_base}/{$row['city']}/variables/{$variable->cv_name}"; ?>" title='edit'><?php print $sprites['edit']; ?></a></td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>

