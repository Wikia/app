<p>
	<form method="GET" action="">
		<label for="template">
			<?= wfMessage( 'template-classification-special-find-template' )->escaped() ?>
			<input name="template" type="text" value="<?= Sanitizer::encodeAttribute( $templateName ) ?>" />
		</label>
		<input type="submit" value="<?= wfMessage( 'template-classification-special-search' )->escaped() ?>">
	</form>
	<form method="GET" action="">
		<?php if ( !empty( $groups ) ): ?>
			<label for="type">
				<?= wfMessage( 'template-classification-special-find-type' )->escaped() ?>
				<select name="type">
					<?php foreach( $groups as $group ): ?>
						<option value="<?= Sanitizer::encodeAttribute( $group ) ?>" <?php if( $group == $type ): ?>selected<?php endif ?>><?= wfMessage( 'template-classification-type-' . $group )->escaped() ?></option>
					<?php endforeach ?>
				</select>
			</label>
			<input type="submit" value="<?= wfMessage( 'template-classification-special-search' )->escaped() ?>">
		<?php endif ?>
	</form>
</p><br/>
<?php if ( !empty( $templates ) ): ?>
<table class="templates-hq article-table">
	<tr>
		<th><?= wfMessage( 'template-classification-special-page-header' )->escaped() ?></th>
		<th><?= wfMessage( 'template-classification-special-used-header' )->escaped() ?></th>
		<th><?= wfMessage( 'template-classification-special-type-header' )->escaped() ?></th>
	</tr>
	<?php $groupName = wfMessage( 'template-classification-type-' . $type )->escaped(); ?>
	<?php foreach( $templates as $template ): ?>
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
						$template['revision']['timestamp']
					)->escaped() ?>
				<?php endif; ?>
			</td>
			<td><a href="<?= Sanitizer::cleanUrl( $template['wlh'] ) ?>"><?= Sanitizer::escapeHtmlAllowEntities( $template['count'] ); ?></a></td>
			<td>
				<?= $groupName ?>
				<?php if( !empty( $template['subgroup'] ) ): ?>
					(<?= $template['subgroup'] ?>)
				<?php endif ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>
<?php if ( $paginatorBar ) : ?>
	<p><?= $paginatorBar ?></p>
<?php endif ?>
<?php else: ?>
	<p><?= wfMessage( 'template-classification-special-noresults' )->escaped() ?></p>
<?php endif ?>
