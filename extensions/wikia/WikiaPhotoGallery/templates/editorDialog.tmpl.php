<?php
	global $wgExtensionsPath, $wgScript, $wgStylePath;
?>
<div id="WikiaPhotoGalleryEditorLoader" style="height: 460px">&nbsp;</div>

<!-- Type chooser (gallery or slideshow) -->
<div class="WikiaPhotoGalleryEditorPage">
	<div class="WikiaPhotoGalleryEditorPageInner WikiaPhotoGalleryEditorChooseType">
		<p><?= wfMsg('wikiaPhotoGallery-choice-intro') ?></p>

		<table align="center" width="600">
			<colgroup>
				<col width="50%" />
				<col width="50%" />
			</colgroup>
			<tr>
				<td class="border">
					<a class="wikia-button" type="<?= WikiaPhotoGallery::WIKIA_PHOTO_SLIDESHOW ?>">
						<?= wfMsg('wikiaPhotoGallery-choice-slideshow') ?>
					</a>
				</td>
				<td>
					<a class="wikia-button" type="<?= WikiaPhotoGallery::WIKIA_PHOTO_GALLERY ?>">
						<?= wfMsg('wikiaPhotoGallery-choice-gallery') ?>
					</a>
				</td>
			</tr>
			<tr>
				<td class="border">
					<a href="#" type="<?= WikiaPhotoGallery::WIKIA_PHOTO_SLIDESHOW ?>">
						<img src="<?= $wgExtensionsPath ?>/wikia/WikiaPhotoGallery/images/slideshow-example.png" alt="<?= wfMsg('wikiaPhotoGallery-choice-slideshow') ?>" width="187" height="169" />
					</a>
				</td>
				<td>
					<a href="#" type="<?= WikiaPhotoGallery::WIKIA_PHOTO_GALLERY ?>">
						<img src="<?= $wgExtensionsPath ?>/wikia/WikiaPhotoGallery/images/gallery-example.png" alt="<?= wfMsg('wikiaPhotoGallery-choice-gallery') ?>" width="212" height="238" />
					</a>
				</td>
			</tr>
		</table>
	</div>
</div>

<!-- Upload / Find -->
<div class="WikiaPhotoGalleryEditorPage">
	<div class="WikiaPhotoGalleryEditorPageInner">
		<h1><?= wfMsg('wikiaPhotoGallery-upload-uploadtitle') ?></h1>
<?php
	if ($showUpload) {
?>
		<?= wfMsgExt('wikiaPhotoGallery-upload-uploadtext', array('parse')) ?>

		<form action="<?= $wgScript ?>?action=ajax&rs=WikiaPhotoGalleryAjax&method=upload" id="WikiaPhotoGalleryImageUploadForm" method="POST" enctype="multipart/form-data">
			<input id="WikiaPhotoGalleryImageUpload" name="wpUploadFile" type="file" size="1" />
			<input id="WikiaPhotoGalleryImageUploadButton" type="submit" value="<?= wfMsg('wikiaPhotoGallery-upload-uploadbutton') ?>" />
			<img id="WikiaPhotoGalleryUploadProgress" class="WikiaPhotoGalleryProgress" src="<?= $wgStylePath ?>/common/images/ajax.gif" width="16" height="16" alt="" />
		</form>
<?php
	}
?>
		<p id="WikiaPhotoGallerySearchResultsChooser">
			<?= wfMsgExt('wikiaPhotoGallery-upload-existingtext', array('parseinline')) ?>
			<span type="<?= WikiaPhotoGallery::RESULTS_IMAGES_FROM_THIS_PAGE ?>"><?= wfMsg('wikiaPhotoGallery-upload-existingtext-onarticle') ?></span>
			|
			<span type="<?= WikiaPhotoGallery::RESULTS_RECENT_UPLOADS ?>"><?= wfMsg('wikiaPhotoGallery-upload-existingtext-recentupload') ?></span>
		</p>

		<div id="WikiaPhotoGallerySearchResults">
			<?= $recentlyUploaded ?>
			<?= $imagesOnPage ?>
		</div>

		<a id="WikiaPhotoGallerySearchResultsSelect" class="wikia-button"><?= wfMsg('wikiaPhotoGallery-upload-selectbutton') ?></a>
	</div>
</div>

<!-- Upload conflict -->
<div class="WikiaPhotoGalleryEditorPage">
	<div class="WikiaPhotoGalleryEditorPageInner">
		<table id="WikiaPhotoGalleryEditorConflictTable">
			<colgroup>
				<col width="50%" />
				<col width="50%" />
			</colgroup>
			<tr>
				<td><h1><?= wfMsg('wikiaPhotoGallery-upload-error-conflict-rename') ?></h1></td>
				<td><h1><?= wfMsg('wikiaPhotoGallery-upload-error-conflict-reuse') ?></h1></td>
			</tr>
			<tr>
				<td>
					<form id="WikiaPhotoGalleryEditorConflictRename">
						<input id="WikiaPhotoGalleryEditorConflictNewName" type="text" />
						<span id="WikiaPhotoGalleryEditorConflictExtension"></span>
						<input type="submit" value="<?= wfMsg('wikiaPhotoGallery-upload-error-conflict-insert') ?>" />
					</form>
				</td>
				<td>
					<button id="WikiaPhotoGalleryEditorConflictReuse"><?= wfMsg('wikiaPhotoGallery-upload-error-conflict-insert') ?></button>
				</td>
			</tr>
			<tr id="WikiaPhotoGalleryEditorConflictThumbs">
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2"><button id="WikiaPhotoGalleryEditorConflictOverwrite"><?= wfMsg('wikiaPhotoGallery-upload-error-conflict-overwrite') ?></button></td>
			</tr>
		</table>
	</div>
