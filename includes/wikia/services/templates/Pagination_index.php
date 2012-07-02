<ul class="Pagination"  <? foreach($data as $key => $val ): ?> data-<?php echo $key ?>="<?php echo htmlentities($val); ?>" <? endforeach; ?> >
	<? if( $prev ): ?>
		<li data-page="<?= $currentPage - 1; ?>"  class="prev">
			<a href="<?= ($url !== '#' ? $url.($currentPage - 1) : $url) ?>"><?php echo wfMsg('wikia-pagination-prev'); ?></a>
		</li>
	<? endif; ?>
	
	<? for( $i=0; $i<count($pages); $i++ ): ?>
		<? $class = ($i == 0) ? ' first ' : ''; ?>
		<? $class .= ($pages[$i] == $currentPage) ? ' selected ' : ''; ?>
		
		<? if( gettype($pages[$i]) == 'string' ): ?>
			<li class="ellipsis"><?= $pages[$i] ?></li>
		<? else: ?>
			<li data-page="<?= $pages[$i]; ?>" class="<?= $class ?>">
				<a href="<?= ($url !== '#' ? $url.$pages[$i] : $url) ?>"><?= $pages[$i] ?></a>
			</li>
		<? endif; ?>
	<? endfor; ?>
	
	<? if( $next ): ?>
		<li data-page="<?= $currentPage + 1; ?>" class="next">
			<a href="<?= ($url !== '#' ? $url.($currentPage + 1) : $url) ?>"><?php echo wfMsg('wikia-pagination-next'); ?></a>
		</li>
	<? endif; ?>
</ul>