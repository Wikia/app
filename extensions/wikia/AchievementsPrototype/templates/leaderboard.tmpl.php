<style>
#achievements-leaderboard {
	width: 100%;
}
#achievements-leaderboard span {
	font-size: 15pt;
	font-weight: bold;
}
#achievements-leaderboard li {
	margin: 20px 0 0 0;
}
#achievements-leaderboard a {
	color: #000;
}
</style>

<?=wfMsg('leaderboard-message')?>

<table id="achievements-leaderboard">
	<tr>
		<td><center><h1>All-Time</h1></center></td>
		<td style="width: 25px;"></td>
		<td><center><h1>This week</h1></center></td>
	</tr>
	<tr>
		<td style="vertical-align: top;">
			<ol>
<?php
foreach($allTime as $item) {
?>
				<li><span><a href="<?=htmlspecialchars($item['url'])?>"><?=htmlspecialchars($item['username'])?></a> <img style="margin: 0pt 7px;" src="http://images.wikia.com/common/skins/common/bullet.gif"> <?=$item['numberOfBadges']?></span> badges</li>
<?php
}
?>
			</ol>
		</td>
		<td>&nbsp;</td>
		<td style="vertical-align: top;">
			<ol>
<?php
foreach($thisWeek as $item) {
?>
				<li><span><a href="<?=htmlspecialchars($item['url'])?>"><?=htmlspecialchars($item['username'])?></a> <img style="margin: 0pt 7px;" src="http://images.wikia.com/common/skins/common/bullet.gif"> <?=$item['numberOfBadges']?></span> badges</li>
<?php
}
?>
			</ol>
		</td>
	</tr>

</table>