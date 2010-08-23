<!-- s:<?= __FILE__ ?> -->
<div class="clearfix"> 
	<div class="article-comm-input reset clearfix">
	<form action="#" method="post" id="article-comm-form-<?= $commentId ?>">
		<input type="hidden" name="wpParentId" value="<?= $commentId ?>" />
		<div class="article-comm-input-text">
			<textarea name="wpArticleReply" id="article-comm-textfield-<?= $commentId ?>"></textarea><br />
			<input type="submit" name="wpArticleSubmit" id="article-comm-submit-<?= $commentId ?>" value="<? echo wfMsg('article-comments-post') ?>" />
			<img src="<?= $stylePath ?>/common/images/ajax.gif" class="throbber" />
		</div>
	</form>
</div>
<!-- e:<?= __FILE__ ?> -->
