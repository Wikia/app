<section class="AchievementsModule UserProfileAchievementsModule">
	<? if(count($ownerBadges) == 0) :?>
		<h1><?= wfMsg('achievements-userprofile-title-no', $ownerName);?></h1>
		<?= wfMsg( ( $viewer_is_owner == true ) ? 'achievements-userprofile-no-badges-owner' : 'achievements-userprofile-no-badges-visitor' ) ;?>
	<? else :?>
		<h1><?= wfMsgExt('achievements-userprofile-title', array('parsemag'), $ownerName, count($ownerBadges)) ?></h1>
		<div class="data">
			<details class="tally"><?= wfMsg('achievements-userprofile-profile-score', $ownerScore) ?></details>
			<details class="ranking"><?= wfMsgExt ('achievements-userprofile-ranked', array('parse') , $ownerRank) ?></details>
		</div>
		<div style="height: <?= count($ownerBadges) > 3 ? '200' : '100' ?>px">
			<ul class="badges-icons badges">
				<? for ($i=0; $i < count($ownerBadges); $i++) :?>
					<?
					$ownerBadge = $ownerBadges[$i]['badge'];
					$badge_name = htmlspecialchars($ownerBadge->getName(), ENT_NOQUOTES);
					$badge_url = $ownerBadge->getPictureUrl(90);
					$is_sponsored = $ownerBadge->isSponsored();
					$hover_url = $ownerBadge->getHoverPictureUrl();
					$badge_tracking_url = $ownerBadge->getTrackingUrl();
					$badge_click_url = $ownerBadge->getClickCommandUrl();
					$hover_tracking_url = $ownerBadge->getHoverTrackingUrl();
					$moreClass = ($i >= $max_badges) ? ' badges-more' : null;
					?>
					<li class="badge-<?= $i?>">
						<div class="profile-hover<?= ( $is_sponsored ) ? ' sponsored-hover' : null ;?>"<?= ( $is_sponsored && !empty( $hover_tracking_url ) ) ? " data-hovertrackurl=\"{$hover_tracking_url}\"" : null ;?>>
							<? if ( $is_sponsored ) :?>
								<img src="<?= $hover_url ;?>"/>
								<p class="earned"><?= wfMsgExt('achievements-earned', array('parsemag'), $ownerBadge->getEarnedBy()) ?></p>
							<? else :?>
								<img src="<?=$badge_url;?>" width="90" height="90"/>

								<div class="profile-hover-text">
									<h3 class="badge-name"><?= $badge_name ?></h3>
									<p><?= $ownerBadge->getGiveHoverFor() ?></p>
									<? if ( !$is_sponsored ) :?>
										<p class="earned"><?= wfMsgExt('achievements-earned', array('parsemag'), $ownerBadge->getEarnedBy()) ?></p>
									<? endif ;?>
								</div>
							<? endif ;?>
						</div>
						<? if ( $is_sponsored ) :?>
						<a class="sponsored-link badge-icon"
							<?= ( !empty( $badge_click_url ) ) ? " href=\"{$badge_click_url}\" title=\"". wfMsg( 'achievements-community-platinum-sponsored-badge-click-tooltip' ) . "\"" : null ;?>
							title="<?= wfMsg( 'achievements-community-platinum-sponsored-badge-click-tooltip' ) ;?>"
							<?= ( !empty( $badge_tracking_url ) ) ? " data-badgetrackurl=\"{$badge_tracking_url}\"" : null ;?>">
						<? endif ;?>
								<img class="<?= ( !$is_sponsored ) ? 'badge-icon ' : null ;?>badge-icon-<?= $i  . $moreClass ?>" width="90" height="90" src="<?= $badge_url ?>" alt="<?=$badge_name;?>" />
						<? if ( $is_sponsored ) :?>
							</a>
						<? endif ;?>
					</li>
				<? endfor ;?>
			</ul>

			<? if ( count( $ownerBadges ) > $max_badges ) :?>
				<a class="more view-all"><?= wfMsg('achievements-viewall-oasis', $ownerName) ?> <img src="<?= $wgBlankImgUrl; ?>" class="chevron"> </a>
			<? endif ;?>
		</div>
	<? endif ;?>
</section>


<? if ( $viewer_is_owner == true ) :?>
	<section class="AchievementsModule UserProfileAchievementsModule">
		<h1><?= wfMsg('achievements-profile-title-challenges', $ownerName) ?></h1>

		<ul class="badges-tracks badges">
			<?= wfRenderPartial('LatestEarnedBadges', 'ListBadges', array('badges'=> $challengesBadges, 'displayMode'=> 'Achievements' )); ?>
		</ul>
		
		<a href="<?= $customize_url ?>" class="more view-all"><?= wfMsg('achievements-profile-customize') ?></a>
	</section>
<? endif ;?>
