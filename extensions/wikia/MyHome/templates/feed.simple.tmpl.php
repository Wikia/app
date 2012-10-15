<?php
if ( isset( $emptyMessage ) ) {
?>
	<h3 class="myhome-empty-message shortlist"><?php print $emptyMessage ?></h3>
<?php
} else {
?>
	<ul class="activityfeed reset shortlist" id="<?php print $tagid ?>">
<?php
	foreach( $data as $row ) {
?>
		<li class="activity-type-<?php print FeedRenderer::getIconType($row) ?> activity-ns-<?php print $row['ns'] ?>">
			<?php print FeedRenderer::getSprite( $row, $assets['blank'] ) ?>
<?php
			if( isset( $row['url'] ) ) {
?>
			<strong><a href="<?php print htmlspecialchars($row['url']) ?>"><?php print htmlspecialchars($row['title'])  ?></a></strong>
<?php
			} else {
?>
			<span class="title"><?php print htmlspecialchars($row['title']) ?></span>
<?php
			}
?>
			<cite><?php print ActivityFeedRenderer::formatTimestamp($row['timestamp']); ?><?php print FeedRenderer::getDiffLink($row); ?></cite>
		</li>
<?php
	}
?>
	</ul>
<?php
}
