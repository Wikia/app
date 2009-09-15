<?php
	if (isset($emptyMessage)) {
?>
	<h3 class="myhome-empty-message"><?= htmlspecialchars($emptyMessage) ?></h3>
<?php
	}
	else {
?>

	<dl>
<?php
		foreach($data as $row) {
		//var_dump($row);
?>
		<dt class="myhome-feed-<?= FeedRenderer::getIconType($row) ?>-icon reset">
<?php
			if (isset($row['url'])) {
?>
			<img src="<?= $assets['blank'] ?>" class="sprite" />
			<a href="<?= htmlspecialchars($row['url']) ?>" class="title" rel="nofollow"><?= htmlspecialchars($row['title'])  ?></a>
<?php
			}
			else {
?>
			<img src="<?= $assets['blank'] ?>" class="sprite" /><span class="title"><?= htmlspecialchars($row['title'])  ?></span>
<?php
			}
?>
			<cite><?= FeedRenderer::getActionLabel($row); ?><?= ActivityFeedRenderer::formatTimestamp($row['timestamp']); ?><?= FeedRenderer::getDiffLink($row); ?></cite>
		</dt>
		<dd><table><?= FeedRenderer::getDetails($row) ?></table>

		</dd>
<?php
		}
?>
	</dl>
<?php
	}
?>
