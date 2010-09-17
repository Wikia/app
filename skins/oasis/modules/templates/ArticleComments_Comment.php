<?php //echo "<pre>" . print_r($comment, true). "</pre>"; ?>

<li id="comm-<?=$commentId?>" class="article-comments-li <?=$rowClass?>">
	<div class="comment-avatar">
		<?= AvatarService::renderAvatar($comment['author']->getName(), 50) ?>
	</div>
	<blockquote>
		<div class="article-comm-text" id="comm-text-<?= $comment['articleId'] ?>">
		<?= $comment['text'] ?>
		</div>
		<details>
		<?= wfMsg('oasis-comments-added-by', $comment['timestamp'], $comment['sig']) ?>

		<?php
		if (count($comment['buttons']) || $comment['replyButton']) {
						?>
						<div class="buttons">
							<?php echo $comment['replyButton']; ?>
							<span class="tools">
								<?= implode(' ', $comment['buttons']) ?>
							</span>
						</div>
			<?php
		}
			?>
		</details>
	</blockquote>
</li>