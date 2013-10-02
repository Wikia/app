<div id="featured-video" class="featured-video row collapse">

	<div class="featured-video-slider hidden small-12 columns" id="featured-video-slider">
		<ul id="featured-video-bxslider" class="bxslider">
			<? $index = 0; ?>
			<? foreach ( $assets as $videoData ): ?>
				<li>
					<div class="slide-image" data-index="<?= $index ?>">
						<div class="Wikia-video-play-button">
							<img class="sprite large play" src="<?= $wg->BlankImgUrl ?>">
						</div>
						<img src="<?= $videoData['largeThumbUrl'] ?>">
						<div class="caption small-4 columns">
							<span class="title"><?= $videoData['displayTitle'] ?></span>
							<span class="description"><?= $videoData['description'] ?></span>
						</div>
					</div>
					<div class="slide-video"></div>
				</li>
				<? $index++; ?>
			<? endforeach; ?>
		</ul>

		<div id="featured-video-thumbs" class="thumbs small-12 columns">
			<ul class="thumbs-inner small-block-grid-5">
				<? foreach ( $assets as $videoData ): ?>
					<li><a class="video">
							<span class="Wikia-video-play-button">
								<img class="sprite medium play" src="<?= $wg->BlankImgUrl ?>">
							</span>
							<img data-video-key="<?= $videoData['videoKey'] ?>" src="<?= $videoData['thumbUrl'] ?>">
						</a>
						<div class="title"><p><?= $videoData['displayTitle'] ?></p></div>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
</div>
