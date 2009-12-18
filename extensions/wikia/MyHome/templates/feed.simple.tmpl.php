<?php
	if (isset($emptyMessage)) {
?>
	<h3 class="myhome-empty-message shortlist"><?= $emptyMessage ?></h3>
<?php
	}
	else {
?>

	<ul class="activityfeed reset shortlist" id="<?= $tagid ?>">
<?php
		foreach($data as $row) {
?>
		<li class="activity-type-<?= FeedRenderer::getIconType($row) ?> activity-ns-<?= $row['ns'] ?>">
			<?php print FeedRenderer::getSprite( $row, $assets['blank'] ) ?>
<?php
			if (isset($row['url'])) {
?>
			<strong><a href="<?= htmlspecialchars($row['url']) ?>"><?= htmlspecialchars($row['title'])  ?></a></strong>
<?php
			}
			else {
?>
			<span class="title"><?= htmlspecialchars($row['title'])  ?></span>
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
