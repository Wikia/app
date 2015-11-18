<p>
	<form method="GET" action="">
		<label for="template">
			<?= wfMessage( 'template-classification-special-search' )->escaped() ?>
			<input name="template" type="text" value="<?= Sanitizer::encodeAttribute( $templateName ) ?>" />
		</label>
		<?php if ( !empty( $groups ) ): ?>
			<select name="type">
				<?php foreach( $groups as $group ): ?>
					<option value="<?= Sanitizer::encodeAttribute( $group ) ?>" <?php if( $group == $type ): ?>selected<?php endif ?>><?= wfMessage( 'template-classification-type-' . $group )->escaped() ?></option>
				<?php endforeach ?>
			</select>
		<?php endif ?>
		<input type="submit" value="<?= wfMessage( 'template-classification-special-search' )->escaped() ?>">
	</form>
</p><br/>
<?php if ( !empty( $templates ) ): ?>
<table class="templates-hq article-table">
	<tr>
		<th>Page name</th>
		<th>Used on</th>
		<th>Template type</th>
	</tr>
	<?php foreach( $templates as $template ): ?>
		<?php $groupName = wfMessage( 'template-classification-type-' . $type )->escaped(); ?>
			<tr>
				<td>
					<h3><a href="<?= Sanitizer::cleanUrl( $template['url'] ) ?>">
						<?= Sanitizer::escapeHtmlAllowEntities( $template['title'] ); ?>
					</a></h3>
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
</table>
<?php if ( $paginatorBar ) : ?>
	<p><?= $paginatorBar ?></p>
<?php endif ?>
<?php else: ?>
	<p><?= wfMessage( 'template-classification-special-noresults' )->escaped() ?></p>
<?php endif ?>
