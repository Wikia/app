<h1><?=wfMessage('vet-details-about-video') ?></h1>
<form class="WikiaForm" id="VET-display-options<? if( $screenType == 'edit' ){ ?>-update<? } ?>">

<?php
global $wgExtensionsPath;
?>
	<div id="VideoEmbedThumb" class="VideoEmbedThumb">
		<script type="text/javascript">
			// TODO: This doesn't seem to be the prescribed way to create a js global
			window.VETPlayerParams = <?= $props['code'] ?>;
		</script>
		<p><?= wfMessage( 'vet-preview' ) ?></p>
		<div class="video-embed"></div>
	</div>
	<div class="preview-options">
		<div class="input-group VideoEmbedNameRow" id="VideoEmbedNameRow">
			<label class="option-label" for="wpVideoEmbedName"><?= wfMessage( 'vet-name' ) ?></label>
			<div>
				<? if( $screenType == 'details' && empty($props['premiumVideo']) ): ?>
					<input type="text" id="VideoEmbedName" class="VideoEmbedName" name="wpVideoEmbedName" value="<?= htmlspecialchars($props['vname']) ?>" />
				<? else: ?>
					<p><?= htmlspecialchars($props['vname']) ?></p>
					<input type="hidden" id="VideoEmbedName" class="VideoEmbedName" name="wpVideoEmbedName" value="<?= htmlspecialchars($props['vname']) ?>" />
				<? endif; ?>
			</div>
		</div>
		<div class="input-group last" id="VideoEmbedDescriptionRow">
			<p class="hint"><?= wfMessage('vet-description-help-text') ?></p>
			<label class="option-label"><?= wfMessage('vet-description-label') ?></label>
			<textarea id="VideoEmbedDescription" class="video-description" name="description" placeholder="<?= wfMessage('vet-description-placeholder') ?>"><?= htmlspecialchars(!empty($props['description']) ? $props['description'] : '') ?></textarea>
		</div>
	</div>

	<h2 class="main-header"><?=wfMessage('vet-details-inf2') ?></h2>

	<div class="preview-options">
		<div class="input-group VideoEmbedSizeRow" id="VideoEmbedSizeRow">
			<label class="option-label"><?= wfMessage('vet-style') ?></label>
			<div>
				<span id="VET_StyleThumb" class="selected">
					<input type="radio" id="VideoEmbedThumbOption" class="hidden" name="style" checked="checked" />
					<label for="VideoEmbedThumbOption" class="vet-style-label VideoEmbedThumbOption" title="<?= wfMessage( 'vet-thumbnail' ) ?>"><?= wfMessage( 'vet-thumbnail' ) ?></label>
				</span>
				<span id="VET_StyleNoThumb">
					<input type="radio" id="VideoEmbedNoThumbOption" class="hidden" name="style" />
					<label for="VideoEmbedNoThumbOption" class="vet-style-label VideoEmbedNoThumbOption" title="<?= wfMessage( 'vet-no-thumbnail' ) ?>"><?= wfMessage( 'vet-no-thumbnail' ) ?></label>
				</span>
				<input id="VideoEmbedCaption" type="text" placeholder="<?= wfMessage( 'vet-caption' ) ?>" class="show VideoEmbedCaption" />
				<p><?= wfMessage( 'vet-no-caption' ) ?></p>
			</div>
		</div>
		<div class="input-group" id="VideoEmbedWidthRow">
			<label class="option-label" for="VideoEmbedManualWidth"><?= wfMessage('vet-width') ?></label>
			<div>
				<div id="VideoEmbedSlider" class="WikiaSlider"></div>
				<span id="VideoEmbedInputWidth" class="VideoEmbedInputWidth">
					<input type="text" id="VideoEmbedManualWidth" name="VideoEmbedManualWidth" value="" /> px
				</span>
			</div>
		</div>
		<div class="input-group last" id="VideoEmbedLayoutRow">
			<label class="option-label"><?= wfMessage('vet-layout') ?></label>
			<div>
				<span id="VET_LayoutLeftBox">
					<input type="radio" id="VideoEmbedLayoutLeft" name="layout" class="hidden" />
					<label for="VideoEmbedLayoutLeft" class="vet-layout-label VideoEmbedLayoutLeft" title="<?= wfMessage( 'vet-left' ) ?>"><?= wfMessage( 'vet-left' ) ?></label>
				</span>
				<span id="VET_LayoutCenterBox">
					<input type="radio" id="VideoEmbedLayoutCenter" name="layout" class="hidden" />
					<label for="VideoEmbedLayoutCenter" class="vet-layout-label VideoEmbedLayoutCenter" title="<?= wfMessage( 'vet-center' ) ?>"><?= wfMessage( 'vet-center' ) ?></label>
				</span>
				<span id="VET_LayoutRightBox" <? if($screenType == 'details') { ?>class="selected" <? } ?>>
					<input type="radio" id="VideoEmbedLayoutRight" name="layout" class="hidden" <? if($screenType == 'details') { ?>checked="checked" <? } ?> />
					<label for="VideoEmbedLayoutRight" class="vet-layout-label VideoEmbedLayoutRight" title="<?= wfMessage( 'vet-right' ) ?>"><?= wfMessage( 'vet-right' ) ?></label>
				</span>
				<span id="VET_LayoutGalleryBox" style="display:none">
					<input type="radio" id="VideoEmbedLayoutGallery" name="layout" />
					<label for="VideoEmbedLayoutGallery"><img src="<?= $wgExtensionsPath.'/wikia/VideoEmbedTool/images/image_upload_gallery.png' ?>" alt="<?= wfMessage( 'vet-gallery' ) ?>" title="<?= wfMessage( 'vet-gallery' ) ?>" /></label>
				</span>
			</div>
		</div>
	</div>
	<? if( $screenType == 'details' ): ?>
		<div class="input-group button-group addVideoDetailsFormControls">
			<? if ($showAddVideoBtn): ?>
				<input class="wikia-button v-float-right" type="submit" value="<?= wfMessage('vet-insert2')->text() ?>" />
			<? endif; ?>
		</div>
		<input id="VideoEmbedId" type="hidden" value="<?= isset($props['id']) ? urlencode($props['id']) : '' ?>" />
		<input id="VideoEmbedProvider" type="hidden" value="<?= urlencode($props['provider']) ?>" />
		<input id="VideoEmbedMetadata" type="hidden" value="<?= isset($props['metadata']) ? urlencode($props['metadata']) : '' ?>" />
	<? else: // $screenType == 'edit' ?>
		<div class="input-group button-group">
			<input class="wikia-button v-float-right" type="submit" value="<?= wfMessage('vet-update')->text() ?>"/>
		</div>
		<div id="VideoReplaceLink" class="VideoReplaceLink"><?= wfMessage('vet-video-replace-link', $props['href'])->parse(); ?></div>
		<input id="VideoEmbedHref" type="hidden" value="<?= htmlspecialchars($props['href']) ?>" />
	<? endif; ?>
</form>
