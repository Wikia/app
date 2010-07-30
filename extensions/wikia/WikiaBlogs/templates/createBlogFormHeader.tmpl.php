<!-- s:<?php echo __FILE__ ?> -->
<?php if(empty($preview)): ?>
	<div id="blogInfo">
	<label><?php echo wfMsgExt( "create-blog-form-info", array ( 'parseinline' ) ) ?></label><br />
	</div>
	<br />
<?php endif; ?>
<div id="blogPostForm" class="clearfix">
	<input type="hidden" name="articleEditAllowed" value="<?php echo isset($formData['isExistingArticleEditAllowed']) ? $formData['isExistingArticleEditAllowed'] : "0"; ?>" />
	<?php if(count($formErrors)): ?>
		<div class="formErrors">
			<?php foreach($formErrors as $error): ?>
			 <?php echo $error; ?><br />
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="formBlock">
		<span id="blogPostTitleHeader"><?php echo wfMsg( "create-blog-form-post-title" ) ?></span>
		<?php if(isset($formData['isExistingArticleEditAllowed']) && $formData['isExistingArticleEditAllowed']): ?>
			<input type="hidden" name="blogPostTitle" value="<?=isset($formData['postTitle']) ? $formData['postTitle'] : 0; ?>" />
			<input type="hidden" name="blogPostId" value="<?=isset($formData['postId']) ? $formData['postId'] : 0; ?>" />
			<div id="blogPostROTitle">
				<?=$formData['postTitle']; ?>
			</div>
		<?php else: ?>
			<input type="text" id="blogPostTitle" name="blogPostTitle" value="<?php echo (isset($formData['postTitle']) ? htmlspecialchars($formData['postTitle']) : ""); ?>" size="60" maxlength="255" />
		<?php endif; ?>
		<div id="blogPostCheckboxes">
			<label><input type="checkbox" name="blogPostIsVotingEnabled" value="1" <?php echo (!empty($formData['isVotingEnabled']) || !isset($formData['isVotingEnabled'])) ? "checked" : ""; ?> /><?php echo wfMsg("blog-voting-label") ?></label>
			<label><input type="checkbox" name="blogPostIsCommentingEnabled" value="1" <?php echo (!empty($formData['isCommentingEnabled']) || !isset($formData['isCommentingEnabled'])) ? "checked" : ""; ?> /><?php echo wfMsg("blog-comments-label") ?></label>
		</div>
	</div>
</div>
<!-- e:<?= __FILE__ ?> -->
