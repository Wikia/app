<li class="result">
	<a href="<?= $url ?>" title="<?= $name ?>" class="wiki-thumb-tracking" data-pos="<?=$pos?>"
	   data-event="search_click_wiki-<?=$thumbTracking?>">
		<img src="<?= $imageURL; ?>" alt="<?= $name ?>" class="wikiPromoteThumbnail"/>
	</a>
	<div class=" result-description">
		<h1>
			<a href="<?= $url ?>" class="result-link" data-pos="<?=$pos?>" data-event="search_click_match""><?= $name
			?></a>
		</h1>

		<p class="hub subtle"><?= strtoupper($hub); ?></p>
		<p class="description"><?= \Wikia\Search\Result::limitTextLength( htmlspecialchars( $description ), $descriptionWordLimit ); ?></p>

		<ul class="wiki-statistics subtle">
			<?
				$shortenedPageCount = $wg->Lang->shortenNumberDecorator( $pageCount);
				$shortenedImageCount = $wg->Lang->shortenNumberDecorator( $imageCount);
				$shortenedVideoCount = $wg->Lang->shortenNumberDecorator( $videoCount);
			?>
			<li><?= wfMessage( 'wikiasearch2-pages' )->params( $shortenedPageCount->decorated, $shortenedPageCount->rounded )->escaped(); ?></li>
			<li><?= wfMessage( 'wikiasearch2-images' )->params( $shortenedImageCount->decorated, $shortenedImageCount->rounded )->escaped(); ?></li>
			<li><?= wfMessage( 'wikiasearch2-videos' )->params( $shortenedVideoCount->decorated, $shortenedVideoCount->rounded )->escaped(); ?></li>
		</ul>
	</div>
</li>
