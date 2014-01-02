<h2><?= wfMsg('wikiahome-stats-heading'); ?></h2>
<div class="statisticdata">
	<div class="datasection firstrowcell">
		<h4><?=
				$app->renderView(
					'WikiaStyleGuideTooltipIconController',
					'index',
					[
						'text' => wfMessage( 'wikiahome-stats-visitors' )->plain(),
						'tooltipIconTitle' => wfMessage( 'wikiahome-stats-visitors-tooltip' )->plain()
					]
				);
			?></h4>
		<strong><?= $visitors; ?></strong>
	</div>
    <div class="datasection">
        <h4><?= wfMessage('wikiahome-stats-mobile-percentage')->plain(); ?></h4>
        <strong><?= wfMessage('wikiahome-stats-mobile-percentage-value', $mobilePercentage)->plain(); ?></strong>
    </div>
    <div class="datasection firstrowcell">
        <h4><?= wfMessage('wikiahome-stats-totalpages')->plain(); ?></h4>
        <strong><?= $totalPages; ?></strong>
    </div>
	<div class="datasection">
		<h4><?= wfMessage('wikiahome-stats-edits')->plain(); ?></h4>
		<strong><?= $edits; ?></strong>
	</div>
	<div class="datasection firstrowcell">
		<h4><?= wfMessage('wikiahome-stats-communities')->plain(); ?></h4>
		<strong><?= $communities; ?></strong>
	</div>
    <div class="datasection">
        <h4><?= wfMessage('wikiahome-stats-new-communities')->plain(); ?></h4>
        <strong><?= $newCommunities; ?></strong>
    </div>
</div>