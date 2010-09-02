<section class="AchievementsModule">
<?php
	if(count($ownerBadges) == 0) {
		echo '<h1>'.wfMsg('achievements-profile-title-no', $ownerName).'</h1>'.wfMsg('achievements-no-badges');
	} else {
?>
	<h2><?= wfMsgExt('achievements-profile-title', array('parsemag'), $ownerName, count($ownerBadges)) ?></h2>
	
	<details class="tally">
		<em><?= $ownerScore ?></em> <?= wfMsg('achievements-profile-title-oasis') ?>
	</details>
	
	<p><?= wfMsgExt ('achievements-ranked-oasis', array('parse') , $ownerName, $ownerRank) ?> </p>
	<div style="height: <?= count($ownerBadges) > 3 ? '200' : '100' ?>px">
		<ul class="badges-icons badges">
<?php
		//$max_badges = 6;
		for ($i=0; $i < count($ownerBadges); $i++) {
			$ownerBadge = $ownerBadges[$i]['badge'];
			$badge_name = htmlspecialchars($ownerBadge->getName(), ENT_NOQUOTES);
			$badge_url = $ownerBadge->getPictureUrl(90);

			$moreClass = '';
			if ($i >= $max_badges) {
				$moreClass = ' badges-more';
			}
?>
			<li class="badge-<?= $i?>">
				<div class="profile-hover">
					<img src="<?=$badge_url;?>" height="90" width="90" />
					<div class="profile-hover-text">
						<h3 class="badge-name"><?= $badge_name ?></h3>
						<p><?= $ownerBadge->getGiveHoverFor() ?></p>
						<p class="earned"><?= wfMsgExt('achievements-earned', array('parsemag'), $ownerBadge->getEarnedBy()) ?></p>
					</div>
				</div>
				<img class="badge-icon-<?= $i  . $moreClass ?>" width="90" height="90" src="<?= $badge_url ?>" alt="<?=$badge_name;?>" />
			</li>
<?php
			}
?>
		</ul>		
<?php
	if (count($ownerBadges) > $max_badges) {
?>
			<a class="more view-all"><?= wfMsg('achievements-viewall-oasis', $ownerName) ?> <img src="<?= $wgBlankImgUrl; ?>" class="chevron"> </a>
<?php	}
?>
	</div>

<?php
		
	}

	if ($viewer_is_owner == true) {
?>
	<h2 class="line-top"><?= wfMsg('achievements-profile-title-challenges', $ownerName) ?></h2>

	<ul class="badges">
	<?= wfRenderPartial('LatestEarnedBadges', 'ListBadges', array('badges'=> $challengesBadges, 'displayMode'=> 'Achievements' )); ?>
		<a href="<?= $customize_url ?>" class="more"><?= wfMsg('achievements-profile-customize') ?></a>
	<?php
	}
	?>
	</ul>
</section>
