<?php //echo "<pre>" . print_r($comment, true). "</pre>"; ?>

<li id="comm-<?=$commentId?>" class="article-comments-li <?=$rowClass?>">
	<div class="comment-avatar">
		<a href="<?= htmlspecialchars(AvatarService::getUrl($comment['username'])) ?>">
			<?= AvatarService::renderAvatar($comment['username'], 50) ?>
		</a>
	</div>
	<blockquote>
		<div class="article-comm-text" id="comm-text-<?= $comment['articleId'] ?>">
		<?= $comment['text'] ?>
		</div>
		<details>
		<?= wfMsg('oasis-comments-added-by', $comment['timestamp'], $comment['sig']) ?>
		<?php if( !empty($comment['isStaff']) ) { print "<span class=\"stafflogo\"><img src=\"http://images.wikia.com/wikia/images/e/e9/WikiaStaff.png\" title=\"This user is a member of Wikia staff\" alt=\"@wikia\" /></span>\n"; } ?>
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
