<div id="featured-video" class="featured-video">

	<div class="featured-video-slider" id="featured-video-slider">
		<ul id="featured-video-bxslider" class="bxslider">
			<? foreach ( $assets as $featured ): ?>
				<? $videoData = $featured->getAssetData() ?>
				<li>
					<img src="<?= $videoData['largeThumbUrl'] ?>">
				</li>
			<? endforeach; ?>
		</ul>

		<div id="featured-video-thumbs" class="thumbs">
			<div class="thumbs-inner">
				<? foreach ( $assets as $featured ): ?>
					<? $videoData = $featured->getAssetData() ?>
					<?= $videoData['videoThumb'] ?>
				<? endforeach; ?>
			</div>
		</div>
	</div>

</div>


<br style="clear:both">
<br>
<br>
<br>
<br>
