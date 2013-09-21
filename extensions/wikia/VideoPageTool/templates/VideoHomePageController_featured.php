<div id="featured-video" class="featured-video">

	<div class="featured-video-slider eight columns centered" id="featured-video-slider">
		<ul id="featured-video-bxslider" class="bxslider">
			<? foreach ( $assets as $featured ): ?>
				<? $videoData = $featured->getAssetData() ?>
				<li>
					<div class="Wikia-video-play-button">
						<img class="sprite large play" src="<?= $wg->BlankImgUrl ?>">
					</div>
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
