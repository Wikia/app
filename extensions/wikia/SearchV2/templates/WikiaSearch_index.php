<section class="Search">

	<form class="WikiaSearch" id="search-v2-form" action="<?=$pageUrl;?>">
		<?php if($crossWikia): ?>
			<p><?= wfMsg('wikiasearch2-global-search-headline') ?></p>
		<?php endif; ?>
		<input type="text" name="query" value="<?=$query;?>" />

		<button type="submit" class="wikia-button" id="search-v2-button" value="<?= wfMsg( 'wikiasearch2-search-btn' ); ?>"><img src="<?= $wgBlankImgUrl ?>" class="sprite search" height="17" width="21"></button>

		<?php if($debug): ?>
		<fieldset>
			<?php // TODO: Hook these up properly ?>
			<input type="checkbox" name="crossWikia" value="1" <?= ( $crossWikia ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-search-all-wikia' ); ?>
			<input type="checkbox" name="groupResults" value="1" <?= ( $groupResults ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-group-results' ); ?>
			<input type="checkbox" name="debug" value="1" <?= ( $debug ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-debug-mode' ); ?>
			<input type="checkbox" name="skipCache" value="1" <?= ($skipCache ? 'checked' : ''); ?>/><?= wfMsg( 'wikiasearch2-skip-cache' ); ?>
			<input type="checkbox" name="solrhost" value="search-s1" <?= ($solrHost == 'search-s1') ? 'checked' : '' ?> /><?= wfMsg( 'wikiasearch2-use-s1' ) ?>
	
			<?php if($crossWikia) : ?>
				<?php echo $app->renderView('WikiaSearchController', 'boostSettings'); ?>
		    <?php endif; ?>
		</fieldset>
	    <?php endif; ?>
	</form>	
	
	<?php if(!empty($results)): ?>
		<?php if( $resultsFound > 0 ): ?>
			<p class="result-count subtle">
				<?= wfMsg('wikiasearch2-results-count', $resultsFound, '<span>'.$query.'</span>'); ?>
			</p>
	
			<? if ($results->getQuery() && $query != $results->getQuery()) : ?>
				<p>No results were found for <em><?=$query?></em>. <strong>Showing results for <em><?=$results->getQuery()?></em>.</strong></p>
				<? endif; ?>
	
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
			<p><i>No results found.</i></p>
		<?php endif; ?>
	<?php endif; ?>

</section> 