<?php if( isset( $emptyMessage ) ) { ?>
	<h3 class="myhome-empty-message"><?php print $emptyMessage ?></h3>
<?php } else { ?>
	<ul class="activityfeed reset" id="<?php print $tagid ?>">
	<?php foreach($data as $row) { ?>
		<li class="activity-type-<?php print FeedRenderer::getIconType($row) ?> activity-ns-<?php print $row['ns'] ?>">
		<?php print FeedRenderer::getSprite( $row, $assets['blank'] )	?>
		<?php if( isset( $row['url'] ) ) { ?>
			<strong><a class="title" href="<?php print htmlspecialchars($row['url']) ?>"><?php print htmlspecialchars($row['title'])  ?></a></strong><br />
		<?php } else { ?>
			<span class="title"><?php print htmlspecialchars($row['title']) ?></span>
<?php } ?>
			<?php
				$timestamp = ActivityFeedRenderer::formatTimestamp( $row['timestamp'] );
				$timestamp = $timestamp ? ' • ' . $timestamp : '';
			?>
			<cite><?php print $timestamp; ?><?php print FeedRenderer::getActionLabel($row); ?><?php print FeedRenderer::getDiffLink($row); ?></cite>
			<table><?php print FeedRenderer::getDetails($row) ?></table>
			<?php
				global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt;
				if((!empty($wgEnableAchievementsInActivityFeed)) && (!empty($wgEnableAchievementsExt))){
					if(isset($row['Badge'])){
						$badge = unserialize($row['Badge']);
						$ownerBadge = array('badge' => $badge);
						AchBadge::renderForActivityFeed($ownerBadge, true);
					}
				}
			?>
		</li>
	<?php } // endforeach; ?>
	</ul>
<?php } // endif; ?>
