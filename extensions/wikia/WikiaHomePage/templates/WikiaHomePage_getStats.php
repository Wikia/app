<h2><?= wfMsg('wikiahome-stats-heading'); ?></h2>
<h3><?= wfMsg('wikiahome-stats-content'); ?></h3>
<div class="statisticdata">
	<div class="datasection firstrowcell">
		<h4><?= wfMsg('wikiahome-stats-visitors'); ?></h4>
		<strong><?= $visitors; ?></strong>
	</div>
	<div class="datasection">
		<h4><?= wfMsg('wikiahome-stats-edits'); ?></h4>
		<strong><?= $edits; ?></strong>
	</div>
	<div class="datasection firstrowcell">
		<h4><?= wfMsg('wikiahome-stats-communities'); ?></h4>
		<strong><?= $communities; ?></strong>
	</div>
	<div class="datasection">
		<h4><?= wfMsg('wikiahome-stats-totalpages'); ?></h4>
		<strong><?= $totalPages; ?></strong>
	</div>
</div>