<div class="flags-special-header clearfix">
	<div class="flags-special-header-content">
		<?= wfMessage('flags-special-video')->parse() ?>
		<h1 class="flags-special-header-content-title">
			<?= wfMessage( 'flags-special-title' )->escaped() ?>
		</h1>
		<p class="flags-special-header-content-text">
			<?= wfMessage( 'flags-special-header-text' )->parse() ?>
		</p>
	</div>
	<? if ( $hasAdminPermissions ): ?>
	<div class="flags-special-create">
		<a href="#" class="flags-special-create-button wikia-button primary">
			<?= wfMessage( 'flags-special-create-button-text' )->escaped(); ?>
		</a>
	</div>
	<? endif; ?>
</div>

<table class="article-table sortable flags-special-list">
	<thead>
		<tr class="flags-special-list-headers">
			<th class="flags-special-list-header-name"><?= wfMessage( 'flags-special-list-header-name' )->escaped() ?></th>
			<th class="flags-special-list-header-template"><?= wfMessage( 'flags-special-list-header-template' )->escaped() ?></th>
			<th class="flags-special-list-header-parameters"><?= wfMessage( 'flags-special-list-header-parameters' )->escaped() ?></th>
			<th class="flags-special-list-header-group"><?= wfMessage( 'flags-special-list-header-group' )->escaped() ?></th>
			<th class="flags-special-list-header-target"><?= wfMessage( 'flags-special-list-header-target' )->escaped() ?></th>
			<th class="flags-special-list-header-actions"><?= wfMessage( 'flags-special-list-header-actions' )->escaped() ?></th>
		</tr>
	</thead>
	<tbody>
<?php if ( !empty( $flagTypes ) ): ?>
	<?php foreach ( $flagTypes as $flagTypeId => $flag ): ?>
		<?php $title = Title::newFromText( $flag['flag_view'], NS_TEMPLATE ); ?>
		<tr class="flags-special-list-item" id="flags-special-list-item-<?= $flagTypeId ?>">
			<td class="flags-special-list-item-name" data-flag-name="<?= Sanitizer::encodeAttribute( $flag['flag_name'] ) ?>"><?= htmlspecialchars( $flag['flag_name'] ) ?></td>
			<td class="flags-special-list-item-template" data-flag-template="<?= Sanitizer::encodeAttribute( $flag['flag_view'] ) ?>">
				<?= Linker::link( $title, htmlspecialchars( $flag['flag_view'] ), [
					'class' => 'flags-special-list-item-template-link',
					'target' => '_blank',
				] ); ?>
			</td>
			<td class="flags-special-list-item-params" data-flag-params-names='<?= Sanitizer::encodeAttribute( $flag['flag_params_names'] ) ?>'>
				<?php
					$paramsNames = json_decode( $flag['flag_params_names'], true );
					if ( is_array( $paramsNames ) ) :
				?>
					<?php foreach ( $paramsNames as $name => $description ): ?>
						<?= htmlspecialchars( $name ) ?> <small><em><?= htmlspecialchars( $description ) ?></em></small><br>
					<?php endforeach; ?>
				<?php
					endif;
				?>
			</td>
			<td class="flags-special-list-item-group" data-flag-group="<?= Sanitizer::encodeAttribute( $flag['flag_group'] ) ?>"><?= $flagGroups[$flag['flag_group']]['name'] ?></td>
			<td class="flags-special-list-item-targeting" data-flag-targeting="<?= Sanitizer::encodeAttribute( $flag['flag_targeting'] ) ?>"><?= ucfirst( $flagTargeting[$flag['flag_targeting']]['name'] ) ?></td>
			<td class="flags-special-list-item-actions clearfix">
				<?php
					if ( $insightsTitle ):
					$insightUrl = Sanitizer::cleanUrl( $insightsTitle->getFullUrl( [ 'flagTypeId' => $flagTypeId ] ) );
				?>
					<a class="flags-special-list-item-actions-insights" href="<?= $insightUrl ?>" target="_blank" title="<?= wfMessage( 'flags-icons-actions-insights' )->escaped() ?>">
						<span class="flags-icons-special flags-icons-insights"></span>
					</a>
				<?php
					endif;
				?>
			<? if ( $hasAdminPermissions ): ?>
				<a class="flags-special-list-item-actions-delete" href="#" title="<?= wfMessage( 'flags-icons-actions-delete' )->escaped() ?>" data-flag-type-id="<?= Sanitizer::encodeAttribute( $flagTypeId ) ?>">
					<span class="flags-icons-special flags-icons-trash"></span>
				</a>
				<a class="flags-special-list-item-actions-edit" href="#" title="<?= wfMessage( 'flags-icons-actions-edit' )->escaped() ?>" data-flag-type-id="<?= Sanitizer::encodeAttribute( $flagTypeId ) ?>">
					<span class="flags-icons-special flags-icons-edit">
						<?= wfMessage( 'flags-icons-actions-edit' )->escaped() ?>
					</span>
				</a>
			<? endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
<?php endif; ?>
	</tbody>
</table>

<?php if ( empty( $flagTypes ) ): ?>
	<div class="flags-special-zero-status">
		<?= wfMessage( 'flags-special-zero-state' )->parse(); ?>
	</div>
<?php endif; ?>
