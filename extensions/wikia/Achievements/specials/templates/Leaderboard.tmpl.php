<div id="about-achievements" class="accent">
	<p><?= wfMsgExt('leaderboard-intro', array('parse'), $username) ?></p>
</div>

<script src="<?= $js_url ?>"></script>

<h1 id="acheivements-title"><?= wfMsg('leaderboard') ?></h1>

<div class="clearfix">
	<ul id="leaderboard" class="clearfix">
<?php
	for($i = 0; $i < count($ranking); $i++) {
?>
		<li class="widget">
			<a href="<?= $ranking[$i]['userpage_url'] ?>">
				<div class="rel-lb-wrapper" style="background-image: url(<?= $ranking[$i]['url'] ?>);">
					<div class="user-rank"><?= $i+1 ?></div>
					<div class="bottom-marquee">
						<p><?= $ranking[$i]['name'] ?></p>
						<p class="points"><?= $ranking[$i]['score'] ?></p>
					</div>
				</div>
			</a>
		</li>
<?php
	}
?>
	</ul>

	<div id="leaderboard-sidebar">
<?php
	foreach($recent as $level => $badges) {
		if(count($badges) == 0) {
			continue;
		}

		$sectionName = wfMsg('achievements-recent-'.AchStatic::$mLevelNames[$level]);

?>
		<h2 class="dark_text_2<?= $level == BADGE_LEVEL_GOLD ? ' first' : '' ?>"><?= $sectionName ?></h2>
		<ul class="recent-badges">
<?php
		foreach($badges as $badge) {
			if(isset($users[$badge['user_id']])) {
				$badge_name = AchHelper::getBadgeName($badge['badge_type'], $badge['badge_lap']);
				$badge_url = AchHelper::getBadgeUrl($badge['badge_type'], $badge['badge_lap'], 40);
				$info = wfMsg('achievements-recent-info',
					$users[$badge['user_id']]['user']->getUserPage()->getLocalURL(),
					$users[$badge['user_id']]['user']->getName(),
					$badge_name,
					AchHelper::getGivenFor($badge['badge_type'], $badge['badge_lap']));
?>
		    <li class="clearfix">
		      <img src="<?= $badge_url ?>" alt="<?= htmlspecialchars($badge_name) ?>" width="40" height="40" />
		      <div class="badge-text">
		        <p><?= $info ?></p>
		      </div>
		    </li>
<?php
			}
		}
?>
		</ul>
<?php
	}
?>
	</div>

</div>
