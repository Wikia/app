<?php
// get wiki thumbnail and thumbnail tracking
$image = (new PromoImage(PromoImage::MAIN))->setCityId($result['id'])->getPathname();
$isOnWikiMatch = isset($result['onWikiMatch']) && $result['onWikiMatch'];

$thumbTracking = 'class="wiki-thumb-tracking" data-pos="' . $pos . '" data-event="search_click_wiki-thumb"';
$imageURL = ImagesService::getImageSrcByTitle( (new CityVisualization)->getTargetWikiId( $result['lang_s'] ),
	$image, WikiaSearchController::CROSS_WIKI_PROMO_THUMBNAIL_WIDTH, WikiaSearchController::CROSS_WIKI_PROMO_THUMBNAIL_HEIGHT );

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

<div class="Results exact">
	<p class="result-count subtle">
		<?= wfMsg('wikiasearch2-exact-result', '<strong>'.$title.'</strong>'); ?>
	</p>

	<div class="result">

		<?php
			$trackingData = 'class="result-link" data-pos="' . $pos . '"';
		?>

		<a href="<?= $url ?>" title="<?= $title ?>" <?= $thumbTracking
			?>>
			<img src="<?= $imageURL ?>" alt="<?= $title ?>" class="wikiPromoteThumbnail" />
		</a>
		<div class="result-description">

			<h1>
				<a href="<?= $url ?>" <?=$trackingData;?> ><?= $title ?></a>
			</h1>

			<p class="hub subtle"><?= strtoupper($result->getHub()); ?></p>
			<p class="description"><?= $result->getText( Wikia\Search\Utilities::field( 'description' ), 16 ); ?></p>

			<ul class="wiki-statistics subtle">
				<li><?= $pagesMsg ?></li>
				<li><?= $imgMsg ?></li>
				<li><?= $videoMsg ?></li>
			</ul>
		</div>
	</div>
</div>