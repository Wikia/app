<?php
	// show both comments and FB likes (new design)
	if (is_numeric($comments) && $showLike) {
?>
<ul class="commentslikes">
	<li class="comments">
		<span class="commentsbubble"><?= $formattedComments ?></span>
		<a href="<?= htmlspecialchars($commentsLink) ?>"data-id="comment" title="<?= htmlspecialchars($commentsTooltip) ?>"<?= $commentsAccesskey ?>><?= wfMsgExt($commentsEnabled ? 'oasis-page-header-comments' : 'oasis-page-header-talk', array('parsemag'), $comments) ?></a>
	</li>
	<li class="likes">
		<fb:like layout="button_count" width="50" show_faces="false" colorscheme="<?= $likeTheme ?>" ref="<?= $likeRef ?>" href="<?= htmlspecialchars($likeHref) ?>"></fb:like>
	</li>
</ul>
<?php
	}
	// show just comments (old design)
	else if (is_numeric($comments)) {
?>
	<div class="commentslikes">
		<a href="<?= htmlspecialchars($commentsLink) ?>" class="wikia-chiclet-button" data-id="comment" title="<?= htmlspecialchars($commentsTooltip) ?>"<?= $commentsAccesskey ?>><img class="osprite icon-article-like" src="<?= $wgBlankImgUrl ?>" height="10" width="10"></a> <?= $formattedComments ?>
	</div>
<?php
	}
?>
