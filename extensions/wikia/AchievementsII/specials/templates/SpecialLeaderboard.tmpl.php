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

<h2 class="achievements-title"><?= wfMsg('leaderboard-title') ?></h2>

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
		$curRanking = $rankedUser->getCurrentRanking();
		$prevRanking = $rankedUser->getPreviousRanking();
		if (!isset($topUserBadges[$rankedUser->getID()])) continue;
		$badge = $topUserBadges[$rankedUser->getID()];
		$badgeIsSponsored = $badge->isSponsored();
		$hoverUrl = $badge->getHoverPictureUrl();
		$badgeTrackingUrl = $badge->getTrackingUrl();
		$badgeClickUrl = $badge->getClickCommandUrl();
		$hoverTrackingUrl = $badge->getHoverTrackingUrl();
		$badgeEarnedBy = $badge->getEarnedBy();
		$userScore = $rankedUser->getScore();
	?>
		<tr>
			<td class="rank">
				<span><?= '&nbsp;' . $curRanking ?>
					<?if($curRanking < $prevRanking):?>
						<img src="<?="{$wgExtensionsPath}/wikia/AchievementsII/images/uparrow.png";?>" />
					<?elseif($curRanking > $prevRanking && $prevRanking !== null):?>
						<img src="<?="{$wgExtensionsPath}/wikia/AchievementsII/images/downarrow.png";?>" />
					<?endif;?>
				</span>
			</td>
			<td class="user">
				<?= AvatarService::renderAvatar($rankedUser->getName(), 35); ?>
				<a href="<?=$rankedUser->getUserPageUrl();?>"><?=htmlspecialchars($rankedUser->getName());?></a>
			</td>
			<td class="tally">
				<em><?=$wgLang->formatNum($userScore);?></em>
				<span><?= wfMsg('achievements-leaderboard-points', $userScore) ?></span>
			</td>
			<td class="badge">
				<div class="badges" style="position: relative;">
					<div class="profile-hover<?= ( $badgeIsSponsored ) ? ' sponsored-hover' : null ;?>"<?= ( $badgeIsSponsored && !empty( $hoverTrackingUrl ) ) ? " data-hovertrackurl=\"{$hoverTrackingUrl}\"" : null ;?>>
						<? if ( $badgeIsSponsored ) :?>
							<img src="<?= $hoverUrl ;?>"/>
							<p class="earned"><?= wfMsgExt('achievements-earned', array('parsemag'), $badgeEarnedBy) ?></p>
						<? else :?>
							<img src="<?=$badge->getPictureURL(90)?>" width="90" height="90" />
							<div class="profile-hover-text">
								<h3 class="badge-name"><?=$badge->getName()?></h3>
								<p><?=$badge->getDetails()?></p>
							</div>
						<? endif ;?>
					</div>
					<? if ( $badgeIsSponsored ) :?>
						<a class="sponsored-link badge-icon badge-small"
							<?= ( !empty( $badgeClickUrl ) ) ? " href=\"{$badgeClickUrl}\"" : null ;?>
							<?= ( !empty( $badgeTrackingUrl ) ) ? " data-badgetrackurl=\"{$badgeTrackingUrl}\"" : null ;?>>
					<? endif ;?>
					<img src="<?=$badge->getPictureURL(40)?>" <?= ( !$badgeIsSponsored ) ? 'class="badge-icon" ' : null ;?>width="40" height="40" />
					<? if ( $badgeIsSponsored ) :?>
						</a>
					<? endif ;?>
					<?=$badge->getName()?>
				</div>
			</td>
		</tr>
	<? } //endforeach ?>
	</tbody>
</table>

<?php
	global $wgUser;
	if (get_class(RequestContext::getMain()->getSkin()) != 'SkinOasis') {
		echo '<div class="article-sidebar">';
		echo F::app()->renderView('LatestEarnedBadges', 'Index');
		echo '</div>';
	}
