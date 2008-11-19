<!-- s:<?php echo __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
#blogPostForm label { display: block; float: left; padding-right: 1em; text-align: right; font-size: 16px; color: orange; }
#blogPostForm div.formErrors { color: red; font-weight: bold; }
#blogPostForm div.formBlock { width: 100%; clear: left; float: left; margin-top: 10px; margin-bottom: 10px; padding-bottom: 20px; border-bottom: 1px dotted gray; }
#blogPostForm #blogPostTitle { clear: left; float: left; display: block; }
#CreateWikiForm div.row { padding: 0.8em; display: block !important; clear: both; }
<?php // #sidebar { display: none } ?>
tr { border: 1px solid #dcdcdc; }
/*]]>*/
</style>

<strong><?php echo wfMsg( "create-blog-form-title" ) ?></strong><br />
<?php echo wfMsg( "create-blog-form-info" ) ?>
<br />
<br />
<form name="blogPostForm" id="blogPostForm" method="post" action="<?php echo $title->getLocalUrl();?>">
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
		<input type="text" id="blogPostTitle" name="blogPostTitle" value="<?php echo $formData['postTitle']; ?>" size="60" maxlength="255" />
		<div style="float: left">
		<input type="checkbox" name="blogPostIsVotingEnabled" value="1" <?php echo !empty($formData['isVotingEnabled']) ? "checked" : ""; ?> />Voting
		<input type="checkbox" name="blogPostIsCommentingEnabled" value="1" <?php echo !empty($formData['isCommentingEnabled']) ? "checked" : ""; ?> />Comments
		</div>
	</div>
	<div class="formBlock">
		<label>Text</label>
		<div class="display: block">
			<?php echo EditPage::getEditToolbar(); ?>
			<textarea id="wpTextbox1" class="yui-ac-input" cols="80" rows="15" name="wpTextbox1" accesskey="," tabindex="1" autocomplete="off"><?php echo $formData['postBody']; ?></textarea>
		</div>
	</div>

	<div class="formBlock">
		<?php echo $categoryCloud; ?>
	</div>

	<div class="formBlock">
		<div class="editButtons">
			<input id="wpSave" type="submit" title="Save your changes [ctrl-s]" accesskey="s" value="Save page" tabindex="5" name="wpSave"/>
			<input id="wpPreview" type="submit" title="Preview your changes, please use this before saving! [ctrl-p]" accesskey="p" value="Show preview" tabindex="6" name="wpPreview"/>
			<span class="editHelp">
				<a id="wpCancel" title="<?php echo $title->getText(); ?>" href="<?php echo $title->getLocalUrl();?>">Cancel</a> |
				<a id="wpEdithelp" href="" target="helpwindow">Editing help</a> (opens in new window)
			</span>
		</div>
	</div>

</form>
<!-- e:<?= __FILE__ ?> -->

