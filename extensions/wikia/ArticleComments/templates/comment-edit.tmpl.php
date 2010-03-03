<div id="article-comments" class="clearfix">
<?php
if ( $canEdit ) {
?>
	<div class="article-comm-input reset clearfix">
	<form action="<?php echo $title->getFullURL() ?>" method="post" id="article-comm-form-<?=$title->getArticleId()?>">
	<input type="hidden" name="wpArticleId" value="<?= $title->getArticleId() ?>" />
		<div class="article-comm-input-text" style="margin-left: 5px">
			<textarea name="wpArticleComment" id="article-comm-textfield-<?=$title->getArticleId()?>"><?=$comment?></textarea><br />
<? if (!$isReadOnly) { ?>
			<input type="submit" name="wpArticleSubmit" id="article-comm-submit-<?=$title->getArticleId()?>" value="<? echo wfMsg('article-comments-post') ?>" />
<? } ?>
		</div>
	</form>
	</div>
<?php
} else {
	echo $comment;
}
?>
<!-- e:<?= __FILE__ ?> -->
