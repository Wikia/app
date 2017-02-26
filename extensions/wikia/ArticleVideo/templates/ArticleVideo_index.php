<div id="article-video" class="article-video">
	<img class="video-thumbnail"
	     src="<?= Sanitizer::encodeAttribute( $videoDetails['thumbnailUrl'] ); ?>">
	<div class="video-container">
		<div class="video-placeholder">
			<img class="video-thumbnail"
			     src="<?= Sanitizer::encodeAttribute( $videoDetails['thumbnailUrl'] ); ?>">
			<img src="<?= $closeIconUrl; ?>" class="close">
			<svg class="spinner">
				<circle cx="24" cy="24" r="22"></circle>
			</svg>
			<div class="video-details">
				<div class="video-details-left">
					<div class="video-time"><?= wfMessage( 'articlevideo-watch',
							$videoDetails['time'] )->escaped(); ?></div>
					<div class="video-title"><?= htmlspecialchars( $videoDetails['title'] ); ?></div>
				</div>
				<img src="<?= $videoPlayButtonUrl; ?>" class="video-play-button">
			</div>
		</div>
		<div id="ooyala-article-video" class="ooyala-article-video"></div>
	</div>
</div>

