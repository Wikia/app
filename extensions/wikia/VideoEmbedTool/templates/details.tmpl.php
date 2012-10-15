<div style="position: absolute; z-index: 4; left: 0; width: 420px; height: 400px;"></div>

<h1 id="VideoEmbedTitle2" ><?=wfMsg('vet-details-inf2') ?></h1>
<?php
echo '<div style="position: relative; z-index: 5;">';
?>
<table class="VideoEmbedOptionsTable">
<?php
global $wgExtensionsPath;
if('' == $props['oname']) {
?>

	<tr id="VideoEmbedNameRow">
		<th><?= wfMsg( 'vet-name' ) ?></th>
		<td>
			<input type="text" id="VideoEmbedName" name="wpVideoEmbedName" value="<?= htmlspecialchars($props['vname']) ?>" />
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
			<span id="VET_LayoutLeftBox">
			<input type="radio" id="VideoEmbedLayoutLeft" name="layout" onclick="VET_toggleSizing( true );" />
			<label for="VideoEmbedLayoutLeft"><img src="<?= $wgExtensionsPath.'/wikia/VideoEmbedTool/images/image_upload_left.png' ?>" alt="<?= wfMsg( 'vet-left' ) ?>" title="<?= wfMsg( 'vet-left' ) ?>" /></label>
			</span>
			<span id="VET_LayoutRightBox">
			<input type="radio" id="VideoEmbedLayoutRight" name="layout" checked="checked" onclick="VET_toggleSizing( true );" />
			<label for="VideoEmbedLayoutRight"><img src="<?= $wgExtensionsPath.'/wikia/VideoEmbedTool/images/image_upload_right.png' ?>" alt="<?=wfMsg( 'vet-right' ) ?>" title="<?= wfMsg( 'vet-right' ) ?>" /></label>
			</span>
			<span id="VET_LayoutGalleryBox" style="display:none">
			<input type="radio" id="VideoEmbedLayoutGallery" name="layout" onclick="VET_toggleSizing( false );" />
			<label for="VideoEmbedLayoutGallery"><img src="<?= $wgExtensionsPath.'/wikia/VideoEmbedTool/images/image_upload_gallery.png' ?>" alt="<?= wfMsg( 'vet-gallery' ) ?>" title="<?= wfMsg( 'vet-gallery' ) ?>" /></label>
			</span>
		</td>
	</tr>
	<tr id="VideoEmbedCaptionRow">
		<th><?= wfMsg('vet-caption') ?></th>
		<td><input id="VideoEmbedCaption" type="text" /><?= wfMsg('vet-optional') ?></td>
	</tr>
	<tr class="VideoEmbedNoBorder" style="padding: 0px" >
		<td colspan="3" style="padding: 10px 0px 0px 0px" >
			<input class="wikia-button" type="submit" style="float:right" value="<?= wfMsg('vet-insert2') ?>" onclick="VET_insertFinalVideo( event, 'details' );" />
		</td>
		
	</tr>
	
</table>
<input id="VideoEmbedId" type="hidden" value="<?= isset($props['id']) ? urlencode($props['id']) : '' ?>" />
<input id="VideoEmbedProvider" type="hidden" value="<?= urlencode($props['provider']) ?>" />
<input id="VideoEmbedOname" type="hidden" value="<?= urlencode($props['oname']) ?>" />
<input id="VideoEmbedMetadata" type="hidden" value="<?= isset($props['metadata']) ? urlencode($props['metadata']) : '' ?>" />
</div>
