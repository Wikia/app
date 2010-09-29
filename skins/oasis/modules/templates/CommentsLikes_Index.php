<?php
	if (is_numeric($comments) || $showLike) {
?>
<ul class="commentslikes">
<?php
		// render comments button
		if (is_numeric($comments)) {
?>
	<li>
		<span class="commentsbubble"><?= $formattedComments ?></span>
		<a href="<?= htmlspecialchars($commentsLink) ?>"data-id="comment" title="<?= htmlspecialchars($commentsTooltip) ?>"<?= $commentsAccesskey ?>><?= wfMsgExt('oasis-page-header-comments', array('parsemag'), $comments) ?></a>
	</li>
<?php
		}

		// render FB likes button
		if ($showLike) {
?>
	<li>
		<fb:like layout="button_count" width="50" show_faces="false" ref="<?= $likeRef ?>" href="<?= htmlspecialchars($likeHref) ?>"></fb:like>
	</li>
<?php
		}
?>
</ul>
<?php
	}
?>
