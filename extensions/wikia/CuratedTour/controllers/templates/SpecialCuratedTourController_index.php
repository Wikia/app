<div class="curated-tour-special-header clearfix">
	<div class="curated-tour-special-header-content">
		<h1 class="curated-tour-special-header-content-title">
			<?=wfMessage( 'curated-tour-manage' )->escaped()?>
		</h1>

		<p class="curated-tour-special-header-content-text">
			<?=wfMessage( 'curated-tour-header-text' )->parse()?>
		</p>
		<? if ( $hasAdminPermissions ): ?>
		<p class="curated-tour-special-header-content-tip">
			<?=wfMessage( 'curated-tour-header-tip' )->parse()?>
		</p>
		<? endif; ?>
	</div>
	<a class="ct-play-button" href="#"><?= wfMessage( 'curated-tour-start-text' )->escaped() ?></a>
</div>
<?php if ( !empty( $pageTour ) ): ?>
	<? if ( $hasAdminPermissions ): ?>
		<div class="curated-tour-special-edit">
			<a href="#" class="curated-tour-special-edit-button wikia-button primary">
				<?=wfMessage( 'curated-tour-special-edit-button-text' )->escaped();?>
			</a>
		</div>
	<? endif; ?>
	<table class="article-table sortable curated-tour-special-list">
		<tr class="curated-tour-special-list-headers">
			<th class="curated-tour-special-list-header-name"><?=wfMessage( 'curated-tour-special-list-header-name' )->escaped()?></th>
			<th class="curated-tour-special-list-header-selector"><?=wfMessage( 'curated-tour-special-list-header-selector' )->escaped()?></th>
			<th class="curated-tour-special-list-header-notes"><?=wfMessage( 'curated-tour-special-list-header-notes' )->escaped()?></th>
		</tr>
		<?php foreach ( $pageTour as $pageTourItem ): ?>
			<tr class="curated-tour-special-list-item">
				<td class="curated-tour-special-list-item-name"><?=$pageTourItem['PageName']?></td>
				<td class="curated-tour-special-list-item-selector"><?=$pageTourItem['Selector']?></td>
				<td class="curated-tour-special-list-item-notes"><?=$pageTourItem['Notes']?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php else: ?>
	<div class="curated-tour-special-zero-status">
		<?=wfMessage( 'curated-tour-special-zero-state' )->parse();?>
	</div>
	<?  if ( $hasAdminPermissions ): ?>
		<div class="curated-tour-special-create">
			<a href="#" class="curated-tour-special-plan-button wikia-button primary">
				<?=wfMessage( 'curated-tour-special-plan-button-text' )->escaped();?>
			</a>
		</div>
	<?  endif; ?>
<?php endif; ?>
