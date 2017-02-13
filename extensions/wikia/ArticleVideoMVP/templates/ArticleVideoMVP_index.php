<div id="premium-mvp-video">
	<img class="thumbnail" src="<?= $thumbnailUrl; ?>">
	<div class="video-container">
		<div class="video-placeholder">
			<div class="video-thumbnail">
				<img class="thumbnail" src="<?= $thumbnailUrl; ?>">
				<img src="<?= $closeIconUrl; ?>" class="close">
			</div>
			<div class="video-details">
				<div class="video-details-left">
					<div class="video-time"><?= wfMessage( 'articlevideomvp-watch',
							$videoDetails['time'] ); ?></div>
					<div class="video-title"><?= $videoDetails['title']; ?></div>
				</div>
				<img src="<?= $videoPlayButtonUrl; ?>" class="video-play-button">
			</div>
		</div>
		<div id="ooyala-article-video"></div>
	</div>
</div>
