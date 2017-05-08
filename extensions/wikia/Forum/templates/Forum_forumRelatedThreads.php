<?php if ( $showModule ) { ?>
	<section class="rail-module activity-module forum-activity-module" id="ForumRelatedThreadsModule">
		<h2><?= wfMessage( 'forum-related-module-heading' )->escaped() ?></h2>
		<ul class="activity-items">
			<?php foreach ( $messages as $message ) { ?>
			<li class="activity-item">
				<?php
					$messageLast = empty( $message['reply'] ) ? $message['message'] : $message['reply'];
					$username = User::isIp( $messageLast->getUser()->getName() ) ? wfMessage( 'oasis-anon-user' )->escaped() : htmlspecialchars( $messageLast->getUser()->getName() );
				?>

				<a class="activity-avatar" href="<?= $messageLast->getUser()->getUserPage()->getFullUrl() ?>">
					<img class="wds-avatar" src="<?= AvatarService::getAvatarUrl( $messageLast->getUser()->getName(), 30 ) ?>" data-tracking="activity-avatar" title="<?= $username ?>" />
				</a>

				<div class="activity-info">
					<div class="page-title">
						<a href="<?= Sanitizer::encodeAttribute( $message['message']->getMessagePageUrl() ); ?>" title="<?= Sanitizer::encodeAttribute( $message['message']->getMetaTitle() ); ?>" data-tracking="activity-title">
							<?= htmlspecialchars( $message['message']->getMetaTitle() ); ?>
						</a>
					</div>
					<div class="edit-info">
						<a class="edit-info-user" href="<?= $messageLast->getUser()->getUserPage()->getFullUrl() ?>" data-tracking="activity-username">
							<?= $username ?>
						</a>
						<span class="edit-info-time"> • <?= wfTimeFormatAgo( $messageLast->getCreateTime() ) ?></span>
					</div>
				</div>
			</li>
			<?php } ?>
		</ul>
	</section>
<?php } ?>
