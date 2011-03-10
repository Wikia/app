		<?php if (!empty($forumHome)): ?>
		<span>
			<a href="/wiki/Forum:Index"><?php echo wfMsgHtml('comments-only-forum-home'); ?></a>
		</span>
		<?php endif; ?>

		<ul class="history">
			<li>
			<?php if (!empty($revisions['current']['avatarUrl'])): ?>
				<img src="<?= $revisions['current']['avatarUrl'] ?>" width="20" height="20" class="avatar">
			<?php endif; ?>
			<?php echo wfMsg('comments-only-page-header-created-by', "<time class='timeago' pubdate datetime='".$revisions['current']['timestamp']."'> </time>", $revisions['current']['link']); ?>
			</li>
		</ul>