</div>

<!-- Caption / link -->
<div class="WikiaPhotoGalleryEditorPage">
	<div class="WikiaPhotoGalleryEditorPageInner clearfix">
		<!-- Image preview -->
		<div id="WikiaPhotoGalleryEditorCaptionImagePreview"></div>

		<!-- Caption -->
		<h1><?= wfMsg('wikiaPhotoGallery-photooptions-captiontitle') ?></h1>
		<p><?= wfMsg('wikiaPhotoGallery-photooptions-captionsub') ?></p>
		<div class="WikiaPhotoGalleryEditorCaptionWrapper">
			<div id="WikiaPhotoGalleryEditorCaptionToolbar"></div>
			<textarea id="WikiaPhotoGalleryEditorCaption" rows="2"></textarea>
		</div>

		<!-- Link editor for galleries -->
		<div id="WikiaPhotoGalleryLinkEditor">
			<h1><?= wfMsg('wikiaPhotoGallery-photooptions-linktitle') ?></h1>

			<p><?= wfMsg('wikiaPhotoGallery-photooptions-linksub') ?></p>
			<input id="WikiaPhotoGalleryLink" type="text" />
			<div id="WikiaPhotoGalleryLinkSuggestWrapper" class="suggestWrapper"></div>
		</div>

		<!-- Link editor for slideshows -->
		<div id="WikiaPhotoSlideshowLinkEditor">
			<h1><?= wfMsg('wikiaPhotoGallery-photooptions-linktitle') ?></h1>

			<p><?= wfMsg('wikiaPhotoGallery-photooptions-linktext') ?></p>
			<input id="WikiaPhotoSlideshowLinkText" type="text" />

			<p><?= wfMsg('wikiaPhotoGallery-photooptions-linkurl') ?></p>
			<input id="WikiaPhotoSlideshowLink" type="text" />
			<div id="WikiaPhotoSlideshowLinkSuggestWrapper" class="suggestWrapper"></div>
		</div>
	</div>
</div>

<!-- Gallery preview -->
<div class="WikiaPhotoGalleryEditorPage">
	<div id="WikiaPhotoGalleryEditorPreview" class="preview"></div>
</div>

<!-- Slideshow preview -->
<div class="WikiaPhotoGalleryEditorPage">
	<div class="WikiaPhotoGalleryEditorPageInner">
		<h1><?= wfMsg('wikiaPhotoGallery-slideshowpreview-optionstitle') ?></h1>

		<p>
			<label for="WikiaPhotoGallerySlideshowWidth"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-size') ?></label>
			<input id="WikiaPhotoGallerySlideshowWidth" type="text" />

			<span id="WikiaPhotoGallerySlideshowWidthSlider">
				<small style="left: 0"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-size-smaller') ?></small>
				<small style="right: 0"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-size-larger') ?></small>
			</span>
		</p>

		<p style="padding-top: 10px">
			<input id="WikiaPhotoGallerySlideshowCrop" type="checkbox" />
			<label for="WikiaPhotoGallerySlideshowCrop"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-crop') ?></label>
		</p>

		<h1><?= wfMsg('wikiaPhotoGallery-slideshowpreview-photostitle') ?></h1>

		<div id="WikiaPhotoGallerySlideshowEditorPreview" class="preview"></div>

		<a id="WikiaPhotoGallerySlideshowAddImage" class="wikia-button"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-addphoto') ?></a>
	</div>
</div>

<!-- Edit conflict -->
<div class="WikiaPhotoGalleryEditorPage">
	<div id="WikiaPhotoGalleryEditConflict" class="WikiaPhotoGalleryEditorPageInner clearfix">
		<p><?= wfMsg('wikiaPhotoGallery-conflict-help',
			wfMsg('wikiaPhotoGallery-conflict-edit'),
			wfMsg('wikiaPhotoGallery-conflict-view'))
		?></p>

		<textarea id="WikiaPhotoGalleryEditConflictWikitext"></textarea>
	</div>
</div>


<!-- Editor toolbar -->
<div class="neutral modalToolbar">
	<a id="WikiaPhotoGalleryEditorSave" class="wikia-button"></a>
	<a id="WikiaPhotoGalleryEditorCancel" class="wikia-button secondary"><?= wfMsg('wikiaPhotoGallery-back') ?></a>

	<div id="WikiaPhotoGalleryEditConflictButtons" style="display: block">
		<a class="wikia-button"><?= wfMsg('wikiaPhotoGallery-conflict-edit') ?></a>
		<a class="wikia-button"><?= wfMsg('wikiaPhotoGallery-conflict-view') ?></a>
	</div>

	<table id="WikiaPhotoGalleryEditorPreviewOptions" style="display: block"><tr>
		<td><?= wfMsg('wikiaPhotoGallery-preview-size') ?></td>
		<td>
			<span id="WikiaPhotoGalleryEditorPreviewSlider">
				<span class="accent ui-slider-tooltip"></span>
			</span>
		</td>
		<td><?= wfMsg('wikiaPhotoGallery-preview-captions') ?></td>
		<td>
			<select id="WikiaPhotoGalleryEditorPreviewAlign">
<?php
	$alignments = array('left', 'center', 'right');
	foreach ($alignments as $align) {
?>
				<option value="<?= $align ?>"><?= wfMsg("wikiaPhotoGallery-preview-captions-{$align}") ?></option>
<?php
	}
?>
			</select>
		</td>
	</tr></table>
</div>

<!-- Fake form for MW suggest -->
<form id="WikiaPhotoGalleryEditorForm">
</form>
