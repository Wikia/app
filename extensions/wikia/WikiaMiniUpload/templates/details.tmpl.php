<?php
global $wgExtensionsPath, $wgBlankImgUrl;
?>

<h1><?= wfMsg('wmu-upload-image') ?></h1>


<div class="ImageUploadLeft">
	<div id="ImageUploadThumb"><?= $props['file']->transform( array( 'width' => min( $props['file']->getWidth(), 400 ) ) )->toHTML() ?></div>


	<div class="details">
		<div class="ImageUploadLeftMask"></div>

		<div style="position: relative; z-index: 2">
			<label><?= wfMsg('wmu-caption') ?></label>
			<textarea id="ImageUploadCaption"><?= isset($props['default_caption']) ? $props['default_caption'] : '' ?></textarea>

			<a class="backbutton" href="#" style="display:none" ><?= wfMsg('wmu-back') ?></a>
			<input type="submit" value="<?= wfMsg('wmu-insert2') ?>" onclick="WMU_insertImage(event, 'details');" />
		</div>
	</div>
</div>


<div class="ImageUploadRight">
	<h2><?= wfMsg('wmu-appearance-in-article') ?></h2>


	<h3><?= wfMsg('wmu-layout') ?></h3>
	<span id="WMU_LayoutThumbBox">
		<input onclick="MWU_imageSizeChanged('thumb');" type="radio" name="fullthumb" id="ImageUploadThumbOption" checked=checked /> <label for="ImageUploadThumbOption" onclick="MWU_imageSizeChanged('thumb');"><?= wfMsg('wmu-thumbnail') ?></label>
	&nbsp;
	</span>
	<span id="WMU_LayoutFullBox">
		<input onclick="MWU_imageSizeChanged('full');" type="radio" name="fullthumb" id="ImageUploadFullOption" /> <label for="ImageUploadFullOption" onclick="MWU_imageSizeChanged('full');"><?= wfMsg('wmu-fullsize', $props['file']->width, $props['file']->height) ?></label>
	</span>



	<div id="ImageWidthRow">
		<input type="hidden" name="ImageUploadWidthCheckbox" id="ImageUploadWidthCheckbox" value="false">
		<div id="ImageUploadSlider">
			<img src="<?= $wgExtensionsPath.'/wikia/WikiaMiniUpload/images/slider_thumb_bg.png' ?>" id="ImageUploadSliderThumb" />
		</div>
		<span id="ImageUploadInputWidth">
			<input type="text" id="ImageUploadManualWidth" name="ImageUploadManualWidth" value="" onchange="WMU_manualWidthInput(this)" onkeyup="WMU_manualWidthInput(this)" /> px
		</span>
	</div>



	<div id="ImageLayoutRow">
		<h3><?= wfMsg('wmu-alignment') ?></h3>
		<input type="radio" id="ImageUploadLayoutLeft" name="layout" />
		<label for="ImageUploadLayoutLeft"><img src="<?= $wgExtensionsPath.'/wikia/WikiaMiniUpload/images/image_upload_left.png' ?>" /></label>

		<input type="radio" id="ImageUploadLayoutRight" name="layout" checked="checked" />
		<label for="ImageUploadLayoutRight"><img src="<?= $wgExtensionsPath.'/wikia/WikiaMiniUpload/images/image_upload_right.png' ?>" /></label>
	</div>





	<div id="ImageLinkRow">
		<h3><?= wfMsg('wmu-link') ?></h3>
		<input id="ImageUploadLink" type="text" />
	</div>

	<?
	if(isset($props['name'])) {
	?>

	<div class="advanced">
		<div id="NameRow">
			<h3><?= wfMsg('wmu-name') ?></h3>
			<input id="ImageUploadName" type="text" size="30" value="<?= $props['partname'] ?>" />
			<label for="ImageUploadName">.<?= $props['extension'] ?></label>
			<input id="ImageUploadExtension" type="hidden" value="<?= $props['extension'] ?>" />
			<input id="ImageUploadReplaceDefault" type="hidden" value="on" />
		</div>

		<div id="LicensingRow">
			<h3><?= wfMsg('wmu-licensing') ?></h3>
			<span id="ImageUploadLicenseSpan" >
			<?php
				$licenses = new Licenses(array('id' => 'ImageUploadLicense', 'name' => 'ImageUploadLicense', 'fieldname' => 'ImageUploadLicense'));
				echo $licenses->getInputHTML(null);
			?>
			</span>
			<div id="ImageUploadLicenseControl">
				<a id="ImageUploadLicenseLink" href="#" onclick="WMU_toggleLicenseMesg(event);" >[<?= wfMsg( 'wmu-hide-license-msg' ) ?>]</a>
			</div>
			<div id="ImageUploadLicenseTextWrapper">
				<div id="ImageUploadLicenseText">&nbsp;</div>
			</div>
		</div>
	</div>

	<img src="<?= $wgBlankImgUrl ?>" class="chevron"> <a href="#" id="WMU_showhide" class="show" data-more="<?= wfMsg('wmu-more-options') ?>" data-fewer="<?= wfMsg('wmu-fewer-options') ?>"><?= wfMsg('wmu-more-options') ?></a>

	<?
	} else if ( empty($props['default_caption'])) { ?>
		<input id="ImageUploadReplaceDefault" type="hidden" value="on" />
	<?
	} else {
	?>
	<h3><?= wfMsg('wmu-caption') ?></h3>
	<input id="ImageUploadReplaceDefault" type="checkbox"> <?= wfMsg('wmu-replace-default-caption') ?>
	<?
	}
	?>

	<input id="ImageUploadExtraId" type="hidden" value="<?= isset($props['extraId']) ? urlencode($props['extraId']) : '' ?>" />
	<input id="ImageUploadMWname" type="hidden" value="<?= urlencode($props['mwname']) ?>" />
	<input id="ImageUploadTempid" type="hidden" value="<?= isset($props['tempid']) ? $props['tempid'] : '' ?>" />
	<input id="ImageRealWidth" type="hidden" value="<?= $props['file']->getWidth() ?>" />
	<input id="ImageRealHeight" type="hidden" value="<?= $props['file']->getHeight() ?>" />


</div>
