<section class="module WikiaActivityModule ForumActivityModule">
	<h2><?= wfMessage( 'forum-activity-module-heading' )->escaped() ?></h2>
	<ul>
		<?php foreach( $posts as $value ): ?>
		<li>
			<?= AvatarService::renderAvatar( $value['user']->getName(), 20 ); ?>
			<em>
				<a href="<?= $value['wall_message']->getMessagePageUrl( true ); ?>" title="<?= htmlspecialchars( $value['metatitle'] ); ?>"><?= htmlspecialchars( $value['metatitle'] ); ?></a>
			</em>
			<div class="edited-by">
				<?php $user = '<a href="' . $value['user']->getUserPage()->getFullUrl() . '">' . htmlspecialchars( $value['display_username'] ) . '</a>'; ?>
				<?php $time = '<span class="timeago abstimeago" title="' . $value['event_iso'].'" alt="' . $value['event_mw'] . '">&nbsp;</span>' ?>
				<?= wfMessage( $value['is_reply'] ? 'forum-activity-module-posted' : 'forum-activity-module-started' )->rawParams( $user, $time )->escaped(); ?>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</section>
