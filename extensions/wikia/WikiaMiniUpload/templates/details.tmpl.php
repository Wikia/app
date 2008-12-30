<?php
global $wgExtensionsPath;
if(isset($props['name'])) {
?>
<div id="ImageUploadSection">
	<?= wfMsg('wmu-details-inf') ?>
	<table class="ImageUploadOptionsTable" style="width: 100%;">
		<tr class="ImageUploadNoBorder">
			<th><?= wfMsg('wmu-name') ?></th>
			<td>
			<input id="ImageUploadName" type="text" size="30" value="<?= $props['partname'] ?>" />
			<label for="ImageUploadName">.<?= $props['extension'] ?></label>
			<input id="ImageUploadExtension" type="hidden" value="<?= $props['extension'] ?>" />
			</td>
		</tr>
		<?php
			if(!empty($props['upload'])) {
		?>
		<tr class="ImageUploadNoBorder ImageUploadThin">
			<th><?= wfMsg('license') ?></th>
			<td>
			<span id="ImageUploadLicenseSpan">
			<?php
				$licenses = new Licenses();
				$licensehtml = $licenses->getHtml();	
			?>
				<select name="ImageUploadLicense" id="ImageUploadLicense" onchange="WMU_licenseSelectorCheck()" />
					<option><?= wfMsg( 'nolicense' ) ?></option>
					<?= $licensehtml ?>
				</select>
			</span>
			</td>
		</tr>		
		<tr class="ImageUploadNoBorder ImageUploadNoSpace">
			<th>&nbsp;</th>	
			<td>
				<div id="ImageUploadLicenseControl"><a id="ImageUploadLicenseLink" href="#" onclick="WMU_toggleLicenseMesg(event);" >[<?= wfMsg( 'wmu-hide-license-msg' ) ?>]</a></div>
			</td>
		</tr>
		<tr class="ImageUploadNoBorder">
		<td colspan="2">
		<div id="ImageUploadLicenseText">&nbsp;</div>			
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
<?php
if($props['file']->media_type == 'BITMAP' || $props['file']->media_type == 'DRAWING') {
?>
<div style="position: absolute; z-index: 4; left: 0; width: 420px; height: 400px; background: #FFF; opacity: .9; filter: alpha(opacity=90);"></div>
<div id="ImageUploadThumb" style="text-align: right; position: absolute; z-index: 3; right: 15px; height: <?= isset($props['name']) ? '255' : '370' ?>px;"><?= $props['file']->getThumbnail(min($props['file']->getWidth(), 400))->toHTML() ?></div>
<?php
}
echo '<div style="position: relative; z-index: 5;">';
echo wfMsg('wmu-details-inf2')
?>
<table class="ImageUploadOptionsTable">
<?php
if($props['file']->media_type == 'BITMAP' || $props['file']->media_type == 'DRAWING') {
?>
	<tr>
		<th><?= wfMsg('wmu-size') ?></th>
		<td>
			<input onclick="MWU_imageSizeChanged('thumb');" type="radio" name="fullthumb" id="ImageUploadThumbOption" checked=checked /> <label for="ImageUploadThumbOption" onclick="MWU_imageSizeChanged('thumb');"><?= wfMsg('wmu-thumbnail') ?></label>
			&nbsp;
			<input onclick="MWU_imageSizeChanged('full');" type="radio" name="fullthumb" id="ImageUploadFullOption" /> <label for="ImageUploadFullOption" onclick="MWU_imageSizeChanged('full');"><?= wfMsg('wmu-fullsize', $props['file']->width, $props['file']->height) ?></label>
		</td>
	</tr>
	<tr id="ImageWidthRow">
		<th><?= wfMsg('wmu-width') ?></th>
		<td>
			<input onclick="MWU_imageWidthChanged(WMU_widthChanges++);" type="checkbox" id="ImageUploadWidthCheckbox" />
			<div id="ImageUploadSlider">
				<img src="<?= $wgExtensionsPath.'/wikia/WikiaMiniUpload/images/slider_thumb_bg.png' ?>" id="ImageUploadSliderThumb" />
			</div>
			<span id="ImageUploadInputWidth">
				<input type="text" id="ImageUploadManualWidth" name="ImageUploadManualWidth" value="" onchange="WMU_manualWidthInput(this)" onkeyup="WMU_manualWidthInput(this)" /> px
			<span>
		</td>
	</tr>
	<tr id="ImageLayoutRow">
		<th><?= wfMsg('wmu-layout') ?></th>
		<td>
			<input type="radio" id="ImageUploadLayoutLeft" name="layout" />
			<label for="ImageUploadLayoutLeft"><img src="<?= $wgExtensionsPath.'/wikia/WikiaMiniUpload/images/image_upload_left.png' ?>" /></label>
			<input type="radio" id="ImageUploadLayoutRight" name="layout" checked="checked" />
			<label for="ImageUploadLayoutRight"><img src="<?= $wgExtensionsPath.'/wikia/WikiaMiniUpload/images/image_upload_right.png' ?>" /></label>
		</td>
	</tr>
<?php
}
?>
	<tr>
		<th><?= wfMsg('wmu-caption') ?></th>
		<td><input id="ImageUploadCaption" type="text" /><?= wfMsg('wmu-optional') ?></td>
	</tr>
	<tr class="ImageUploadNoBorder">
		<td>&nbsp;</td>
		<td>
			<input type="submit" value="<?= wfMsg('wmu-insert2') ?>" onclick="WMU_insertImage(event, 'details');" />
		</td>
	</tr>
</table>
<input id="ImageUploadExtraId" type="hidden" value="<?= isset($props['extraId']) ? urlencode($props['extraId']) : '' ?>" />
<input id="ImageUploadMWname" type="hidden" value="<?= urlencode($props['mwname']) ?>" />
<input id="ImageRealWidth" type="hidden" value="<?= $props['file']->getWidth() ?>" />
<input id="ImageRealHeight" type="hidden" value="<?= $props['file']->getHeight() ?>" />
</div>
