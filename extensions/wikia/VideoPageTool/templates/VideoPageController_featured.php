<h1>This is the 'featured' display handler</h1>
<ul>
<? foreach ( $assets as $featured ): ?>
	<? $videoData = $featured->getAssetData() ?>
	<li><?= $featured->getOrder() ?> - <?= $videoData['videoThumb'] ?><?= $videoData['videoTitle'] ?> : <?= $videoData['largeThumbUrl'] ?></li>
<? endforeach; ?>
</ul>