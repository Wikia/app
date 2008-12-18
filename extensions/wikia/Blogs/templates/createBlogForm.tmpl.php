<!-- s:<?php echo __FILE__ ?> -->

<strong><?php echo wfMsg( "create-blog-form-title" ) ?></strong><br />
<?php echo wfMsg( "create-blog-form-info" ) ?>
<br />
<br />
<form name="blogPostForm" id="blogPostForm" method="post" action="<?php echo $title->getLocalUrl();?>">
	<input type="hidden" name="articleEditAllowed" value="<?php echo isset($formData['isExistingArticleEditAllowed']) ? $formData['isExistingArticleEditAllowed'] : "0"; ?>" />
	<?php if(!empty($preview)): ?>
		<h2>Preview</h2>
		<div class='previewnote'><p><strong><?php echo wfMsg('previewnote');?></strong></p></div>
		<?php echo $preview->getText(); ?>
		<br />
	<?php endif; ?>
	<?php if(count($formErrors)): ?>
		<div class="formErrors">
			<?php foreach($formErrors as $error): ?>
			 <?php echo $error; ?><br />
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="formBlock">
		<label><?php echo wfMsg( "create-blog-form-post-title" ) ?></label>
		<?php if(isset($formData['isExistingArticleEditAllowed']) && $formData['isExistingArticleEditAllowed']): ?>
			<input type="hidden" name="blogPostTitle" value="<?=isset($formData['postTitle']) ? $formData['postTitle'] : 0; ?>" />
			<input type="hidden" name="blogPostId" value="<?=isset($formData['postId']) ? $formData['postId'] : 0; ?>" />
			<div id="blogPostROTitle">
				<?=$formData['postTitle']; ?>
			</div>
		<?php else: ?>
			<input type="text" id="blogPostTitle" name="blogPostTitle" value="<?php echo (isset($formData['postTitle']) ? htmlspecialchars($formData['postTitle']) : ""); ?>" size="60" maxlength="255" />
		<?php endif; ?>
		<div style="float: left">
			<input type="checkbox" name="blogPostIsVotingEnabled" value="1" <?php echo (!empty($formData['isVotingEnabled']) || !isset($formData['isVotingEnabled'])) ? "checked" : ""; ?> /><?php echo wfMsg("blog-voting-label") ?>
			<input type="checkbox" name="blogPostIsCommentingEnabled" value="1" <?php echo (!empty($formData['isCommentingEnabled']) || !isset($formData['isCommentingEnabled'])) ? "checked" : ""; ?> /><?php echo wfMsg("blog-comments-label") ?>
		</div>
	</div>
	<div class="formBlock">
		<label><?php echo wfMsg( "create-blog-form-post-text" ) ?></label>
		<div class="display: block">
			<?php echo EditPage::getEditToolbar(); ?>
			<textarea id="wpTextbox1" class="yui-ac-input" cols="80" rows="15" name="wpTextbox1" accesskey="," autocomplete="off"><?php echo (isset($formData['postBody']) ? $formData['postBody'] : ""); ?></textarea>
		</div>
	</div>

	<div class="formBlock">
		<?php echo $categoryCloud; ?>
	</div>

	<div class="formLastBlock">
		<div class="editButtons">
			<input id="wpSave" type="submit" title="<?=wfMsg( 'tooltip-save' ).' ['.wfMsg( 'accesskey-save' ).']'?>" accesskey="s" value="<?=wfMsg('create-blog-save')?>" name="wpSave"/>
			<input id="wpPreview" type="submit" title="<?=wfMsg( 'tooltip-preview' ).' ['.wfMsg( 'accesskey-preview' ).']'?>" accesskey="p" value="<?=wfMsg('create-blog-preview')?>" name="wpPreview"/>
			<span class="editHelp">
				<a id="wpCancel" title="<?php echo $title->getText(); ?>" href="<?php echo $title->getLocalUrl();?>"><?=wfMsgExt('cancel', array('parseinline'))?></a> |
				<a id="wpEdithelp" href="<?=Skin::makeInternalOrExternalUrl( wfMsgForContent( 'edithelppage' ))?>" target="helpwindow"><?=htmlspecialchars( wfMsg('edithelp') )?></a> <?=htmlspecialchars( wfMsg( 'newwindow' ) )?>
			</span>
		</div>
	</div>

</form>
<!-- e:<?= __FILE__ ?> -->
