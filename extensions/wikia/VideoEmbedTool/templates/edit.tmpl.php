<?php
echo '<div style="position: relative; z-index: 5;">';
echo '<h1 id="VideoEmbedTitle">';
echo wfMsg('vet-details-inf2');
echo '</h1>';
?>
<table class="VideoEmbedOptionsTable">
<?php
global $wgExtensionsPath;
if('' == $props['oname']) {
?>

	<tr id="VideoEmbedNameRow">
		<th><?= wfMsg( 'vet-name' ) ?></th>
		<td>
			<?= htmlspecialchars($props['vname']) ?>
		</td>
		<td rowspan="5" >
			<div id="VideoEmbedThumb" style="text-align: right; right: 15px">
			<?= $props['code'] ?>
			<div style="text-align: center;"><?= wfMsg( 'vet-preview' ) ?></div>
			</div>
		</td>
	</tr>
<?
}
?>
	<tr id="VideoEmbedSizeRow">
		<th><?= wfMsg('vet-size') ?></th>
		<td>
			<input type="checkbox" name="fullthumb" id="VideoEmbedThumbOption" checked=checked /> <label for="VideoEmbedThumbOption" ><?= wfMsg('vet-thumbnail') ?></label>
			&nbsp;
		</td>
	</tr>
	<tr id="VideoEmbedWidthRow">
		<th><?= wfMsg('vet-width') ?></th>
		<td>
			<div id="VideoEmbedSlider" class="WikiaSlider"></div>
			<span id="VideoEmbedInputWidth">
				<input type="text" id="VideoEmbedManualWidth" name="VideoEmbedManualWidth" value="" onchange="VET_manualWidthInput(this)" onkeyup="VET_manualWidthInput(this)" /> px
			<span>
		</td>
	</tr>
	<tr id="VideoEmbedLayoutRow">
		<th><?= wfMsg('vet-layout') ?></th>
		<td>
			<input type="radio" id="VideoEmbedLayoutLeft" name="layout" onclick="VET_toggleSizing( true );" />
			<label for="VideoEmbedLayoutLeft"><img src="<?= $wgExtensionsPath.'/wikia/VideoEmbedTool/images/image_upload_left.png' ?>" /></label>
			<input type="radio" id="VideoEmbedLayoutRight" name="layout" checked="checked" onclick="VET_toggleSizing( true );" />
			<label for="VideoEmbedLayoutRight"><img src="<?= $wgExtensionsPath.'/wikia/VideoEmbedTool/images/image_upload_right.png' ?>" /></label>
		</td>
	</tr>
	<tr>
		<th><?= wfMsg('vet-caption') ?></th>
		<td><input id="VideoEmbedCaption" type="text" /><?= wfMsg('vet-optional') ?></td>
	</tr>
	<tr class="VideoEmbedNoBorder">
		<td colspan="3" style="padding: 5px 0px 0px 0px" >
			<div id="VideoReplaceLink"><?= wfMsgExt('vet-video-replace-link', 'parse', $props['href']); ?></div>
			<input class="wikia-button v-float-right" type="submit" value="<?= wfMsg('vet-update') ?>" onclick="VET_doEditVideo();" />
		</td>
	</tr>
</table>
<input id="VideoEmbedHref" type="hidden" value="<?= htmlspecialchars($props['href']) ?>" />
</div>
