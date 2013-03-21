<h2><?= wfMsg('wikiahome-stats-heading'); ?></h2>
<div class="statisticdata">
	<div class="datasection firstrowcell">
		<h4><?= wfMessage('wikiahome-stats-visitors')->text(); ?></h4>
		<strong><?= $visitors; ?></strong>
	</div>
    <div class="datasection">
        <h4><?= wfMessage('wikiahome-stats-mobile-visitors')->text(); ?></h4>
        <strong><?= $mobileVisitors; ?></strong>
    </div>
    <div class="datasection firstrowcell">
        <h4><?= wfMessage('wikiahome-stats-totalpages')->text(); ?></h4>
        <strong><?= $totalPages; ?></strong>
    </div>
	<div class="datasection">
		<h4><?= wfMessage('wikiahome-stats-edits')->text(); ?></h4>
		<strong><?= $edits; ?></strong>
	</div>
	<div class="datasection firstrowcell">
		<h4><?= wfMessage('wikiahome-stats-communities')->text(); ?></h4>
		<strong><?= $communities; ?></strong>
	</div>
    <div class="datasection">
        <h4><?= wfMessage('wikiahome-stats-new-communities')->text(); ?></h4>
        <strong><?= $newCommunities; ?></strong>
    </div>
</div>