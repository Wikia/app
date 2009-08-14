<div class="myhome-feed myhome-<?= $type ?>-feed">
<h2><?= wfMsg("myhome-{$type}-feed") ?></h2>
<div id="myhome-<?= $type ?>-feed-content">
<?php
	echo $content;
?>
</div>
<?php
	if (!empty($showMore)) {
?>
	<div class="myhome-feed-more"><a id="myhome-<?= $type ?>-feed-more" onclick="MyHome.fetchMore(this)"><?= wfMsg('myhome-activity-more') ?></a></div>
<?php		
	}
?>
</div>
