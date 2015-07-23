<div class="curatedTour-special-header clearfix">
	<div class="curatedTour-special-header-content">
		<h1 class="curatedTour-special-header-content-title">
			<?=wfMessage( 'curated-tour-manage' )->escaped()?>
		</h1>

		<p class="curatedTour-special-header-content-text">
			<?=wfMessage( 'curated-tour-header-text' )->parse()?>
		</p>
	</div>
</div>
<table class="article-table sortable curatedTour-special-list">
	<?php if (!empty( $pageTour )): ?>
	<tr class="curatedTour-special-list-headers">
		<th class="curatedTour-special-list-header-name"><?=wfMessage( 'curated-tour-special-list-header-name' )->escaped()?></th>
		<th class="curatedTour-special-list-header-selector"><?=wfMessage( 'curated-tour-special-list-header-selector' )->escaped()?></th>
		<th class="curatedTour-special-list-header-notes"><?=wfMessage( 'curated-tour-special-list-header-notes' )->escaped()?></th>

	</tr>
	<?php foreach ( $pageTour as $pTour ): ?>
	<tr class="curatedTour-special-list-item">
		<td class="curatedTour-special-list-item-name"><?=$pageTour['PageName']?></td>
		<td class="curatedTour-special-list-item-selector"><?=$pageTour['Selector']?></td>
		<td class="curatedTour-special-list-item-notes"><?=$pageTour['Notes']?></td>
		<?php endforeach; ?>
		<?php else: ?>
			<div class="curatedTour-special-zero-status">
				<?=wfMessage( 'curatedTour-special-zero-state' )->parse();?>
			</div>
		<?php endif; ?>
</table>
