<header id="WikiaPageHeader" class="WikiaPageHeader">
	<? if ( ${ForumConst::showStats} ): ?>
		<div class="header-right">
			<div class="first tally">
				<?= wfMessage( 'forum-header-total-threads', $wg->Lang->formatNum( ${ForumConst::threads} ) )->parse() ?>
			</div>
			<div class="last tally">
				<?= wfMessage( 'forum-header-active-threads', $wg->Lang->formatNum( ${ForumConst::activeThreads} ) )->parse() ?>
			</div>
		</div>
	<? endif; ?>
	<h1><?= ${ForumConst::pageHeading} ?></h1>
</header>
