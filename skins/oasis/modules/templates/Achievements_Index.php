<section class="AchievementsModule">
<?php
	if(count($ownerBadges) == 0) {
		echo '<h1>'.wfMsg('achievements-profile-title-no', $ownerName).'</h1>'.wfMsg('achievements-no-badges');
	} else {
?>
	<h2><?= wfMsgExt('achievements-profile-title', array('parsemag'), $ownerName, count($ownerBadges)) ?></h2>
	
	<details>
		<em><?= $ownerScore ?></em> <?= wfMsg('achievements-profile-title-oasis') ?>
	</details>
	
	<p><?= wfMsgExt ('achievements-ranked-oasis', array('parse') , $ownerName, $ownerRank) ?> </p>
	<div style="height: <?= count($ownerBadges) > 3 ? '200' : '100' ?>px">
		<ul class="badges-icons">
<?php
		//$max_badges = 6;
		for ($i=0; $i < count($ownerBadges); $i++) {
			$ownerBadge = $ownerBadges[$i];
			$moreClass = '';
			if ($i >= $max_badges) {
				$moreClass = ' badges-more';
			}
?>
			<li class="badge-<?= $i?>">
				<img class="badge-icon-<?= $i  . $moreClass ?>" width="90" height="90" src="<?= $ownerBadge['badge']->getPictureUrl(90) ?>" alt="<?= htmlspecialchars($ownerBadge['badge']->getName()) ?>" />
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
