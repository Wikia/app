<div class="article-comments clearfix">
<?php
if ( $canEdit ) {
?>
	<div class="article-comm-input reset clearfix">
	<form action="<?php echo $articleFullUrl; ?>" method="post" id="article-comm-form-<?=$articleId?>">
		<input type="hidden" name="wpArticleId" value="<?=$articleId?>" />
		<div class="article-comm-input-text">
			<textarea name="wpArticleComment" id="article-comm-textfield-<?=$articleId?>"><?=$comment?></textarea><br />
<? if (!$isReadOnly) { ?>
			<input type="submit" name="wpArticleSubmit" id="article-comm-submit-<?=$articleId?>" value="<? echo wfMsg('article-comments-post') ?>" />
			<input type="submit" name="wpArticleCancel" id="article-comm-edit-cancel-<?=$articleId?>" class="wikia-button secondary" value="<? echo wfMsg('article-comments-cancel') ?>" />
			<img src="<?= $stylePath ?>/common/images/ajax.gif" class="throbber" />
<? } ?>
		</div>
	</form>
	</div>
<?php
} else {
	echo $comment;
}
?>