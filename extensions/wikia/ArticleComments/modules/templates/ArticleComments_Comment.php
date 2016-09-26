<? if ( is_array( $comment ) ) :?>
<li id="comm-<?=$commentId?>" class="comment SpeechBubble <?=$rowClass?>" data-user="<?=$comment['username']?>">
	<div class="speech-bubble-avatar">
		<a href="<?= $comment['userurl'] ?>">
			<?= $comment['avatar'] ?>
		</a>
	</div>
	<blockquote class="speech-bubble-message">
		<div class="WikiaArticle article-comm-text" id="comm-text-<?= $comment['id'] ?>">
		<?= $comment['text'] ?>
		</div>

		<div class="edited-by">
		<?= wfMessage( 'oasis-comments-added-by' )->rawParams( $comment['timestamp'], $comment['sig'] )->escaped() ?>
		<?php if (!empty($comment['isStaff'])) { print "<span class=\"stafflogo\"><img src=\"".wfReplaceImageServer( '/extensions/wikia/StaffSig/images/WikiaStaff.png' ) . "\" title=\"This user is a member of Wikia staff\" alt=\"@wikia\" /></span>\n"; } ?>
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