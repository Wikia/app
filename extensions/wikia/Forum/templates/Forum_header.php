<header id="WikiaPageHeader" class="WikiaPageHeader">
	<h1><?= $pageHeading ?></h1>
	<? if($showStats): ?>
		<div class="header-right">
			<div class="first tally">
				<?= wfMsgExt(('forum-header-total-threads'), array('parsemag'), $wg->Lang->formatNum( $threads )) ?>
			</div>
			<div class="last tally">
				<?= wfMsgExt(('forum-header-active-threads'), array('parsemag'), $wg->Lang->formatNum( $activeThreads )) ?>
			</div>
		</div>
	<? endif; ?>
</header>
