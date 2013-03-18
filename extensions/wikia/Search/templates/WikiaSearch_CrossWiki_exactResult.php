<li class="result">

	<?php
		$trackingData = 'class="result-link" data-pos="' . $pos . '" data-event="search_click_match"';
	?>

    <a href="<?= $resultSet->getHeader( 'url' ) ?>" title="<?= $resultSet->getHeader('title'); ?>">
	    <img src="<?= $imageURL ?>" alt="<?= $resultSet->getHeader('title'); ?>" class="wikiPromoteThumbnail" />
	</a>
    <div class="result-description">

        <h1>
            <a href="<?= $resultSet->getHeader( 'url' ) ?>" <?=$trackingData;?> ><?= $resultSet->getHeader
			('title'); ?></a>
        </h1>

        <p class="hub subtle"><?= strtoupper( $resultSet->getHeader( 'hub' ) ); ?></p>
        <p class="description"><?= $resultSet->getHeader('description'); ?></p>

        <ul class="wiki-statistics subtle">
            <li><?= wfMsg( 'wikiasearch2-pages', $wg->Lang->formatNum($resultSet->getHeader('articles_count')) ); ?></li>
            <li><?= wfMsg( 'wikiasearch2-images', $wg->Lang->formatNum($resultSet->getHeader('images_count')) ); ?></li>
            <li><?= wfMsg( 'wikiasearch2-videos', $wg->Lang->formatNum($resultSet->getHeader('videos_count')) ); ?></li>
        </ul>
    </div>
</li>