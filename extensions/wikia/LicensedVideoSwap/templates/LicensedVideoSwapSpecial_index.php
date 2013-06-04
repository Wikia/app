<? global $wgStylePath ?>

<section class="lvs-callout">
	<button class="close wikia-chiclet-button">
		<img src="<?= $wgStylePath ?>/oasis/images/icon_close.png">
	</button>
	<h1><?= wfMessage('lvs-callout-header')->text() ?></h1>
	<ul>
		<li>- <?= wfMessage('lvs-callout-reason-licensed')->text() ?></li>
		<li>- <?= wfMessage('lvs-callout-reason-quality')->text() ?></li>
		<li>- <?= wfMessage('lvs-callout-reason-collaborative')->text() ?></li>
		<li>- <?= wfMessage('lvs-callout-reason-more')->text() ?></li>
	</ul>
</section>

<p><?= wfMessage('lvs-instructions')->text() ?></p>

<?= $app->renderView('WikiaStyleGuideElementsController', 'contentHeaderSort', $contentHeaderSortOptions ) ?>

<div class="WikiaGrid LVSGrid">

	<? foreach ($videoList as $video) : ?>
		<div class="grid-3 alpha non-premium">
			<p>
				<?php foreach( $video['truncatedList'] as $article ) { ?>
					<?= $article['titleText'] ?>
				<?php } ?>
				&nbsp; <!-- TODO: hack, replace this with message -->
			</p>
			<div class="video-container" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
				<a href="<?= $video['fileUrl'] ?>" class="image video">
					<?= $video['videoPlayButton'] ?>
					<img itemprop="thumbnail" alt="<?= $video['fileTitle'] ?>" src="<?= $video['thumbUrl'] ?>" width="<?= $thumbWidth ?>" height="<?= $thumbHeight ?>" data-video-name="<?= htmlspecialchars($video['fileTitle']) ?>" data-video-key="<?= htmlspecialchars(urlencode($video['title'])) ?>" class="Wikia-video-thumb thumbimage">
					<?= $video['videoOverlay'] ?>
				</a>
				<meta itemprop="embedUrl" content="<?= $video['embedUrl'] ?>" />
			</div>
			<button class="secondary"><?= wfMessage('lvs-button-keep') ?></button>
		</div>
		<div class="grid-3 premium">
			<p><?= wfMessage('lvs-best-match-label')->text() ?></p>
			<div class="video-container" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
				<a href="<?= $video['fileUrl'] ?>" class="image video">
					<?= $video['videoPlayButton'] ?>
					<img itemprop="thumbnail" alt="<?= $video['fileTitle'] ?>" src="<?= $video['thumbUrl'] ?>" width="<?= $thumbWidth ?>" height="<?= $thumbHeight ?>" data-video-name="<?= htmlspecialchars($video['fileTitle']) ?>" data-video-key="<?= htmlspecialchars(urlencode($video['title'])) ?>" class="Wikia-video-thumb thumbimage">
					<?= $video['videoOverlay'] ?>
				</a>
				<meta itemprop="embedUrl" content="<?= $video['embedUrl'] ?>" />
			</div>
			<a class="more" href="#"><?= wfMessage('lvs-more-suggestions')->numParams(5)->text() ?></a>
			<!-- TODO: add arrow asset -->
			<button>(&lt;) <?= wfMessage('lvs-button-swap') ?></button>
		</div>
		<div class="more-videos">

		</div>
	<? endforeach; ?>

</div>