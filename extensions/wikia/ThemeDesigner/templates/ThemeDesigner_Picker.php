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
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/pattern_dots_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/pattern_dots.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/pattern_flower_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/pattern_flower.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/pattern_steel_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/pattern_steel.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/pattern_straightdots_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/pattern_straightdots.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/opulence_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/opulence.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/oasis_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/oasis.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/babygirl_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/babygirl.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/carbon_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/carbon.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/rockgarden_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/rockgarden.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/creamsicle_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/creamsicle.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/plated_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/plated.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/police_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/police.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/aliencrate_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/aliencrate.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/sapphire_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/sapphire.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/sky_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/sky.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/moonlight_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/moonlight.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/beach_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/beach.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/dragstrip_swatch.jpg" data-image="<?= $wg->CdnStylePath ?>/skins/oasis/images/themes/dragstrip.jpg">
			</li>
			<li class="no-image">
				<?= wfMsg('themedesigner-dont-use-a-background') ?>
			</li>
		</ul>
		<?php if ( !empty( $wg->EnableUploads ) ) { ?>
			<h1><?= wfMsg('themedesigner-upload-your-own') ?></h1>

			<form id="BackgroundImageForm" class="BackgroundImageForm" action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=BackgroundImageUpload" method="POST" enctype="multipart/form-data">
				<input id="backgroundImageUploadFile" name="wpUploadFile" type="file">
				<input type="submit" value="<?= wfMsg('themedesigner-button-upload') ?>" onclick="return ThemeDesigner.backgroundImageUpload(event);">
				<?= wfMsgExt('themedesigner-rules-background', array( 'parsemag' ), UploadBackgroundFromFile::FILESIZE_LIMIT / 1024 ) ?>
			</form>
		<?php } ?>
	</div>
</aside>
