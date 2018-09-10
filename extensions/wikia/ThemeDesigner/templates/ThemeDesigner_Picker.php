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
			<?php foreach (ThemeDesignerBackgroundAssets::$backgrounds as $bg) { ?>
				<li>
					<img src="<?= $wg->ExtensionsPath . $bg['thumbnail'] ?>"
					     data-image="<?= $wg->ResourceBasePath . $bg['source'] ?>">
				</li>
			<?php } ?>
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
