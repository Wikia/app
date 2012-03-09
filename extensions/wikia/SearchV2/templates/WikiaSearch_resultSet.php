<?php if($resultSet->getResultsFound() > 1): ?>
	<!-- grouped serach result-->
	<div style="float: left">
		<strong><?=$debug?$pos.'. ':'';?><a href="<?=$resultSet->getHeader('cityUrl');?>"><?=$resultSet->getHeader('cityTitle');?></a></strong>
		<?php if($resultSet->getHeader('cityArticlesNum')): ?>
			| <?=$resultSet->getHeader('cityArticlesNum');?> <?= wfMsg( 'wikiasearch2-pages' ); ?>
		<?php endif; ?>
		| <?=$resultSet->getResultsFound();?> <?= wfMsg( 'wikiasearch2-results' ); ?>
		<?php if($resultSet->getHeader('cityRank')): ?>
			| (1st pos: <?=$resultSet->getHeader('1stResultPos');?>) <font color="red">WikiRank: <?=$resultSet->getHeader('cityRank');?></font>
		<?php endif; ?>
		<br />
		<a href="<?=$resultSet->getHeader('cityUrl');?>"><?=$resultSet->getHeader('cityUrl');?></a>
	</div>
	<br clear="left">
		<?php for($i = 1; $i < 5; $i++): ?>
			<?php $result = $resultSet->next(); ?>
			<?php if($result instanceof WikiaSearchResult): ?>
				<div style="width: 350px; float: left; padding: 5px; margin-left: 20px; margin-right: 15px; ">
					<?= F::app()->getView( 'WikiaSearch', 'result', array( 'result' => $result, 'pos' => $i, 'rankExpr' => $rankExpr, 'debug' => $debug, 'inGroup' => true )); ?>
				</div>
				<?php if(!($i%2)): ?>
					<br clear="left">
				<?php endif; ?>
			<?php else: break; endif; ?>
		<?php endfor; ?>
	<br clear="left">
<?php else: ?>
	<?= F::app()->getView( 'WikiaSearch', 'result', array( 'result' => $resultSet->next(), 'pos' => $pos, 'rankExpr' => $rankExpr, 'debug' => $debug, 'rank' =>  $resultSet->getHeader('cityRank'))); ?>
<?php endif; ?>
