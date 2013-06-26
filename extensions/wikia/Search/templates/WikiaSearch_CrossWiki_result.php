<?php
	// get wiki thumbnail and thumbnail tracking
	$image = $result['image_s'];
	if (! empty( $image ) ) {
		$imageURL = (new WikiaHomePageHelper)->getImageUrl( $image, 180, 120 );
		$thumbTracking = 'class="wiki-thumb-tracking" data-pos="' . $pos . '" data-event="search_click_wiki-thumb"';
	} else {
		// display placeholder image if no thumbnail
		$imageURL = $wgExtensionsPath . '/wikia/Search/images/wiki_image_placeholder.png';
		$thumbTracking = 'class="wiki-thumb-tracking" data-pos="' . $pos . '" data-event="search_click_wiki-no-thumb"';
	}

	$pagesMsg = $result['articles_i'];
	$imgMsg = $result['images_i'];
	$videoMsg = $result['videos_i'];
	$title = ( $hl = $result->getText( 'headline_txt' ) ) ? $hl : $result->getText( 'sitename_txt' );
	$url = $result->getText( 'url' );
?>

<li class="result">
	<?php
	$suffix = $result['exactMatch'] ? "match" : "wiki";
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

		<p class="hub subtle"><?= strtoupper( $result->getText( 'hub_s' ) ); ?></p>
		<p class="description"><?= $result->getText( Wikia\Search\Utilities::field( 'description' ) ) ; ?></p>

		<ul class="wiki-statistics subtle">
			<li><?= $pagesMsg ?></li>
			<li><?= $imgMsg ?></li>
			<li><?= $videoMsg ?></li>
		</ul>
	</div>
</li>