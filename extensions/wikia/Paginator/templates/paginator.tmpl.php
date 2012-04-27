<div  class="wikia-paginator">
	<ul>
	<? $i = 1; ?>
	<? foreach($pages as $page ): ?>
		<? if ($i === 1): ?>
			<? $prevClass = $page < $currentPage ? "button secondary" : "disabled"; ?>
			<li><a href="<?=str_replace( '%s', ( $currentPage - 1 ), $url); ?>" data-back="true" data-page="<?= $currentPage - 1; ?>" class="paginator-prev <?= $prevClass; ?>"><span><?= wfMsg('paginator-back'); ?></span></a></li>
		<? endif; ?>
		<? if ( $page === '' ): ?>
			<li><span class="paginator-spacer">...</span></li>
		<? else: ?>
			<li><a href="<?=str_replace( '%s', $page, $url); ?>" <? if( $currentPage > $page ) echo 'data-back="true"'; ?>  data-page="<?= $page; ?>" class="paginator-page<? if ( $page == $currentPage ) echo ' active'; ?>" ><?=$page; ?></a></li>
		<? endif; ?>
		<? if ($i === count($pages)): ?>
			<? $nextClass = $page > $currentPage ? "button secondary" : "disabled"; ?>
			<li><a href="<?=str_replace( '%s', ( $currentPage + 1 ), $url); ?>" data-page="<?=$currentPage + 1; ?>" class="paginator-next <?= $nextClass; ?>"><span><?=wfMsg('paginator-next')?></span></a></li>
		<? endif; ?>
		<? $i++; ?>
	<? endforeach; ?>
	</ul>
</div>