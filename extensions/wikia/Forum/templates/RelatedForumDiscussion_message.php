<li class="forum-reply">
	<img class="forum-user-avatar" src="<?= AvatarService::getAvatarUrl($reply['userName'], 50) ?>">
	<div class="forum-user-name">
		<a href="<?= $reply['userUrl'] ?>"><?= $reply['userName'] ?></a>
	</div>
	<div class="forum-message-body">
		<?= $reply['messageBody'] ?>
		<time class="forum-timestamp" datetime="<?= $reply['timeStamp'] ?>"><?= $reply['timeStamp'] ?></time>
	</div>
</li>