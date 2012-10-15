<div id="VideoEmbedError"></div>
<?php
	$uploadmesg = wfMsgExt( 'vet-uploadtext', 'parse' );
	$uploadmesg = preg_replace( '/(<a[^>]+)/', '$1 target="_blank" ', $uploadmesg );
?>

<?php
	global $wgStylePath, $wgUser, $wgScript, $wgExtensionsPath;
?>

<h1 id="VideoEmbedTitle"><?= wfMsg( 'vet-title' ) ?></h1>
<section class="modalContent">
<p>
	<img src="<?= $wgStylePath; ?>/common/images/ajax.gif" id="VideoEmbedProgress2" style="visibility: hidden;"/>
	<form action="<?= $wgScript ?>?action=ajax&rs=VET&method=insertVideo" id="VideoEmbedForm" method="POST">
		<?php
	if( !$wgUser->isAllowed( 'upload' ) ) {
		if( !$wgUser->isLoggedIn() ) {
			echo '<a id="VideoEmbedLoginMsg">' .wfMsg( 'vet-notlogged' ) . '</a>';
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
			<input id="VideoEmbedUrl" name="wpVideoEmbedUrl" type="text" size="32" onkeypress="VET_onVideoEmbedUrlKeypress(event);" />

			<?php
	}
	?>
	<p><?= wfMsg( 'vet-description' ) ?> <a href="http://help.wikia.com/wiki/Help:Video_Embed_Tool" target="_blank"><?= wfMsg( 'vet-see-all' ) ?></a></p>
		<a id="VideoEmbedUrlSubmit" class="wikia-button" style="display: block; " onclick="return VET_preQuery(event);" ><?= wfMsg('vet-upload-btn') ?></a>
	</form>
</p>
</section>

<div id="VET_results_0">
	<?= $result ?>
</div>

<div id="VET_results_1" style="display: none;">
<br/><br/><br/><br/><br/>
	<div style="text-align: center;">
		<img src="<?= $wgExtensionsPath ?>/wikia/VideoEmbedTool/images/flickr_logo.gif" />
		<div class="VideoEmbedSourceNote"><?= wfMsg('vet-flickr-inf') ?></div>
	</div>
</div>