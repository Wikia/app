<form class="WikiaSearch" id="search-v2-form" action="<?=$pageUrl;?>">
	<input type="text" name="query" value="<?=$query;?>" /><input type="submit" class="wikia-button" id="search-v2-button" style="display: inline;" value="<?= wfMsg( 'wikiasearch2-search-btn' ); ?>" /><br/>
	<input type="checkbox" name="crossWikia" value="1" <?= ( $crossWikia ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-search-all-wikia' ); ?>
	<input type="checkbox" name="groupResults" value="1" <?= ( $groupResults ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-group-results' ); ?>
	<input type="checkbox" name="debug" value="1" <?= ( $debug ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-debug-mode' ); ?>
	<input type="checkbox" name="skipCache" value="1" <?= ($skipCache ? 'checked' : ''); ?>/><?= wfMsg( 'wikiasearch2-skip-cache' ); ?>
	<input type="checkbox" name="solrhost" value="search-s1" <?= ($solrHost == 'search-s1') ? 'checked' : '' ?> /><?= wfMsg( 'wikiasearch2-use-s1' ) ?>
<?php if($debug && $crossWikia) : ?>
<br />
<?php  global $wikipagesBoost, $activeusersBoost, $revcountBoost, $viewBoost; ?>
<b>Interwiki Boost Settings</b><br/>
WikiPages: <input type="text" value="<?=$wikipagesBoost?>" id="page_boost" name="page_boost" style="width: 25px; padding-right: 0px;" /> | 
ActiveUsers: <input type="text" value="<?=$activeusersBoost?>" id="activeusers_boost" name="activeusers_boost" style="width: 25px;  padding-right: 0px;"/> | 
RevCount: <input type="text" value="<?=$revcountBoost?>" id="revcount_boost" name="revcount_boost" style="width: 25px; padding-right: 0px;"/> | 
Views: <input type="text" value="<?=$viewBoost?>" id="views_boost" name="views_boost" style="width: 25px;  padding-right: 0px;"/>
<br />

    <?php endif; ?>
</form>
<br />


<?php if(!empty($results)): ?>
	<?php if( $resultsFound > 0 ): ?>
		<strong>Search results:</strong>&nbsp;<strong><?= $results->getStartPosition()+1; ?> - <?= (($results->getStartPosition()+$resultsPerPage) < $resultsFound) ? ($results->getStartPosition()+$resultsPerPage) : $resultsFound; ?></strong> of <strong><?= $resultsFound; ?></strong> document(s)<br />
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