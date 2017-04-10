<section class="module activity-module ForumActivityModule" id="ForumActivityModule">
	<h2 class="activity-module-header"><?= wfMessage( 'forum-activity-module-heading' )->escaped() ?></h2>
	<ul class="activity-items">
		<?php foreach ( $posts as $value ): ?>
		<li class="activity-item">
			<a href="<?= $value['user']->getUserPage()->getFullUrl() ?>">
				<img class="wds-avatar" src="<?= AvatarService::getAvatarUrl( $value['user']->getName(), 30 ) ?>" />
			</a>

			<div class="activity-info">
				<div class="page-title">
					<a href="<?= $value['wall_message']->getMessagePageUrl( true ); ?>" title="<?= htmlspecialchars( $value['metatitle'] ); ?>"><?= htmlspecialchars( $value['metatitle'] ); ?></a>
				</div>

				<div class="edit-info">
					<a class="edit-info-user" href="<?= $value['user']->getUserPage()->getFullUrl() ?>">
						<?= User::isIP( $value['display_username'] ) ? wfMessage( 'oasis-anon-user' )->escaped() : htmlspecialchars( $value['display_username'] ) ?>
					</a>
					<span class="edit-info-time"> • <?= wfTimeFormatAgo( $value['event_iso'] ) ?></span>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</section>
