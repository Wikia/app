<? if ( is_array( $comment ) ) :?>
<li id="comm-<?=$commentId?>" class="comment SpeechBubble <?=$rowClass?><?= $comment['isStaff'] ? ' staff' : '' ?>" data-user="<?= Sanitizer::encodeAttribute( $comment['username'] ); ?>">
	<div class="speech-bubble-avatar">
		<a href="<?= $comment['userurl'] ?>">
			<?= $comment['avatar'] ?>
		</a>
	</div>
	<blockquote class="speech-bubble-message">
		<div class="WikiaArticle article-comm-text" id="comm-text-<?= $comment['id'] ?>">
		<?= $commentContent ?>
		</div>

		<div class="edited-by">
		<?= wfMessage( 'oasis-comments-added-by' )->rawParams( $comment['timestamp'], $comment['sig'] )->escaped() ?>
		<?php if (!empty($comment['isStaff'])) { print "<span class=\"stafflogo\"><img src=\"".wfReplaceImageServer( wfGetSignatureUrl() ) . "\" title=\"This user is a member of Fandom staff\" alt=\"@fandom\" /></span>\n"; } ?>
		<?php global $wgArticleCommentsReadOnlyMode;
		if (!$wgArticleCommentsReadOnlyMode && (count($comment['buttons']) || $comment['replyButton'])) { ?>
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
