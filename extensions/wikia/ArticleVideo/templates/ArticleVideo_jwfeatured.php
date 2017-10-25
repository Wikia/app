<div class="featured-video__wrapper">
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
			<?= DesignSystemHelper::renderSvg( 'wds-icons-cross-tiny', 'wds-icon wds-icon-tiny featured-video__close' ) ?>
		</div>
		<?= $app->renderPartial( 'ArticleVideo', 'feedback' ) ?>
		<script>
			define('wikia.articleVideo.featuredVideo.data', function() {
				return <?= json_encode($videoDetails); ?>;
			})
		</script>
		<script><?= $jwPlayerScript ?></script>
	</div>
	<?= $app->renderPartial( 'ArticleVideo', 'attribution', [ 'videoDetails' => $videoDetails ] ) ?>
</div>
