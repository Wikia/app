<h1><?=wfMsg('vet-details-about-video') ?></h2>
<form class="VideoEmbedOptionsTable WikiaForm" id="VET-display-options<? if( $screenType == 'edit' ){ ?>-update<? } ?>">

<?php
global $wgExtensionsPath;
?>
	<div id="VideoEmbedThumb">
		<?= $props['code'] ?>
		<p><?= wfMsg( 'vet-preview' ) ?></p>
	</div>
	<div class="preview-options">
		<div class="input-group" id="VideoEmbedNameRow">
			<label class="option-label" for="wpVideoEmbedName"><?= wfMsg( 'vet-name' ) ?></label>
			<div>
				<? if( $screenType == 'details' && empty($props['premiumVideo']) ): ?>
					<input type="text" id="VideoEmbedName" name="wpVideoEmbedName" value="<?= htmlspecialchars($props['vname']) ?>" />
				<? else: ?>
					<p><?= htmlspecialchars($props['vname']) ?></p>
					<input type="hidden" id="VideoEmbedName" name="wpVideoEmbedName" value="<?= htmlspecialchars($props['vname']) ?>" />
				<? endif; ?>
			</div>
		</div>
		<div class="input-group last" id="VideoEmbedDescriptionRow">
			<p class="hint"><?= wfMessage('vet-description-help-text') ?></p>
			<label class="option-label">Description:</label>
			<textarea id="VideoEmbedDescription" class="video-description" name="description" placeholder="<?= wfMessage('vet-description-placeholder') ?>"><?= htmlspecialchars(!empty($props['description']) ? $props['description'] : '') ?></textarea>
		</div>
	</div>

	<h2 class="main-header"><?=wfMsg('vet-details-inf2') ?></h2>

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
					<input type="text" id="VideoEmbedManualWidth" name="VideoEmbedManualWidth" value="" /> px
				</span>
			</div>
		</div>
		<div class="input-group last" id="VideoEmbedLayoutRow">
			<label class="option-label"><?= wfMsg('vet-layout') ?></label>
			<div>
				<span id="VET_LayoutLeftBox">
					<input type="radio" id="VideoEmbedLayoutLeft" name="layout" class="hidden" />
					<label for="VideoEmbedLayoutLeft" class="vet-layout-label VideoEmbedLayoutLeft" title="<?= wfMsg( 'vet-left' ) ?>"><?= wfMsg( 'vet-left' ) ?></label>
				</span>
				<span id="VET_LayoutCenterBox">
					<input type="radio" id="VideoEmbedLayoutCenter" name="layout" class="hidden" />
					<label for="VideoEmbedLayoutCenter" class="vet-layout-label VideoEmbedLayoutCenter" title="<?= wfMsg( 'vet-center' ) ?>"><?= wfMsg( 'vet-center' ) ?></label>
				</span>
				<span id="VET_LayoutRightBox" <? if($screenType == 'details') { ?>class="selected" <? } ?>>
					<input type="radio" id="VideoEmbedLayoutRight" name="layout" class="hidden" <? if($screenType == 'details') { ?>checked="checked" <? } ?> />
					<label for="VideoEmbedLayoutRight" class="vet-layout-label VideoEmbedLayoutRight" title="<?= wfMsg( 'vet-right' ) ?>"><?= wfMsg( 'vet-right' ) ?></label>
				</span>
				<span id="VET_LayoutGalleryBox" style="display:none">
					<input type="radio" id="VideoEmbedLayoutGallery" name="layout" />
					<label for="VideoEmbedLayoutGallery"><img src="<?= $wgExtensionsPath.'/wikia/VideoEmbedTool/images/image_upload_gallery.png' ?>" alt="<?= wfMsg( 'vet-gallery' ) ?>" title="<?= wfMsg( 'vet-gallery' ) ?>" /></label>
				</span>
			</div>
		</div>
	</div>
	<? if( $screenType == 'details' ): ?>
		<div class="input-group VideoEmbedNoBorder addVideoDetailsFormControls">
			<input class="wikia-button v-float-right" type="submit" value="<?= wfMsg('vet-insert2') ?>" />
		</div>
		<input id="VideoEmbedId" type="hidden" value="<?= isset($props['id']) ? urlencode($props['id']) : '' ?>" />
		<input id="VideoEmbedProvider" type="hidden" value="<?= urlencode($props['provider']) ?>" />
		<input id="VideoEmbedMetadata" type="hidden" value="<?= isset($props['metadata']) ? urlencode($props['metadata']) : '' ?>" />
	<? else: // $screenType == 'edit' ?>
		<div class="input-group VideoEmbedNoBorder">
			<input class="wikia-button v-float-right" type="submit" value="<?= wfMsg('vet-update') ?>"/>
		</div>
		<div id="VideoReplaceLink"><?= wfMsgExt('vet-video-replace-link', 'parse', $props['href']); ?></div>
		<input id="VideoEmbedHref" type="hidden" value="<?= htmlspecialchars($props['href']) ?>" />
	<? endif; ?>
</form>
