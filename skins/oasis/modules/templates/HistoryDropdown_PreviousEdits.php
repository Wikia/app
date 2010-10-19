<?php
	foreach($revisions as $entry) {
?>
<li>
	<img src="<?= $entry['avatarUrl'] ?>" width="20" height="20" class="avatar">
	<?= wfMsg('oasis-page-header-edited-by', "<time class='timeago' datetime='".$entry['timestamp']."'> </time>", $entry['link']) ?>
</li>
<?php
	}
?>