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
		</div>
		<div id="ooyala-article-video" class="ooyala-article-video"></div>
		<div class="video-details">
			<div class="video-label"><?= wfMessage( 'articlevideo-watch' )->escaped() ?>
				<span class="video-time"></span>
			</div>
			<div class="video-title"></div>
		</div>
		<?= $app->renderPartial( 'ArticleVideo', 'feedback' ) ?>
	</div>

	<? if ( isset( $videoDetails['username'], $videoDetails['userUrl'], $videoDetails['userAvatarUrl'] ) ): ?>
		<div class="attribution-container">
			<img class="attribution-avatar" src="<?= Sanitizer::encodeAttribute( $videoDetails['userAvatarUrl'] ) ?>"/>
			<a class="attribution-username" href="<?= Sanitizer::encodeAttribute( $videoDetails['userUrl'] ) ?>">
				<?= wfMessage( 'articlevideo-attribution-from' )->escaped() ?>
				<?= Sanitizer::encodeAttribute( $videoDetails['username'] ) ?>
				<?//= DesignSystemHelper::renderSvg( 'wds-icons-out-arrow' ) ?> // TODO: update DS version
			</a>
		</div>
	<?endif;?>
</div>

