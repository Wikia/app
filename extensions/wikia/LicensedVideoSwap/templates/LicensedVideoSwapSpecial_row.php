<?
foreach ($videoList as $video):
	$suggestions = $video['videoSuggestions'];
	$best = count($suggestions) > 0 ? $suggestions[0] : null;
	$numMoreSuggestions = count($suggestions) - 1; // Text is "x more suggestions" so remove selected suggestion for that count
	$confirmKeep = empty( $video['confirmKeep'] ) ? '' : 'data-subsequent-keep="true"';
?>
<div class="row">
	<span class="swap-arrow lvs-sprite"></span>
	<div class="grid-3 alpha non-premium">
		<div class="posted-in">
			<a class="ellipses" href="<?= $video['seeMoreLink'] ?>"><?= wfMessage('lvs-posted-in-more')->plain() ?></a>
			<div>
				<? if ( count($video['truncatedList']) ): ?>
					<?= wfMessage('lvs-posted-in-label')->plain() ?>
					<ul>
						<? foreach( $video['truncatedList'] as $article ): ?>
							<li><a href="<?= $article['url'] ?>"><?= $article['titleText'] ?></a></li>
						<? endforeach; ?>
					</ul>
				<? else: ?>
					<?= wfMessage('lvs-posted-in-label-none')->plain() ?>
				<? endif; ?>
			</div>
		</div>
		<div class="video-wrapper">
			<a href="<?= $video['fileUrl'] ?>" class="image video no-lightbox">
				<?= $video['videoPlayButton'] ?>
				<img alt="<?= $video['fileTitle'] ?>" src="<?= $video['thumbUrl'] ?>" width="<?= $thumbWidth ?>" height="<?= $thumbHeight ?>" data-video-name="<?= htmlspecialchars($video['fileTitle']) ?>" data-video-key="<?= htmlspecialchars(urlencode($video['title'])) ?>" class="Wikia-video-thumb thumbimage">
				<?= $video['videoOverlay'] ?>
			</a>
		</div>
		<button class="keep-button secondary" <?= $confirmKeep ?> data-video-keep="<?= htmlspecialchars($video['title']) ?>"><?= wfMessage('lvs-button-keep')->plain() ?></button>
	</div>
	<div class="grid-3 premium">
		<p><?= wfMessage('lvs-best-match-label')->plain() ?></p>
		<? if ( !empty($best) ): ?>
			<div class="video-wrapper">
				<? if ( $video['isNew'] ): ?>
					<div class="new">New</div>
				<? endif; ?>
				<a href="<?= $best['fileUrl'] ?>" class="image video no-lightbox">
					<?= $best['videoPlayButton'] ?>
					<img alt="<?= $best['fileTitle'] ?>" src="<?= $best['thumbUrl'] ?>" width="<?= $thumbWidth ?>" height="<?= $thumbHeight ?>" data-video-name="<?= htmlspecialchars($best['fileTitle']) ?>" data-video-key="<?= htmlspecialchars(urlencode($best['title'])) ?>" class="Wikia-video-thumb thumbimage">
					<?= $best['videoOverlay'] ?>
				</a>
			</div>
			<? if ( $numMoreSuggestions > 0 ): ?>
				<a class="more-link" href="#"><?= wfMessage('lvs-more-suggestions')->plain() ?></a>
			<? endif; ?>
			<button class="swap-button lvs-sprite" data-video-swap="<?= htmlspecialchars($best['title']) ?>"> <?= wfMessage('lvs-button-swap')->plain() ?></button>
		<? else: ?>
			<p><?= wfMessage('lvs-no-matching-videos')->plain() ?></p>
		<? endif; ?>
	</div>
	<? if ( $numMoreSuggestions > 0 ): ?>
		<div class="more-videos">
			<ul>
				<?
				   foreach ($suggestions as $suggest):
				?>
					<li>
						<a href="<?= $suggest['fileUrl'] ?>" class="video thumb<? if ( $suggest === reset($suggestions) ): ?> selected<? endif; ?>">
							<span class="timer">1:30</span>
							<div class="Wikia-video-play-button"><img class="sprite play small" src=" <?= $wg->BlankImgUrl ?>"></div>
							<img alt="<?= $suggest['fileTitle'] ?>" src="<?= $suggest['thumbUrl'] ?>" data-video-name="<?= htmlspecialchars($suggest['title']) ?>" data-video-key="<?= htmlspecialchars(urlencode($suggest['title'])) ?>" class="Wikia-video-thumb thumbimage">
						</a>
						<p class="suggestion-title"><?=$suggest['fileTitle'] ?></p>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	<? endif; ?>
</div>
 <? endforeach; ?>
