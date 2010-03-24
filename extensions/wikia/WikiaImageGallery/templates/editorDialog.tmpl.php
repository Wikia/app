<div id="WikiaImageGalleryEditorLoader" style="height: 400px">&nbsp;</div>

<!-- Upload / Find -->
<div class="WikiaImageGalleryEditorPage">
	<div class="WikiaImageGalleryEditorPageInner">
		<table id="WikiaImageGalleryEditorUploadTable" cellspacing="0" width="100%">
<?php
	if ($showUpload) {
?>
			<tr>
				<td><h1><?= wfMsg('wig-upload-uploadtitle') ?></h1></td>
				<td>
					<form action="<?= $wgScript ?>?action=ajax&rs=WMU&method=uploadImage" id="WikiaImageGalleryImageUploadForm" method="POST" enctype="multipart/form-data">
						<input id="WikiaImageGalleryImageUpload" name="wpUploadFile" type="file" size="32" />
						<input id="WikiaImageGalleryImageButton" type="submit" value="<?= wfMsg('wig-upload-uploadbutton') ?>" />
					</form>
				</td>
			</tr>
<?php
	}
?>
			<tr>
				<td><h1><?= wfMsg('wig-upload-findtitle') ?></h1></td>
				<td>
					<form id="WikiaImageGallerySearchForm">
						<input id="WikiaImageGallerySearchQuery" type="text" />
						<input id="WikiaImageGallerySearchButton" type="submit" value="<?= wfMsg('wig-upload-findbutton') ?>" />
					</form>

					<img id="WikiaImageGallerySearchProgress" src="<?= $wgStylePath ?>/common/images/ajax.gif" width="16" height="16" alt="" />
				</td>
			</tr>
		</table>

		<div id="WikiaImageGallerySearchHeadline" class="clearfix">
			<span id="WikiaImageGallerySearchHeader"><?= wfMsg('wig-upload-filestitle-pre') ?></span>
			<span id="WikiaImageGallerySearchPagination" style="display: none">
				<a href="#"><?= wfMsg('wig-upload-page-prev') ?></a>
				<a href="#"><?= wfMsg('wig-upload-page-next') ?></a>
			</span>
		</div>

		<div id="WikiaImageGallerySearchResults"><?= $recentlyUploaded ?></div>
	</div>
</div>

<div class="WikiaImageGalleryEditorPage">
	<div class="WikiaImageGalleryEditorPageIntro accent"><?= wfMsg('wig-pictureoptions-intro') ?></div>
	<p>Caption/Link page</p>
</div>

<div class="WikiaImageGalleryEditorPage">
	<p>Gallery preview</p>
</div>

<div class="WikiaImageGalleryEditorToolbar neutral">
	<a id="WikiaImageGalleryEditorSave" class="wikia_button"><span></span></a>
	<a id="WikiaImageGalleryEditorCancel" class="wikia_button secondary"><span><?= wfMsg('cancel') ?></span></a>
</div>
