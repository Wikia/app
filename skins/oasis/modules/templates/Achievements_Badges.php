<? for ($i=0; $i < count($ownerBadges); $i++) :?>
<?
	/** @var AchBadge $ownerBadge */
	$ownerBadge = $ownerBadges[$i]['badge'];
	$badge_name = htmlspecialchars( $ownerBadge->getName(), ENT_NOQUOTES );
	$badge_url = $ownerBadge->getPictureUrl(90);
	$is_sponsored = $ownerBadge->isSponsored();
	$hover_url = $ownerBadge->getHoverPictureUrl();
	$badge_tracking_url = $ownerBadge->getTrackingUrl();
	$badge_click_url = $ownerBadge->getClickCommandUrl();
	$hover_tracking_url = $ownerBadge->getHoverTrackingUrl();
	?>
	<li class="badge-<?= $i?>">
		<div class="profile-hover<?= ( $is_sponsored ) ? ' sponsored-hover' : null ;?>"<?= ( $is_sponsored && !empty( $hover_tracking_url ) ) ? " data-hovertrackurl=\"{$hover_tracking_url}\"" : null ;?>>
			<? if ( $is_sponsored ) :?>
				<img src="<?= $hover_url ;?>"/>
				<p class="earned"><?= wfMessage( 'achievements-earned', $ownerBadge->getEarnedBy() )->escaped(); ?></p>
			<? else :?>
				<img src="<?=$badge_url;?>" width="85" height="85"/>

				<div class="profile-hover-text">
					<h3 class="badge-name"><?= $badge_name ?></h3>
					<p><?= $ownerBadge->getGiveHoverFor() ?></p>
					<? if ( !$is_sponsored ) :?>
						<p class="earned"><?= wfMessage( 'achievements-earned', $ownerBadge->getEarnedBy() )->escaped(); ?></p>
					<? endif ;?>
				</div>
			<? endif ;?>
		</div>
		<? if ( $is_sponsored ) :?>
			<a class="sponsored-link badge-icon"
			<?= ( !empty( $badge_click_url ) ) ? " href=\"{$badge_click_url}\" title=\"". wfMessage( 'achievements-community-platinum-sponsored-badge-click-tooltip' )->escaped() . "\"" : null ;?>
			title="<?= wfMessage( 'achievements-community-platinum-sponsored-badge-click-tooltip' )->escaped(); ?>"
			<?= ( !empty( $badge_tracking_url ) ) ? " data-badgetrackurl=\"{$badge_tracking_url}\"" : null ;?>>
		<? endif ;?>
				<img class="<?= ( !$is_sponsored ) ? 'badge-icon ' : null ;?>badge-icon-<?= $i ?>" width="85" height="85" src="<?= $badge_url ?>" alt="<?=$badge_name;?>" />
		<? if ( $is_sponsored ) :?>
			</a>
		<? endif ;?>
	</li>
<? endfor ;?>
