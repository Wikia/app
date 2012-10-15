<section class="module WikiaActivityModule ForumParticipationModule">
	<h1><?= wfMsg('forum-participation-module-heading') ?></h1>
	<ul>
		<?php foreach($participants as $value): ?>
			<li>
				<?= AvatarService::renderAvatar($value['user']->getName(), 20); ?>
				<em>
					<a href="<?php echo $value['user']->getUserPage()->getFullUrl(); ?>"><?php echo $value['display_username'] ?></a>
					<?php if($value['user']->getId() == 0): ?>
						<a href="<?php echo $value['user']->getUserPage()->getFullUrl(); ?>" class="subtle"><?php echo $value['user']->getName();?></a>
					<?php endif; ?>
				</em>
				<div class="edited-by">
					<?php $time = '<span class="timeago abstimeago" title="'.$value['event_iso'].'" alt="'.$value['event_mw'].'">&nbsp;</span>' ?>
					<?= wfMsg($value['is_reply'] ? 'forum-participation-module-posted':'forum-participation-module-started', array($value['wall_message']->getMessagePageUrl(), $time) ); ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</section>