<div class="module AchievementsModule UserProfileAchievementsModule">
	<? if(count($ownerBadges) == 0) :?>
		<h2><?= wfMsg('achievements-userprofile-title-no', $ownerName);?></h2>
		<?= wfMsg( ( $viewer_is_owner == true ) ? 'achievements-userprofile-no-badges-owner' : 'achievements-userprofile-no-badges-visitor' ) ;?>
	<? else :?>
		<h2><?= wfMsgExt('achievements-userprofile-title', array('parsemag'), $ownerName, $ownerBadgesCount) ?></h2>
		<div class="data" data-user="<?= $ownerName ?>" data-badges-count="<?= $ownerBadgesCount ?>" data-badges-per-page="<?= AchUserProfileService::BADGES_PER_PAGE ?>">
			<div class="data-details tally"><?= wfMsg('achievements-userprofile-profile-score', $ownerScore) ?></div>
			<div class="data-details ranking"><?= wfMsgExt ('achievements-userprofile-ranked', array('parse') , $ownerRank) ?></div>
		</div>
		<div>
			<ul class="badges-icons badges">
				<?= $app->getView('Achievements', 'Badges', array(
				'ownerBadges'=> $ownerBadges)); ?>
			</ul>

			<? if ( $ownerBadgesCount > AchUserProfileService::BADGES_PER_PAGE ) :?>
				<a class="badges-prev"><span><?= wfMsg('achievements-prev-oasis') ?></span></a>
				<a class="badges-next"><span><?= wfMsg('achievements-next-oasis') ?></span></a>
			<? endif ;?>
		</div>
	<? endif ;?>
</div>


<? if ( $viewer_is_owner == true ) :?>
	<div class="module AchievementsModule UserProfileAchievementsModule">
		<h2><?= wfMsg('achievements-profile-title-challenges', $ownerName) ?></h2>

		<ul class="badges-tracks badges">
			<?= $app->getView('LatestEarnedBadges', 'ListBadges', array('badges'=> $challengesBadges, 'displayMode'=> 'Achievements' )); ?>
		</ul>

		<? if ( !empty( $customize_url ) ): ?>
		<a href="<?= $customize_url ?>" class="more"><?= wfMsg('achievements-profile-customize') ?></a>
		<? endif; ?>
	</div>
<? endif ;?>
