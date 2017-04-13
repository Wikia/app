<div class="wikia-paginator">
	<ul>
		<?php if ( $currentPage > 1 ): ?>
			<li><a class="paginator-prev button secondary" href="<?= $pageTitle->getFullUrl( array_merge( [ 'search' => $query, 'fulltext' => 'Search', 'page' => ($currentPage-1) ], $extraParams ) ); ?>"><span><?= wfMessage( 'paginator-back' )->escaped(); ?></span></a></li>
		<?php else: ?>
			<li><span class="paginator-prev disabled"><span><?= wfMessage( 'paginator-back' )->escaped(); ?></span></span></li>
		<?php endif; ?>

		<?php for ( $i = $windowFirstPage; $i <= $windowLastPage; $i++ ): ?>

			<?php if ( $i == $currentPage ): ?>
				<li><span class="active paginator-page"><?=$i;?></span></li>
			<?php else: ?>
				<li><a class="paginator-page" href="<?= $pageTitle->getFullUrl( array_merge( [ 'search' => $query, 'fulltext' => 'Search', 'page' => $i ], $extraParams ) ); ?>"><?=$i;?></a></li>
			<?php endif;?>
		<?php endfor; ?>

		<?php if ( $currentPage < $pagesNum ): ?>
			<li><a class="paginator-next button secondary" href="<?= $pageTitle->getFullUrl( array_merge( [ 'search' => $query, 'fulltext' => 'Search', 'page' => ($currentPage+1) ], $extraParams ) ); ?>"><span><?= wfMessage( 'paginator-next' )->escaped(); ?></span></a></li>
		<?php else: ?>
			<li><span class="paginator-next disabled"><span><?= wfMessage( 'paginator-next' )->escaped(); ?></span></span></li>
		<?php endif; ?>
	</ul>
</div>
