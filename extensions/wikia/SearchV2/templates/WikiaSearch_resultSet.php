<?php if($resultSet->getResultsFound() > 1): ?>
	<!-- grouped serach result-->
	<div style="float: left">
		<strong><?=$debug?$pos.'. ':'';?><a href="<?=$resultSet->getHeader('cityUrl');?>"><?=$resultSet->getHeader('cityTitle');?></a></strong>
		<?php if($resultSet->getHeader('cityArticlesNum')): ?>
			| <?=$resultSet->getHeader('cityArticlesNum');?> <?= wfMsg( 'wikiasearch2-pages' ); ?>
		<?php endif; ?>
		<?php if($debug): ?>
			| <?=$resultSet->getResultsFound();?> <?= wfMsg( 'wikiasearch2-results' ); ?>
		<?php endif; ?>
		<?php if($resultSet->getHeader('cityRank') && $debug): ?>
			| (1st pos: <?=$resultSet->getHeader('1stResultPos');?>) <font color="red">WikiRank: <?=$resultSet->getHeader('cityRank');?></font>
		<?php endif; ?>
			| Total Score: <?=sprintf('%.3f',  $resultSet->totalScore)?>
			| <a href="<?= $resultSet->getHeader('cityUrl') .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search';?>"><?= wfMsg( 'wikiasearch2-search-on-wiki')?></a>
		<br />
		<a href="<?=$resultSet->getHeader('cityUrl');?>"><?=$resultSet->getHeader('cityUrl');?></a>
	</div>
	<br clear="left">
		<?php for($i = 1; $i < 5; $i++): ?>
			<?php $result = $resultSet->next(); ?>
			<?php if($result instanceof WikiaSearchResult): ?>
				<div style="width: 350px; float: left; padding: 5px; margin-left: 20px; margin-right: 15px; ">
					<?= F::app()->getView( 'WikiaSearch', 'result', array( 'result' => $result, 'pos' => $i, 'rankExpr' => $rankExpr, 'debug' => $debug, 'query' => $query, 'inGroup' => true )); ?>
				</div>
				<?php if(!($i%2)): ?>
					<br clear="left">
				<?php endif; ?>
			<?php else: break; endif; ?>
		<?php endfor; ?>
	<br clear="left">
<?php else: ?>
	<?= F::app()->getView( 'WikiaSearch', 'result', array( 'result' => $resultSet->next(), 'pos' => $pos, 'rankExpr' => $rankExpr, 'debug' => $debug, 'query' => $query, 'rank' =>  $resultSet->getHeader('cityRank'))); ?>
<?php endif; ?>
