<ul class="forum-discussions">
	<? foreach($messages as $message): ?>
		<li class="forum-thread">
			<img class="sprite talk-two" src="<?= $wg->BlankImgUrl ?>">
			<h4>
				<a href="<?= $message['threadUrl'] ?>" class="forum-thread-title">
					<?= $message['metaTitle'] ?>
				</a>
			</h4>
			<? if($message['totalReplies'] > 0): ?>
				<div class="forum-total-replies"><?= wfMessage( 'forum-related-discussion-total-replies', $message['totalReplies'] + 1 )->escaped() ?></div>
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
