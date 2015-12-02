<div id="about-achievements">
	<span class="hide"><?= wfMessage( 'leaderboard-intro-hide' )->escaped(); ?></span>
	<span class="open"><?= wfMessage( 'leaderboard-intro-open' )->escaped(); ?></span>
	<h1><?= wfMessage( 'leaderboard-intro-headline' )->escaped(); ?></h1>
	<div>
		<?= wfMessage( 'leaderboard-intro', $userpage )->parseAsBlock(); ?>
		<ul>
			<li class="bronze">
				<?= wfMessage( 'achievements-bronze' )->escaped(); ?>
				<span><?= wfMessage( 'achievements-bronze-points' )->parse(); ?></span>
			</li>
			<li class="silver">
				<?= wfMessage( 'achievements-silver' )->escaped(); ?>
				<span><?= wfMessage( 'achievements-silver-points' )->parse(); ?></span>
			</li>
			<li class="gold">
				<?= wfMessage( 'achievements-gold' )->escaped(); ?>
				<span><?= wfMessage( 'achievements-gold-points' )->parse(); ?></span>
			</li>
		</ul>
	</div>
</div>

<h2 class="achievements-title"><?= wfMessage( 'leaderboard-title' )->escaped(); ?></h2>

<table id="LeaderboardTable" class="LeaderboardTable">
	<thead>
		<tr>
			<th><?= wfMessage( 'achievements-leaderboard-rank-label' )->escaped(); ?></th>
			<th><?= wfMessage( 'achievements-leaderboard-member-label' )->escaped(); ?></th>
			<th><?= wfMessage( 'achievements-leaderboard-points-label' )->escaped(); ?></th>
			<th><?= wfMessage( 'achievements-leaderboard-most-recently-earned-label' )->escaped(); ?></th>
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
				<span><?= wfMessage( 'achievements-leaderboard-points', $userScore )->escaped(); ?></span>
			</td>
			<td class="badge">
				<div class="badges" style="position: relative;">
					<div class="profile-hover<?= ( $badgeIsSponsored ) ? ' sponsored-hover' : null ;?>"<?= ( $badgeIsSponsored && !empty( $hoverTrackingUrl ) ) ? " data-hovertrackurl=\"{$hoverTrackingUrl}\"" : null ;?>>
						<? if ( $badgeIsSponsored ) :?>
							<img src="<?= $hoverUrl ;?>"/>
							<p class="earned"><?= wfMessage( 'achievements-earned', $badgeEarnedBy )->escaped(); ?></p>
						<? else :?>
							<img src="<?=$badge->getPictureURL(90)?>" width="90" height="90" />
							<div class="profile-hover-text">
								<h3 class="badge-name"><?= htmlspecialchars( $badge->getName() ); ?></h3>
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
					<?= htmlspecialchars( $badge->getName() ); ?>
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
