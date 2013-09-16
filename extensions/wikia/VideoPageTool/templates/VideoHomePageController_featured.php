<div id="featured-video" class="featured-video">

	<ul class="featured-video-slider">
		<? foreach ( $assets as $featured ): ?>
			<? $videoData = $featured->getAssetData() ?>
			<li>
				<img src="<?= $videoData['largeThumbUrl'] ?>">
			</li>
		<? endforeach; ?>
	</ul>

	<ul>
		<? foreach ( $assets as $featured ): ?>
			<? $videoData = $featured->getAssetData() ?>
			<li><?= $featured->getOrder() ?> - <?= $videoData['videoThumb'] ?><?= $videoData['videoTitle'] ?></li>
		<? endforeach; ?>
	</ul>

</div>
