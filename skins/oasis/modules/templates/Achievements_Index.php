<div class="module AchievementsModule UserProfileAchievementsModule">
	<? if(count($ownerBadges) == 0) :?>
		<h2><?= wfMessage( 'achievements-userprofile-title-no', $ownerName )->escaped(); ?></h2>
		<?= wfMessage( ( $viewer_is_owner == true ) ? 'achievements-userprofile-no-badges-owner' : 'achievements-userprofile-no-badges-visitor' )->escaped(); ?>
	<? else :?>
		<h2><?= wfMessage( 'achievements-userprofile-title', $ownerName, $ownerBadgesCount )->escaped(); ?></h2>
		<div class="data" data-user="<?= $ownerName ?>" data-badges-count="<?= $ownerBadgesCount ?>" data-badges-per-page="<?= AchUserProfileService::BADGES_PER_PAGE ?>">
			<div class="data-details tally"><?= wfMessage( 'achievements-userprofile-profile-score', $ownerScore )->escaped(); ?></div>
			<div class="data-details ranking"><?= wfMessage( 'achievements-userprofile-ranked', $ownerRank )->parse(); ?></div>
		</div>
		<div>
			<ul class="badges-icons badges">
				<?= $app->renderView( 'Achievements', 'Badges', [ 'ownerBadges' => $ownerBadges ] ); ?>
			</ul>

			<? if ( $ownerBadgesCount > AchUserProfileService::BADGES_PER_PAGE ) :?>
				<a class="badges-prev"><span><?= wfMessage( 'achievements-prev-oasis' )->escaped(); ?></span></a>
				<a class="badges-next"><span><?= wfMessage( 'achievements-next-oasis' )->escaped(); ?></span></a>
			<? endif ;?>
		</div>
	<? endif ;?>
</div>


<? if ( $viewer_is_owner == true ) :?>
	<div class="module AchievementsModule UserProfileAchievementsModule">
		<h2><?= wfMessage( 'achievements-profile-title-challenges', $ownerName )->escaped() ?></h2>

		<ul class="badges-tracks badges">
			<?= $app->renderView( 'LatestEarnedBadges', 'ListBadges', [ 'badges' => $challengesBadges, 'displayMode' => 'Achievements' ] ); ?>
		</ul>

		<? if ( !empty( $customize_url ) ): ?>
		<a href="<?= $customize_url ?>" class="more"><?= wfMessage( 'achievements-profile-customize' )->escaped(); ?></a>
		<? endif; ?>
	</div>
<? endif ;?>
