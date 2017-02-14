<div id="article-video" class="article-video">
	<img class="video-thumbnail" src="<?= $thumbnailUrl; ?>">
	<div class="video-container">
		<div class="video-placeholder">
			<img class="video-thumbnail" src="<?= $thumbnailUrl; ?>">
			<img src="<?= $closeIconUrl; ?>" class="close">
			<div class="video-details">
				<div class="video-details-left">
					<div class="video-time"><?= wfMessage( 'articlevideo-watch',
							$videoDetails['time'] ); ?></div>
					<div class="video-title"><?= $videoDetails['title']; ?></div>
				</div>
				<img src="<?= $videoPlayButtonUrl; ?>" class="video-play-button">
			</div>
		</div>
		<div id="ooyala-article-video"></div>
	</div>
</div>
