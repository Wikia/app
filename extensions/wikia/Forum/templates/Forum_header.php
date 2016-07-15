<header id="WikiaPageHeader" class="WikiaPageHeader">
	<? if ( $showStats ): ?>
		<div class="header-right">
			<div class="first tally">
				<?= wfMessage( 'forum-header-total-threads' )->numParams( $threads )->parse() ?>
			</div>
			<div class="last tally">
				<?= wfMessage( 'forum-header-active-threads' )->numParams( $activeThreads )->parse() ?>
			</div>
		</div>
	<? endif; ?>
	<h1><?= $pageHeading ?></h1>
</header>
