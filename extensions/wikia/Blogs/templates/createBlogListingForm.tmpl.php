<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
//
var wgAjaxPath = wgScriptPath + wgScript;
var CreateBlogListing = {};

CreateBlogListing.checkMatchesCallback = function( respData ) {
	$( "#blogListingMatches" ).html('<span class="matches-info">' + (respData ? respData : '0') + ' <?php echo wfMsg('create-blog-listing-matches-info'); ?></span>');
	$( "#blogListingCalculateMatches" ).val('<?php echo wfMsg('create-blog-listing-matches-recalculate'); ?>');
};

CreateBlogListing.checkMatches = function (e) {
		var listingCategories = $( "#wpCategoryTextarea1" ).val();
		//var listingAuthors = YD.get( "blogListingAuthors" ).value;
		$( "#blogListingMatches" ).html('<?php echo Wikia::ImageProgress() ?>');
		$.get(wgAjaxPath, {action: "ajax", rs: "CreateBlogListingPage::axBlogListingCheckMatches", categories: encodeURIComponent(listingCategories)}, CreateBlogListing.checkMatchesCallback);
	};

$(document).ready( function () {
	$('#blogListingCalculateMatches').click( CreateBlogListing.checkMatches );
} );
/*]]>*/
</script>
<strong><?php echo wfMsg( "create-blog-listing-form-title" ) ?></strong><br />
<?php echo wfMsg( "create-blog-listing-form-info" ) ?>
<br />
<br />
<form name="blogPostForm" id="blogPostForm" class="wikia_form" method="post" action="<?php echo $title->getLocalUrl();?>">
	<input type="hidden" name="articleEditAllowed" value="<?php echo isset($formData['isExistingArticleEditAllowed']) ? $formData['isExistingArticleEditAllowed'] : "0"; ?>" />
	<input type="hidden" name="token" value="<?= F::app()->wg->User->getEditToken() ?>" />
	<?php if(!empty($preview)): ?>
		<h2><?=wfMsg('create-blog-listing-preview')?></h2>
		<div class='previewnote'><p><strong><?php echo wfMsg('previewnote');?></strong></p></div>
		<?php echo $preview; ?>
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
		<label><?php echo wfMsg( "create-blog-listing-page-title" ) ?></label>
		<?php if(isset($formData['isExistingArticleEditAllowed']) && $formData['isExistingArticleEditAllowed']): ?>
			<input type="hidden" name="blogListingTitle" value="<?=$formData['listingTitle']; ?>" />
			<div id="blogPostROTitle">
				<?=$formData['listingTitle']; ?>
			</div>
			<?php else: ?>
				<input type="text" id="blogPostTitle" name="blogListingTitle" value="<?php echo ( isset($formData['listingTitle']) ? htmlspecialchars($formData['listingTitle']) : "" ); ?>" size="60" maxlength="255" />
			<?php endif; ?>
	</div>

	<div class="formBlock">
		<?php echo $blogCategoryCloud; ?>
	</div>

<? /*
	<div class="formBlock">
		<label><?php echo wfMsg('create-blog-listing-authors'); ?></label>
		<textarea name="blogListingAuthors" id="blogListingAuthors"><?php echo $formData['listingAuthors'];?></textarea>
	</div>
*/ ?>

	<div class="formBlock">
		<label><?php echo wfMsg('create-blog-listing-matches'); ?></label>
		<span id="blogListingMatches">&nbsp;</span>
		<input type="button" name="blogListingCalcuateMatches" id="blogListingCalculateMatches" value="<?php echo wfMsg('create-blog-listing-matches-calculate'); ?>" />
	</div>

	<div class="formBlock">
		<label><?php echo wfMsg('create-blog-listing-sortby'); ?></label>
		<select name="blogListingSortBy">
			<?php foreach($sortByKeys as $sortByKey => $sortByValue): ?>
				<option value="<?=$sortByKey;?>" <?=(isset($formData['listingSortBy']) && ($formData['listingSortBy'] == $sortByKey)) ? "selected" : "";?> ><?=wfMsg('create-blog-listing-sortby-' . $sortByKey);?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="formBlock">
		<?php echo $pageCategoryCloud; ?>
	</div>

	<div class="formLastBlock">
		<div style="padding-bottom: 15px;">
			<input type="radio" name="listingType" value="plain" <?=(empty($formData['listingType']) || ($formData['listingType'] == 'plain'))?"checked=\"yes\"":"";?> />&nbsp;<?php echo wfMsg('create-blog-listing-output-as-page');?>
			<input type="radio" name="listingType" value="box" <?=(isset($formData['listingType']) && ($formData['listingType'] == 'box'))?"checked=\"yes\"":"";?> />&nbsp;<?php echo wfMsg('create-blog-listing-output-as-box');?>
		</div>
		<div class="editButtons">
			<input id="wpSave" type="submit" title="Save your changes [ctrl-s]" accesskey="s" value="<?=wfMsg('create-blog-save')?>" tabindex="5" name="wpSave"/>
			<input id="wpPreview" type="submit" title="Preview your changes, please use this before saving! [ctrl-p]" accesskey="p" value="<?=wfMsg('create-blog-preview')?>" tabindex="6" name="wpPreview"/>
		</div>
	</div>

</form>
<!-- e:<?= __FILE__ ?> -->
