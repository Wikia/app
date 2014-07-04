<h2><?= wfMsg('wikiastats-heading'); ?></h2>
<div class="statisticdata">
	<div class="datasection firstrowcell">
		<h4><?=
				$app->renderView(
					'WikiaStyleGuideTooltipIconController',
					'index',
					[
						'text' => wfMessage( 'wikiastats-visitors' )->plain(),
						'tooltipIconTitle' => wfMessage( 'wikiastats-visitors-tooltip' )->plain()
					]
				);
			?></h4>
		<strong><?= $wg->Lang->formatNum($visitors); ?></strong>
	</div>
    <div class="datasection">
        <h4><?= wfMessage('wikiastats-mobile-percentage')->plain(); ?></h4>
        <strong><?= wfMessage('wikiastats-mobile-percentage-value', $wg->Lang->formatNum($mobilePercentage))->plain(); ?></strong>
    </div>
    <div class="datasection firstrowcell">
        <h4><?= wfMessage('wikiastats-totalpages')->plain(); ?></h4>
        <strong><?= $wg->Lang->formatNum($totalPages); ?></strong>
    </div>
	<div class="datasection">
		<h4><?= wfMessage('wikiastats-edits')->plain(); ?></h4>
		<strong><?= $wg->Lang->formatNum($edits); ?></strong>
	</div>
	<div class="datasection firstrowcell">
		<h4><?= wfMessage('wikiastats-communities')->plain(); ?></h4>
		<strong><?= $wg->Lang->formatNum($communities); ?></strong>
	</div>
	<div class="datasection">
		<h4><?= wfMessage('wikiastats-new-communities')->plain(); ?></h4>
		<strong><?= $wg->Lang->formatNum($newCommunities); ?></strong>
	</div>
</div>