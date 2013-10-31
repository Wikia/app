<?php if($showModule): ?>
	<section class="module WikiaActivityModule ForumActivityModule">
		<h1><?= wfMessage( 'forum-related-module-heading' )->escaped(); ?></h1>
		<ul>
			<?php foreach($messages as $message): ?>
			<li>
				<?= AvatarService::renderAvatar($message['message']->getUser()->getName(), 20); ?>
				<em>
					<a href="<?= $message['message']->getMessagePageUrl(); ?>"><?= $message['message']->getMetaTitle(); ?></a>
				</em>
				<div class="edited-by">

					<?php $messageLast = empty($message['reply']) ? $message['message']:$message['reply'];  ?>

					<?php $user = '<a href="'.$messageLast->getUser()->getUserPage()->getFullUrl().'">'.$messageLast->getUser()->getName().'</a>'; ?>
					<?php $time = '<span class="timeago abstimeago" title="'.$messageLast->getCreateTime().'" alt="'.$messageLast->getCreateTime(TS_MW).'">&nbsp;</span>' ?>
					<?= wfMessage( !empty($message['reply']) ? 'forum-activity-module-posted' : 'forum-activity-module-started' )->rawParams( $user, $time )->escaped(); ?>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</section>
<?php endif; ?>
