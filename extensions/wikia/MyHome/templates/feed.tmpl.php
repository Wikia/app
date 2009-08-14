<?php
	foreach($data as $row) {

		// fix for old entries in recentchanges table
		if (!isset($row['type'])) {
			continue;
		}

		echo '<!-- ' . print_r($row, true) . '-->';
?>
	<dl class="myhome-feed-<?= FeedRenderer::getIconType($row['type']) ?>-icon reset">
		<dt>
			<a href="<?= htmlspecialchars($row['url']) ?>" class="sprite">
				<img src="<?= $assets['blank'] ?>" class="sprite" />
			</a>
			<a href="<?= htmlspecialchars($row['url']) ?>" class="title"><?= htmlspecialchars($row['title'])  ?></a>
			<cite><?= FeedRenderer::getActionLabel($row); ?><?= FeedRenderer::formatTimestamp($row['timestamp']); ?></cite>
		</dt>
		<dd>
			<?= FeedRenderer::getDetailsRow($row) ?>

		</dd>
	</dl>
<?php
	}
?>
