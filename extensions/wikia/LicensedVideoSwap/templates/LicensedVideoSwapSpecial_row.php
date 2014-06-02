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
			<?= F::app()->renderPartial( 'ThumbnailController', 'title', [
				'thumbnail' => $video['thumbnail'],
				'title' => $video['fileTitle'],
				'url' => $video['fileUrl'],
			]) ?>
		</div>
		<button class="keep-button secondary" <?= $confirmKeep ?> data-video-keep="<?= htmlspecialchars($video['title']) ?>"><?= wfMessage('lvs-button-keep')->plain() ?></button>
	</div>
	<div class="grid-3 premium">
		<p><?= wfMessage('lvs-best-match-label')->plain() ?></p>
		<? if ( !empty($best) ): ?>
			<div class="video-wrapper">
				<? if ( $video['isNew'] ): ?>
					<div class="new"><?= wfMessage( 'lvs-new-flag' )->plain() ?></div>
				<? endif; ?>
				<?= F::app()->renderPartial( 'ThumbnailController', 'title', [
					'thumbnail' => $best['thumbnail'],
					'title' => $best['fileTitle'],
					'url' => $best['fileUrl'],
				]) ?>
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
						<?= F::app()->renderPartial( 'ThumbnailController', 'title', [
							'thumbnail' => $suggest['thumbnail'],
							'title' => $suggest['fileTitle'],
							'url' => $suggest['fileUrl'],
						]) ?>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	<? endif; ?>
</div>
 <? endforeach; ?>
