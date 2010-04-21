<?/*<div class="activityfeed reset clearfix">*/?>

<h2 class="dark_text_2"><?= wfMsg("myhome-{$type}-feed") ?></h2>

<?php
	echo $defaultSwitch;
?>
<div id="myhome-<?= $type ?>-feed-content">
<?php
	echo $content;
?>
</div>
<?php
	if (!empty($showMore)) {
?>
	<div class="myhome-feed-more"><a id="myhome-<?= $type ?>-feed-more" onclick="MyHome.fetchMore(this)" rel="nofollow"><?= wfMsg('myhome-activity-more') ?></a></div>
<?php
	}
?>
<?/*</div>*/?>
