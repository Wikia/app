<aside class="ThemeDesignerPicker" id="ThemeDesignerPicker">
	<div class="color">
		<h1><?= wfMessage( 'themedesigner-pick-a-color' )->escaped() ?></h1>
		<ul class="swatches"></ul>
		<h1><?= wfMessage( 'themedesigner-enter-your-own' )->escaped() ?></h1>
		<form id="ColorNameForm" class="ColorNameForm">
			<input type="text" placeholder="<?= wfMessage( 'themedesigner-color-name-or-hex-code' )->escaped() ?>" id="color-name"
				   class="color-name">
			<input type="submit" value="<?= wfMessage( 'themedesigner-button-ok' )->escaped() ?>">
		</form>
	</div>
	<div class="image">
		<h1><?= wfMessage( 'themedesigner-pick-an-image' )->escaped() ?></h1>
		<ul class="swatches">
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/pattern_dots_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/pattern_dots.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/pattern_flower_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/pattern_flower.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/pattern_steel_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/pattern_steel.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/pattern_straightdots_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/pattern_straightdots.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/opulence_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/opulence.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/oasis_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/oasis.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/babygirl_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/babygirl.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/carbon_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/carbon.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/rockgarden_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/rockgarden.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/creamsicle_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/creamsicle.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/plated_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/plated.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/police_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/police.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/aliencrate_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/aliencrate.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/sapphire_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/sapphire.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/sky_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/sky.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/moonlight_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/moonlight.jpg">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/beach_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/beach.png">
			</li>
			<li>
				<img src="<?= $wg->ExtensionsPath ?>/wikia/ThemeDesigner/images/dragstrip_swatch.jpg"
					 data-image="<?= $wg->ResourceBasePath ?>/skins/oasis/images/themes/dragstrip.jpg">
			</li>
			<li class="no-image">
				<?= wfMessage( 'themedesigner-dont-use-a-background' )->escaped() ?>
			</li>
		</ul>
		<?php if ( !empty( $wg->EnableUploads ) ) { ?>
			<h1><?= wfMessage( 'themedesigner-upload-your-own' )->escaped() ?></h1>

			<form id="BackgroundImageForm" class="BackgroundImageForm"
				  action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=BackgroundImageUpload&type=background&format=html"
				  method="POST" enctype="multipart/form-data">
				<input id="backgroundImageUploadFile" name="wpUploadFile" type="file">
				<input type="submit" value="<?= wfMessage( 'themedesigner-button-upload' )->escaped() ?>"
					   onclick="return ThemeDesigner.backgroundImageUpload(event);">
				<?= wfMessage( 'themedesigner-rules-background', UploadBackgroundFromFile::FILESIZE_LIMIT / 1024 )->escaped() ?>
			</form>
		<?php } ?>
	</div>
	<div class="community-header">
		<h1><?= wfMessage( 'themedesigner-pick-an-image' )->text() ?></h1>
		<ul class="swatches">
			<li class="no-image">
				<?= wfMessage( 'themedesigner-dont-use-a-background' )->text() ?>
			</li>
		</ul>
		<?php if ( !empty( $wg->EnableUploads ) ) { ?>
			<h1><?= wfMessage( 'themedesigner-upload-your-own' )->text() ?></h1>

			<form id="CommunityHeaderBackgroundImageForm" class="CommunityHeaderBackgroundImageForm"
				  action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=BackgroundImageUpload&type=community-header-background&format=html"
				  method="POST" enctype="multipart/form-data">
				<input id="CommunityHeaderBackgroundImageUploadFile" name="wpUploadFile" type="file">
				<input type="submit" value="<?= wfMessage( 'themedesigner-button-upload' )->text() ?>"
					   onclick="return ThemeDesigner.communityHeaderBackgroundImageUpload(event);">
				<?= wfMessage( 'themedesigner-rules-background', UploadBackgroundFromFile::FILESIZE_LIMIT / 1024 )->text() ?>
			</form>
		<?php } ?>
	</div>
</aside>
