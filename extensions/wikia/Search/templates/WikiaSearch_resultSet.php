<?php if($resultSet->getResultsFound() > 1): ?>
	<!-- grouped search result-->
	<li class="result">

		<?php
			$trackingData = 'class="ResultLink" data-wid="'.$resultSet->getHeader('cityId').'" data-gpos="'.$pos.'" data-pos="0" data-sterm="'.addslashes($query).'" data-stype="'.( $isInterWiki ? 'inter' : 'intra' ).'" data-rver="'.$relevancyFunctionId.'" data-event="search_click_wiki"';
		?>

		<h3><?=$debug?$pos.'. ':'';?><a href="<?=$resultSet->getHeader('cityUrl');?>" <?=$trackingData;?> ><?=$resultSet->getHeader('cityTitle');?></a></h3>
		<ul>
			<li><a href="<?=$resultSet->getHeader('cityUrl');?>" <?=$trackingData;?> ><?=$resultSet->getHeader('cityUrl');?></a></li>
			<?php if($resultSet->getHeader('cityArticlesNum')): ?>
				<li><?= wfMsg( 'wikiasearch2-pages', $wg->Lang->formatNum($resultSet->getHeader('cityArticlesNum')) ); ?></li>
			<?php endif; ?>
			<li><a href="<?= $resultSet->getHeader('cityUrl') .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search';?>"><?= wfMsg( 'wikiasearch2-search-on-wiki')?></a></li>
			<?php if ($debug): ?>
				<li><?= wfMsg( 'wikiasearch2-results', $resultSet->getResultsFound() ); ?></li>
				<?php if($resultSet->getHeader('cityRank')): ?>
					<li>(1st pos: <?=$resultSet->getHeader('1stResultPos');?>) <font color="red">WikiRank: <?=$resultSet->getHeader('cityRank');?></font></li>
				<?php endif; ?>
				<li>Max Score: <?=sprintf('%.3f',  $resultSet->totalScore)?></li>
			<?php endif;?>
		</ul>
		<?php for($i = 1; $i < 5; $i++): ?>
			<?php $result = $resultSet->next(); ?>
			<?php if($result instanceof WikiaSearchResult): ?>
				<div class="grouped-result <?php if($i%2): ?>new-row<?php endif; ?>">
					<?= $app->getView( 'WikiaSearch', 'result', array( 'result' => $result, 'gpos' => $pos, 'pos' => $i, 'debug' => $debug, 'query' => $query, 'inGroup' => true, 'isInterWiki' => $isInterWiki, 'relevancyFunctionId' => $relevancyFunctionId )); ?>
				</div>
			<?php else: break; endif; ?>
		<?php endfor; ?>
	</li>
<?php elseif ($nextResult = $resultSet->next()): ?>
	<?= $app->getView( 'WikiaSearch', 'result', array( 'result' => $nextResult, 'gpos' => 0, 'pos' => $pos, 'debug' => $debug, 'query' => $query, 'rank' =>  $resultSet->getHeader('cityRank'), 'isInterWiki'=> true, 'relevancyFunctionId' => $relevancyFunctionId )); ?>
<?php endif; ?>
