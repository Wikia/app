<div style="position: absolute; z-index: 4; left: 0; width: 420px; height: 400px; background: #FFF; opacity: .9; filter: alpha(opacity=90);"></div>
<div id="VideoEmbedThumb" style="text-align: right; position: absolute; z-index: 1000; right: 15px; height: <?= isset($props['name']) ? '255' : '370' ?>px;">
<?= $props['code'] ?>
<div style="text-align: center;"><?= wfMsg( 'vet-preview' ) ?></div>
</div>
<?php
echo '<div style="position: relative; z-index: 5;">';
echo wfMsg('vet-details-inf2')
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
	<tr id="ImageWidthRow">
		<th><?= wfMsg('vet-width') ?></th>
		<td>
                        <div id="VideoEmbedSlider">
                                <img src="<?= $wgExtensionsPath.'/wikia/VideoEmbedTool/images/slider_thumb_bg.png' ?>" id="VideoEmbedSliderThumb" />
                        </div>

			<span id="VideoEmbedInputWidth">
				<input type="text" id="VideoEmbedManualWidth" name="VideoEmbedManualWidth" value="" onchange="VET_manualWidthInput(this)" onkeyup="VET_manualWidthInput(this)" /> px
			<span>
		</td>
	</tr>
	<tr id="ImageLayoutRow">
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
		<td>&nbsp;</td>
		<td>
			<input type="submit" value="<?= wfMsg('vet-update') ?>" onclick="VET_doEditVideo();" />
		</td>
	</tr>
</table>

<div id="VideoReplaceLink"><?= wfMsgExt('vet-video-replace-link', 'parse', $props['href']); ?></div>

<input id="VideoEmbedHref" type="hidden" value="<?= htmlspecialchars($props['href']) ?>" />
</div>
