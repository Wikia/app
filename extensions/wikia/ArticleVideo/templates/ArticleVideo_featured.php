<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
	<meta itemprop="name" content="<?= htmlspecialchars( $videoDetails['metadata']['name'] ) ?>">
	<meta itemprop="duration" content="<?= htmlspecialchars( $videoDetails['metadata']['duration'] ) ?>">
	<meta itemprop="description" content="<?= htmlspecialchars( $videoDetails['metadata']['description'] ) ?>">
	<meta itemprop="thumbnailUrl" content="<?= htmlspecialchars( $videoDetails['metadata']['thumbnailUrl'] ) ?>">
	<meta itemprop="contentURL" content="<?= htmlspecialchars( $videoDetails['metadata']['contentUrl'] ) ?>">
	<meta itemprop="uploadDate" content="<?= htmlspecialchars( $videoDetails['metadata']['uploadDate'] ) ?>">
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
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-close-tiny',
					'wds-icon wds-icon-tiny featured-video__close'
				) ?>
			</div>
			<?= $app->renderPartial( 'ArticleVideo', 'feedback' ) ?>
			<script>
				define('wikia.articleVideo.featuredVideo.data', function () {
					return <?= json_encode( $videoDetails ); ?>;
				})
			</script>
			<script><?= $jwPlayerScript ?></script>
		</div>
		<?php if ( !empty( $videoDetails['username'] ) &&
				!empty( $videoDetails['userUrl'] )
		): ?>
			<?= $app->renderView( 'ArticleVideo', 'attribution', [ 'videoDetails' => $videoDetails ] ) ?>
		<?php endif; ?>
	</div>
</div>
