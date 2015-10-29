<li class="forum-reply">
	<img class="forum-user-avatar" src="<?= AvatarService::getAvatarUrl( $reply['userName'], 50 ) ?>">
	<div class="forum-user-name">
		<a href="<?= $reply['userUrl'] ?>"><?= $reply['displayName'] ?></a>
	</div>
	<div class="forum-message-body">
		<?= $reply['messageBody'] ?>
		<time class="forum-timestamp timeago" datetime="<?= $reply['timeStamp'] ?>"><?= $reply['timeStamp'] ?></time>
	</div>
</li>
