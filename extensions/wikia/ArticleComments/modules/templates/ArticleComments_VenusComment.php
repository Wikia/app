<? if ( is_array( $comment ) ) :?>
<li id="comm-<?=$commentId?>" class="SpeechBubble <?=$rowClass?>" data-user="<?=$comment['username']?>">
	<div class="speech-bubble-avatar">
		<a href="<?= $comment['userurl'] ?>">
			<?= $comment['avatar'] ?>
			<?= $comment['username'] ?>
		</a>
	</div>
	<blockquote class="speech-bubble-message">
		<div class="WikiaArticle article-comm-text" id="comm-text-<?= $comment['id'] ?>">
		<?= $comment['text'] ?>
		</div>

		<div class="edited-by">
		<?= $comment['timestamp'] ?>
		<?php if (count($comment['buttons']) || $comment['replyButton']) { ?>
			<div class="buttons">
				<?php echo $comment['replyButton']; ?>
				<span class="tools">
					<?= implode(' ', $comment['buttons']) ?>
				</span>
			</div>
		<?php } ?>
		</div>
	</blockquote>
</li>
<? endif; ?>