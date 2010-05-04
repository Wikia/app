<?php
if(count($badges) == 0) {
	echo '<h2 class="dark_text_2 first">'.$title_no.'</h2>'.wfMsg('achievements-no-badges');
} else {
?>
	<script src="<?= $js_url ?>"></script>
	<h2 class="dark_text_2 first"><?= $title ?></h2>
	<div id="badges" style="height: <?= count($badges) > 3 ? '200' : '100' ?>px">
		<ul id="badge-list" class="clearfix">
<?php
		$counters = array(BADGE_LEVEL_GOLD => 0, BADGE_LEVEL_SILVER => 0, BADGE_LEVEL_BRONZE => 0);
		for($i = 0; $i < count($badges); $i++) {
			$counters[$badges[$i]['badge_level']]++;
?>
			<li id="badge-<?= $i+1; ?>">
				<div id="hover-<?= $i+1; ?>" class="profile-hover" style="display: none;">

          <div class="clearfix">
	          <img width="90" height="90" src="<?= $badges[$i]['badge_url'] ?>" alt="<?= htmlspecialchars($badges[$i]['badge_name']) ?>" />
	          <div>
		          <h3 class="badge-name"><?= $badges[$i]['badge_name'] ?></h3>
		          <p><?= $badges[$i]['given_for'] ?></p>
		          <p class="earned"><?= wfMsgExt('achievements-earned', array('parsemag'), $badges[$i]['earned_by']) ?></p>
	          </div>
          </div>

					<?= isset($badges[$i]['to_get']) ? '<p class="to-get">'.wfMsg('achievements-you-must', $badges[$i]['to_get']).'</p>' : '' ?>

				</div>

				<img id="badge-icon-<?= $i+1; ?>" width="90" height="90" src="<?= $badges[$i]['badge_url'] ?>" alt="<?= htmlspecialchars($badges[$i]['badge_name']) ?>" />
			</li>
<?php
		}
?>
		</ul>
	</div>
<?php
}
global $wgExtensionsPath;
?>

	<div id="sub-badges">
<?php
	if(count($badges) > 6) {
?>

		<p><button id="view-all"><?= wfMsg('achievements-viewall') ?></button><button id="view-less" style="display:none;"><?= wfMsg('achievements-viewless') ?></button></p>
<?php
	}
	if(count($badges) > 0) {
?>
		<p><img src="<?= "{$wgExtensionsPath}/wikia/Achievements/images/gold-achievement-24.png" ?>"/> <?= $counters[BADGE_LEVEL_GOLD] ?> <?= wfMsg('achievements-gold') ?> <img src="<?= "{$wgExtensionsPath}/wikia/Achievements/images/silver-achievement-24.png" ?>" class="image-24"> <?= $counters[BADGE_LEVEL_SILVER] ?> <?= wfMsg('achievements-silver') ?> <img src="<?= "{$wgExtensionsPath}/wikia/Achievements/images/bronze-achievement-24.png" ?>" class="image-24"> <?= $counters[BADGE_LEVEL_BRONZE] ?> <?= wfMsg('achievements-bronze') ?></p>
		<p><?= wfMsg('achievements-ranked', $rank) ?></p>

<?php
	}
?>
		<p><a href="<?= $leaderboard_url ?>" class="wikia-button" id="achievements-leaderboard"><?= wfMsg('leaderboard') ?></a></p>
<?php
	if(isset($customize_url)) {
?>
		<p><a href="<?= $customize_url ?>" id="achievements-customize"><?= wfMsg('achievements-profile-customize') ?></a></p>
<?php
	}
?>
	</div>

	<h2 class="dark_text_2"><?= $title_challenges ?></h2>
	<ul id="challenges">
<?php
foreach($challengesInfo as $badge) {
?>
		<li class="clearfix">
			<img width="40" height="40" src="<?= $badge['badge_url'] ?>" alt="<?= htmlspecialchars($badge['badge_name']) ?>" />
			<div class="badge-text">
				<p class="badge-title"><?= htmlspecialchars($badge['badge_name']) ?></p>
				<p><?= $badge['info'] ?></p>
			</div>
		</li>
<?php
}
?>
	</ul>