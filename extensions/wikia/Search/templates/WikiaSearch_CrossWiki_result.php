<li class="result">
	<a href="<?= $url ?>" title="<?= $title ?>" class="wiki-thumb-tracking" data-pos="<?=$pos?>" data-event="search_click_wiki-<?=$thumbTracking?>">
		<img src="<?= $imageURL; ?>" alt="<?= $title ?>" class="wikiPromoteThumbnail"/>
	</a>
	<div class=" result-description">
		<h1>
			<a href="<?= $url ?>" class="result-link" data-pos="<?=$pos?>" data-event="search_click_<?=$result['exactWikiMatch'] ? "match" : "wiki"?>"><?= $title ?></a>
		</h1>

		<p class="hub subtle"><?= strtoupper($hub); ?></p>
		<p class="description"><?= \Wikia\Search\Result::limitTextLength( htmlspecialchars( $description ), $descriptionWordLimit ); ?></p>

		<ul class="wiki-statistics subtle">
			<?
				$shortenedPagesCount = $wg->Lang->shortenNumberDecorator( $pagesCount);
				$shortenedImagesCount = $wg->Lang->shortenNumberDecorator( $imagesCount);
				$shortenedVideosCount = $wg->Lang->shortenNumberDecorator( $videosCount);
			?>
			<li><?= wfMessage( 'wikiasearch2-pages' )->params( $shortenedPagesCount->decorated, $shortenedPagesCount->rounded )->escaped(); ?></li>
			<li><?= wfMessage( 'wikiasearch2-images' )->params( $shortenedImagesCount->decorated, $shortenedImagesCount->rounded )->escaped(); ?></li>
			<li><?= wfMessage( 'wikiasearch2-videos' )->params( $shortenedVideosCount->decorated, $shortenedVideosCount->rounded )->escaped(); ?></li>
		</ul>
	</div>
</li>
