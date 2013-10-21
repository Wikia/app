<section id="CustomizeTab" class="CustomizeTab">
	<fieldset>
		<h1><?= wfMsg('themedesigner-background') ?></h1>
		<ul>
			<li>
				<h2><?= wfMsg('themedesigner-color') ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-body" id="swatch-color-background">
			</li>
			<li class="background">
				<h2><?= wfMsg('themedesigner-graphic') ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="background-image" id="swatch-image-background">
				<input type="checkbox" id="tile-background"> <label for="tile-background"><?= wfMessage('themedesigner-tile-background')->plain() ?></label>
				<input type="checkbox" id="fix-background"> <label for="fix-background"><?= wfMessage('themedesigner-fix-background')->plain() ?></label>
				<input type="checkbox" id="dynamic-background"> <label for="dynamic-background"><?= wfMessage('themedesigner-dynamic-background')->plain() ?></label>
			</li>
		</ul>
	</fieldset>
	<fieldset class="page">
		<h1><?= wfMsg('themedesigner-page') ?></h1>
		<ul>
			<li>
				<h2><?= wfMsg('themedesigner-buttons') ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-buttons" id="swatch-color-buttons">
			</li>
			<li>
				<h2><?= wfMsg('themedesigner-links') ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-links" id="swatch-color-links">
			</li>
			<li>
				<h2><?= wfMsg('themedesigner-header') ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-header" id="swatch-color-header">
			</li>
			<li>
				<h2><?= wfMsg('themedesigner-color') ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-page" id="swatch-color-page">
				<h2><?= wfMsg('themedesigner-transparency') ?></h2>
				<div id="OpacitySlider" class="WikiaSlider OpacitySlider"></div>
			</li>
		</ul>
	</fieldset>
</section>