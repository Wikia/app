<section class="WikiaLatestEarnedBadgesModule module">
	<?= AdEngine::getInstance()->getPlaceHolderIframe("ACHIEVEMENTS_BOXAD") ?>
	<h1 class="achievements-title"><?= wfMsg('achievements-recent-earned-badges'); ?></h1>
	
	<ul class="recent-badges badges">
		<?=	wfRenderPartial('LatestEarnedBadges', 'ListBadges', array('badges'=> $recents, 'displayMode'=> 'LatestBadges')); ?>
	</ul>

	<?= View::specialPageLink('WikiActivity', 'oasis-more', 'more') ?>
</section>
