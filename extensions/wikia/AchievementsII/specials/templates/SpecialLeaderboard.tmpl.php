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
<?php
	global $wgUser;
	if (get_class($wgUser->getSkin()) != 'SkinOasis') {
		echo '<div class="article-sidebar">';
		echo wfRenderModule('LatestEarnedBadges');
		echo '</div>';
	}
?>
