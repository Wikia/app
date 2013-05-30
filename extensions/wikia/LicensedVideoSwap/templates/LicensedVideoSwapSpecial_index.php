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

<div>
	<ul>
	<?php $counter = 0 ?>
	<? foreach ($videoList as $video) : ?>
		<?php $alpha = $counter % 3 == 0 ? ' alpha' : ''; ?>

		<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
			<a href="<?= $video['fileUrl'] ?>" class="image video">
				<?= $video['videoPlayButton'] ?>
				<img itemprop="thumbnail" alt="<?= $video['fileTitle'] ?>" src="<?= $video['thumbUrl'] ?>" width="<?= $thumbWidth ?>" height="<?= $thumbHeight ?>" data-video-name="<?= htmlspecialchars($video['fileTitle']) ?>" data-video-key="<?= htmlspecialchars(urlencode($video['title'])) ?>" class="Wikia-video-thumb thumbimage">
				<?= $video['videoOverlay'] ?>
			</a>
			<p>
				<ul>
				<?php foreach( $video['truncatedList'] as $article ) { ?>
					<li><?= $article['titleText'] ?></li>
				<?php } ?>
				</ul>
			</p>
			<meta itemprop="embedUrl" content="<?= $video['embedUrl'] ?>" />
		</div>
		<?php $counter++; ?>
	<? endforeach; ?>
	</ul>
</div>

