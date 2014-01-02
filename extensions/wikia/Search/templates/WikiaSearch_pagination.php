<?php if($windowLastPage > 1): ?>
<?php
	$extraParams = array();
	if(!empty($crossWikia)) {
		$extraParams['crossWikia'] = 1;
	}
	if(!empty($skipCache)) {
		$extraParams['skipCache'] = 1;
	}
	if(!empty($debug)) {
		$extraParams['debug'] = 1;
	}
	if(!empty($advanced)) {
		$extraParams['advanced'] = 1;
		$extraParams['redirs'] = ($redirs ? 1 : 0);
	}
	
	if(!empty($filters)) {
		foreach($filters as $filter) {
			$extraParams['filters'][] = $filter;			
		}
	}
	
	if(count($namespaces)) {
		foreach($namespaces as $ns) {
			$extraParams['ns'.$ns] = 1;
		}
	}
	
	if(!empty($by_category)) {
		$extraParams['by_category'] = 1;
	}
	
	if ($limit !== WikiaSearchController::RESULTS_PER_PAGE) {
		$extraParams['limit'] = $limit;
	}
?>
	<div class="wikia-paginator">
		<ul>
			<?php if($currentPage > 1): ?>
				<li><a class="paginator-prev button secondary" href="<?= $pageTitle->getFullUrl( array_merge( array( 'search' => $query, 'fulltext' => 'Search', 'page' => ($currentPage-1) ), $extraParams ) ); ?>"><span><?=wfMsg('paginator-back')?></span></a></li>
			<?php else: ?>
				<li><span class="paginator-prev disabled"><span><?=wfMsg('paginator-back')?></span></span></li>
			<?php endif; ?>

			<?php for( $i = $windowFirstPage; $i <= $windowLastPage; $i++ ): ?>
			
				<?php if($i == $currentPage): ?>
					<li><span class="active paginator-page"><?=$i;?></span></li>
				<?php else: ?>
					<li><a class="paginator-page" href="<?= $pageTitle->getFullUrl( array_merge( array( 'search' => $query, 'fulltext' => 'Search', 'page' => $i ), $extraParams ) ); ?>"><?=$i;?></a></li>
				<?php endif;?>
			<?php endfor; ?>
			
			<?php if($currentPage < $pagesNum): ?>
				<li><a class="paginator-next button secondary" href="<?= $pageTitle->getFullUrl( array_merge( array( 'search' => $query, 'fulltext' => 'Search', 'page' => ($currentPage+1) ), $extraParams ) ); ?>"><span><?=wfMsg('paginator-next')?></span></a></li>
			<?php else: ?>
				<li><span class="paginator-next disabled"><span><?=wfMsg('paginator-next')?></span></span></li>
			<?php endif; ?>
		</ul>
	</div>
<?php endif; ?>	