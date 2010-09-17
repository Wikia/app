<aside class="ThemeDesignerPicker" id="ThemeDesignerPicker">
	<div class="color">
		<h1>Pick a Color</h1>
		<ul class="swatches"></ul>
		<h1>Enter Your Own</h1>
		<form id="ColorNameForm" class="ColorNameForm">
			<input type="text" placeholder="Color name or Hex code" id="color-name" class="color-name">
			<input type="submit" value="Ok">
		</form>
	</div>
	<div class="image">
		<h1>Pick an Image</h1>
		<ul class="swatches">
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/oasis_swatch.jpg" data-image="/skins/oasis/images/themes/oasis.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/sapphire_swatch.jpg" data-image="/skins/oasis/images/themes/sapphire.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/sky_swatch.jpg" data-image="/skins/oasis/images/themes/sky.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/moonlight_swatch.jpg" data-image="/skins/oasis/images/themes/moonlight.jpg">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/opulence_swatch.jpg" data-image="/skins/oasis/images/themes/opulence.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/carbon_swatch.jpg" data-image="/skins/oasis/images/themes/carbon.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/beach_swatch.jpg" data-image="/skins/oasis/images/themes/beach.png">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/dragstrip_swatch.jpg" data-image="/skins/oasis/images/themes/dragstrip.jpg">
			</li>
			<li>
				<img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/aliencrate_swatch.jpg" data-image="/skins/oasis/images/themes/aliencrate.jpg">
			</li>
			<li class="no-image">
				Don't use a background
			</li>
		</ul>
		<h1>Upload Your Own</h1>

		<form id="BackgroundImageForm" class="BackgroundImageForm" onsubmit="return AIM.submit(this, ThemeDesigner.backgroundImageUploadCallback)" action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=moduleProxy&moduleName=ThemeDesigner&actionName=BackgroundImageUpload&outputType=html" method="POST" enctype="multipart/form-data">
			<input id="backgroundImageUploadFile" name="wpUploadFile" type="file">
			<input type="submit" value="Upload" onclick="return ThemeDesigner.backgroundImageUpload(event);">
			jpg, gif or png. 100k limit
		</form>

	</div>
</aside>