<div id="about-achievements">
	<span class="hide"><?= wfMsg('leaderboard-intro-hide') ?></span>
	<span class="open"><?= wfMsg('leaderboard-intro-open') ?></span>
	<h1><?= wfMsg('leaderboard-intro-headline') ?></h1>
	<div>
		<?= wfMsgExt( 'leaderboard-intro', 'parse', $userpage ) ?>
		<ul>
			<li class="bronze">
				<?= wfMsg('achievements-bronze') ?>
				<span><?= wfMsg('achievements-bronze-points') ?></span>
			</li>
			<li class="silver">
				<?= wfMsg('achievements-silver') ?>
				<span><?= wfMsg('achievements-silver-points') ?></span>
			</li>
			<li class="gold">
				<?= wfMsg('achievements-gold') ?>
				<span><?= wfMsg('achievements-gold-points') ?></span>
			</li>
		</ul>	
	</div>
</div>

<h1 class="achievements-title"><?= wfMsg('leaderboard-title') ?></h1>

<table id="LeaderboardTable" class="LeaderboardTable">
	<thead>
		<tr>
			<th><?= wfMsg('achievements-leaderboard-rank-label'); ?></th>
			<th><?= wfMsg('achievements-leaderboard-member-label'); ?></th>
			<th><?= wfMsg('achievements-leaderboard-points-label'); ?></th>
			<th><?= wfMsg('achievements-leaderboard-most-recently-earned-label'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?
		foreach($ranking as $rank => $rankedUser){
		global $wgExtensionsPath, $wgLang;
		/*
		$curRanking = $rankedUser->getCurrentRanking();
		$prevRanking = $rankedUser->getPreviousRanking();
		*/
		$badge = $topUserBadges[$rankedUser->getID()];
		
	?>
		<tr>
			<td class="rank">
				<span><?= $rankedUser->getCurrentRanking();?></span>
			</td>
			<td class="user">
				<img src="<?=$rankedUser->getAvatarUrl();?>" width="35" height="35">
				<a href="<?=$rankedUser->getUserPageUrl();?>"><?=htmlspecialchars($rankedUser->getName());?></a>
			</td>
			<td class="tally">
				<em><?=$wgLang->formatNum($rankedUser->getScore());?></em>
				<span>Points</span>
			</td>
			<td class="badge">
				<div class="badges" style="position: relative;">
					<div class="profile-hover">
						<img src="<?=$badge->getPictureURL(90)?>">
						<div class="profile-hover-text">
							<h3 class="badge-name"><?=$badge->getName()?></h3>
							<p><?=$badge->getDetails()?></p>							
						</div>
					</div>
					<img src="<?=$badge->getPictureURL(40)?>" class="badge-icon">
					<?=$badge->getName()?>
				</div>
			</td>
		</tr>
	<? } //endforeach ?>
	</tbody>
</table>

<?php
	global $wgUser;
	if (get_class($wgUser->getSkin()) != 'SkinOasis') {
		echo '<div class="article-sidebar">';
		echo wfRenderModule('LatestEarnedBadges');
		echo '</div>';
	}
?>
