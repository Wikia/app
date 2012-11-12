<section id="RelatedForumDiscussion" class="RelatedForumDiscussion">
	<h2>
		<a class="button forum-new-post" href="<?= $newPostUrl ?>" title="<?= $newPostTooltip ?>"><?= $newPostButton ?></a>
		<?= $sectionHeading ?>
	</h2>
	<ul class="forum-discussions">
		<? foreach($messages as $message): ?>
			<li class="forum-thread">
				<img class="sprite talk" src="<?= $blankImgUrl ?>">
				<a href="<?= $message['threadUrl'] ?>">
					<h4>
						<?= $message['metaTitle'] ?>
					</h4>
				</a>
				<div class="forum-total-replies"><?= $message['totalReplies'] ?></div>
				<ul class="forum-replies">
					<? foreach($message['replies'] as $reply): ?>
						<li class="forum-reply">
							<img class="forum-user-avatar" src="<?= $reply['userAvatarUrl'] ?>">
							<div class="forum-user-name">
								<a href="<?= $reply['userUrl'] ?>"><?= $reply['userName'] ?></a>
							</div>
							<div class="forum-message-body">
								<?= $reply['messageBody'] ?>
								<span class="forum-timestamp">
									<?= $reply['timeStamp'] ?>
								</span>
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
</section>