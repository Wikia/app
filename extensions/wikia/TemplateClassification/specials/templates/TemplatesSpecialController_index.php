<div>
	<form method="GET">
		<input type="text" value="<?= $template ?>">
		<select>
			<option value="">All types</option>
			<?php foreach( $groups as $group ): ?>
				<option value="<?= $group ?>" <?php if( $group == $type ): ?>selected<?php endif ?>><?= wfMessage( 'template-classification-type-' . $group )->escaped() ?></option>
			<?php endforeach ?>
		</select>
		<input type="submit">
	</form>
</div>
<table class="templates-hq">
	<tr>
		<th>Page name</th>
		<th>Used on</th>
		<th>Template type</th>
	</tr>
	<?php foreach( $groupedTemplates as $group => $templates ): ?>
		<?php $groupName = wfMessage( 'template-classification-type-' . $group )->escaped(); ?>
		<tr>
			<td colspan="3" style="text-align: left;"><h3><?= $groupName ?></h3><hr/></td>
		</tr>
		<?php foreach( $templates as $template ): ?>
			<tr>
				<td>
					<a href="<?= $template['url'] ?>"><?= $template['title']; ?></a><br/>
					Last edited by <a href="<?= $template['revision']['userpage'] ?>"><?= $template['revision']['username'] ?></a>,
					<?= date( 'F j, Y', $template['revision']['timestamp'] ) ?>
				</td>
				<td><a href="<?= $template['wlh'] ?>"><?= $template['count']; ?></a></td>
				<td><?= $groupName ?></td>
			</tr>
		<?php endforeach ?>
	<?php endforeach ?>
</table>