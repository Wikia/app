<ul class="forum-discussions">
	<? foreach($messages as $message): ?>
		<li class="forum-thread">
			<img class="sprite talk-two" src="<?= $wg->BlankImgUrl ?>">
			<a href="<?= $message['threadUrl'] ?>">
				<h4>
					<?= $message['metaTitle'] ?>
				</h4>
			</a>
			<div class="forum-total-replies"><?= wfMsg('forum-related-discussion-total-replies', $message['totalReplies']) ?></div>
			<ul class="forum-replies">
				<? foreach($message['replies'] as $reply): ?>
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
				<? endforeach; ?>
			</ul>
		</li>
	<? endforeach; ?>
</ul>
<div class="forum-see-more">
	<a href="<?= $seeMoreUrl ?>"><?= $seeMoreText ?> &gt;</a>
</div>
