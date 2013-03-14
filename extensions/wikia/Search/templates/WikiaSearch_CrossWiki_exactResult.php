<li class="result">

	<?php
	$trackingData = 'class="ResultLink" data-wid="' . $resultSet->getHeader('wid') . '" data-gpos="' . $pos
		. '" data-pos="0" data-sterm="' . addslashes($query) . '" data-stype="inter" data-rver="6" data-event="search_click_wiki"';
	?>

	<?php
		$urlInfo = parse_url( $resultSet->getHeader( 'url' ) );
		$host = $urlInfo[ 'host' ] ;
	?>
    <img src="<?= $imageURL ?>" alt="<?= $resultSet->getHeader('title'); ?>" class="wikiPromoteThumbnail grid-1 alpha"
	    />
    <div class="grid-5 result-description">

        <h1>
            <a href="<?= $host; ?>" <?=$trackingData;?> ><?= $resultSet->getHeader
			('title'); ?></a>
        </h1>

        <p class="hub subtle"><?= strtoupper( $resultSet->getHeader( 'hub' ) ); ?></p>
        <p><?= $resultSet->getHeader('description'); ?></p>

        <ul>
            <li><a href="<?=$resultSet->getHeader('url');?>" <?=$trackingData;?> ><?= $host; ?></a></li>
            <li><a href="<?= $host .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search';?>"><?= wfMsg( 'wikiasearch2-search-on-wiki')?></a></li>
        </ul>
        <ul class="wiki-statistics subtle">
            <li><?= wfMsg( 'wikiasearch2-pages', $wg->Lang->formatNum($resultSet->getHeader('articles_count')) ); ?></li>
            <li><?= wfMsg( 'wikiasearch2-images', $wg->Lang->formatNum($resultSet->getHeader('images_count')) ); ?></li>
            <li><?= wfMsg( 'wikiasearch2-videos', $wg->Lang->formatNum($resultSet->getHeader('videos_count')) ); ?></li>
        </ul>
    </div>
</li>