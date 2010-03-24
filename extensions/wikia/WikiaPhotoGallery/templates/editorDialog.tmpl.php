<div id="WikiaPhotoGalleryEditorLoader" style="height: 460px">&nbsp;</div>

<!-- Upload / Find -->
<div class="WikiaPhotoGalleryEditorPage">
	<div class="WikiaPhotoGalleryEditorPageIntro accent"><?= wfMsg('wikiaPhotoGallery-upload-intro-first') ?></div>

	<div class="WikiaPhotoGalleryEditorPageInner">
		<table id="WikiaPhotoGalleryEditorUploadTable" cellspacing="0" width="100%">
			<colgroup>
				<col width="150" />
				<col width="*" />
			</colgroup>
<?php
	if ($showUpload) {
?>
			<tr>
				<td><h1><?= wfMsg('wikiaPhotoGallery-upload-uploadtitle') ?></h1></td>
				<td>
					<form action="<?= $wgScript ?>?action=ajax&rs=WikiaPhotoGalleryAjax&method=upload" id="WikiaPhotoGalleryImageUploadForm" method="POST" enctype="multipart/form-data">
						<input id="WikiaPhotoGalleryImageUpload" name="wpUploadFile" type="file" size="32" />
						<input id="WikiaPhotoGalleryImageUploadButton" type="submit" value="<?= wfMsg('wikiaPhotoGallery-upload-uploadbutton') ?>" />
					</form>

					<img id="WikiaPhotoGalleryUploadProgress" class="WikiaPhotoGalleryProgress" src="<?= $wgStylePath ?>/common/images/ajax.gif" width="16" height="16" alt="" />
				</td>
			</tr>
<?php
	}
?>
			<tr>
				<td><h1><?= wfMsg('wikiaPhotoGallery-upload-findtitle') ?></h1></td>
				<td>
					<form id="WikiaPhotoGallerySearchForm">
						<input id="WikiaPhotoGallerySearchQuery" type="text" />
						<input id="WikiaPhotoGallerySearchButton" type="submit" value="<?= wfMsg('wikiaPhotoGallery-upload-findbutton') ?>" />
					</form>

					<img id="WikiaPhotoGallerySearchProgress" class="WikiaPhotoGalleryProgress" src="<?= $wgStylePath ?>/common/images/ajax.gif" width="16" height="16" alt="" />
				</td>
			</tr>
		</table>

		<div id="WikiaPhotoGallerySearchHeadline" class="clearfix">
			<span id="WikiaPhotoGallerySearchHeader"><?= wfMsg('wikiaPhotoGallery-upload-filestitle-pre') ?></span>
			<span id="WikiaPhotoGallerySearchPagination" style="display: none">
				<a href="#"><?= wfMsg('wikiaPhotoGallery-upload-page-prev') ?></a>
				<a href="#"><?= wfMsg('wikiaPhotoGallery-upload-page-next') ?></a>
			</span>
		</div>

		<div id="WikiaPhotoGallerySearchResults"></div>
	</div>
</div>

<!-- Upload conflict -->
<div class="WikiaPhotoGalleryEditorPage">
	<div class="WikiaPhotoGalleryEditorPageIntro accent"><?= wfMsg('wikiaPhotoGallery-upload-error-conflict-intro') ?></div>

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
	<div class="WikiaPhotoGalleryEditorPageIntro accent"><?= wfMsg('wikiaPhotoGallery-photooptions-intro') ?></div>

	<div class="WikiaPhotoGalleryEditorPageInner clearfix">
		<table id="WikiaPhotoGalleryEditorCaptionLinkTable">
			<colgroup>
				<col width="150" />
				<col width="*" />
			</colgroup>
			<tr id="WikiaPhotoGalleryEditorCaptionRow">
				<td><h1><?= wfMsg('wikiaPhotoGallery-photooptions-captiontitle') ?></h1></td>
				<td>
					<div id="WikiaPhotoGalleryEditorCaptionToolbar"></div>
					<textarea id="WikiaPhotoGalleryEditorCaption" rows="2"></textarea>
					<small><?= wfMsgExt('wikiaPhotoGallery-photooptions-captionsub', array('parseinline')) ?></small>
				</td>
			</tr>
			<tr>
				<td><h1><?= wfMsg('wikiaPhotoGallery-photooptions-linktitle') ?></h1></td>
				<td>
					<input id="WikiaPhotoGalleryLink" type="text" />
					<div id="WikiaPhotoGalleryLinkSuggestWrapper"></div>
					<small><?= wfMsgExt('wikiaPhotoGallery-photooptions-linksub', array('parseinline')) ?></small>
				</td>
			</tr>
		</table>

		<table id="WikiaPhotoGalleryEditorCaptionImagePreview">
			<tr><td>
				<span></span>
			</td></tr>
			<tr><td style="height: auto">
				<a id="WikiaPhotoGalleryEditorCaptionChangeImage" href="#"><?= wfMsg('wikiaPhotoGallery-photooptions-changepicture') ?></a>
			</td></tr>
		</table>
	</div>
</div>

<!-- Gallery preview -->
<div class="WikiaPhotoGalleryEditorPage">
	<div class="WikiaPhotoGalleryEditorPageIntro accent"><?= wfMsg('wikiaPhotoGallery-preview-intro') ?></div>
	<div id="WikiaPhotoGalleryEditorPreview"></div>
</div>

<!-- Edit conflict -->
<div class="WikiaPhotoGalleryEditorPage">
	<div id="WikiaPhotoGalleryEditConflictIntro" class="WikiaPhotoGalleryEditorPageIntro accent">
		<img src="http://images1.wikia.nocookie.net/common/skins/common/blank.gif/cb1" class="sprite error" />
		<?= wfMsg('wikiaPhotoGallery-conflict-intro') ?>
	</div>

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
	<a id="WikiaPhotoGalleryEditorCancel" class="wikia-button secondary"><?= wfMsg('cancel') ?></a>

	<div id="WikiaPhotoGalleryEditConflictButtons" style="display: block">
		<a class="wikia-button"><?= wfMsg('wikiaPhotoGallery-conflict-edit') ?></a>
		<a class="wikia-button"><?= wfMsg('wikiaPhotoGallery-conflict-view') ?></a>
	</div>

	<table id="WikiaPhotoGalleryEditorPreviewOptions" style="display: block"><tr>
		<td><?= wfMsg('wikiaPhotoGallery-preview-size') ?></td>
		<td>
			<span id="WikiaPhotoGalleryEditorPreviewSlider">
				<span id="WikiaPhotoGalleryEditorPreviewSliderTooltip" class="accent"></span>
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

<!-- Recently uploaded images (to be shown on every editor init) -->
<div id="WikiaPhotoGalleryRecentlyUploadedImages">
	<?= $recentlyUploaded ?>
</div>

<!-- Fake form for MW suggest -->
<form id="WikiaPhotoGalleryEditorForm">
</form>
