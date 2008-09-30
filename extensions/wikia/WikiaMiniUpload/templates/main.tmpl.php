<div id="ImageUploadError"></div>

<table cellspacing="0" style="width: 100%;" id="ImageUploadInputTable">
	<tr id="ImageUploadUpload">
		<td><h1><?= wfMsg('wmu-upload') ?></h1></td>
		<td>
<?php
global $wgStylePath, $wgUser, $wgScriptPath;
if($wgUser->isLoggedIn()) {
	if ($error) {
?>
		<span id="WMU_error_box"><?= $error ?></span>
<?php
	}
?>
			<form onsubmit="return AIM.submit(this, WMU_uploadCallback)" action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=WMU&method=uploadImage" id="ImageUploadForm" method="POST" enctype="multipart/form-data">
				<input id="ImageUploadFile" name="wpUploadFile" type="file" />
				<input type="submit" value="<?= wfMsg('wmu-upload-btn') ?>" onclick="return WMU_upload(event);" />
			</form>
<?php
} else {
	echo wfMsg('wmu-notlogged');
}
?>
		</td>
	</tr>
	<tr id="ImageUploadFind">
		<td><h1><?= wfMsg('wmu-find') ?></h1></td>
		<td>
<?php
if($wgUser->isLoggedIn()) {
?>
			<div onclick="WMU_changeSource(event);" style="font-size: 9pt; float: right; margin-top: 5px;">
				<a id="WMU_source_0" href="#" style="font-weight: bold;"><?= wfMsg('wmu-thiswiki') ?></a> |
				<a id="WMU_source_1" href="#"><?= wfMsg('wmu-flickr') ?></a>
			</div>
<?php
}
?>
			<input onkeydown="WMU_trySendQuery(event);" type="text" id="ImageQuery" />
			<input onclick="WMU_trySendQuery(event);" type="button" value="<?= wfMsg('wmu-find-btn') ?>" />
			<img src="<?= $wgStylePath; ?>/monaco/images/widget_loading.gif" id="ImageUploadProgress2" style="visibility: hidden;"/>
		</td>
	</tr>
</table>

<div id="WMU_results_0">
	<?= $result ?>
</div>

<div id="WMU_results_1" style="display: none;">
	<br/><br/><br/><br/><br/>
	<div style="text-align: center;">
		<img src="<?= $wgStylePath ?>/../extensions/wikia/WikiaMiniUpload/images/flickr_logo.gif" />
		<div class="ImageUploadSourceNote"><?= wfMsg('wmu-flickr-inf') ?></div>
	</div>
</div>
