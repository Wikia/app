<li class="result">
	<a href="<?= $url ?>" title="<?= $title ?>" class="wiki-thumb-tracking" data-pos="<?=$pos?>" data-event="search_click_wiki-<?=$thumbTracking?>">
		<img src="<?= $imageURL; ?>" alt="<?= $title ?>" class="wikiPromoteThumbnail"/>
	</a>
	<div class=" result-description">
		<h1>
			<a href="<?= $url ?>" class="result-link" data-pos="<?=$pos?>" data-event="search_click_<?=$result['exactWikiMatch'] ? "match" : "wiki"?>"><?= $title ?></a>
		</h1>

		<p class="hub subtle"><?= strtoupper($hub); ?></p>
		<p class="description"><?= $description; ?></p>

		<ul class="wiki-statistics subtle">
			<li><?= wfMessage( 'wikiasearch2-pages' )->params( $wg->Lang->shortenNumberDecorator( $pagesCount), $pagesCount )->escaped(); ?></li>
			<li><?= wfMessage( 'wikiasearch2-images' )->params( $wg->Lang->shortenNumberDecorator( $imagesCount), $imagesCount )->escaped(); ?></li>
			<li><?= wfMessage( 'wikiasearch2-videos' )->params( $wg->Lang->shortenNumberDecorator( $videosCount), $videosCount )->escaped(); ?></li>
		</ul>
	</div>
</li>
