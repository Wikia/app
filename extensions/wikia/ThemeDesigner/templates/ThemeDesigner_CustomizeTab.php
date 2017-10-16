<section id="CustomizeTab" class="CustomizeTab">
	<fieldset class="background">
		<h1><?= wfMessage( 'themedesigner-background' )->escaped() ?></h1>
		<ul>
			<li class="wrap-color">
				<h2><?= wfMessage( 'themedesigner-color' )->escaped() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-body" id="swatch-color-background">
			</li>
			<? //TODO: Remove this after global release of responsive layout  ?>
			<? if ( $wg->OasisResponsive ) : ?>
				<li class="wrap-middle-color">
					<h2><?= wfMessage( 'themedesigner-color-middle' )->escaped() ?></h2>
					<img src="<?= $wg->BlankImgUrl ?>" class="color-body-middle" id="swatch-color-background-middle">
					<div class="middle-color-mask"></div>
				</li>
			<? endif ?>
			<li class="wrap-background">
				<h2><?= wfMessage( 'themedesigner-graphic' )->escaped() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="background-image" id="swatch-image-background">
				<label for="tile-background">
					<input type="checkbox" id="tile-background">
					<?= wfMessage( 'themedesigner-tile-background' )->escaped() ?>
				</label>
				<label for="fix-background">
					<input type="checkbox" id="fix-background">
					<?= wfMessage( 'themedesigner-fix-background' )->escaped() ?>
				</label>
				<? //TODO: Remove this after global release of responsive layout  ?>
				<? if ( $wg->OasisResponsive ) : ?>
					<span class="not-split-option">
						<label for="not-split-background">
							<input type="checkbox" id="not-split-background">
							<?= wfMessage( 'themedesigner-not-split-background' )->escaped() ?>
						</label>
						<span class="form-questionmark" rel="tooltip"
							  title="<?= wfMessage( 'themedesigner-rules-not-split-background', ThemeSettings::MIN_WIDTH_FOR_NO_SPLIT )->parse() ?>"></span>
					</span>
				<? endif ?>
			</li>
			<li class="wrap-background">
				<h2><?= wfMessage( 'themedesigner-community-header-graphic' )->escaped() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="community-header-background-image" id="swatch-community-header-image-background">
				<div class="community-header-size-text">
					<?= ThemeSettings::COMMUNITY_HEADER_BACKGROUND_WIDTH ?>px x
					<?= ThemeSettings::COMMUNITY_HEADER_BACKGROUND_HEIGHT ?>px
				</div>
			</li>
		</ul>
	</fieldset>
	<fieldset class="page">
		<h1><?= wfMessage( 'themedesigner-page' )->escaped() ?></h1>
		<ul>
			<li>
				<h2><?= wfMessage( 'themedesigner-community-header-color' )->escaped() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-community-header" id="swatch-color-community-header">
			</li>
			<li>
				<h2><?= wfMessage( 'themedesigner-buttons' )->escaped() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-buttons" id="swatch-color-buttons">
			</li>
			<li>
				<h2><?= wfMessage( 'themedesigner-links' )->escaped() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-links" id="swatch-color-links">
			</li>
			<li>
				<h2><?= wfMessage( 'themedesigner-toolbar-color' )->escaped() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-header" id="swatch-color-header">
			</li>
			<li>
				<h2><?= wfMessage( 'themedesigner-color' )->escaped() ?></h2>
				<img src="<?= $wg->BlankImgUrl ?>" class="color-page" id="swatch-color-page">
				<h2><?= wfMessage( 'themedesigner-transparency' )->escaped() ?></h2>
				<div id="OpacitySlider" class="WikiaSlider OpacitySlider"></div>
			</li>
		</ul>
	</fieldset>
</section>
