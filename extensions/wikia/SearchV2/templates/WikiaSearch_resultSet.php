<?php if($resultSet->getResultsFound() > 1): ?>
	<!-- grouped search result-->
	<section class="Result">
		<header>
			<h1><?=$debug?$pos.'. ':'';?><a href="<?=$resultSet->getHeader('cityUrl');?>"><?=$resultSet->getHeader('cityTitle');?></a></h1>
		</header>
		<nav>
			<ul>
				<li><a href="<?=$resultSet->getHeader('cityUrl');?>"><?=$resultSet->getHeader('cityUrl');?></a></li>
				<?php if($resultSet->getHeader('cityArticlesNum')): ?>
					<li><?= wfMsg( 'wikiasearch2-pages', $resultSet->getHeader('cityArticlesNum') ); ?></li>
				<?php endif; ?>
				<li><a href="<?= $resultSet->getHeader('cityUrl') .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search';?>"><?= wfMsg( 'wikiasearch2-search-on-wiki')?></a></li>
				<?php if ($debug): ?>
					<li><?=$resultSet->getResultsFound();?> <?= wfMsg( 'wikiasearch2-results' ); ?></li>
					<?php if($resultSet->getHeader('cityRank')): ?>
						<li>(1st pos: <?=$resultSet->getHeader('1stResultPos');?>) <font color="red">WikiRank: <?=$resultSet->getHeader('cityRank');?></font></li>
					<?php endif; ?>
					<li>Total Score: <?=sprintf('%.3f',  $resultSet->totalScore)?></li>
				<?php endif;?>
			</ul>
		</nav>
		<?php for($i = 1; $i < 5; $i++): ?>
			<?php $result = $resultSet->next(); ?>
			<?php if($result instanceof WikiaSearchResult): ?>
				<div class="grouped-result <?php if($i%2): ?>new-row<?php endif; ?>">
				   <?= F::app()->getView( 'WikiaSearch', 'result', array( 'result' => $result, 'pos' => $i, 'rankExpr' => $rankExpr, 'debug' => $debug, 'query' => $query, 'inGroup' => true, 'isInterWiki' => $isInterWiki )); ?>
				</div>				
			<?php else: break; endif; ?>
		<?php endfor; ?>
	</section>
<?php else: ?>
	<?= F::app()->getView( 'WikiaSearch', 'result', array( 'result' => $resultSet->next(), 'pos' => $pos, 'rankExpr' => $rankExpr, 'debug' => $debug, 'query' => $query, 'rank' =>  $resultSet->getHeader('cityRank'), 'isInterWiki'=>true)); ?>
<?php endif; ?>
