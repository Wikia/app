<section class="WikiaLatestEarnedBadgesModule">
	<?= AdEngine::getInstance()->getPlaceHolderIframe("ACHIEVEMENTS_BOXAD") ?>
	<h2 class="achievements-title"><?= wfMsg('achievements-recent-earned-badges'); ?></h2>
	
	<ul class="recent-badges badges">
		<?=	wfRenderPartial('LatestEarnedBadges', 'ListBadges', array('badges'=> $recents, 'displayMode'=> 'LatestBadges')); ?>
	</ul>

	<?= View::specialPageLink('WikiActivity', 'oasis-more', 'more') ?>
</section>
