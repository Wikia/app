<?php
if( isset( $emptyMessage ) ) {
?>
	<h3 class="myhome-empty-message widgetfeed"><?php print $emptyMessage ?></h3>
<?php
} else {
?>
	<ul class="activityfeed widgetfeed" id="<?php print $tagid ?>-recently-edited">
<?php
	foreach( $data as $row) {
 		$title = str_replace('/', '/&#8203;', htmlspecialchars( $row['title'] ));
?>
		<li class="activity-type-<?php print FeedRenderer::getIconType( $row ) ?> activity-ns-<?php print $row['ns'] ?>">
			<?php print FeedRenderer::getSprite( $row, $assets['blank'] ) ?>
<?php
		if (isset($row['url'])) {
?>
			<strong><a href="<?php print htmlspecialchars( $row['url'] ) ?>"><?php print $title; ?></a></strong><br />
<?php
		} else {
?>
			<span class="title"><?php print $title; ?></span>
<?php
		}
?>
			<cite><span class="timeago" title="<?= wfTimestamp(TS_ISO_8601, $row['timestamp']) ?>"><?php print ActivityFeedRenderer::formatTimestamp( $row['timestamp'] ); ?></span> <?php print wfMsg( "myhome-feed-by", FeedRenderer::getUserPageLink( $row ) ) ?></cite>
		</li>
<?php
	}
?>
	</ul>
<?php
}
