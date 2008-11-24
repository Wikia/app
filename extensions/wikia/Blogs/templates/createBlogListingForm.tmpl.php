<!-- s:<?= __FILE__ ?> -->
<strong><?php echo wfMsg( "create-blog-listing-form-title" ) ?></strong><br />
<?php echo wfMsg( "create-blog-listing-form-info" ) ?>
<br />
<br />
<form name="blogPostForm" id="blogPostForm" method="post" action="<?php echo $title->getLocalUrl();?>">
	<div class="formBlock">
		<label><?php echo wfMsg( "create-blog-listing-page-title" ) ?></label>
		<input type="text" id="blogPostTitle" name="blogListingTitle" value="<?php echo $formData['listingTitle']; ?>" size="60" maxlength="255" />
	</div>

	<div class="formBlock">
		<?php echo $blogCategoryCloud; ?>
	</div>

	<div class="formBlock">
		<label>Matches:</label>
		<input type="submit" name="blogListingCalcuateMatches" id="blogListingCalculateMatches" value="Calculate" />
	</div>

	<div class="formBlock">
		<label>Sort By:</label>
		<select name="blogListingSortBy">
			<option value="">Most recent</option>
		</select>
	</div>

	<div class="formBlock">
		<?php echo $pageCategoryCloud; ?>
	</div>

	<div class="formBlock">
		<div class="editButtons">
			<input id="wpSave" type="submit" title="Save your changes [ctrl-s]" accesskey="s" value="Save page" tabindex="5" name="wpSave"/>
			<input id="wpPreview" type="submit" title="Preview your changes, please use this before saving! [ctrl-p]" accesskey="p" value="Show preview" tabindex="6" name="wpPreview"/>
		</div>
	</div>

</form>
<!-- e:<?= __FILE__ ?> -->
