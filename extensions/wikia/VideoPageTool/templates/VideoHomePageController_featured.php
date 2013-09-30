<div id="featured-video" class="featured-video row collapse">

	<div class="featured-video-slider small-12 medium-8 columns small-centered" id="featured-video-slider">
		<ul id="featured-video-bxslider" class="bxslider">
			<? $index = 0; ?>
			<? foreach ( $assets as $videoData ): ?>
				<li>
					<div class="slide-image" data-index="<?= $index ?>">
						<div class="Wikia-video-play-button">
							<img class="sprite large play" src="<?= $wg->BlankImgUrl ?>">
						</div>
						<img src="<?= $videoData['largeThumbUrl'] ?>">
					</div>
					<div class="slide-video"></div>
				</li>
				<? $index++; ?>
			<? endforeach; ?>
		</ul>

		<div id="featured-video-thumbs" class="thumbs small-12 columns">
			<div class="thumbs-inner">
				<? foreach ( $assets as $videoData ): ?>
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
