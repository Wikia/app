<?= wfMsg('wmu-success') ?>
<div style="text-align: center;">
	<div id="ImageUploadDisplayedTag" style="border-bottom: 1px solid #CCC; padding: 15px 0; margin: 15px;"><?= $tag ?></div>
	<input onclick="WMU_close(event);" type="button" value="<?= wfMsg('wmu-return') ?>" />
	<input type="hidden" id="ImageUploadTag" value="<?= htmlspecialchars( $tag ) ?>" />
</div>
