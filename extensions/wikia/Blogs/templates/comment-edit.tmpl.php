<div id="blog-comments" class="clearfix">
<?php
if( $canEdit ):
?>
	<div class="blog-comm-input reset clearfix">
	<form action="<?php echo $title->getFullURL() ?>" method="post" id="blog-comm-form-<?=$title->getArticleId()?>">
	<input type="hidden" name="wpArticleId" value="<?= $title->getArticleId() ?>" />
		<div class="blog-comm-input-text" style="margin-left: 5px">
			<textarea name="wpBlogComment" id="blog-comm-textfield-<?=$title->getArticleId()?>"><?=$comment?></textarea><br />
<? if (!$isReadOnly) { ?>
			<input type="submit" name="wpBlogSubmit" id="blog-comm-submit-<?=$title->getArticleId()?>" value="<? echo wfMessage( "blog-comment-post" )->text() ?>" />
<? } ?>
			<div class="right" style="font-style: italic;"><?php echo wfMessage( "blog-comments-info" )->text() ?></div>
		</div>
	</form>
	</div>
<?php
else:
	echo $comment;
endif;
?>
<!-- e:<?= __FILE__ ?> -->
