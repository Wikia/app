<?php
	// get wiki thumbnail and thumbnail tracking
	$image = $resultSet->getHeader( 'image' );
	if (! empty( $image ) ) {
		$imageURL = (new WikiaHomePageHelper)->getImageUrl( $image, 180, 120 );
		$thumbTracking = 'class="wiki-thumb-tracking" data-pos="' . $pos . '" data-event="search_click_wiki-thumb"';
	} else {
		// display placeholder image if no thumbnail
		$imageURL = $wgExtensionsPath . '/wikia/Search/images/wiki_image_placeholder.png';
		$thumbTracking = 'class="wiki-thumb-tracking" data-pos="' . $pos . '" data-event="search_click_wiki-no-thumb"';
	}

	$pagesMsg = $resultSet->getArticlesCountMsg();
	$imgMsg = $resultSet->getImagesCountMsg();
	$videoMsg =  $resultSet->getVideosCountMsg();
?>

<?php if($resultSet->getResultsFound() > 1): ?>
	<?php if ( $resultSet->getHeader('wikititle') ): ?>
		<li class="result">
			<?php
			$trackingData = 'class="result-link" data-pos="' . $pos . '" data-event="search_click_wiki"';
			?>
			<a href="<?= $resultSet->getHeader('url'); ?>" title="<?= $resultSet->getHeader('wikititle'); ?>" <?=
				$thumbTracking ?>>
				<img src="<?= $imageURL; ?>" alt="<?= $resultSet->getHeader('wikititle'); ?>" class="wikiPromoteThumbnail"
					/>
			</a>
			<div class=" result-description">

				<h1>
					<a href="<?= $resultSet->getHeader('url'); ?>" <?=$trackingData;?> ><?= $resultSet->getHeader
							('wikititle'); ?></a>
				</h1>

				<p class="hub subtle"><?= strtoupper( $resultSet->getHeader( 'hub' ) ); ?></p>
				<p class="description"><?= $resultSet->getDescription(); ?></p>

				<ul class="wiki-statistics subtle">
					<li><?= $pagesMsg ?></li>
					<li><?= $imgMsg ?></li>
					<li><?= $videoMsg ?></li>
				</ul>
			</div>
		</li>
	<?php endif; ?>
<?php else: ?>
	<?= $app->getView( 'WikiaSearch', 'CrossWiki_exactResult', array(
		'resultSet' => $resultSet,
		'pos' => $pos,
		'query' => $query,
		'rank' =>  $resultSet->getHeader('cityRank'),
		'imageURL' => $imageURL,
		'thumbTracking' => $thumbTracking,
		'pagesMsg' => $pagesMsg,
		'imgMsg' => $imgMsg,
		'videoMsg' => $videoMsg
		)); ?>
<?php endif; ?>
