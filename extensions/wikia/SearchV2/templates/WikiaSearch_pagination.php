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
	if(count($namespaces)) {
		foreach($namespaces as $ns) {
			$extraParams['ns'.$ns] = 1;
		}
	}
	$prevClass = $currentPage > 1 ? "button secondary" : "disabled"; 
	$nextClass = $currentPage < $pagesNum ? "button secondary" : "disabled";
?>
	<div class="wikia-paginator">
		<ul>
			<li><a class="paginator-prev <?= $prevClass ?>" href="<?= $pageTitle->getFullUrl( array_merge( array( 'query' => $query, 'page' => ($currentPage-1) ), $extraParams ) ); ?>"><span><?=wfMsg('paginator-back')?></span></a></li>
			<?php for( $i = $windowFirstPage; $i <= $windowLastPage; $i++ ): ?>
			
				<?php if($i == $currentPage): ?>
					<li><span class="active paginator-page"><?=$i;?></span></li>
				<?php else: ?>
					<li><a class="paginator-page" href="<?= $pageTitle->getFullUrl( array_merge( array( 'query' => $query, 'page' => $i ), $extraParams ) ); ?>"><?=$i;?></a></li>
				<?php endif;?>
			<?php endfor; ?>
			
			<li><a class="paginator-next  <?= $nextClass ?>" href="<?= $pageTitle->getFullUrl( array_merge( array( 'query' => $query, 'page' => ($currentPage+1) ), $extraParams ) ); ?>"><span><?=wfMsg('paginator-next')?></span></a></li>
		</ul>
	</div>
<?php endif; ?>	