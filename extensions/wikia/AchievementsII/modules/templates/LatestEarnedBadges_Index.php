<section class="WikiaLatestEarnedBadgesModule module">
	<?= AdEngine::getInstance()->getPlaceHolderIframe("ACHIEVEMENTS_BOXAD") ?>
	<h1 class="achievements-title"><?= wfMsg('achievements-recent-earned-badges'); ?></h1>
	
	<ul class="recent-badges badges">
		<?=	$app->getView('LatestEarnedBadges', 'ListBadges', array('badges'=> $recents, 'displayMode'=> 'LatestBadges'))->render(); ?>
	</ul>

	<?= Wikia::specialPageLink('WikiActivity', 'oasis-more', 'more') ?>
</section>
