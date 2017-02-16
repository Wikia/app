<div id="article-video" class="article-video">
	<img class="video-thumbnail" src="<?= $thumbnailUrl; ?>">
	<div class="video-container">
		<div class="video-placeholder">
			<img class="video-thumbnail" src="<?= $thumbnailUrl; ?>">
			<!-- TODO: replace with DS tiny icon -->
			<img src="<?= $closeIconUrl; ?>" class="close">
			<svg class="spinner">
				<circle cx="24" cy="24" r="22"></circle>
			</svg>
			<div class="video-details">
				<div class="video-details-left">
					<div class="video-time"><?= htmlspecialchars( wfMessage( 'articlevideo-watch',
							$videoDetails['time'] ) ); ?></div>
					<div
						class="video-title"><?= htmlspecialchars( $videoDetails['title'] ); ?></div>
				</div>
				<img src="<?= $videoPlayButtonUrl; ?>" class="video-play-button">
			</div>
		</div>
		<div id="ooyala-article-video" class="ooyala-article-video"></div>
	</div>
</div>

<script src="<?= $ooyalaJs; ?>"></script>