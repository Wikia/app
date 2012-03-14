<form class="WikiaSearch" id="search-v2-form" action="<?=$pageUrl;?>">
	<?php if($debug): ?>
		Rank Expr:
		<select name="rankExpr">
			<option value="-indextank" <?= (empty($rankExpr) || ($rankExpr == '-indextank')) ? 'selected' : ''; ?> >indextank</option>
			<option value="-bl" <?= ($rankExpr == '-bl') ? 'selected' : ''; ?> >backlinks</option>
			<option value="-bl2" <?= ($rankExpr == '-bl2') ? 'selected' : ''; ?> >backlinks (Mike)</option>
			<option value="-bl3" <?= ($rankExpr == '-bl3') ? 'selected' : ''; ?> >backlinks only</option>
		</select>
	<?php endif; ?>
	<input type="text" name="query" value="<?=$query;?>" /><a class="wikia-button" id="search-v2-button"><?= wfMsg( 'wikiasearch2-search-btn' ); ?></a><br />
	<input type="checkbox" name="crossWikia" value="1" <?= ( $crossWikia ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-search-all-wikia' ); ?>
	<input type="checkbox" name="groupResults" value="1" <?= ( $groupResults ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-group-results' ); ?>
	<input type="checkbox" name="debug" value="1" <?= ( $debug ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-debug-mode' ); ?>
	<input type="checkbox" name="skipCache" value="1" <?= ($skipCache ? 'checked' : ''); ?>/><?= wfMsg( 'wikiasearch2-skip-cache' ); ?>
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