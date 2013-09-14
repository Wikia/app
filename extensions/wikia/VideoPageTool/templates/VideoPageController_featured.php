<h1>This is the 'featured' display handler</h1>
<ul>
<? foreach ( $assets as $featured ): ?>
	<? $videoData = $featured->getAssetData() ?>
	<li><?= $featured->getOrder() ?> - <?= $videoData['videoThumb'] ?><?= $videoData['videoTitle'] ?> : <?= $videoData['largeThumbUrl'] ?></li>
<? endforeach; ?>
</ul>

<br />
<br />
<br />
<br />
<br />
<div id="featured-video" class="featured-video">
	<ul class="featured-video-slider">
		<li>
			<img src="http://placekitten.com/1000/500">
		</li>
		<li>
			<img src="http://placekitten.com/1001/500">
		</li>
		<li>
			<img src="http://placekitten.com/1002/500">
		</li>
		<li>
			<img src="http://placekitten.com/1003/500">
		</li>
		<li>
			<img src="http://placekitten.com/1004/500">
		</li>
	</ul>
</div>
