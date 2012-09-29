<?php
	// render simple version for comments bubble (for blogs)
	if ($commentsBubble) {
?>
	<div class="commentslikes">
		<a href="<?= htmlspecialchars($commentsLink) ?>" data-id="comment" class="<?= empty($isArticleComments) ? 'talk' : '' ?>" title="<?= htmlspecialchars($commentsTooltip) ?>"<?= $commentsAccesskey ?>><span class="commentsbubble"><?= $formattedComments ?></span></a>
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
		<a href="<?= htmlspecialchars($commentsLink) ?>" rel="nofollow" data-id="comment" class="<?= empty($isArticleComments) ? 'talk' : '' ?>" title="<?= htmlspecialchars($commentsTooltip) ?>"<?= $commentsAccesskey ?>><?= wfMsgExt($commentsEnabled ? 'oasis-page-header-comments' : 'oasis-page-header-talk', array('parsemag'), $comments) ?></a>
	</li>
<?php
		}

		if ($showLike) {
?>
	<li class="likes">
		<div class="fb-like" data-href="<?= htmlspecialchars($likeHref) ?>" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false" data-colorscheme="<?= $likeTheme ?>"></div>
	</li>
<?php
		}
?>
</ul>
<?php
	}
?>
