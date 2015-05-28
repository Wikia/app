<section class="WikiaLatestEarnedBadgesModule module">
	<h2 class="achievements-title"><?= wfMsg('achievements-recent-earned-badges'); ?></h2>
	
	<ul class="recent-badges badges">
		<?=	$app->getView('LatestEarnedBadges', 'ListBadges', array('badges'=> $recents, 'displayMode'=> 'LatestBadges'))->render(); ?>
	</ul>

	<?= Wikia::specialPageLink('WikiActivity', 'oasis-more', 'more') ?>
</section>
