<?php if($resultSet->getResultsFound() > 1): ?>
    <!-- grouped search result-->
    <li class="result">

		<?php
		$trackingData = 'class="ResultLink" data-wid="' . $resultSet->getHeader('wid') . '" data-gpos="' . $pos
			. '" data-pos="0" data-sterm="' . addslashes($query) . '" data-stype="' .( $isInterWiki ? 'inter' :
			'intra' ) . '" data-rver="6" data-event="search_click_wiki"';
		?>

		<?php
			$images = $resultSet->getHeader( 'images' );
			if ( !empty( $images ) ) {
				$imageInfo = ImagesService::getLocalFileThumbUrlAndSizes( reset( $images ) );
			} else {
				//TODO: get default image
				$imageInfo = new stdClass();
				$imageInfo->url = '';
			}
		?>
        <img src="<?= $imageInfo->url; ?>" alt="<?= $resultSet->getHeader('title'); ?>" class="wikiPromoteThumbnail grid-1 alpha" />
        <div class="grid-5 result-description">

            <h1>
                <a href="<?= $resultSet->getHeader('host'); ?>" <?=$trackingData;?> ><?= $resultSet->getHeader
				('wikititle'); ?></a>
            </h1>

            <p class="hub subtle"><?= strtoupper( $resultSet->getHeader( 'hub' ) ); ?></p>
            <p><?= $resultSet->getHeader('description'); ?></p>

            <ul>
                <li><a href="<?=$resultSet->getHeader('url');?>" <?=$trackingData;?> ><?=$resultSet->getHeader('host');?></a></li>
				<li><a href="<?= $resultSet->getHeader('host') .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search';?>"><?= wfMsg( 'wikiasearch2-search-on-wiki')?></a></li>
            </ul>
            <ul class="wiki-statistics subtle">
                <li><?= wfMsg( 'wikiasearch2-pages', $wg->Lang->formatNum($resultSet->getHeader('articles_count')) ); ?></li>
                <li><?= wfMsg( 'wikiasearch2-images', $wg->Lang->formatNum($resultSet->getHeader('images_count')) ); ?></li>
                <li><?= wfMsg( 'wikiasearch2-videos', $wg->Lang->formatNum($resultSet->getHeader('videos_count')) ); ?></li>
            </ul>
        </div>
    </li>
<?php else: ?>
	<?= $app->getView( 'WikiaSearch', 'CrossWiki_exactResult', array( 'resultSet' => $resultSet, 'gpos' => 0, 'pos' => $pos, 'query' => $query, 'rank' =>  $resultSet->getHeader('cityRank'), 'isInterWiki'=> true )); ?>
<?php endif; ?>
