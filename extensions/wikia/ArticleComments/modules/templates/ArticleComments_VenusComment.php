<? if ( is_array( $comment ) ) :?>
<li id="comm-<?=$commentId?>" class="comment" data-user="<?=$comment['username']?>">
	<div class="speech-bubble-avatar">
		<a href="<?= $comment['userurl'] ?>">
			<?= $comment['avatar'] ?><?= $comment['username'] ?>
		</a>
	</div>
	<blockquote class="speech-bubble-message">
		<div class="WikiaArticle article-comm-text" id="comm-text-<?= $comment['id'] ?>">
		<?= $comment['text'] ?>
		</div>

		<div class="edited-by">
		<?= $comment['timestamp'] ?>
		<?php if (count($comment['buttons']) || $comment['replyButton']) { ?>
			<ul class="tools">
				<? if (isset($comment['links']['delete'])) :?>
					<li><a href="<?= htmlspecialchars($comment['links']['delete']) ?>" class="article-comm-delete" title="<?= wfMessage('article-comments-delete')->plain() ?>"></a></li>
				<? endif; ?>
				<? if (isset($comment['links']['edit'])) :?>
					<li><a href="<?= htmlspecialchars($comment['links']['edit']) ?>" class="article-comm-edit" id="comment<?= $comment['id'] ?>" title="<?= wfMessage('article-comments-edit')->plain() ?>"></a></li>
				<? endif; ?>
				<? if ($comment['replyButton'] !== ''):?>
					<li><a class="article-comm-reply" href="#"> <?= wfMessage('article-comments-reply')->plain() ?></a></li>
				<? endif; ?>
			</ul>
		<?php } ?>
		</div>
	</blockquote>
</li>
<? endif; ?>
