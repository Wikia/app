<section id="CustomizeTab" class="CustomizeTab">
	<fieldset>
		<h1><?= wfMessage('themedesigner-background')->plain() ?></h1>
		<ul>
			<li>
				<h2><?= wfMsg('themedesigner-color') ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-body" id="swatch-color-background">
				<? if ($wg->OasisResponsive) : ?>
					<div class="wrap-middle-color">
						<input type="checkbox" id="color-body-middle" />
						<label for="color-body-middle"><?= wfMessage('themedesigner-color-middle')->plain() ?></label>
						<img src="<?= $wg->BlankImgUrl ?>" class="color-body-middle" id="swatch-color-background-middle">
					</div>
				<? endif ?>
			</li>
			<li class="background">
				<h2><?= wfMessage('themedesigner-graphic')->plain() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="background-image" id="swatch-image-background">
				<input type="checkbox" id="tile-background"> <label for="tile-background"><?= wfMessage('themedesigner-tile-background')->plain() ?></label>
				<input type="checkbox" id="fix-background"> <label for="fix-background"><?= wfMessage('themedesigner-fix-background')->plain() ?></label>
				<? if ($wg->OasisResponsive) : ?>
					<input type="checkbox" id="dynamic-background"> <label for="dynamic-background"><?= wfMessage('themedesigner-dynamic-background')->plain() ?></label>
					<span class="form-questionmark" rel="tooltip" title="<?= wfMessage('themedesigner-rules-dynamic-background')->plain() ?>"></span>
				<? endif ?>
			</li>
		</ul>
	</fieldset>
	<fieldset class="page">
		<h1><?= wfMessage('themedesigner-page')->plain() ?></h1>
		<ul>
			<li>
				<h2><?= wfMessage('themedesigner-buttons')->plain() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-buttons" id="swatch-color-buttons">
			</li>
			<li>
				<h2><?= wfMessage('themedesigner-links')->plain() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-links" id="swatch-color-links">
			</li>
			<li>
				<h2><?= wfMessage('themedesigner-header')->plain() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-header" id="swatch-color-header">
			</li>
			<li>
				<h2><?= wfMessage('themedesigner-color')->plain() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-page" id="swatch-color-page">
				<h2><?= wfMessage('themedesigner-transparency')->plain() ?></h2>
				<div id="OpacitySlider" class="WikiaSlider OpacitySlider"></div>
			</li>
		</ul>
	</fieldset>
</section>
