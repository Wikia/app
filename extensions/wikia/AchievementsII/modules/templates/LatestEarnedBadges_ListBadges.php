<?php 
$count = 0;
foreach ($badges as $item) {
	
	//if ($count > $maxBadges) {	break;	}
	$badge_name = htmlspecialchars($item['badge']->getName(), ENT_NOQUOTES);
	$badge_url = $item['badge']->getPictureUrl(40);
	$badge_url_hover = $item['badge']->getPictureUrl(90);
	$badge_details = $item['badge']->getDetails();
	$is_sponsored = $item['badge']->isSponsored();
	$hover_url = $item['badge']->getHoverPictureUrl();
	$badge_tracking_url = $item['badge']->getTrackingUrl();
	$badge_click_url = $item['badge']->getClickCommandUrl();
	$hover_tracking_url = $item['badge']->getHoverTrackingUrl();
	$earned_by = $item['badge']->getEarnedBy();

	// Display mode can be 'LatestBadges' (special:leaderboard) or 'Achievements' (user page)

	if ($displayMode == 'LatestBadges') {
		$info = wfMsg('achievements-recent-info',
			$item['user']->getUserPage()->getLocalURL(),
			$item['user']->getName(),
			$badge_name,
			$item['badge']->getGiveFor(),
			wfTimeFormatAgo($item['date'])
		);
	} else {
		$info = "<strong>$badge_name</strong><br /> {$item['to_get']}";
	}
?>
	<li>
		<div class="profile-hover<?= ( $is_sponsored ) ? ' sponsored-hover' : null ;?>"<?= ( $is_sponsored && !empty( $hover_tracking_url ) ) ? " data-hovertrackurl=\"{$hover_tracking_url}\"" : null ;?>>
			<? if ( $is_sponsored ) :?>
				<img src="<?= $hover_url ;?>"/>
				<p class="earned"><?= wfMsgExt('achievements-earned', array('parsemag'), $earned_by) ?></p>
			<? else :?>
				<img src="<?=$badge_url_hover;?>" width="90" height="90"/>

				<div class="profile-hover-text">
					<h3 class="badge-name"><?= $badge_name ?></h3>
					<p><?=$badge_details;?></p>
					<? if ( !$is_sponsored ) :?>
						<p class="earned"><?= wfMsgExt('achievements-earned', array('parsemag'), $earned_by) ?></p>
					<? endif ;?>
				</div>
			<? endif ;?>
		</div>
		<? if ( $is_sponsored ) :?>
			<a class="sponsored-link badge-icon badge-small"
				<?= ( !empty( $badge_click_url ) ) ? " href=\"{$badge_click_url}\" title=\"". wfMsg( 'achievements-community-platinum-sponsored-badge-click-tooltip' ) . "\"" : null ;?>
				title="<?= wfMsg( 'achievements-community-platinum-sponsored-badge-click-tooltip' ) ;?>"
				<?= ( !empty( $badge_tracking_url ) ) ? " data-badgetrackurl=\"{$badge_tracking_url}\"" : null ;?>">
		<? endif ;?>
			<img class="<?= ( !$is_sponsored ) ? 'badge-icon ' : null ;?>badge-small badge-icon-<?= $count++ ?> badge-icon-earnable" width="40" height="40"  src="<?= $badge_url ;?>" alt="<?= $badge_name ;?>">
		<? if ( $is_sponsored ) :?>
			</a>
		<? endif ;?>
		<div class="badge-text">
			<p><?= $info ?></p>
		</div>
	</li>
<?php 
}
?>
