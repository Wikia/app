<div class="featured-video">
	<div class="featured-video__player-container">
		<div id="featured-video__player" class="featured-video__player"></div>
		<div class="featured-video__details">
			<div class="featured-video__label"><?= wfMessage( 'articlevideo-watch' )->escaped() ?>
				<span class="featured-video__time"><?= $videoDetails['duration'] ?></span>
			</div>
			<div
				class="featured-video__title"><?= htmlspecialchars( $videoDetails['title'] ) ?></div>
		</div>
	</div>
	<?= $app->renderPartial( 'ArticleVideo', 'feedback' ) ?>
	<script src="//content.jwplatform.com/libraries/VXc5h4Tf.js"></script>
	<script>
		window.wgFeaturedVideoData = <?= json_encode($videoDetails); ?>;
	</script>
	<script src="<?= $jwplayerScript; ?>"></script>
</div>
