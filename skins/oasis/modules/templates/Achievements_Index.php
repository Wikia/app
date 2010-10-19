<section class="AchievementsModule">
<?php
	if(count($ownerBadges) == 0) {
		echo '<h1>'.wfMsg('achievements-profile-title-no', $ownerName).'</h1>'.wfMsg('achievements-no-badges');
	} else {
?>
	<h2><?= wfMsgExt('achievements-profile-title', array('parsemag'), $ownerName, count($ownerBadges)) ?></h2>
	
	<details class="tally">
		<em><?= $ownerScore ?></em> <?= wfMsg('achievements-profile-title-oasis') ?>
	</details>
	
	<p><?= wfMsgExt ('achievements-ranked-oasis', array('parse') , $ownerName, $ownerRank) ?> </p>
	<div style="height: <?= count($ownerBadges) > 3 ? '200' : '100' ?>px">
		<ul class="badges-icons badges">
<?php
		//$max_badges = 6;
		for ($i=0; $i < count($ownerBadges); $i++) {
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
<?php
			}
?>
		</ul>		
<?php
	if (count($ownerBadges) > $max_badges) {
?>
			<a class="more view-all"><?= wfMsg('achievements-viewall-oasis', $ownerName) ?> <img src="<?= $wgBlankImgUrl; ?>" class="chevron"> </a>
<?php	}
?>
	</div>

<?php
		
	}

	if ($viewer_is_owner == true) {
?>
	<h2 class="line-top"><?= wfMsg('achievements-profile-title-challenges', $ownerName) ?></h2>

	<ul class="badges-tracks badges">
	<?= wfRenderPartial('LatestEarnedBadges', 'ListBadges', array('badges'=> $challengesBadges, 'displayMode'=> 'Achievements' )); ?>
		<a href="<?= $customize_url ?>" class="more"><?= wfMsg('achievements-profile-customize') ?></a>
	<?php
	}
	?>
	</ul>
</section>
