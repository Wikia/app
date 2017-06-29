<div class="featured-video-wrapper">
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
					<span class="video-time"><?= $videoDetails['duration'] ?></span>
				</div>
				<div class="video-title"><?= htmlspecialchars( $videoDetails['title'] ) ?></div>
				<?= $app->renderPartial( 'ArticleVideo', 'attribution', [ 'videoDetails' => $videoDetails ] ) ?>
			</div>
			<?= $app->renderPartial( 'ArticleVideo', 'feedback' ) ?>
		</div>
	</div>
	<?= $app->renderPartial( 'ArticleVideo', 'attribution', [ 'videoDetails' => $videoDetails ] ) ?>
</div>
