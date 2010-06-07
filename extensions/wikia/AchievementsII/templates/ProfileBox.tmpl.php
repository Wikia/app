<?php
global $wgExtensionsPath, $wgStyleVersion;
?>
<script src="<?= $wgExtensionsPath.'/wikia/AchievementsII/js/achievements.js?'.$wgStyleVersion ?>"></script>
<?php
if(count($ownerBadges) == 0) {
	echo '<h2 class="dark_text_2 first">'.$title_no.'</h2>'.wfMsg('achievements-no-badges');
} else {
?>
	<h2 class="dark_text_2 first"><?= $title ?></h2>
	<div id="badges" style="height: <?= count($ownerBadges) > 3 ? '200' : '100' ?>px">
		<ul id="badge-list" class="clearfix">
<?php
		$i = 0;
		foreach($ownerBadges as $ownerBadge) {
			$i++;
?>
			<li id="badge-<?= $i ?>">

				<div id="hover-<?= $i ?>" class="profile-hover">
					<img width="90" height="90" src="<?= $ownerBadge['badge']->getPictureUrl(90) ?>" alt="<?= htmlspecialchars($ownerBadge['badge']->getName()) ?>" />
					<div class="profile-hover-text">
						<h3 class="badge-name"><?= $ownerBadge['badge']->getName() ?></h3>
						<p><?= $ownerBadge['badge']->getGiveHoverFor() ?></p>
						<p class="earned"><?= wfMsgExt('achievements-earned', array('parsemag'), $ownerBadge['badge']->getEarnedBy()) ?></p>
					</div>
					<?= !empty($ownerBadge['to_get']) ? '<p class="to-get">'.wfMsg('achievements-you-must', $ownerBadge['to_get']).'</p>' : '' ?>
				</div>

				<img id="badge-icon-<?= $i ?>" width="90" height="90" src="<?= $ownerBadge['badge']->getPictureUrl(90) ?>" alt="<?= htmlspecialchars($ownerBadge['badge']->getName()) ?>" />
			</li>
<?php
		}
?>
		</ul>
	</div>

<?php
	if(count($ownerBadges) > 6) {
?>
	<div id="sub-badges">
		<p><button id="view-all"><?= wfMsg('achievements-viewall') ?></button><button id="view-less" style="display:none;"><?= wfMsg('achievements-viewless') ?></button></p>
	</div>
<?php
	}
}
?>

	<h2 class="dark_text_2"><?= $title_challenges ?></h2>
	<ul id="challenges">
<?php
foreach($challengesBadges as $badge) {
?>
		<li class="clearfix">
			<div class="profile-hover">
				<img src="<?= $badge['badge']->getPictureUrl(90) ?>" height="90" width="90" />
				<div class="profile-hover-text">
					<h3><?= $badge['badge']->getName() ?></h3>
					<p><?= $badge['badge']->getDetails() ?></p>
				</div>
			</div>
			<img width="40" height="40" src="<?= $badge['badge']->getPictureUrl(40) ?>" alt="<?= $badge['badge']->getName() ?>" />
			<div class="badge-text">
				<p class="badge-title"><?= $badge['badge']->getName() ?></p>
				<p><?= $badge['to_get'] ?></p>
			</div>
		</li>
<?php
}
?>
	</ul>

	<div id="sub-badges-2">
<?php
	if(!empty($user_rank)) {
?>
		<p><?= wfMsg('achievements-ranked', $user_rank) ?></p>
<?php
	}
?>
		<p><a href="<?= $leaderboard_url ?>" class="wikia-button" id="achievements-leaderboard"><?= wfMsg('leaderboard-button') ?></a></p>
<?php
	if(isset($customize_url)) {
?>
		<p><a href="<?= $customize_url ?>" id="achievements-customize"><?= wfMsg('achievements-profile-customize') ?></a></p>
<?php
	}
?>
	</div>