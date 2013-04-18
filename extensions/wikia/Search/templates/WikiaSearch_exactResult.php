<div class="Results exact">
	<p class="result-count subtle">
		<?= wfMsg('wikiasearch2-exact-result', '<strong>'.$resultSet->getHeader('title').'</strong>'); ?>
	</p>

	<div class="result">

		<?php
			$trackingData = 'class="result-link" data-pos="' . $pos . '" data-event="search_click_match"';
		?>

		<a href="<?= $resultSet->getHeader( 'url' ) ?>" title="<?= $resultSet->getHeader('title'); ?>" <?= $thumbTracking
			?>>
			<img src="<?= $imageURL ?>" alt="<?= $resultSet->getHeader('title'); ?>" class="wikiPromoteThumbnail" />
		</a>
		<div class="result-description">

			<h1>
				<a href="<?= $resultSet->getHeader( 'url' ) ?>" <?=$trackingData;?> ><?= $resultSet->getHeader
				('title'); ?></a>
			</h1>

			<p class="hub subtle"><?= strtoupper( $resultSet->getHeader( 'hub' ) ); ?></p>
			<p class="description"><?= $resultSet->getDescription(); ?></p>

			<ul class="wiki-statistics subtle">
				<li><?= $pagesMsg ?></li>
				<li><?= $imgMsg ?></li>
				<li><?= $videoMsg ?></li>
			</ul>
		</div>
	</div>
	<ul class="articles">
		<?php /**
		$articlePos = 0;
		foreach ( $topArticlesData as $articleData ) :
			$trackingArticles = 'data-pos='.$articlePos++.' data-event="article_click_search_match"';
		?>
			<li>
				<h4>
					<a href="<?= $articleData['url'] ?>" <?= $trackingArticles ?> ><?= $articleData['title'] ?></a>
				</h4>
				<p><?= $articleData['abstract'] ?></p>
			</li>
		<?php endforeach; **/ ?>
	</ul>
</div>