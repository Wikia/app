<?
/**
 * @var $showAddVideoBtn Boolean
 * @var $screenType String
 * @var $props Array
 */
?>
<h1><?=wfMessage('vet-details-about-video')->parse() ?></h1>
<form class="WikiaForm" id="VET-display-options<? if( $screenType == 'edit' ){ ?>-update<? } ?>">
	<div id="VideoEmbedThumb" class="VideoEmbedThumb">
		<script type="text/javascript">
			// TODO: This doesn't seem to be the prescribed way to create a js global
			window.VETPlayerParams = <?= $props['code'] ?>;
		</script>
		<p><?= wfMessage( 'vet-preview' )->parse() ?></p>
		<div class="video-embed"></div>
	</div>
	<div class="preview-options">
		<div class="input-group VideoEmbedNameRow" id="VideoEmbedNameRow">
			<label class="option-label" for="wpVideoEmbedName"><?= wfMessage( 'vet-name' )->parse() ?></label>
			<div>
				<? if( $screenType == 'details' && $props['provider'] != 'FILE' ): ?>
					<input type="text" id="VideoEmbedName" class="VideoEmbedName" name="wpVideoEmbedName" value="<?= htmlspecialchars($props['vname']) ?>" />
				<? else: ?>
					<p><?= htmlspecialchars($props['vname']) ?></p>
					<input type="hidden" id="VideoEmbedName" class="VideoEmbedName" name="wpVideoEmbedName" value="<?= htmlspecialchars($props['vname']) ?>" />
				<? endif; ?>
			</div>
		</div>
		<div class="input-group last" id="VideoEmbedDescriptionRow">
			<p class="hint"><?= wfMessage('vet-description-help-text')->parse() ?></p>
			<label class="option-label"><?= wfMessage('vet-description-label')->parse() ?></label>
			<textarea id="VideoEmbedDescription" class="video-description" name="description" placeholder="<?= wfMessage('vet-description-placeholder')->parse() ?>"><?= htmlspecialchars(!empty($props['description']) ? $props['description'] : '') ?></textarea>
		</div>
	</div>

	<h2 class="main-header"><?=wfMessage('vet-details-inf2')->parse() ?></h2>

	<div class="preview-options">
		<div class="input-group VideoEmbedSizeRow" id="VideoEmbedSizeRow">
			<label class="option-label"><?= wfMessage('vet-style')->parse() ?></label>
			<input id="VideoEmbedCaption" type="text" placeholder="<?= wfMessage( 'vet-caption' )->parse() ?>" class="VideoEmbedCaption" />
		</div>
		<div class="input-group" id="VideoEmbedWidthRow">
			<label class="option-label" for="VideoEmbedManualWidth"><?= wfMessage('vet-width')->parse() ?></label>
			<div>
				<div id="VideoEmbedSlider" class="WikiaSlider"></div>
				<span id="VideoEmbedInputWidth" class="VideoEmbedInputWidth">
					<input type="text" id="VideoEmbedManualWidth" name="VideoEmbedManualWidth" value="" /> px
				</span>
			</div>
		</div>
		<div class="input-group last" id="VideoEmbedLayoutRow">
			<label class="option-label"><?= wfMessage('vet-layout')->parse() ?></label>
			<div>
				<span id="VET_LayoutLeftBox">
					<input type="radio" id="VideoEmbedLayoutLeft" name="layout" class="hidden" />
					<label for="VideoEmbedLayoutLeft" class="vet-layout-label VideoEmbedLayoutLeft" title="<?= wfMessage( 'vet-left' )->parse() ?>"><?= wfMessage( 'vet-left' )->parse() ?></label>
				</span>
				<span id="VET_LayoutCenterBox">
					<input type="radio" id="VideoEmbedLayoutCenter" name="layout" class="hidden" />
					<label for="VideoEmbedLayoutCenter" class="vet-layout-label VideoEmbedLayoutCenter" title="<?= wfMessage( 'vet-center' )->parse() ?>"><?= wfMessage( 'vet-center' )->parse() ?></label>
				</span>
				<span id="VET_LayoutRightBox" <? if($screenType == 'details') { ?>class="selected" <? } ?>>
					<input type="radio" id="VideoEmbedLayoutRight" name="layout" class="hidden" <? if($screenType == 'details') { ?>checked="checked" <? } ?> />
					<label for="VideoEmbedLayoutRight" class="vet-layout-label VideoEmbedLayoutRight" title="<?= wfMessage( 'vet-right' )->parse() ?>"><?= wfMessage( 'vet-right' )->parse() ?></label>
				</span>
			</div>
		</div>
	</div>
	<? if( $screenType == 'details' ): ?>
		<div class="input-group button-group addVideoDetailsFormControls">
			<? if ($showAddVideoBtn): ?>
				<input class="wikia-button v-float-right" type="submit" value="<?= wfMessage('vet-insert2')->parse() ?>" />
			<? endif; ?>
		</div>
		<input id="VideoEmbedId" type="hidden" value="<?= isset($props['id']) ? urlencode($props['id']) : '' ?>" />
		<input id="VideoEmbedProvider" type="hidden" value="<?= urlencode($props['provider']) ?>" />
		<input id="VideoEmbedMetadata" type="hidden" value="<?= isset($props['metadata']) ? urlencode($props['metadata']) : '' ?>" />
	<? else: // $screenType == 'edit' ?>
		<div class="input-group button-group">
			<input class="wikia-button v-float-right" type="submit" value="<?= wfMessage('vet-update')->parse() ?>"/>
		</div>
		<div id="VideoReplaceLink" class="VideoReplaceLink"><?= wfMessage('vet-video-replace-link', $props['href'])->parse(); ?></div>
		<input id="VideoEmbedHref" type="hidden" value="<?= htmlspecialchars($props['href']) ?>" />
	<? endif; ?>
</form>
