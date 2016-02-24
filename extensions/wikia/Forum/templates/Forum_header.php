<header id="WikiaPageHeader" class="WikiaPageHeader">
	<? if ( $showStats ): ?>
		<div class="header-right">
			<div class="first tally">
				<?= wfMessage( 'forum-header-total-threads', $wg->Lang->formatNum( $threads ) )->parse() ?>
			</div>
			<div class="last tally">
				<?= wfMessage( 'forum-header-active-threads', $wg->Lang->formatNum( $activeThreads ) )->parse() ?>
			</div>
		</div>
	<? endif; ?>
	<h1><?= $pageHeading ?></h1>
</header>
