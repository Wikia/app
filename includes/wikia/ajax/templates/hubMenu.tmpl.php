<div id="headerMenuHub" class="headerMenu color1 reset">
	<table cellspacing="0">
	<tr>
		<td>
<?php
	for($i = 0; $i < ceil(count($categorylist['nodes']) / 2); $i++) {
?>
			<a rel="nofollow" href="<?= htmlspecialchars($categorylist['nodes'][$i]['href']) ?>" id="headerMenuHub-<?= $i ?>"><?= $categorylist['nodes'][$i]['text'] ?></a><br />
<?php
	}
?>
		</td>
		<td>
<?php
	for($i = ceil(count($categorylist['nodes']) / 2); $i < count($categorylist['nodes']); $i++) {
?>
			<a rel="nofollow" href="<?= htmlspecialchars($categorylist['nodes'][$i]['href']) ?>" id="headerMenuHub-<?= $i ?>"><?= $categorylist['nodes'][$i]['text'] ?></a><br />
<?php
	}
?>
		</td>
	</tr>
	</table>
<?php
	if($categorylist['cat']['text']) {
?>
	<a rel="nofollow" href="<?= htmlspecialchars($categorylist['cat']['href']) ?>" id="goToHub"><?= wfMsg('seemoredotdotdot') ?></a>
<?php
	}
?>
</div>
