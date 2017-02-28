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
				<div class="video-wiki-play-button">
					<?php /* TODO: Extract it to DS (XW-2875) */ ?>
					<svg width="22" height="30" viewBox="0 0 22 30"
					     xmlns="http://www.w3.org/2000/svg">
						<path
							d="M21.573 15.818l-20 14c-.17.12-.372.18-.573.18-.158 0-.316-.037-.462-.112C.208 29.714 0 29.372 0 29V1C0 .625.207.283.538.11c.33-.17.73-.146 1.035.068l20 14c.268.187.427.493.427.82 0 .325-.16.63-.427.818z"/>
					</svg>
				</div>
			</div>
		</div>
		<div id="ooyala-article-video" class="ooyala-article-video"></div>
	</div>
</div>

