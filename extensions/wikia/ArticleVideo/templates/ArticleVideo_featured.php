<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
	<h2>Video: <span itemprop="<?= htmlspecialchars( $videoMetaData['name'] ) ?>">Title</span></h2>
	<meta itemprop="duration" content="T1M33S" />
	<meta itemprop="thumbnailUrl" content="<?= htmlspecialchars( $videoMetaData['thumbnailUrl'] ) ?>" />
	<meta itemprop="contentURL" content="<?= htmlspecialchars( $videoMetaData['contentUrl'] ) ?>" />
	<meta itemprop="uploadDate" content="<?= htmlspecialchars( $videoMetaData['uploadDate'] ) ?>" />
	<div class="featured-video__wrapper">
		<div class="featured-video">
			<div class="featured-video__player-container">
				<div id="featured-video__player" class="featured-video__player"></div>
				<div class="featured-video__details">
					<div class="featured-video__label"><?= wfMessage( 'articlevideo-watch' )->escaped() ?>
						<span class="featured-video__time"><?= htmlspecialchars( $videoDetails['duration'] ) ?></span>
					</div>
					<div class="featured-video__title"><?= htmlspecialchars( $videoDetails['title'] ) ?></div>
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
	<span itemprop="description"><?= htmlspecialchars( $videoMetaData['description'] ) ?></span>
</div>
