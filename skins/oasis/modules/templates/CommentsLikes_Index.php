<?php
	// render simple version for comments bubble (for blogs)
	if ($commentsBubble) {
?>
	<div class="commentslikes">
		<a href="<?= htmlspecialchars($commentsLink) ?>" data-id="comment" title="<?= htmlspecialchars($commentsTooltip) ?>"<?= $commentsAccesskey ?>><span class="commentsbubble"><?= $formattedComments ?></span></a>
	</div>
<?php
	}
	// show both comments and FB likes
	else if (isset($comments) || $showLike) {
?>
<ul class="commentslikes">
<?php
		if (isset($comments)) {
?>
	<li class="comments">
		<span class="commentsbubble"><?= $formattedComments ?></span>
		<a href="<?= htmlspecialchars($commentsLink) ?>" data-id="comment" title="<?= htmlspecialchars($commentsTooltip) ?>"<?= $commentsAccesskey ?>><?= wfMsgExt($commentsEnabled ? 'oasis-page-header-comments' : 'oasis-page-header-talk', array('parsemag'), $comments) ?></a>
	</li>
<?php
		}

		if ($showLike) {
?>
	<li class="likes">
		<fb:like layout="button_count" width="50" colorscheme="<?= $likeTheme ?>" ref="<?= $likeRef ?>" href="<?= htmlspecialchars($likeHref) ?>"></fb:like>
	</li>
<?php
		}
?>
</ul>
<?php
	}
?>
