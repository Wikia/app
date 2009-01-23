<div id="VideoEmbedError"></div>
<?php
	$uploadmesg = wfMsgExt( 'vet-uploadtext', 'parse' );
	$uploadmesg = preg_replace( '/(<a[^>]+)/', '$1 target="_new" ', $uploadmesg );

?>

<table cellspacing="0" style="width: 100%;" id="VideoEmbedInputTable">
	<tr id="VideoEmbedTitle">
		<td colspan="2">
			<div id="VideoEmbedTitle"><h1><?= wfMsg( 'vet-title' ) ?></h1></div>
		</td>
	</tr>
<?php
	global $wgStylePath, $wgUser, $wgScriptPath;
?>
	<tr id="VideoEmbedSearch">
		<td>
			<img src="<?= $wgStylePath; ?>/monaco/images/widget_loading.gif" id="VideoEmbedProgress2" style="visibility: hidden;"/>
			<?php
			if( !$wgUser->isAllowed( 'upload' ) ) {
				if( !$wgUser->isLoggedIn() ) {
					echo wfMsg( 'vet-notlogged' );
				} else {
					echo wfMsg( 'vet-notallowed' ); 
				}
			} else {
				if ($error) {
					?>
						<span id="VET_error_box"><?= $error ?></span>
						<?php
				}
				?>
					<form onsubmit="return AIM.submit(this, VET_uploadCallback)" action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=VET&method=insertVideo" id="VideoEmbedForm" method="POST" enctype="multipart/form-data">
					<label for="VideoEmbedUrl"><?= wfMsg('vet-upload') ?></label><input id="VideoEmbedUrl" name="wpVideoEmbedUrl" type="text" size="32" />
					<input type="submit" value="<?= wfMsg('vet-upload-btn') ?>" onclick="return VET_upload(event);" />
					</form>
					<?php
			}
?>
</td>
<td>
<?php

if( ( $wgUser->isLoggedIn() ) && ( $wgUser->isAllowed( 'upload' ) ) ) {
?>
			<div id="VideoEmbedSupported">
				<?= wfMsg( 'vet-supported' ) ?>
			</div>
		</td>
<?php
}
?>
	</tr>
</table>

<div id="VET_results_0">
	<?= $result ?>
</div>

<div id="VET_results_1" style="display: none;">
	<br/><br/><br/><br/><br/>
	<div style="text-align: center;">
		<img src="<?= $wgStylePath ?>/../extensions/wikia/VideoEmbedTool/images/flickr_logo.gif" />
		<div class="VideoEmbedSourceNote"><?= wfMsg('vet-flickr-inf') ?></div>
	</div>
</div>
