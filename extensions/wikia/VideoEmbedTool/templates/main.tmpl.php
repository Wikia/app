<div id="VideoEmbedError"></div>
<?php
	$uploadmesg = wfMsgExt( 'vet-uploadtext', 'parse' );
	$uploadmesg = preg_replace( '/(<a[^>]+)/', '$1 target="_blank" ', $uploadmesg );

?>

<table cellspacing="0" style="width: 100%;" id="VideoEmbedInputTable">
	<tr id="VideoEmbedTitle">
		<td colspan="2">
			<div id="VideoEmbedTitle"><h1><?= wfMsg( 'vet-title' ) ?></h1></div>
		</td>
	</tr>
<?php
	global $wgStylePath, $wgUser, $wgScriptPath, $wgExtensionsPath;
?>
	<tr id="VideoEmbedAdd">
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
					<form action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=VET&method=insertVideo" id="VideoEmbedForm" method="POST">
					<input id="VideoEmbedUrl" name="wpVideoEmbedUrl" type="text" size="32" />
					<input id="VideoEmbedUrlSubmit" type="submit" value="<?= wfMsg('vet-upload-btn') ?>" onclick="return VET_preQuery(event);" />
					</form>
					<?php
			}
?>
<div id="VideoEmbedMainMesg"><?= wfMsg( 'vet-main-info' ) ?></div>
</td>
<td id="VideoEmbedSupported" width="200">
<a href="http://www.youtube.com" class="image" title="YouTube" target="_blank"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/youtube.jpg" height="42" width="60" border="0"></a>
<a href="http://www.5min.com" class="image" title="5min" target="_blank"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/5min.gif" height="23" width="60" border="0"></a>
<a href="http://gamevideos.1up.com/" class="image" title="Gamevideos"  target="_blank"><img alt="Gamevideos" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/gamevideos.jpg" height="26" width="60" border="0"></a>
<a href="http://www.myvideo.de" class="image" title="Myvideo" target="_blank"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/myvideo.jpg" height="17" width="60" border="0"></a>
<a href="http://en.sevenload.com" class="image" title="Sevenload" target="_blank"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/sevenload.jpg" height="11" width="60" border="0"></a>
<a href="http://www.vimeo.com" class="image" title="Vimeo" target="_blank"><img alt="" src="<?= $wgExtensionsPath; ?>/wikia/VideoEmbedTool/images/vimeo.png" height="36" width="60" border="0"></a>
<a href="http://help.wikia.com/wiki/Help:Video_Embed_Tool" target="_blank"><?= wfMsg( 'vet-see-all' ) ?></a>
</td>
</tr>
</table>
<br/>
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
