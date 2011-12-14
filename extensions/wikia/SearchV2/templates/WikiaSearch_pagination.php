<fieldset>
<?php for( $i = 1; $i <= $pagesNum; $i++ ): ?>
	<?php if($i == $currentPage): ?>
		<?=$i;?>&nbsp;
	<?php else: ?>
		<a href="<?= $pageTitle->getFullUrl( array( 'query' => $query, 'start' => (($i-1)*$resultsPerPage) ) ); ?>"><?=$i;?></a>&nbsp;
	<?php endif;?>
<?php endfor; ?>
</fieldset>