<?php if($resultSet->getResultsFound() > 1): ?>
	<!-- grouped search result-->
	<li class="result">

		<?php
			$trackingData = 'class="ResultLink" data-wid="' . $resultSet->getHeader('cityId') . '" data-gpos="' . $pos
				. '" data-pos="0" data-sterm="' . addslashes($query) . '" data-stype="' .( $isInterWiki ? 'inter' :
				'intra' ) . '" data-rver="6" data-event="search_click_wiki"';
		?>

		<img src="#" alt="<?= $resultSet->getHeader('cityTitle'); ?>" class="wikiPromoteThumbnail grid-1 alpha" />
		<div class="grid-5 result-description">

			<?php var_dump($resultSet->getHeader('hub')); ?>
			<?php var_dump($resultSet->getHeader('description')); ?>
			<?php var_dump($resultSet->getHeader('images_count')); ?>
			<?php var_dump($resultSet->getHeader('pages_count')); ?>
			<?php var_dump($resultSet->getHeader('videos_count')); ?>

			<h1><a href="<?= $resultSet->getHeader('cityUrl'); ?>" <?= $trackingData; ?> ><?= $resultSet->getHeader
			('cityTitle'); ?></a></h1>
			<p class="hub subtle"><?= $resultSet->getHeader('hub'); ?></p>
			<p><?= $resultSet->getHeader('description'); ?></p>

			<ul>
				<li><a href="<?=$resultSet->getHeader('cityUrl');?>" <?=$trackingData;?> ><?=$resultSet->getHeader('cityUrl');?></a></li>
				<?php if($resultSet->getHeader('cityArticlesNum')): ?>
					<li><?= wfMsg( 'wikiasearch2-pages', $wg->Lang->formatNum($resultSet->getHeader('cityArticlesNum')) ); ?></li>
				<?php endif; ?>
				<li><a href="<?= $resultSet->getHeader('cityUrl') .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search';?>"><?= wfMsg( 'wikiasearch2-search-on-wiki')?></a></li>
			</ul>

			<?php $i = 0; ?>
			<?php foreach ( $resultSet as $result ): ?>
				<?php if ( $result instanceof Wikia\Search\Result || $i++ < 5 ): ?>
					<div class="grouped-result <?php if($i%2): ?>new-row<?php endif; ?>">
						<?= $app->getView( 'WikiaSearch', 'result', array( 'result' => $result, 'gpos' => $pos, 'pos' => $i, 'query' => $query, 'inGroup' => true, 'isInterWiki' => $isInterWiki )); ?>
					</div>
				<?php else: break; endif; ?>
			<?php endforeach; ?>
		</div>
	</li>
<?php elseif ($nextResult = $resultSet->next()): ?>
	<?= $app->getView( 'WikiaSearch', 'result', array( 'result' => $nextResult, 'gpos' => 0, 'pos' => $pos, 'query' => $query, 'rank' =>  $resultSet->getHeader('cityRank'), 'isInterWiki'=> true )); ?>
<?php endif; ?>
