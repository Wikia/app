<?php if ( count( $data ) ): ?>
	<ul id="myhome-user-contributions" class="activityfeed reset">
	<?php foreach ( $data as $row ): ?>
		<li class="activity-type-<?= UserContributionsRenderer::getIconType( $row ); ?>">
			<?= FeedRenderer::getSprite( $row, $assets['blank'] ); ?>
			<a href="<?= Sanitizer::encodeAttribute( $row['url'] ); ?>" class="title" rel="nofollow"><?= htmlspecialchars( $row['title'] );  ?></a>
			<cite><?= FeedRenderer::formatTimestamp( $row['timestamp'] ); ?></cite>
			<?= FeedRenderer::getDiffLink( $row ); ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php else: ?>
	<?= wfMessage( 'myhome-user-contributions-empty' )->parse(); ?>
<?php endif; ?>
