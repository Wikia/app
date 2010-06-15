<div id="ImageUploadError"></div>
<div id="ImageUploadMessageControl"><a id="ImageUploadMessageLink" href="#" onclick="WMU_toggleMainMesg(event);" >[<?= wfMsg( 'wmu-hide-message' ) ?>]</a></div>
<?php
	$uploadmesg = wfMsgExt( 'wmu-uploadtext', 'parse' );
	$uploadmesg = preg_replace( '/(<a[^>]+)/', '$1 target="_new" ', $uploadmesg );

?>

<table cellspacing="0" style="width: 100%;" id="ImageUploadInputTable">
	<tr id="ImageUploadTextCont">
		<td colspan="2">
			<div id="ImageUploadMessage"><?= $uploadmesg ?></div>
		</td>
	</tr>

	<tr id="ImageUploadUpload">
		<td><h1><?= wfMsg('wmu-upload') ?></h1></td>
		<td>
<?php
global $wgStylePath, $wgUser, $wgScriptPath, $wgEnableUploads, $wgDisableUploads;

// macbre: check wgDisableUploads too (RT #53714)
if (!$wgEnableUploads || !empty($wgDisableUploads)) {
	echo wfMsg( "wmu-uploaddisabled" );
} else if( !$wgUser->isAllowed( 'upload' ) ) {
	if( !$wgUser->isLoggedIn() ) {
		echo '<a id="ImageUploadLoginMsg">' .wfMsg( 'wmu-notlogged' ) . '</a>';
	} else {
		echo wfMsg( 'wmu-notallowed' );
	}
} else if( wfReadOnly() ) {
	echo wfMsg( 'wmu-readonly' );
} else {
	if ($error) {
		?>
			<span id="WMU_error_box"><?= $error ?></span>
			<?php
	}
	?>
			<form onsubmit="return AIM.submit(this, WMU_uploadCallback)" action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=WMU&method=uploadImage" id="ImageUploadForm" method="POST" enctype="multipart/form-data">
				<input id="ImageUploadFile" name="wpUploadFile" type="file" size="32" />
				<input type="submit" value="<?= wfMsg('wmu-upload-btn') ?>" onclick="return WMU_upload(event);" />
			</form>
	<?php
}
?>
		</td>
	</tr>
	<tr id="ImageUploadFind">
		<td><h1><?= wfMsg('wmu-find') ?></h1></td>
		<td>
<?php
// macbre: check wgDisableUploads too (RT #53714)
if( $wgUser->isLoggedIn() && $wgUser->isAllowed('upload') && $wgEnableUploads && empty($wgDisableUploads) && !wfReadOnly() ) {
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
			<img src="<?= $wgStylePath; ?>/common/images/ajax.gif" id="ImageUploadProgress2" style="visibility: hidden;"/>
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
