



<div id="myhome-main">
	<nav class="activity-nav">
		<?= View::specialPageLink('WikiActivity', 'oasis-button-wiki-activity', array('class' => 'wikia-button secondary', 'data-id' => 'wikiactivity'), 'blank.gif', null, 'sprite activity') ?>
		<?= View::specialPageLink('WikiActivity/watchlist', 'oasis-button-wiki-activity-watchlist', array('class' => 'wikia-button secondary', 'data-id' => 'wikiactivity-watchlist'), 'blank.gif', null) ?>
	</nav>
	
<?php  if( isset( $emptyMessage ) ) { ?>
	<h3 class="myhome-empty-message"><?php print $emptyMessage ?></h3>
<?php	} else { ?>
	<ul class="activityfeed reset" id="<?php print $tagid ?>">
	<?php foreach($data as $row) { ?>
		<li class="activity-type-<?php print FeedRenderer::getIconType($row) ?> activity-ns-<?php print $row['ns'] ?>">
		<?php print FeedRenderer::getSprite( $row, $assets['blank'] )	?>
		<?php if( isset( $row['url'] ) ) { ?>
			<strong><a class="title" href="<?php print htmlspecialchars($row['url']) ?>"><?php print htmlspecialchars($row['title'])  ?></a></strong><br />
		<?php } else { ?>
			<span class="title"><?php print htmlspecialchars($row['title']) ?></span>
<?php		  } ?>
			<cite><?php print FeedRenderer::getActionLabel($row); ?><?php print ActivityFeedRenderer::formatTimestamp($row['timestamp']); ?><?php print FeedRenderer::getDiffLink($row); ?></cite>
			<table><?php print FeedRenderer::getDetails($row) ?></table>
		</li>
	<?php } // endforeach; ?>
	</ul>
<?php
	  if ($showMore) {
		?>
		<div class="activity-feed-more"><a href="#" data-since="<?= $query_continue ?>"><?= wfMsg('myhome-activity-more') ?></a></div>
		<?
	  }
	} // endif; ?>
</div>
<?php

?>