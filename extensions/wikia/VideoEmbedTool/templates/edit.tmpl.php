<h1 id="VideoEmbedTitle2" ><?=wfMsg('vet-details-inf2') ?></h1>
<form class="VideoEmbedOptionsTable WikiaForm" id="VET-display-options-update">
<?php
global $wgExtensionsPath;
if('' == $props['oname']) {
?>
	<div id="VideoEmbedThumb">
		<?= $props['code'] ?>
		<p><?= wfMsg( 'vet-preview' ) ?></p>
	</div>
	<div class="preview-options">
		<div class="input-group" id="VideoEmbedNameRow">
			<label class="option-label" for="wpVideoEmbedName"><?= wfMsg( 'vet-name' ) ?></label>
			<div>
				<p><?= htmlspecialchars($props['vname']) ?></p>
			</div>
		</div>
	</div>
<?
}
?>
	<div class="preview-options">
		<div class="input-group" id="VideoEmbedSizeRow">
			<label class="option-label"><?= wfMsg('vet-style') ?></label>
			<div>
				<span id="VET_StyleThumb" class="selected">
					<input type="radio" id="VideoEmbedThumbOption" class="hidden" name="style" checked="checked" />
					<label for="VideoEmbedThumbOption" class="vet-style-label VideoEmbedThumbOption" title="<?= wfMsg( 'vet-thumbnail' ) ?>"><?= wfMsg( 'vet-thumbnail' ) ?></label>
				</span>
				<span id="VET_StyleNoThumb">
					<input type="radio" id="VideoEmbedNoThumbOption" class="hidden" name="style" />
					<label for="VideoEmbedNoThumbOption" class="vet-style-label VideoEmbedNoThumbOption" title="<?= wfMsg( 'vet-no-thumbnail' ) ?>"><?= wfMsg( 'vet-no-thumbnail' ) ?></label>
				</span>
				<input id="VideoEmbedCaption" type="text" placeholder="<?= wfMsg( 'vet-caption' ) ?>" class="show" />
				<p><?= wfMsg( 'vet-no-caption' ) ?></p>
			</div>
		</div>
		<div class="input-group" id="VideoEmbedWidthRow">
			<label class="option-label" for="VideoEmbedManualWidth"><?= wfMsg('vet-width') ?></label>
			<div>
				<div id="VideoEmbedSlider" class="WikiaSlider"></div>
				<span id="VideoEmbedInputWidth">
					<input type="text" id="VideoEmbedManualWidth" name="VideoEmbedManualWidth" value="" onchange="VET_manualWidthInput(this)" onkeyup="VET_manualWidthInput(this)" /> px
				</span>
			</div>
		</div>
		<div class="input-group" id="VideoEmbedLayoutRow">
			<label class="option-label"><?= wfMsg('vet-layout') ?></label>
			<div>
				<span id="VET_LayoutLeftBox">
					<input type="radio" id="VideoEmbedLayoutLeft" name="layout" class="hidden" onclick="VET_toggleSizing( true );" />
					<label for="VideoEmbedLayoutLeft" class="vet-layout-label VideoEmbedLayoutLeft" title="<?= wfMsg( 'vet-left' ) ?>"><?= wfMsg( 'vet-left' ) ?></label>
				</span>
				<span id="VET_LayoutCenterBox">
					<input type="radio" id="VideoEmbedLayoutCenter" name="layout" class="hidden" onclick="VET_toggleSizing( true );" />
					<label for="VideoEmbedLayoutCenter" class="vet-layout-label VideoEmbedLayoutCenter" title="<?= wfMsg( 'vet-center' ) ?>"><?= wfMsg( 'vet-center' ) ?></label>
				</span>
				<span id="VET_LayoutRightBox">
					<input type="radio" id="VideoEmbedLayoutRight" name="layout" class="hidden" onclick="VET_toggleSizing( true );" />
					<label for="VideoEmbedLayoutRight" class="vet-layout-label VideoEmbedLayoutRight" title="<?= wfMsg( 'vet-right' ) ?>"><?= wfMsg( 'vet-right' ) ?></label>
				</span>
				<span id="VET_LayoutGalleryBox" style="display:none">
					<input type="radio" id="VideoEmbedLayoutGallery" name="layout" onclick="VET_toggleSizing( false );" />
					<label for="VideoEmbedLayoutGallery"><img src="<?= $wgExtensionsPath.'/wikia/VideoEmbedTool/images/image_upload_gallery.png' ?>" alt="<?= wfMsg( 'vet-gallery' ) ?>" title="<?= wfMsg( 'vet-gallery' ) ?>" /></label>
				</span>
			</div>
		</div>
	</div>
	<div id="VideoReplaceLink"><?= wfMsgExt('vet-video-replace-link', 'parse', $props['href']); ?></div>
	<div class="input-group VideoEmbedNoBorder">
		<input class="wikia-button v-float-right" type="submit" value="<?= wfMsg('vet-update') ?>"/>
	</div>
	<input id="VideoEmbedHref" type="hidden" value="<?= htmlspecialchars($props['href']) ?>" />
</form>
