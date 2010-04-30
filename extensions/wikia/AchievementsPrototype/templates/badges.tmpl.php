<style>
#achievements-info {
	float: right;
	width: 200px;
	line-height: 3.5em;
	text-align: center;
	padding-top: 7px;
}
#achievements-badges {
	margin-right: 210px;
}
#achievements-badges div {
	display: inline-block;
	width: 170px;
	text-align: center;
	vertical-align: top;
	margin-right: 20px;
}
#achievements-badges span {
	display: block;
	margin-top: 10px;
	margin-bottom: 25px;
}
#achievements-badges big,
#achievements-badges strong,
#achievements-badges em {
	display: block;
}
</style>

<div id="achievements" class="clearfix">
	<div id="achievements-info">
<?php
	$numberOfBadges = array_sum($userBadges) + count($userBadges);
	if($numberOfBadges == 0) {
		echo wfMsg('achievement-no-badges', $user->getName());
	} else {
?>
<span style="font-size: 15pt; font-weight: bold; margin-right: 3px;"><?=$user->getName()?></span> has earned <br/><span style="font-size: 45pt; font-weight: bold; color: green;"><?=$numberOfBadges?></span> badges
<br/><br/><hr/><br/>
<span style="font-size: 12pt; font-weight: bold;"><?=$user->getName()?> is the</span>
<br/>
<span style="font-size: 45pt; font-weight: bold; color: purple;">#<?=$allWiki?></span>
<br/>
<span style="font-size: 12pt; font-weight: bold;">all-time wiki member</span>
<br/>
<span style="font-size: 12pt; font-weight: bold;">and</span>
<br/>
<span style="font-size: 45pt; font-weight: bold; color: purple; display: block; margin-top: 15px; margin-bottom: 5px">#<?=$thisWeek?></span>
<span style="font-size: 12pt; font-weight: bold;">for this week</span>
<?php
	}
?>
	<br/><br/>
	<hr/>
	<br/>
	<a rel="nofollow" class="wikia-button" href="<?= Skin::makeSpecialUrl('Leaderboard') ?>">Leaderboard</a>
	</div>
	<div id="achievements-badges">
<?php
global $wgExtensionsPath, $achievementTypes;
foreach($achievementTypes as $achievementTypeId => $achievement) {
	$text = '<big><b>'.wfMsg('achievement-'.$achievement['name'].'-name').'</b></big>';

	if(!isset($userBadges[$achievementTypeId])) {
		$src = $wgExtensionsPath . '/wikia/Achievements/images/'.$achievement['name'].'/'.$achievement['name'].'-bw.jpg';
		$text .= wfMsg('achievement-'.$achievement['name'].'-info');
	} else {

		if($achievementTypes[$achievementTypeId]['type'] == 'onetime') {
			$src = $wgExtensionsPath . '/wikia/Achievements/images/'.$achievement['name'].'/'.$achievement['name'].'.jpg';
			$text .= wfMsg('achievement-'.$achievement['name'].'-summary');
		} else {
			$src = $wgExtensionsPath . '/wikia/Achievements/images/'.$achievement['name'].'/'.$achievement['name'].($userBadges[$achievementTypeId] > 4 ? 'x' : $userBadges[$achievementTypeId] + 1).'.jpg';
			$text .= '<strong>' . wfMsg('achievement-level', $userBadges[$achievementTypeId] + 1) . '</strong>';
			$text .= wfMsg('achievement-'.$achievement['name'].'-summary', $userCounters[$achievementTypeId]);
			if(isset($achievement['levels'][$userBadges[$achievementTypeId] + 1])) {
				$next = $achievement['levels'][$userBadges[$achievementTypeId] + 1];
			} else {
				$valuesNo = count($achievement['levels']);
				$maxValue = $achievement['levels'][$valuesNo-1];
				$secondMaxValue = $achievement['levels'][$valuesNo-2];
				$diff = $maxValue - $secondMaxValue;
				$next = $diff * ($userBadges[$achievementTypeId] + 1);
			}
			$text .= '<em>'.wfMsg('achievement-'.$achievement['name'].'-next', $next).'</em>';
		}
	}
?>
		<div>
			<img width="150" height="150" src="<?= $src ?>">
			<span><?= $text ?></span>
		</div>
<?php
}
?>
	</div>
</div>