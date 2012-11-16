<header id="WikiaPageHeader" class="WikiaPageHeader">
	<h1><?= $pageHeading ?></h1>
	<? if($showStats): ?>
		<div class="header-right">
			<div class="first tally">
				<?= $wf->MsgExt(('forum-header-total-threads'), array('parsemag'), $threads) ?>
			</div>
			<div class="last tally">
				<?= $wf->MsgExt(('forum-header-active-threads'), array('parsemag'), $activeThreads) ?>
			</div>
		</div>
	<? endif; ?>
</header>