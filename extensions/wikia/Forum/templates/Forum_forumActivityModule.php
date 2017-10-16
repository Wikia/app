<section class="rail-module activity-module forum-activity-module" id="ForumActivityModule">
	<h2><?= wfMessage( 'forum-activity-module-heading' )->escaped() ?></h2>
	<ul class="activity-items">
		<?php foreach ( $posts as $value ): ?>
		<li class="activity-item">
			<?php $username = User::isIP( $value['display_username'] ) ? wfMessage( 'oasis-anon-user' )->escaped() : htmlspecialchars( $value['display_username'] ); ?>

			<a class="activity-avatar" href="<?= $value['user']->getUserPage()->getFullUrl() ?>">
				<img class="wds-avatar" src="<?= AvatarService::getAvatarUrl( $value['user']->getName(), 30 ) ?>" data-tracking="activity-avatar" title="<?= $username ?>" />
			</a>

			<div class="activity-info">
				<div class="page-title">
					<a href="<?= $value['wall_message']->getMessagePageUrl( true ); ?>" title="<?= Sanitizer::encodeAttribute( $value['metatitle'] ); ?>" data-tracking="activity-title"><?= htmlspecialchars( $value['metatitle'] ); ?></a>
				</div>

				<div class="edit-info">
					<a class="edit-info-user" href="<?= $value['user']->getUserPage()->getFullUrl() ?>" data-tracking="activity-username">
						<?= $username ?>
					</a><span class="edit-info-time"> • <?= wfTimeFormatAgo( $value['event_iso'] ) ?></span>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</section>
