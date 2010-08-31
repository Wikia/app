<?php 
$count = 0;
foreach ($badges as $item) {
	
	//if ($count > $maxBadges) {	break;	}
	$badge_name = htmlspecialchars($item['badge']->getName(), ENT_NOQUOTES);
	$badge_url = $item['badge']->getPictureUrl(82);
	$badge_url_hover = $item['badge']->getPictureUrl(90);
	$badge_details = $item['badge']->getDetails();

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
		$info = $item['to_get'];
	}
?>
	<li>
		<div class="profile-hover">
			<img src="<?=$badge_url_hover;?>" height="90" width="90" />
			<div class="profile-hover-text">
				<h3><?=$badge_name;?></h3>
				<p><?=$badge_details;?></p>
			</div>
		</div>
		<img width="40" height="40" class="badge-icon-<?= $count++ ?> badge-icon-earnable" src="<?= $item['badge']->getPictureUrl(40) ?>" alt="<?= $item['badge']->getName() ?>">
		<div class="badge-text">
			<p><?= $info ?></p>
		</div>
	</li>
<?php 
}
?>
