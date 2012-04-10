<section class="Search">

	<form class="WikiaSearch" id="search-v2-form" action="<?=$pageUrl;?>">
		<input type="text" name="query" value="<?=$query;?>" />

		<button type="submit" class="secondary" id="search-v2-button" value="<?= wfMsg( 'wikiasearch2-search-btn' ); ?>"><img src="<?= $wgBlankImgUrl ?>" class="sprite search" height="17" width="21"></button>

		<br />
		<input type="checkbox" name="crossWikia" value="1" <?= ( $crossWikia ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-search-all-wikia' ); ?>
		<input type="checkbox" name="groupResults" value="1" <?= ( $groupResults ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-group-results' ); ?>
		<input type="checkbox" name="debug" value="1" <?= ( $debug ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-debug-mode' ); ?>
		<input type="checkbox" name="skipCache" value="1" <?= ($skipCache ? 'checked' : ''); ?>/><?= wfMsg( 'wikiasearch2-skip-cache' ); ?>
		<input type="checkbox" name="solrhost" value="search-s1" <?= ($solrHost == 'search-s1') ? 'checked' : '' ?> /><?= wfMsg( 'wikiasearch2-use-s1' ) ?>

		<?php if($debug && $crossWikia) : ?>
			<?php echo $app->renderView('WikiaSearchController', 'boostSettings'); ?>
	    <?php endif; ?>
	</form>	
	
	<?php if(!empty($results)): ?>
		<?php if( $resultsFound > 0 ): ?>
			<strong>Search results:</strong>&nbsp;<strong><?= $results->getStartPosition()+1; ?> - <?= (($results->getStartPosition()+$resultsPerPage) < $resultsFound) ? ($results->getStartPosition()+$resultsPerPage) : $resultsFound; ?></strong> of <strong><?= $resultsFound; ?></strong> document(s)<br />
	
			<? if ($query != $results->getQuery()) : ?>
	                     No results were found for <em><?=$query?></em>.
	                     <strong>Showing results for <em><?=$results->getQuery()?></em>.</strong>
		        <? endif; ?>
	
			<?= $paginationLinks; ?>
			<?php $pos = 0; ?>
			<?php foreach( $results as $result ): ?>
				<?php
					$pos++;
					if($result instanceof WikiaSearchResultSet) {
						echo F::app()->getView( 'WikiaSearch', 'resultSet', array(
						  'resultSet' => $result,
						  'pos' => $pos + (($currentPage - 1) * $resultsPerPage),
						  'rankExpr' => $rankExpr,
						  'debug' => $debug,
						  'query' => $query
						));
					}
					else {
						echo F::app()->getView( 'WikiaSearch', 'result', array(
						  'result' => $result,
						  'pos' => $pos + (($currentPage - 1) * $resultsPerPage),
						  'rankExpr' => $rankExpr,
						  'debug' => $debug,
						  'query' => $query
						));
					}
				?>
			<?php endforeach; ?>
			<?= $paginationLinks; ?>
		<?php else: ?>
			<i>No results found.</i>
		<?php endif; ?>
	<?php endif; ?>

</section> 