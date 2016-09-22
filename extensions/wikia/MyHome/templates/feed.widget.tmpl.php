<?php if ( isset( $emptyMessage ) ): ?>
	<h3 class="myhome-empty-message widgetfeed"><?= $emptyMessage ?></h3>
<?php else: ?>
	<ul class="activityfeed widgetfeed" id="<?= $tagid ?>-recently-edited">
	<?php foreach ( $data as $row ): ?>
		<?php $title = str_replace( '/', '/&#8203;', htmlspecialchars( $row['title'] ) );	?>
		<li class="activity-type-<?= FeedRenderer::getIconType( $row ); ?> activity-ns-<?= $row['ns'] ?>">
			<?= FeedRenderer::getSprite( $row, $assets['blank'] ); ?>
		<?php if ( isset( $row['url'] ) ): ?>
			<strong><a href="<?= Sanitizer::encodeAttribute( $row['url'] ); ?>"><?= $title; ?></a></strong><br />
		<?php else: ?>
			<span class="title"><?= $title; ?></span>
		<?php endif; ?>
			<cite>
				<span class="timeago" title="<?= wfTimestamp(TS_ISO_8601, $row['timestamp']) ?>">
					<?= ActivityFeedRenderer::formatTimestamp( $row['timestamp'] ); ?>
				</span>
				<?= wfMessage( 'myhome-feed-by' )->rawParams( FeedRenderer::getUserPageLink( $row ) )->escaped(); ?>
			</cite>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
