<?php
	// get wiki thumbnail and thumbnail tracking
	$isOnWikiMatch = isset($result['onWikiMatch']) && $result['onWikiMatch'];
	$imageFileName = PromoImage::fromPathname($result['image_s'])->ensureCityIdIsSet($result['id'])->getPathname();

	$imageOriginalURL = ImagesService::getImageSrcByTitle( $corporateWikiId, $imageFileName,
		WikiaSearchController::CROSS_WIKI_PROMO_THUMBNAIL_WIDTH, WikiaSearchController::CROSS_WIKI_PROMO_THUMBNAIL_HEIGHT );
	if (! empty( $imageOriginalURL ) ) {
		$imageURL = ImagesService::overrideThumbnailFormat( $imageOriginalURL, ImagesService::EXT_JPG );

		$thumbTracking = 'class="wiki-thumb-tracking" data-pos="' . $pos . '" data-event="search_click_wiki-thumb"';
	}

	if ( empty( $imageURL ) ) {
		// display placeholder image if no thumbnail
		$imageURL = $wg->ExtensionsPath . '/wikia/Search/images/wiki_image_placeholder.png';
		$thumbTracking = 'class="wiki-thumb-tracking" data-pos="' . $pos . '" data-event="search_click_wiki-no-thumb"';
	}

	$service = new Wikia\Search\MediaWikiService();

	$pagesMsg = $service->shortnumForMsg( $result['articles_i']?:0, 'wikiasearch2-pages' );
	$imgMsg = $service->shortnumForMsg( $result['images_i']?:0, 'wikiasearch2-images' );
	$videoMsg = $service->shortnumForMsg( $result['videos_i']?:0, 'wikiasearch2-videos' );
	$title = ( $sn = $result->getText( 'sitename_txt' ) ) ? $sn : $result->getText( 'headline_txt' );
	$url = $result->getText( 'url' );
?>

<li class="result">
	<?php
	$suffix = $result['exactWikiMatch'] ? "match" : "wiki";
	$trackingData = 'class="result-link" data-pos="' . $pos . '" data-event="search_click_' . $suffix . '"';
	?>
	<a href="<?= $url ?>" title="<?= $title ?>" <?=
		$thumbTracking ?>>
		<img src="<?= $imageURL; ?>" alt="<?= $title ?>" class="wikiPromoteThumbnail"
			/>
	</a>
	<div class=" result-description">

		<h1>
			<a href="<?= $url ?>" <?=$trackingData;?> ><?= $title ?></a>
		</h1>

		<p class="hub subtle"><?= strtoupper($result->getHub()); ?></p>
		<p class="description"><?= $result->getText( Wikia\Search\Utilities::field( 'description' ), $isOnWikiMatch ? 16 : 60 ); ?></p>

		<ul class="wiki-statistics subtle">
			<li><?= $pagesMsg ?></li>
			<li><?= $imgMsg ?></li>
			<li><?= $videoMsg ?></li>
		</ul>
	</div>
</li>
