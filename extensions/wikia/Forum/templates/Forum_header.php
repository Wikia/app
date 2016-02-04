<header id="pageHeader" class="page-header forum">
	<div class="header-column header-left">
		<h1><?= $pageHeading ?></h1>
	</div>
	<?php if ( $showStats ) { ?>
		<div class="header-column header-right">
			<div class="first tally">
				<?= wfMessage( 'forum-header-total-threads', $wg->Lang->formatNum( $threads ) )->parse() ?>
			</div>
			<div class="last tally">
				<?= wfMessage( 'forum-header-active-threads', $wg->Lang->formatNum( $activeThreads ) )->parse() ?>
			</div>
		</div>
	<?php } ?>
</header>
