<section class="module activity-module ForumActivityModule" id="ForumActivityModule">
	<h2 class="activity-module-header"><?= wfMessage( 'forum-activity-module-heading' )->escaped() ?></h2>
	<ul class="activity-items">
		<?php foreach ( $posts as $value ): ?>
		<li class="activity-item">
			<?= AvatarService::renderAvatar( $value['user']->getName(), 20 ); ?>
			<div class="page-title">
				<a href="<?= $value['wall_message']->getMessagePageUrl( true ); ?>" title="<?= htmlspecialchars( $value['metatitle'] ); ?>"><?= htmlspecialchars( $value['metatitle'] ); ?></a>
			</div>
			<div class="edit-info">
				<a class="edit-info-user" href="<?= $value['user']->getUserPage()->getFullUrl() ?>"><?= htmlspecialchars( $value['display_username'] ) ?></a>
				<span class="edit-info-time"> • <?= wfTimeFormatAgo( $value['event_iso'] ) ?></span>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</section>
