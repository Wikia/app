<div id="about-achievements" class="accent">
	<?= wfMsgExt( 'leaderboard-intro', array( 'parse' ), $username ) ?>
</div>

<div id="leaderboard-body" class="accent">
  <div class="leaderboard-body-inner">
  	<h1 class="achievements-title"><?= wfMsg('leaderboard') ?></h1>
  	<ul id="leaderboard">
  		<li class="accent list-heading">
  			<div id="rank-label"><?= wfMsg('achievements-leaderboard-rank-label'); ?></div>
  			<div id="member-label"><?= wfMsg('achievements-leaderboard-member-label'); ?></div>
  			<div id="points-label"><?= wfMsg('achievements-leaderboard-points-label'); ?></div>
  		</li>
  		<?foreach($ranking as $rank => $rankedUser):?>
  			<?php
  			global $wgExtensionsPath, $wgLang;
  			$curRanking = $rankedUser->getCurrentRanking();
  			$prevRanking = $rankedUser->getPreviousRanking();
  			?>
  			<li class="accent">
  				<div class="user-rank accent">
  					<span><?=++$rank;?></span>
  					<?if($curRanking < $prevRanking):?>
  						<img src="<?="{$wgExtensionsPath}/wikia/AchievementsII/images/uparrow.png";?>" />
  					<?elseif($curRanking > $prevRanking && $prevRanking !== null):?>
  						<img src="<?="{$wgExtensionsPath}/wikia/AchievementsII/images/downarrow.png";?>" />
  					<?endif;?>
  				</div>
  				<img class="user-avatar" src="<?=$rankedUser->getAvatarUrl();?>" width="25" height="25" />
  				<div class="user-name"><a href="<?=$rankedUser->getUserPageUrl();?>"><?=htmlspecialchars($rankedUser->getName());?></a></div>
  				<div class="user-score"><?=$wgLang->formatNum($rankedUser->getScore());?></div>
  			</li>
  		<?endforeach;?>
  	</ul>
  	<div id="legend">
  		<?= wfMsg('achievements-leaderboard-disclaimer'); ?>
  	</div>
	</div>
</div>
<div class="article-sidebar">
	<?= AdEngine::getInstance()->getPlaceHolderIframe("ACHIEVEMENTS_BOXAD") ?>
	<h2 class="achievements-title"><?= wfMsg('achievements-recent-earned-badges'); ?></h2>
	<ul class="recent-badges">
		<?php
		foreach($recents as $level => $badges):
			foreach($badges as $item):
                                $badge_name = htmlspecialchars($item['badge']->getName());
				$badge_url = $item['badge']->getPictureUrl(82);
				$badge_url_hover = $item['badge']->getPictureUrl(90);
				$badge_details = $item['badge']->getDetails();
				$info = wfMsg('achievements-recent-info',
					$item['user']->getUserPage()->getLocalURL(),
					$item['user']->getName(),
					$badge_name,
					$item['badge']->getGiveFor(),
					wfTimeFormatAgo($item['date'])
				);
		?>
				<li class="clearfix">
					<div class="profile-hover">
						<img src="<?=$badge_url_hover;?>" height="90" width="90" />
						<div class="profile-hover-text">
							<h3><?=$badge_name;?></h3>
							<p><?=$badge_details;?></p>
						</div>
					</div>
					<img rel="leaderboard" src="<?= $badge_url ?>" alt="<?=$badge_name;?>" height="82" width="82" />
					<div class="badge-text">
						<p><?= $info ?></p>
					</div>
				</li>
			<?endforeach;?>
		<?endforeach;?>
	</ul>
</div>

