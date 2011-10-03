<li id="comm-<?=$commentId?>" class="SpeechBubble <?php if (!empty($comment['isStaff'])) echo 'article-comment-staff '; ?><?=$rowClass?>" data-user="<?=$comment['username']?>">
	<div class="speech-bubble-avatar">
		<a href="<?= htmlspecialchars(AvatarService::getUrl($comment['username'])) ?>">
			<?= AvatarService::renderAvatar($comment['username'], 50) ?>
		</a>
	</div>
	<blockquote  class="speech-bubble-message">
		<?php if( isset( $comment['votes'] ) && $level == 1 ): ?>
		<div class="withVoting">
		<div class="article-comm-voteup-btn<?php if($page==1 && $id==1) echo " No1"; ?>">
		<?php if( $page == 1 && $id <= 3 ): ?>
		<span>#<?= $id ?></span>
		<?php endif; ?>
		<button class="article-comm-vote"><img src="<?= $GLOBALS['wgBlankImgUrl'] ?>" class="chevron"><?= wfMsg('article-comments-vote') ?></button>
		</div>
		<?php endif; ?>
		<div class="article-comm-text" id="comm-text-<?= $comment['articleId'] ?>">
		<?= $comment['text'] ?>
		<div class="edited-by">
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
		</div>
		</div>
		<?php if( isset( $comment['votes'] ) && $level == 1 ): ?>
		<div class="article-comm-votes"><?= $comment['votes'] ?> votes</div>
		</div>
		<?php endif; ?>
	</blockquote>
</li>
