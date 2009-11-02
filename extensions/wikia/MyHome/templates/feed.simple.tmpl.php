<?php
	if (isset($emptyMessage)) {
?>
	<h3 class="myhome-empty-message shortlist"><?= htmlspecialchars($emptyMessage) ?></h3>
<?php
	}
	else {
?>

	<ul class="activityfeed reset shortlist" id="<?= $tagid ?>">
<?php
		foreach($data as $row) {
?>
		<li class="activity-type-<?= FeedRenderer::getIconType($row) ?>">
<?php
			if (isset($row['url'])) {
?>
			<img src="<?= $assets['blank'] ?>" class="sprite"<?= FeedRenderer::getIconAltText($row) ?>/>
			<strong><a href="<?= htmlspecialchars($row['url']) ?>" rel="nofollow"><?= htmlspecialchars($row['title'])  ?></a></strong>
<?php
			}
			else {
?>
			<img src="<?= $assets['blank'] ?>" class="sprite"<?= FeedRenderer::getIconAltText($row) ?>/><span class="title"><?= htmlspecialchars($row['title'])  ?></span>
<?php
			}
?>
			<cite><?= ActivityFeedRenderer::formatTimestamp($row['timestamp']); ?><?= FeedRenderer::getDiffLink($row); ?></cite>
		</li>
<?php
		}
?>
	</ul>
<?php
	}
?>
