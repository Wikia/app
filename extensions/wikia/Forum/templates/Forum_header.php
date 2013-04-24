<header id="WikiaPageHeader" class="WikiaPageHeader">
	<h1><?= $pageHeading ?></h1>
	<? if($showStats): ?>
		<div class="header-right">
			<div class="first tally">
				<?= $wf->MsgExt(('forum-header-total-threads'), array('parsemag'), $wg->Lang->formatNum( $threads )) ?>
			</div>
			<div class="last tally">
				<?= $wf->MsgExt(('forum-header-active-threads'), array('parsemag'), $wg->Lang->formatNum( $activeThreads )) ?>
			</div>
		</div>
	<? endif; ?>
</header>
