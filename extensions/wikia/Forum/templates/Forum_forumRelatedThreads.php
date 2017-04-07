<?php if ( $showModule ) { ?>
	<section class="module activity-module ForumActivityModule" id="ForumRelatedThreadsModule">
		<h2 class="activity-module-header"><?= wfMessage( 'forum-related-module-heading' )->escaped() ?></h2>
		<ul class="activity-items">
			<?php foreach ( $messages as $message ) { ?>
			<li class="activity-item">
				<?php $messageLast = empty( $message['reply'] ) ? $message['message'] : $message['reply']; ?>

				<a href="<?= $messageLast->getUser()->getUserPage()->getFullUrl() ?>">
					<img class="wds-avatar" src="<?= AvatarService::getAvatarUrl( $messageLast->getUser()->getName(), 30 ) ?>" />
				</a>

				<div class="page-title">
					<a href="<?= Sanitizer::encodeAttribute( $message['message']->getMessagePageUrl() ); ?>" title="<?= Sanitizer::encodeAttribute( $message['message']->getMetaTitle() ); ?>">
						<?= htmlspecialchars( $message['message']->getMetaTitle() ); ?>
					</a>
				</div>
				<div class="edit-info">
					<a class="edit-info-user" href="<?= $messageLast->getUser()->getUserPage()->getFullUrl() ?>"><?= htmlspecialchars( $messageLast->getUser()->getName() ) ?></a>
					<span class="edit-info-time"> • <?= wfTimeFormatAgo( $messageLast->getCreateTime() ) ?></span>
				</div>
			</li>
			<?php } ?>
		</ul>
	</section>
<?php } ?>
