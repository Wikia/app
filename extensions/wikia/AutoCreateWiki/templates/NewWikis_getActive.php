<strong>Top Active wikis recently created (from last <?= $weeksNum; ?> weeks):</strong><br />
<br />
Page No: <?= $pageNo ?><br />
<br />
<ul>
<?php foreach( $wikis as $wikiData ): ?>
	<?php var_dump( $wikiData ); ?>
	<li><a href="<?= $wikiData['wikiUrl']; ?>"><?= $wikiData['wikiName']; ?></a> (<?= $wikiData['pv']; ?> PVs)</li>
<?php endforeach; ?>
</ul>
