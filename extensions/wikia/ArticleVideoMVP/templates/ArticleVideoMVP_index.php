<div id="premium-mvp-video" style="background-image: url(<?= $thumbnailUrl; ?>);">
	<div class="video-container">
		<div class="video-placeholder">
			<div class="video-thumbnail" style="background-image: url(<?= $thumbnailUrl; ?>);">
				<div class="close"></div>
			</div>
			<div class="video-details">
				<div class="video-details-left">
					<div class="video-time"><?= wfMessage( 'articlevideomvp-watch',
							$videoDetails['time'] ); ?></div>
					<div class="video-title"><?= $videoDetails['title']; ?></div>
				</div>
				<div class="video-play-button"></div>
			</div>
		</div>
		<div id="ooyala-article-video"></div>
	</div>
</div>
