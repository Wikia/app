<div id="VideoEmbedSuccess">
<?= wfMsg( 'vet-success' ) ?>
<?= $message ?>
</div>
<div style="text-align: center;">
	<div id="VideoEmbedPageSuccess" style="display:none;"><?= $message ?></br><br/></div>
	<input onclick="VET_close(event);" type="button" value="<?= wfMsg( 'vet-return' ) ?>" />
	<div id="VideoEmbedCode" style="display: none;" ><?= $code ?></div>
	<input type="hidden" id="VideoEmbedTag" value="<?= htmlspecialchars( $tag ) ?>" />
</div>
