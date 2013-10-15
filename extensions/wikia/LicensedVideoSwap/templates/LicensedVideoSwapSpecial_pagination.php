<!-- Hard coded values until backend is ready -->
<? $currentPage = 1; ?>
<? $pagesNum = 6; ?>

<div class="wikia-paginator">
	<ul>
		<? if( $currentPage > 1 ): ?>
			<li><a class="paginator-prev button secondary" href=""><span><?= wfMessage('paginator-back')->plain() ?></span></a></li>
		<? else: ?>
			<li><span class="paginator-prev disabled"><span><?= wfMessage('paginator-back')->plain() ?></span></span></li>
		<? endif; ?>

		<!-- Loop through pages, creating a paginator link for each -->
		<? for( $i = 1; $i <= 6; $i++ ): ?>
			<? if( $i == $currentPage ): ?>
				<li><span class="active paginator-page"><?= $i ?></span></li>
			<? else: ?>
				<li><a class="paginator-page" href=""><?= $i ?></a></li>
			<? endif; ?>
		<? endfor; ?>
		
		<? if( $currentPage < $pagesNum ): ?>
			<li><a class="paginator-next button secondary" href=""><span><?= wfMessage('paginator-next')->plain() ?></span></a></li>
		<? else: ?>
			<li><span class="paginator-next disabled"><span><?= wfMessage('paginator-next')->plain() ?></span></span></li>
		<? endif; ?>
	</ul>
</div>
