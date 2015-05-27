<?php if ( $showModule ): ?>
	<section class="module WikiaActivityModule ForumActivityModule">
		<h2><?= wfMessage( 'forum-related-module-heading' )->escaped(); ?></h2>
		<ul>
			<?php foreach($messages as $message): ?>
			<li>
				<?= AvatarService::renderAvatar($message['message']->getUser()->getName(), 20); ?>
				<em>
					<a href="<?= Sanitizer::encodeAttribute( $message['message']->getMessagePageUrl() ); ?>" title="<?= Sanitizer::encodeAttribute( $message['message']->getMetaTitle() ); ?>"><?= htmlspecialchars( $message['message']->getMetaTitle() ); ?></a>
				</em>
				<div class="edited-by">

					<?php $messageLast = empty($message['reply']) ? $message['message'] : $message['reply'];  ?>

					<?php $user = '<a href="' . Sanitizer::encodeAttribute( $messageLast->getUser()->getUserPage()->getFullUrl() ) . '">' . htmlspecialchars( $messageLast->getUser()->getName() ) . '</a>'; ?>
					<?php $time = '<span class="timeago abstimeago" title="' . $messageLast->getCreateTime() . '" alt="' . $messageLast->getCreateTime(TS_MW) . '">&nbsp;</span>' ?>
					<?= wfMessage( !empty($message['reply']) ? 'forum-activity-module-posted' : 'forum-activity-module-started' )->rawParams( $user, $time )->escaped(); ?>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</section>
<?php endif; ?>
