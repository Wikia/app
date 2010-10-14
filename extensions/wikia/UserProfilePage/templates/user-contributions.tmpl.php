<?php
if (count($data)) {
?>
	<ul id="myhome-user-contributions" class="activityfeed reset">
<?php
	foreach($data as $row) {
?>
		<li class="activity-type-<?= UserContributionsRenderer::getIconType($row) ?>">
			<?php print FeedRenderer::getSprite( $row, $assets['blank'] ) ?>
			<a href="<?= htmlspecialchars($row['url']) ?>" class="title" rel="nofollow"><?= htmlspecialchars($row['title'])  ?></a>
			<cite><?= FeedRenderer::formatTimestamp($row['timestamp']); ?></cite>
			<?= FeedRenderer::getDiffLink($row) ?>

		</li>
<?php
	}
?>
	</ul>
<?php
} else {
	echo wfMsgExt( 'userprofilepage-contributions-empty', array('parse') );
}
