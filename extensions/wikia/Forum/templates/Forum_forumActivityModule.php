<section class="module WikiaActivityModule ForumActivityModule">
	<h1><?= wfMessage( 'forum-activity-module-heading' )->escaped() ?></h1>
	<ul>
		<?php foreach($posts as $value): ?>
		<li>
			<?= AvatarService::renderAvatar($value['user']->getName(), 20); ?>
			<em>
				<a href="<?= $value['wall_message']->getMessagePageUrl(true); ?>"><?= $value['metatitle']; ?></a>
			</em>
			<div class="edited-by">
				<?php $user = '<a href="'.$value['user']->getUserPage()->getFullUrl().'">'.$value['display_username'].'</a>'; ?>
				<?php $time = '<span class="timeago abstimeago" title="'.$value['event_iso'].'" alt="'.$value['event_mw'].'">&nbsp;</span>' ?>
				<?= wfMessage( $value['is_reply'] ? 'forum-activity-module-posted' : 'forum-activity-module-started' )->rawParams( $user, $time )->escaped(); ?>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</section>
