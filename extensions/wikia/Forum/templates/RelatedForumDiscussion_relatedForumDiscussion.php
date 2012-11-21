<ul class="forum-discussions">
	<? foreach($messages as $message): ?>
		<li class="forum-thread">
			<img class="sprite talk-two" src="<?= $wg->BlankImgUrl ?>">
			<a href="<?= $message['threadUrl'] ?>">
				<h4>
					<?= $message['metaTitle'] ?>
				</h4>
			</a>
			<? if($message['totalReplies'] > 0): ?>
				<div class="forum-total-replies"><?= wfMsg('forum-related-discussion-total-replies', $message['totalReplies'] + 1) ?></div>
			<? endif; ?>
			<ul class="forum-replies">
				<? if($message['totalReplies'] < 2): ?>
					<?= $app->renderPartial('RelatedForumDiscussion', 'message', array('reply' => $message)); ?>
				<? endif; ?>
			
				<? foreach($message['replies'] as $reply): ?>
					<?= $app->renderPartial('RelatedForumDiscussion', 'message', array('reply' => $reply)); ?>
				<? endforeach; ?>
			</ul>
		</li>
	<? endforeach; ?>
</ul>
<div class="forum-see-more">
	<a href="<?= $seeMoreUrl ?>"><?= $seeMoreText ?> &gt;</a>
</div>