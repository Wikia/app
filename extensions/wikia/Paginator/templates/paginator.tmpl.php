<div class="wikia-paginator">
	<ul>
	<? $i = 1; ?>
	<? foreach($pages as $page ): ?>
		<? if ($i === 1): ?>
			<? if($page < $currentPage): ?>
				<li><a href="<?= Sanitizer::encodeAttribute( $urls[$currentPage - 1] ); ?>" data-back="true" data-page="<?= $currentPage - 1; ?>" class="paginator-prev button secondary"><span><?= wfMessage( 'paginator-back' )->escaped(); ?></span></a></li>
			<? else: ?>
				<li><span class="paginator-prev disabled"><span><?= wfMessage( 'paginator-back' )->escaped(); ?></span></span></li>
			<? endif; ?>
		<? endif; ?>
		<? if ( $page === '' ): ?>
			<li><span class="paginator-spacer">...</span></li>
		<? else: ?>
			<li><a href="<?= Sanitizer::encodeAttribute( $urls[$page] ); ?>" <? if( $currentPage > $page ) echo 'data-back="true"'; ?>  data-page="<?= Sanitizer::encodeAttribute( $page ); ?>" class="paginator-page<? if ( $page == $currentPage ) echo ' active'; ?>" ><?= htmlspecialchars( $page ); ?></a></li>
		<? endif; ?>
		<? if ($i === count($pages)): ?>
			<? if($page > $currentPage): ?>
				<li><a href="<?= Sanitizer::encodeAttribute( $urls[$currentPage + 1] ); ?>" data-page="<?=$currentPage + 1; ?>" class="paginator-next button secondary"><span><?= wfMessage( 'paginator-next' )->escaped(); ?></span></a></li>
			<? else: ?>
				<li><span class="paginator-next disabled"><span><?= wfMessage( 'paginator-next' )->escaped(); ?></span></span></li>
			<? endif; ?>
		<? endif; ?>
		<? $i++; ?>
	<? endforeach; ?>
	</ul>
</div>
