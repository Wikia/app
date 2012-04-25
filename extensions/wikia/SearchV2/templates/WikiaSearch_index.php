<section class="Search">

	<form class="WikiaSearch" id="search-v2-form" action="<?=$pageUrl;?>">
		<?php if($isInterWiki): ?>
			<p><?= wfMsg('wikiasearch2-global-search-headline') ?></p>
		<?php else: ?>
			<p><?= wfMsg('wikiasearch2-wiki-search-headline') ?></p>
		<?php endif; ?>
		<input type="text" name="query" value="<?=$query;?>" />

		<button type="submit" class="wikia-button" id="search-v2-button" value="<?= wfMsg( 'wikiasearch2-search-btn' ); ?>"><img src="<?= $wg->BlankImgUrl ?>" class="sprite search" height="17" width="21"></button>

		<?php if($debug): ?>
		<fieldset>
			<label><input type="checkbox" name="crossWikia" value="1" <?= ( $isInterWiki ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-search-all-wikia' ); ?></label>
			<label><input type="checkbox" name="debug" value="1" <?= ( $debug ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-debug-mode' ); ?></label>
			
			<?php if($isInterWiki) : ?>
				<?php echo $app->renderView('WikiaSearchController', 'boostSettings'); ?>
		    <?php endif; ?>
		</fieldset>
	    <?php endif; ?>

	<?php if(!empty($advancedSearchBox)) : ?>
		<?php echo $advancedSearchBox; ?>
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
						echo $app->getView( 'WikiaSearch', 'resultSet', array(
						  'resultSet' => $result,
						  'pos' => $pos + (($currentPage - 1) * $resultsPerPage),
						  'debug' => $debug,
						  'query' => $query,
						  'isInterWiki' => $isInterWiki
						));
					}
					else {
						echo $app->getView( 'WikiaSearch', 'result', array(
						  'result' => $result,
						  'pos' => $pos + (($currentPage - 1) * $resultsPerPage),
						  'debug' => $debug,
						  'query' => $query,
						  'isInterWiki' => $isInterWiki
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