<?php
global $wgExtensionsPath;
if(isset($props['name'])) {
?>
<div id="VideoEmbedSection">
	<?= wfMsg('vet-details-inf') ?>
	<table class="VideoEmbedOptionsTable" style="width: 100%;">
		<tr class="VideoEmbedNoBorder">
			<th><?= wfMsg('vet-name') ?></th>
			<td>
			<input id="VideoEmbedName" type="text" size="30" value="" />
			</td>
		</tr>
		<?php
			if(!empty($props['upload'])) {
		?>
		<tr class="VideoEmbedNoBorder VideoEmbedNoSpace">
			<th>&nbsp;</th>	
			<td>
				<div id="VideoEmbedLicenseControl"><a id="VideoEmbedLicenseLink" href="#" onclick="VET_toggleLicenseMesg(event);" >[<?= wfMsg( 'vet-hide-license-msg' ) ?>]</a></div>
			</td>
		</tr>
		<tr class="VideoEmbedNoBorder">
		<td colspan="2">
		<div id="VideoEmbedLicenseText">&nbsp;</div>			
		</td>
		</tr>
		<?php
			}
		?>

	</table>
</div>
<?php
}
?>
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
?>
	<tr>
		<th><?= wfMsg( 'vet-name' ) ?></th>
		<td>
			<input type="text" id="VideoEmbedName" name="wpVideoEmbedName" />
		</td>
	</tr>
	<tr>
		<th><?= wfMsg('vet-size') ?></th>
		<td>
			<input onclick="VET_imageSizeChanged('thumb');" type="checkbox" name="fullthumb" id="VideoEmbedThumbOption" checked=checked /> <label for="VideoEmbedThumbOption" onclick="VET_imageSizeChanged('thumb');"><?= wfMsg('vet-thumbnail') ?></label>
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
			<input type="radio" id="VideoEmbedLayoutLeft" name="layout" />
			<label for="VideoEmbedLayoutLeft"><img src="<?= $wgExtensionsPath.'/wikia/VideoEmbedTool/images/image_upload_left.png' ?>" /></label>
			<input type="radio" id="VideoEmbedLayoutRight" name="layout" checked="checked" />
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
			<input type="submit" value="<?= wfMsg('vet-insert2') ?>" onclick="VET_insertFinalVideo( event, 'details' );" />
		</td>
	</tr>
</table>
<input id="VideoEmbedId" type="hidden" value="<?= isset($props['id']) ? urlencode($props['id']) : '' ?>" />
<input id="VideoEmbedProvider" type="hidden" value="<?= urlencode($props['provider']) ?>" />
<input id="VideoEmbedMetadata" type="hidden" value="<?= isset($props['metadata']) ? urlencode($props['metadata']) : '' ?>" />

</div>
