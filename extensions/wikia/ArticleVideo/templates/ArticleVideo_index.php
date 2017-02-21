<div id="article-video" class="article-video">
	<img class="video-thumbnail" src="<?= $thumbnailUrl; ?>">
	<div class="video-container">
		<div class="video-placeholder">
			<img class="video-thumbnail" src="<?= $thumbnailUrl; ?>">
			<img src="<?= $closeIconUrl; ?>" class="close">
			<svg class="spinner">
				<circle cx="24" cy="24" r="22"></circle>
			</svg>
			<div class="video-details">
				<div class="video-details-left">
					<div class="video-time"><?= wfMessage( 'articlevideo-watch', $videoDetails['time'] )->escaped(); ?></div>
					<div class="video-title"><?= htmlspecialchars( $videoDetails['title'] ); ?></div>
				</div>

			</div>
		</div>
		<div class="video-button paused">
			<div class="countdown-timer">
				<div class="left-half"><div class="countdown-track"></div></div>
				<div class="right-half"><div class="countdown-track"></div></div>
			</div>
		</div>
		<div id="ooyala-article-video" class="ooyala-article-video"></div>
	</div>
</div>

