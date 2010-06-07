<div id="about-achievements" class="accent">
	<p><?= wfMsgExt('leaderboard-intro', array('parse'), $username) ?></p>
</div>

<h1 id="acheivements-title"><?= wfMsg('leaderboard') ?></h1>

<div class="clearfix">
	<ul id="leaderboard" class="clearfix">
		<?foreach($ranking as $rank => $rankedUser):?>
			<li class="widget">
				<a href="<?=$rankedUser->getUserPageUrl();?>">
					<div class="rel-lb-wrapper" style="background-image: url(<?=$rankedUser->getAvatarUrl();?>);">
						<div class="user-rank"><?=++$rank;?></div>
						<div class="bottom-marquee">
							<p><?=htmlspecialchars($rankedUser->getName());?></p>
							<p class="points"><?=number_format($rankedUser->getScore());?></p>
						</div>
					</div>
				</a>
			</li>
		<?endforeach;?>
	</ul>

	<div id="leaderboard-sidebar">
<?php
	$first = null;

	foreach($recents as $level => $badges) {
		$sectionName = wfMsg('achievements-recent-'.AchConfig::getInstance()->getLevelMsgKeyPart($level));
?>
		<h2 class="dark_text_2<?= $first == null ? ' first' : '' ?>"><?= $sectionName ?></h2>
		<ul class="recent-badges">
<?php
		$first = true;
		foreach($badges as $item):
			$badge_name = htmlspecialchars($item['badge']->getName());
			$badge_url = $item['badge']->getPictureUrl(90);
			$badge_details = $item['badge']->getDetails();
			$info = wfMsg('achievements-recent-info',
				$item['user']->getUserPage()->getLocalURL(),
				$item['user']->getName(),
				$badge_name,
				$item['badge']->getGiveFor());
?>
		    <li class="clearfix">
					<div class="profile-hover">
						<img src="<?=$badge_url;?>" height="90" width="90" />
						<div class="profile-hover-text">
							<h3><?=$badge_name;?></h3>
							<p><?=$badge_details;?></p>
						</div>
					</div>		    
		      <img src="<?= $badge_url ?>" alt="<?=$badge_name;?>" width="40" height="40" />
		      <div class="badge-text">
		        <p><?= $info ?></p>
		      </div>
		    </li>
		<?endforeach;?>
		</ul>
<?php
	}
?>
	</div>
</div>
