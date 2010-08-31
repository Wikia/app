<?php
	if (is_numeric($comments) || is_numeric($likes)) {
?>
<div class="commentslikes">
<?php
		// render comments button
		if (is_numeric($comments)) {
?>
	<a href="<?= htmlspecialchars($commentsLink) ?>" class="wikia-chiclet-button"data-id="comment" title="<?= htmlspecialchars($commentsTooltip) ?>"<?= $commentsAccesskey ?>><img class="osprite icon-article-like" src="<?= $wgBlankImgUrl ?>"></a> <?= $comments ?>
<?php
		}

		// render likes button
		/**
		if (is_numeric($likes)) {
?>
	<img src="<?= $wgStylePath ?>/oasis/images/icon_article_like.png"> <?= $likes ?>
<?php
		}
		**/
?>
</div>
<?php
	}
?>
