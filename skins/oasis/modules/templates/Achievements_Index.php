<div class="module AchievementsModule UserProfileAchievementsModule">
	<? if(count($ownerBadges) == 0) :?>
		<h1><?= wfMsg('achievements-userprofile-title-no', $ownerName);?></h1>
		<?= wfMsg( ( $viewer_is_owner == true ) ? 'achievements-userprofile-no-badges-owner' : 'achievements-userprofile-no-badges-visitor' ) ;?>
	<? else :?>
		<h1><?= wfMsgExt('achievements-userprofile-title', array('parsemag'), $ownerName, $ownerBadgesCount) ?></h1>
		<div class="data" data-user="<?= $ownerName ?>" data-badges-count="<?= $ownerBadgesCount ?>" data-badges-per-page="<?= AchUserProfileService::ITEMS_PER_BATCH ?>">
			<div class="data-details tally"><?= wfMsg('achievements-userprofile-profile-score', $ownerScore) ?></div>
			<div class="data-details ranking"><?= wfMsgExt ('achievements-userprofile-ranked', array('parse') , $ownerRank) ?></div>
		</div>
		<div>
			<ul class="badges-icons badges">
				<?= $app->getView('Achievements', 'Badges', array(
				'ownerBadges'=> $ownerBadges)); ?>
			</ul>

			<? if ( $ownerBadgesCount > AchUserProfileService::ITEMS_PER_BATCH ) :?>
				<a class="badges-prev"><span><?= wfMsg('achievements-prev-oasis') ?></span></a>
				<a class="badges-next"><span><?= wfMsg('achievements-next-oasis') ?></span></a>
			<? endif ;?>
		</div>
	<? endif ;?>
</div>


<? if ( $viewer_is_owner == true ) :?>
	<div class="module AchievementsModule UserProfileAchievementsModule">
		<h1><?= wfMsg('achievements-profile-title-challenges', $ownerName) ?></h1>

		<ul class="badges-tracks badges">
			<?= $app->getView('LatestEarnedBadges', 'ListBadges', array('badges'=> $challengesBadges, 'displayMode'=> 'Achievements' )); ?>
		</ul>
		
		<a href="<?= $customize_url ?>" class="more"><?= wfMsg('achievements-profile-customize') ?></a>
	</div>
<? endif ;?>
