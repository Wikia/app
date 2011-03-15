<?php 
if (count($fbSaveData) > 0) {
?>
<table class="fbconnect-synced-profile">
<?php if (isset($fbSaveData['fb-name'])) {
?>
	<tr><th><?=wfMsg('fb-sync-realname')?></th>
		<td><?= $fbSaveData['fb-name'] ?></td></tr>
		<?php
	}
?>
<?php if (isset($fbSaveData['fb-birthday'])) {
?>
	<tr><th><?=wfMsg('fb-sync-birthday')?></th>
		<td><?= $fbSaveData['fb-birthday'] ?></td></tr>
		<?php
	}
?>
<?php if (isset($fbSaveData['fb-gender'])) { 
?>
	<tr><th><?=wfMsg('fb-sync-gender')?></th>
		<td><?= $fbSaveData['fb-gender']; ?></td></tr>
		<?php
	}
?>
<?php if (isset($fbSaveData['fb-relationshipstatus'])) {
?>
	<tr><th><?=wfMsg('fb-sync-relationshipstatus')?></th>
		<td><?= $fbSaveData['fb-relationshipstatus'] ?></td></tr>
		<?php
	}
?>
	<?php if (isset($fbSaveData['fb-languages'])) {
?>
	<tr><th><?=wfMsg('fb-sync-languages')?></th>
		<td><?= $fbSaveData['fb-languages'] ?></td></tr>
		<?php
	}
?>
<?php if (isset($fbSaveData['fb-hometown'])) { 
?>
	<tr><th><?=wfMsg('fb-sync-hometown')?></th>
		<td><?= $fbSaveData['fb-hometown'] ?></td></tr>
		<?php
	}
?>
<?php if (isset($fbSaveData['fb-location'])) { 
?>
	<tr><th><?=wfMsg('fb-sync-currentlocation')?></th>
		<td><?= $fbSaveData['fb-location']?></td></tr>
		<?php
	}
?>
<?php if (isset($fbSaveData['fb-education'])) { 
?>
	<tr><th><?=wfMsg('fb-sync-education')?></th>
		<td><?= nl2br($fbSaveData['fb-education']); ?></td></tr>
		<?php
	}
?>
<?php if (isset($fbSaveData['fb-religion'])) { 
?>
	<tr><th><?=wfMsg('fb-sync-religiousviews')?></th>
		<td><?= $fbSaveData['fb-religion']; ?></td></tr>
		<?php
	}
?>
<?php if (isset($fbSaveData['fb-political'])) { 
?>
	<tr><th><?=wfMsg('fb-sync-politicalviews')?></th>
		<td><?= $fbSaveData['fb-political'] ?></td></tr>
		<?php
	}
?>
<?php if (isset($fbSaveData['fb-website'])) { 
?>
	<tr><th><?=wfMsg('fb-sync-website')?></th>
		<td><?= $fbSaveData['fb-website'] ?></td></tr>
		<?php
	}
?>
<?php if (isset($fbSaveData['fb-interests'])) { ?>
	<tr><th><?=wfMsg('fb-sync-interestedin')?></th>
		<td><?= nl2br($fbSaveData['fb-interests']) ?></td></tr>
<?php
} ?>
</table>
<?php } ?>