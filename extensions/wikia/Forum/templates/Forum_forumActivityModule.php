<section class="rail-module activity-module forum-activity-module" id="ForumActivityModule">
	<h2><?= wfMessage( 'forum-activity-module-heading' )->escaped() ?></h2>
	<ul class="activity-items">
		<?php foreach ( $posts as $value ): ?>
		<li class="activity-item">
			<?php $displayName = $value['authorId'] ? htmlspecialchars( $value['authorName'], ENT_QUOTES ) : wfMessage( 'oasis-anon-user' )->escaped(); ?>

			<a class="activity-avatar" href="<?= Sanitizer::encodeAttribute( $value['authorUrl'] ); ?>">
				<img class="wds-avatar" src="<?= AvatarService::getAvatarUrl( $value['authorName'], 30 ) ?>" data-tracking="activity-avatar" title="<?= $displayName ?>" />
			</a>

			<div class="activity-info">
				<div class="page-title">
					<a href="<?= Sanitizer::encodeAttribute( $value['threadUrl'] ); ?>" title="<?= Sanitizer::encodeAttribute( $value['threadTitle'] ); ?>" data-tracking="activity-title"><?= htmlspecialchars( $value['threadTitle'] ); ?></a>
				</div>

				<div class="edit-info">
					<a class="edit-info-user" href="<?= Sanitizer::encodeAttribute( $value['authorUrl'] ); ?>" data-tracking="activity-username">
						<?= $displayName ?>
					</a><span class="edit-info-time"> • <?= wfTimeFormatAgo( $value['timestamp'] ); ?></span>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</section>
