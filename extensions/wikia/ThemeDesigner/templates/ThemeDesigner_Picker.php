<aside class="ThemeDesignerPicker" id="ThemeDesignerPicker">
	<div class="color">
		<h1><?= wfMsg('themedesigner-pick-a-color') ?></h1>
		<ul class="swatches"></ul>
		<h1><?= wfMsg('themedesigner-enter-your-own') ?></h1>
		<form id="ColorNameForm" class="ColorNameForm">
			<input type="text" placeholder="<?= wfMsg('themedesigner-color-name-or-hex-code') ?>" id="color-name" class="color-name">
			<input type="submit" value="<?= wfMsg('themedesigner-button-ok') ?>">
		</form>
	</div>
	<div class="image">
		<h1><?= wfMsg('themedesigner-pick-an-image') ?></h1>
		<ul class="swatches">
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/oasis_swatch.jpg" data-image="<?= $wgCdnStylePath ?>/skins/oasis/images/themes/oasis.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/sapphire_swatch.jpg" data-image="<?= $wgCdnStylePath ?>/skins/oasis/images/themes/sapphire.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/sky_swatch.jpg" data-image="<?= $wgCdnStylePath ?>/skins/oasis/images/themes/sky.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/moonlight_swatch.jpg" data-image="<?= $wgCdnStylePath ?>/skins/oasis/images/themes/moonlight.jpg">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/opulence_swatch.jpg" data-image="<?= $wgCdnStylePath ?>/skins/oasis/images/themes/opulence.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/carbon_swatch.jpg" data-image="<?= $wgCdnStylePath ?>/skins/oasis/images/themes/carbon.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/beach_swatch.jpg" data-image="<?= $wgCdnStylePath ?>/skins/oasis/images/themes/beach.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/dragstrip_swatch.jpg" data-image="<?= $wgCdnStylePath ?>/skins/oasis/images/themes/dragstrip.jpg">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/aliencrate_swatch.jpg" data-image="<?= $wgCdnStylePath ?>/skins/oasis/images/themes/aliencrate.jpg">
			</li>
			<li class="no-image">
				<?= wfMsg('themedesigner-dont-use-a-background') ?>
			</li>
		</ul>
		<h1><?= wfMsg('themedesigner-upload-your-own') ?></h1>

		<form id="BackgroundImageForm" class="BackgroundImageForm" onsubmit="return AIM.submit(this, ThemeDesigner.backgroundImageUploadCallback)" action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=moduleProxy&moduleName=ThemeDesigner&actionName=BackgroundImageUpload&outputType=html" method="POST" enctype="multipart/form-data">
			<input id="backgroundImageUploadFile" name="wpUploadFile" type="file">
			<input type="submit" value="<?= wfMsg('themedesigner-button-upload') ?>" onclick="return ThemeDesigner.backgroundImageUpload(event);">
			<?= wfMsg('themedesigner-rules-background') ?>
		</form>

	</div>
</aside>