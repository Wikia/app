<div>
	<form method="GET" action="">
		<input name="template" type="text" value="<?= Sanitizer::encodeAttribute( $template ) ?>">
		<select name="type">
			<option value="">All types</option>
			<?php foreach( $groups as $group ): ?>
				<option value="<?= Sanitizer::encodeAttribute( $group ) ?>" <?php if( $group == $type ): ?>selected<?php endif ?>><?= wfMessage( 'template-classification-type-' . $group )->escaped() ?></option>
			<?php endforeach ?>
		</select>
		<input type="submit" value="<?= wfMessage( 'template-classification-special-search' )->escaped() ?>">
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
					<a href="<?= Sanitizer::cleanUrl( $template['url'] ) ?>">
						<?= Sanitizer::escapeHtmlAllowEntities( $template['title'] ); ?>
					</a>
					<br/>
					<?php if ( isset( $template['revision'] ) ) : ?>
						<?= wfMessage( 'template-classification-special-last-edit' )->rawParams(
							Xml::element( 'a', [
								'href' => $template['revision']['userpage']
							],
								$template['revision']['username']
							),
							date( 'F j, Y', $template['revision']['timestamp'] )
						)->escaped() ?>
					<?php endif; ?>
				</td>
				<td><a href="<?= Sanitizer::cleanUrl( $template['wlh'] ) ?>"><?= Sanitizer::escapeHtmlAllowEntities( $template['count'] ); ?></a></td>
				<td><?= $groupName ?></td>
			</tr>
		<?php endforeach ?>
	<?php endforeach ?>
</table>

<?php if ( $paginatorBar ) : ?>
	<p><?= $paginatorBar ?></p>
<?php endif ?>