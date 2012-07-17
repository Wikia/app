<section class="module ForumActivityModule">
	<h1><?= wfMsg('forum-activity-module-heading') ?></h1>
	<ul>
		<?php foreach($posts as $value): ?>
		<li class="forum-activity">
			<?= AvatarService::renderAvatar($value['user']->getName(), 24); ?>
			<h2>
				<a href="<?= $value['wall_message']->getMessagePageUrl(); ?>"><?= $value['metatitle']; ?></a>
			</h2>
			<?php $user = '<a href="'.$value['user']->getUserPage()->getFullUrl().'">'.$value['display_username'].'</a>'; ?>
			<?php $time = '<span class="timeago abstimeago" title="'.$value['event_iso'].'" alt="'.$value['event_mw'].'">&nbsp;</span>' ?>
			<?= wfMsg( $value['is_reply'] ? 'forum-activity-module-posted':'forum-activity-module-started', array($user, $time )); ?>			
		</li>
		<?php endforeach; ?>
	</ul>
</section>