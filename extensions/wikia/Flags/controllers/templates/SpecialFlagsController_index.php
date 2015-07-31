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
</div>
<?php if ( !empty( $flagTypes ) ): ?>
	<table class="article-table sortable flags-special-list">
		<tr class="flags-special-list-headers">
			<th class="flags-special-list-header-name"><?= wfMessage( 'flags-special-list-header-name' )->escaped() ?></th>
			<th class="flags-special-list-header-template"><?= wfMessage( 'flags-special-list-header-template' )->escaped() ?></th>
			<th class="flags-special-list-header-parameters"><?= wfMessage( 'flags-special-list-header-parameters' )->escaped() ?></th>
			<th class="flags-special-list-header-group"><?= wfMessage( 'flags-special-list-header-group' )->escaped() ?></th>
			<th class="flags-special-list-header-target"><?= wfMessage( 'flags-special-list-header-target' )->escaped() ?></th>
		</tr>
	<?php foreach ( $flagTypes as $flagTypeId => $flag ): ?>
		<?php $title = Title::newFromText( $flag['flag_view'], NS_TEMPLATE ); ?>
		<tr class="flags-special-list-item">
			<td class="flags-special-list-item-name"><?= $flag['flag_name'] ?></td>
			<td class="flags-special-list-item-template">
				<?= Linker::link( $title, $flag['flag_view'], [
					'class' => 'flags-special-list-item-template-link',
					'target' => '_blank',
				] ); ?>
			</td>
			<td class="flags-special-list-item-params">
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
			<td class="flags-special-list-item-group"><?= $flagGroups[$flag['flag_group']] ?></td>
			<td class="flags-special-list-item-targeting"><?= ucfirst( $flagTargeting[$flag['flag_targeting']] ) ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<div class="flags-special-zero-status">
		<?= wfMessage( 'flags-special-zero-state' )->parse(); ?>
	</div>
<?php endif; ?>
