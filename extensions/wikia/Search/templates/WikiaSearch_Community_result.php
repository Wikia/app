<?php
use Wikia\Search\UnifiedSearch\UnifiedSearchCommunityResultItem;
/** @var UnifiedSearchCommunityResultItem $result */
?>

<li class="result">
	<a href="<?= $result->getUrl() ?>" title="<?= $result['name'] ?>" class="wiki-thumb-tracking"
	   data-pos="<?=$result['pos']?>"
	   data-event="search_click_wiki-<?=$result['thumbTracking']?>">
		<img src="<?= $result['thumbnail'] ?>" alt="<?= $result['name'] ?>" class="wikiPromoteThumbnail"/>
	</a>
	<div class=" result-description">
		<h1>
			<a href="<?= $result->getUrl() ?>" class="result-link" data-pos="<?=$result['pos']?>"
			   data-event="search_click_match""><?= $result['name'] ?></a>
		</h1>

		<p class="hub subtle"><?= strtoupper($result['hub']); ?></p>
		<p class="description"><?= $result->getDescription() ?></p>

		<ul class="wiki-statistics subtle">
			<?
				$shortenedPageCount = $wg->Lang->shortenNumberDecorator( $result['pageCount']);
				$shortenedImageCount = $wg->Lang->shortenNumberDecorator( $result['imageCount']);
				$shortenedVideoCount = $wg->Lang->shortenNumberDecorator( $result['videoCount']);
			?>
			<li><?= wfMessage( 'wikiasearch2-pages' )->params( $shortenedPageCount->decorated, $shortenedPageCount->rounded )->escaped(); ?></li>
			<li><?= wfMessage( 'wikiasearch2-images' )->params( $shortenedImageCount->decorated, $shortenedImageCount->rounded )->escaped(); ?></li>
			<li><?= wfMessage( 'wikiasearch2-videos' )->params( $shortenedVideoCount->decorated, $shortenedVideoCount->rounded )->escaped(); ?></li>
		</ul>
	</div>
</li>
