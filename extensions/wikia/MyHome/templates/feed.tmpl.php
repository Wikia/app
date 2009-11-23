<?php
	if (isset($emptyMessage)) {
?>
	<h3 class="myhome-empty-message"><?= $emptyMessage ?></h3>
<?php
	}
	else {
?>

	<ul class="activityfeed reset" id="<?= $tagid ?>">
<?php
		foreach($data as $row) {
?>
		<li class="activity-type-<?= FeedRenderer::getIconType($row) ?>">
<?php
			if (isset($row['url'])) {
?>
			<img src="<?= $assets['blank'] ?>" class="sprite"<?= FeedRenderer::getIconAltText($row) ?>/>
			<strong><a class="title" href="<?= htmlspecialchars($row['url']) ?>"><?= htmlspecialchars($row['title'])  ?></a></strong>
<?php
			}
			else {
?>
			<img src="<?= $assets['blank'] ?>" class="sprite"<?= FeedRenderer::getIconAltText($row) ?>/><span class="title"><?= htmlspecialchars($row['title'])  ?></span>
<?php
			}
?>
			<cite><?= FeedRenderer::getActionLabel($row); ?><?= ActivityFeedRenderer::formatTimestamp($row['timestamp']); ?><?= FeedRenderer::getDiffLink($row); ?></cite>
		<table><?= FeedRenderer::getDetails($row) ?></table>

		</li>
<?php
		}
?>
	</ul>
<?php
	}
?>
