<?php
	global $wgExtensionsPath, $wgScript, $wgStylePath;
?>
<div id="WikiaPhotoGalleryEditorLoader" style="height: 460px">&nbsp;</div>

<div id="WikiaPhotoGalleryEditorPagesWrapper">

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
	if ($showUploadForm) {
?>
		<?= wfMsgExt('wikiaPhotoGallery-upload-uploadtext', array('parse')) ?>

		<form action="<?= $wgScript ?>?action=ajax&rs=WikiaPhotoGalleryAjax&method=upload" id="WikiaPhotoGalleryImageUploadForm" method="POST" enctype="multipart/form-data">
			<input id="WikiaPhotoGalleryImageUpload" name="wpUploadFile" type="file" size="1" />
			<input id="WikiaPhotoGalleryImageUploadButton" type="submit" value="<?= wfMsg('wikiaPhotoGallery-upload-uploadbutton') ?>" />
			<img id="WikiaPhotoGalleryUploadProgress" class="WikiaPhotoGalleryProgress" src="<?= $wgStylePath ?>/common/images/ajax.gif" width="16" height="16" alt="" />
		</form>
<?php
	}
	else {
?>
		<?= wfMsgExt('wikiaPhotoGallery-upload-uploadtext', array('parse')) ?>
		<p><?= wfMsg('uploaddisabledtext') ?></p>
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

			<p><?= wfMsg('wikiaPhotoGallery-photooptions-linkurl') ?></p>
			<input id="WikiaPhotoSlideshowLink" type="text" />
			<div id="WikiaPhotoSlideshowLinkSuggestWrapper" class="suggestWrapper"></div>

			<p><?= wfMsg('wikiaPhotoGallery-photooptions-linktext') ?></p>
			<input id="WikiaPhotoSlideshowLinkText" type="text" />
		</div>
	</div>
</div>

<!-- Gallery preview -->
<div class="WikiaPhotoGalleryEditorPage">
	<div class="WikiaPhotoGalleryEditorPageInner WikiaPhotoGalleryPreviewPage">

		<!-- options tabs -->
		<div id="WikiaPhotoGalleryOptionsTabs">
			<div class="wikia-tabs">
				<ul>
					<li class="accent"><a href="#"><?= wfMsg('wikiaPhotoGallery-preview-tab-layout') ?></a></li>
					<li class="accent"><a href="#"><?= wfMsg('wikiaPhotoGallery-preview-tab-theme') ?></a></li>
				</ul>
			</div>

			<!-- layout -->
			<div class="WikiaPhotoGalleryOptionsTab clearfix">
				<!-- width slider -->
				<div class="WikiaPhotoGalleryOptionsColumn">
					<div id="WikiaPhotoGallerySliderGallery" class="WikiaPhotoGallerySlider">
						<label for="WikiaPhotoGalleryPhotoWidth"><?= wfMsg('wikiaPhotoGallery-preview-size') ?></label>
						<input id="WikiaPhotoGalleryPhotoWidth" type="text" /> <?= wfMsg('wikiaPhotoGallery-preview-px') ?>

						<span class="slider">
							<small style="left: 0"><?= wfMsg('wikiaPhotoGallery-preview-size-smaller') ?></small>
							<small style="right: 0"><?= wfMsg('wikiaPhotoGallery-preview-size-larger') ?></small>
						</span>
					</div>
				</div>

				<!-- columns / image spacing dropdown -->
				<div class="WikiaPhotoGalleryOptionsColumn">
					<table border ="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><?= WikiaPhotoGalleryHelper::renderLabel('wikiaPhotoGallery-preview-position', 'WikiaPhotoGalleryEditorGalleryPosition') ;?></td>
							<td><?= WikiaPhotoGalleryHelper::renderOptionDropdown('WikiaPhotoGalleryEditorGalleryPosition', 'wikiaPhotoGallery-preview-position', array('left', 'center', 'right'), 0, false) ;?></td>
						</tr>
						<tr>
							<td><?= WikiaPhotoGalleryHelper::renderLabel('wikiaPhotoGallery-preview-columns', 'WikiaPhotoGalleryEditorGalleryColumns') ;?></td>
							<td><?= WikiaPhotoGalleryHelper::renderOptionDropdown('WikiaPhotoGalleryEditorGalleryColumns', 'wikiaPhotoGallery-preview-columns', array_merge(array('dynamic'), range(1,6)), 0, false) ;?></td>
						</tr>
						<tr>
							<td><?= WikiaPhotoGalleryHelper::renderLabel('wikiaPhotoGallery-preview-spacing', 'WikiaPhotoGalleryEditorGalleryImageSpacing') ;?></td>
							<td><?= WikiaPhotoGalleryHelper::renderOptionDropdown('WikiaPhotoGalleryEditorGalleryImageSpacing', 'wikiaPhotoGallery-preview-spacing', array('small', 'medium', 'large'), 1 /*default is large*/, false) ;?></td>
						</tr>
					</table>
				</div>

				<!-- image orientation / crop -->
				<div class="WikiaPhotoGalleryOptionsColumn" style="margin-right:0px;">
					<?= WikiaPhotoGalleryHelper::renderImageOptionWidget('WikiaPhotoGalleryOrientation', 'wikiaPhotoGallery-preview-orientation', array('none', 'square', 'landscape', 'portrait', ), 34) ;?>
				</div>
			</div>

			<!-- borders & captions -->
			<div class="WikiaPhotoGalleryOptionsTab clearfix">
				<!-- caption position / alignment -->
				<div class="WikiaPhotoGalleryOptionsColumn">
					<table border ="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><?= WikiaPhotoGalleryHelper::renderLabel('wikiaPhotoGallery-preview-captionposition', 'WikiaPhotoGalleryEditorGalleryCaptionPosition') ;?></td>
							<td><?= WikiaPhotoGalleryHelper::renderOptionDropdown('WikiaPhotoGalleryEditorGalleryCaptionPosition', 'wikiaPhotoGallery-preview-captionposition', array('within', 'below'), 1 /*default is below*/, false) ;?></td>
						</tr>
						<tr>
							<td><?= WikiaPhotoGalleryHelper::renderLabel('wikiaPhotoGallery-preview-captionalignment', 'WikiaPhotoGalleryEditorGalleryCaptionAlignment') ;?></td>
							<td><?= WikiaPhotoGalleryHelper::renderOptionDropdown('WikiaPhotoGalleryEditorGalleryCaptionAlignment', 'wikiaPhotoGallery-preview-captionalignment', array('left', 'center', 'right'), 0 /* left is default */, false) ?></td>
						</tr>
					</table>
				</div>

				<!-- caption font size / color -->
				<div class="WikiaPhotoGalleryOptionsColumn">
					<table border ="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><?= WikiaPhotoGalleryHelper::renderLabel('wikiaPhotoGallery-preview-captionsize', 'WikiaPhotoGalleryEditorGalleryCaptionSize') ;?></td>
							<td><?= WikiaPhotoGalleryHelper::renderOptionDropdown('WikiaPhotoGalleryEditorGalleryCaptionSize', 'wikiaPhotoGallery-preview-captionsize', array('small', 'medium', 'large'), 1 /* medium is default */, false) ?></td>
						</tr>
						<tr>
							<td><?= WikiaPhotoGalleryHelper::renderLabel('wikiaPhotoGallery-preview-captioncolor', 'WikiaPhotoGalleryEditorGalleryCaptionColor') ;?></td>
							<td><?= WikiaPhotoGalleryHelper::renderColorPicker('WikiaPhotoGalleryEditorGalleryCaptionColor', 'wikiaPhotoGallery-preview-captioncolor', array(
								array(
									array('color' => '#FFFFFF'),
									array('color' => '#8E8E8E'),
									array('color' => '#000000')
								),

								// horizontal line
								'hr',

								// defined colors
								array(
									array('color' => '#D63429'),
									array('color' => '#FB7CB4'),
									array('color' => '#FD6C01')
								),

								array(
									array('color' => '#FCCA00'),
									array('color' => '#27BB0A'),
									array('color' => '#5CC1C7')
								),

								array(
									array('color' => '#323574'),
									array('color' => '#D235CA'),
									array('color' => '#7A3CA7')
								)
							),
							'#000000' /* default is black */,
							false
							) ;?></td>
						</tr>
					</table>
				</div>

				<!-- border width / color -->
				<div class="WikiaPhotoGalleryOptionsColumn" style="margin-right:0px;">
					<table border ="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><?= WikiaPhotoGalleryHelper::renderLabel('wikiaPhotoGallery-preview-bordersize', 'WikiaPhotoGalleryEditorGalleryBorderSize') ;?></td>
							<td><?= WikiaPhotoGalleryHelper::renderOptionDropdown('WikiaPhotoGalleryEditorGalleryBorderSize', 'wikiaPhotoGallery-preview-bordersize', array('none', 'small', 'medium', 'large'), 1 /* default is small */, false) ?></td>
						</tr>
						<tr>
							<td><?= WikiaPhotoGalleryHelper::renderLabel('wikiaPhotoGallery-preview-bordercolor', 'WikiaPhotoGalleryEditorGalleryBorderColor') ;?></td>
							<td><?= WikiaPhotoGalleryHelper::renderColorPicker('WikiaPhotoGalleryEditorGalleryBorderColor', 'wikiaPhotoGallery-preview-bordercolor', array(
								// CSS classes
								array(
									array('class' => 'accent', 'property' => 'border'),
									array('color' => 'transparent')
								),
								
								array(
									array('color' => '#FFFFFF'),
									array('color' => '#8E8E8E'),
									array('color' => '#000000')
								),
								
								// horizontal line
								'hr',

								// defined colors
								array(
									array('color' => '#D63429'),
									array('color' => '#FB7CB4'),
									array('color' => '#FD6C01')
								),

								array(
									array('color' => '#FCCA00'),
									array('color' => '#27BB0A'),
									array('color' => '#5CC1C7')
								),

								array(
									array('color' => '#323574'),
									array('color' => '#D235CA'),
									array('color' => '#7A3CA7')
								)
							),
							array('accent', 'border'),
							false) ;?></td>
						</tr>
					</table>


					<br />

				</div>
			</div>
		</div>

		<!-- preview area -->
		<h1><?= wfMsg('wikiaPhotoGallery-preview-previewtitle') ?></h1>
		<p>
			<button id="WikiaPhotoGalleryAddImage" class="wikia-button"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-addphoto') ?></button>
		</p>

		<div id="WikiaPhotoGalleryEditorPreview" class="preview"></div>
	</div>
</div>

<!-- Slideshow preview -->
<div class="WikiaPhotoGalleryEditorPage">
	<div class="WikiaPhotoGalleryEditorPageInner">
		<h1><?= wfMsg('wikiaPhotoGallery-slideshowpreview-optionstitle') ?></h1>

		<div class="clearfix">
			<!-- width slider -->
			<div class="WikiaPhotoGalleryOptionsColumn">
				<div id="WikiaPhotoGallerySliderSlideshow" class="WikiaPhotoGallerySlider">
					<label for="WikiaPhotoGallerySlideshowWidth"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-size') ?></label>
					<input id="WikiaPhotoGallerySlideshowWidth" type="text" />

					<span class="slider">
						<small style="left: 0"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-size-smaller') ?></small>
						<small style="right: 0"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-size-larger') ?></small>
					</span>
				</div>
			</div>

			<!-- checkboxes -->
			<div class="WikiaPhotoGalleryOptionsColumn">
				<?= WikiaPhotoGalleryHelper::renderOptionCheckbox('WikiaPhotoGallerySlideshowCrop', 'wikiaPhotoGallery-slideshowpreview-crop') ?>
				<br />
				<?= WikiaPhotoGalleryHelper::renderOptionDropdown('WikiaPhotoGalleryEditorSlideshowAlign', 'wikiaPhotoGallery-slideshowpreview-position', array('left', 'center', 'right'), 2 /* right is default option */) ?>
			</div>
		</div>

		<h1><?= wfMsg('wikiaPhotoGallery-slideshowpreview-photostitle') ?></h1>
		<p>
			<button id="WikiaPhotoGallerySlideshowAddImage" class="wikia-button"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-addphoto') ?></button>
			<span style="padding-left: 100px">
				<input id="WikiaPhotoGallerySlideshowRecentUploads" type="checkbox" />
				<label for="WikiaPhotoGallerySlideshowRecentUploads"><?= wfMsg('wikiaPhotoGallery-slideshowpreview-recentuploads') ?></label>
			</span>
		</p>

		<div id="WikiaPhotoGallerySlideshowEditorPreview" class="preview"></div>
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

<!-- close pages wrapper -->
</div>

<!-- Editor toolbar -->
<div class="neutral modalToolbar clearfix">
	<a id="WikiaPhotoGalleryEditorSave" class="wikia-button"></a>
	<a id="WikiaPhotoGalleryEditorCancel" class="wikia-button secondary"><?= wfMsg('wikiaPhotoGallery-back') ?></a>

	<div id="WikiaPhotoGalleryEditConflictButtons" style="display: block">
		<a class="wikia-button"><?= wfMsg('wikiaPhotoGallery-conflict-edit') ?></a>
		<a class="wikia-button"><?= wfMsg('wikiaPhotoGallery-conflict-view') ?></a>
	</div>
</div>

<!-- Fake form for MW suggest -->
<form id="WikiaPhotoGalleryEditorForm">
</form>
