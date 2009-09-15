<?php
if (count($data)) {
?>
	<dl>
<?php
	foreach($data as $row) {
?>
		<dt class="myhome-feed-<?= UserContributionsRenderer::getIconType($row) ?>-icon reset">
			<img src="<?= $assets['blank'] ?>" class="sprite" />
			<a href="<?= htmlspecialchars($row['url']) ?>" class="title" rel="nofollow"><?= htmlspecialchars($row['title'])  ?></a>
			<cite><?= FeedRenderer::formatTimestamp($row['timestamp']); ?></cite>
			<?= FeedRenderer::getDiffLink($row) ?>

		</dt>
<?php
	}
?>
	</dl>
<?php
} else {
	echo wfMsgExt('myhome-user-contributions-empty', array('parse'));
}
