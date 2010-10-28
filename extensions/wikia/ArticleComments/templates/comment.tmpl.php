<!-- s:<?= __FILE__ ?> -->
<div class="article-comments">
	<a name="comment-<?= $comment['id'] ?>" />
	<div class="comment-avatar">
		<?= $comment['avatar'] ?>
	</div>

	<div class="details">
		<strong><?= $comment['sig'] ?></strong><br/>
		<span class="timestamp"><?= $comment['timestamp'] ?></span>
		<?php if( !empty($comment['isStaff']) ) { print "<br/><span class=\"stafflogo\"><img src=\"http://images.wikia.com/wikia/images/e/e9/WikiaStaff.png\" title=\"This user is a member of Wikia staff\" alt=\"@wikia\" /></span>\n"; } ?>
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
