<div id="VideoEmbedSuccess" class="VideoEmbedSuccess">
<h1><?= wfMsg( 'vet-success' ) ?></h1>
<p><?= $message ?></p>
</div>
<div style="float:right;">
	<div id="VideoEmbedPageSuccess" style="display:none;"><?= $message ?></br><br/></div>
	<input type="button" value="<?= htmlspecialchars( $button_message ) ?>" id="VideoEmbedCloseButton" class="vet-close" />
	<div id="VideoEmbedCode" style="display: none;" ><?= $code ?></div>
	<input type="hidden" id="VideoEmbedTag" value="<?= htmlspecialchars( $tag ) ?>" />
</div>
