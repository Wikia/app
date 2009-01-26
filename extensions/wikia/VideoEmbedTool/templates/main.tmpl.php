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
					<div id="VideoEmbedMainMesg"><?= wfMsg( 'vet-main-info' ) ?></div>
					</form>
					<?php
			}
?>
</td>
<td>
<?
if( ( $wgUser->isLoggedIn() ) && ( $wgUser->isAllowed( 'upload' ) ) ) {
	global $wgExtensionsPath;
?>
		</td>
<?php
}
	global $wgExtensionsPath;
?>
	</tr>
</table>

<div id="VET_results_0">
	<?= $result ?>
</div>
<div id="VideoEmbedSupported">
<?= wfMsg( 'vet-supported' ) ?>

<table class="gallery" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td><div class="gallerybox" style="width: 155px;">
			<div class="thumb" style="padding: 47px 0pt; width: 150px;"><div style="margin-left: auto; margin-right: auto; width: 120px;"><a href="" class="image" title="Gamevideos.jpg"><img alt="Gamevideos" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/gamevideos.jpg" height="51" width="120" border="0"></a></div></div>
			<div class="gallerytext">

			</div>
		</div></td>
		<td><div class="gallerybox" style="width: 155px;">
			<div class="thumb" style="padding: 49px 0pt; width: 150px;"><div style="margin-left: auto; margin-right: auto; width: 120px;"><a href="" class="image" title="5min.gif"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/5min.gif" height="47" width="120" border="0"></a></div></div>
			<div class="gallerytext">
			</div>
		</div></td>
		<td><div class="gallerybox" style="width: 155px;">
			<div class="thumb" style="padding: 30px 0pt; width: 150px;"><div style="margin-left: auto; margin-right: auto; width: 120px;"><a href="" class="image" title="YouTube.jpg"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/youtube.jpg" height="85" width="120" border="0"></a></div></div>
			<div class="gallerytext">
			</div>
		</div></td>
		<td><div class="gallerybox" style="width: 155px;">
			<div class="thumb" style="padding: 56px 0pt; width: 150px;"><div style="margin-left: auto; margin-right: auto; width: 120px;"><a href="" class="image" title="Metacafe.gif"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/metacafe.gif" height="33" width="120" border="0"></a></div></div>
			<div class="gallerytext">
			</div>
		</div></td>
	</tr>

	<tr>
		<td><div class="gallerybox" style="width: 155px;">
			<div class="thumb" style="padding: 62px 0pt; width: 150px;"><div style="margin-left: auto; margin-right: auto; width: 120px;"><a href="" class="image" title="Sevenload.jpg"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/sevenload.jpg" height="21" width="120" border="0"></a></div></div>
			<div class="gallerytext">
			</div>
		</div></td>
		<td><div class="gallerybox" style="width: 155px;">
			<div class="thumb" style="padding: 37px 0pt; width: 150px;"><div style="margin-left: auto; margin-right: auto; width: 120px;"><a href="" class="image" title="Vimeo.png"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/vimeo.png" height="72" width="120" border="0"></a></div></div>
			<div class="gallerytext">

			</div>
		</div></td>
		<td><div class="gallerybox" style="width: 155px;">
			<div class="thumb" style="padding: 55px 0pt; width: 150px;"><div style="margin-left: auto; margin-right: auto; width: 120px;"><a href="" class="image" title="Myvideo.jpg"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/myvideo.jpg" height="35" width="120" border="0"></a></div></div>
			<div class="gallerytext">
			</div>
		</div></td>
	</tr>
</tbody></table>
</div>

<div id="VET_results_1" style="display: none;">
<br/><br/><br/><br/><br/>
	<div style="text-align: center;">
		<img src="<?= $wgStylePath ?>/../extensions/wikia/VideoEmbedTool/images/flickr_logo.gif" />
		<div class="VideoEmbedSourceNote"><?= wfMsg('vet-flickr-inf') ?></div>
	</div>
</div>
