<div  class="wikia-paginator">
	<ul>
	<? $i = 1; ?>
	<? foreach($pages as $page ): ?>
		<? if ($i === 1): ?>
			<? if($page < $currentPage): ?>
				<li><a href="<?=str_replace( '%s', ( $currentPage - 1 ), $url); ?>" data-back="true" data-page="<?= $currentPage - 1; ?>" class="paginator-prev button secondary"><span><?= wfMsg('paginator-back'); ?></span></a></li>
			<? else: ?>
				<li><span class="paginator-prev disabled"><span><?= wfMsg('paginator-back'); ?></span></span></li>
			<? endif; ?>
		<? endif; ?>
		<? if ( $page === '' ): ?>
			<li><span class="paginator-spacer">...</span></li>
		<? else: ?>
			<li><a href="<?=str_replace( '%s', $page, $url); ?>" <? if( $currentPage > $page ) echo 'data-back="true"'; ?>  data-page="<?= $page; ?>" class="paginator-page<? if ( $page == $currentPage ) echo ' active'; ?>" ><?=$page; ?></a></li>
		<? endif; ?>
		<? if ($i === count($pages)): ?>
			<? if($page > $currentPage): ?>
				<li><a href="<?=str_replace( '%s', ( $currentPage + 1 ), $url); ?>" data-page="<?=$currentPage + 1; ?>" class="paginator-next button secondary"><span><?=wfMsg('paginator-next')?></span></a></li>
			<? else: ?>
				<li><span class="paginator-next disabled"><span><?=wfMsg('paginator-next')?></span></span></li>
			<? endif; ?>
		<? endif; ?>
		<? $i++; ?>
	<? endforeach; ?>
	</ul>
</div>