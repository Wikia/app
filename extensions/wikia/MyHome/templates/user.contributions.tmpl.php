<?php
	foreach($data as $row) {

		// fix for old entries in recentchanges table
		if (!isset($row['type'])) {
			continue;
		}

		echo '<!-- ' . print_r($row, true) . '-->';
?>
	<dl class="myhome-feed-<?= UserContributionsRenderer::getIconType($row) ?>-icon reset">
		<dt>
			<a href="<?= htmlspecialchars($row['url']) ?>" class="sprite">
				<img src="<?= $assets['blank'] ?>" class="sprite" />
			</a>
			<a href="<?= htmlspecialchars($row['url']) ?>" class="title"><?= htmlspecialchars($row['title'])  ?></a>
			<cite><?= FeedRenderer::formatTimestamp($row['timestamp']); ?></cite>
			<?= $row['diff'] != '' ? FeedRenderer::getDiffPageLink($row['diff']) : '' ?>
		</dt>
	</dl>
<?php
	}
?>
