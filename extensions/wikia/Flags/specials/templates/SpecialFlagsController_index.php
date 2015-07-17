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
	<div class="flags-special-create">
		<a href="#" class="flags-special-create-button wikia-button primary">
			<?= wfMessage( 'flags-special-create-button-text' )->escaped(); ?>
		</a>
	</div>
</div>

<table class="article-table sortable flags-special-list">
	<thead>
		<tr class="flags-special-list-headers">
			<th class="flags-special-list-header-name"><?= wfMessage( 'flags-special-list-header-name' )->escaped() ?></th>
			<th class="flags-special-list-header-template"><?= wfMessage( 'flags-special-list-header-template' )->escaped() ?></th>
			<th class="flags-special-list-header-parameters"><?= wfMessage( 'flags-special-list-header-parameters' )->escaped() ?></th>
			<th class="flags-special-list-header-group"><?= wfMessage( 'flags-special-list-header-group' )->escaped() ?></th>
			<th class="flags-special-list-header-target"><?= wfMessage( 'flags-special-list-header-target' )->escaped() ?></th>
			<th class="flags-special-list-header-target"><?= wfMessage( 'flags-special-list-header-actions' )->escaped() ?></th>
		</tr>
	</thead>
	<tbody>
<?php if ( !empty( $flagTypes ) ): ?>
	<?php foreach ( $flagTypes as $flagTypeId => $flag ): ?>
		<?php $title = Title::newFromText( $flag['flag_view'], NS_TEMPLATE ); ?>
		<tr class="flags-special-list-item" id="flags-special-list-item-<?= $flagTypeId ?>">
			<td class="flags-special-list-item-name" data-flag-name="<?= $flag['flag_name'] ?>"><?= $flag['flag_name'] ?></td>
			<td class="flags-special-list-item-template" data-flag-template="<?= $flag['flag_view'] ?>">
				<a class="flags-special-list-item-template-link" href="<?= Sanitizer::cleanUrl( $title->getFullURL() ) ?>" target="_blank">
					<?= $flag['flag_view'] ?>
				</a>
			</td>
			<td class="flags-special-list-item-params" data-flag-params-names='<?= $flag['flag_params_names'] ?>'>
				<?php
					$paramsNames = json_decode( $flag['flag_params_names'], true );
					if ( is_array( $paramsNames ) ) :
				?>
					<?php foreach ( $paramsNames as $name => $description ): ?>
						<?= $name ?> <small><em><?= $description ?></em></small><br>
					<?php endforeach; ?>
				<?php
					endif;
				?>
			</td>
			<td class="flags-special-list-item-group" data-flag-group="<?= $flag['flag_group'] ?>"><?= $flagGroups[$flag['flag_group']] ?></td>
			<td class="flags-special-list-item-targeting" data-flag-targeting="<?= $flag['flag_targeting'] ?>"><?= ucfirst( $flagTargeting[$flag['flag_targeting']] ) ?></td>
			<td class="flags-special-list-item-actions clearfix">
				<a class="flags-special-list-item-actions-insights" href="#" target="_blank" title="<?= wfMessage( 'flags-icons-actions-insights' )->escaped() ?>">
					<span class="flags-icons-special flags-icons-insights"></span>
				</a>
				<a class="flags-special-list-item-actions-delete" href="#" title="<?= wfMessage( 'flags-icons-actions-delete' )->escaped() ?>" data-flag-type-id="<?= $flagTypeId ?>">
					<span class="flags-icons-special flags-icons-trash"></span>
				</a>
				<a class="flags-special-list-item-actions-edit" href="#" title="<?= wfMessage( 'flags-icons-actions-edit' )->escaped() ?>" data-flag-type-id="<?= $flagTypeId ?>">
					<span class="flags-icons-special flags-icons-edit">
						<?= wfMessage( 'flags-icons-actions-edit' )->escaped() ?>
					</span>
				</a>
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
