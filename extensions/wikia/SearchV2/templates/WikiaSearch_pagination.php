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
	}
	if(count($namespaces)) {
		foreach($namespaces as $ns) {
			$extraParams['ns'.$ns] = 1;
		}
	}
?>
	<div class="pagination">
		<?php if( $windowFirstPage > 1 ): ?>
			<a href="<?= $pageTitle->getFullUrl( array_merge( array( 'query' => $query, 'page' => ($windowFirstPage-1) ), $extraParams ) ); ?>">...</a>
		<?php endif; ?>
		<?php for( $i = $windowFirstPage; $i <= $windowLastPage; $i++ ): ?>
		
			<?php if($i == $currentPage): ?>
				<?=$i;?>&nbsp;
			<?php else: ?>
				<a href="<?= $pageTitle->getFullUrl( array_merge( array( 'query' => $query, 'page' => $i ), $extraParams ) ); ?>"><?=$i;?></a>&nbsp;
			<?php endif;?>
		<?php endfor; ?>
		
		<?php if( $windowLastPage < $pagesNum ): ?>
			<a href="<?= $pageTitle->getFullUrl( array_merge( array( 'query' => $query, 'page' => $i ), $extraParams ) ); ?>">...</a>
		<?php endif; ?>
	</div>
<?php endif; ?>	