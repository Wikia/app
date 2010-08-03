<!-- s:<?= __FILE__ ?> -->
<div class="article-comments">
	<div class="comment-avatar">
		<?= $comment['avatar'] ?>
	</div>

	<div class="details">
		<strong><?= $comment['sig'] ?></strong><br/>
		<span class="timestamp"><?= $comment['timestamp'] ?></span>
	</div>

	<div class="comment">
		<div class="article-comm-text" id="comm-text-<?= $comment['articleId'] ?>">
		<?= $comment['text'] ?>
		</div>
		<?php
		if (count($comment['buttons']) || $comment['replyButton']) {
		?>
		<div class="buttons">
			<?= $comment['replyButton'] ?>
			<span class="tools">
				<?= implode(' ', $comment['buttons']) ?>
			</span>
		</div>
		<?php
		}
		?>
	</div>
</div>
<!-- e:<?= __FILE__ ?> -->
