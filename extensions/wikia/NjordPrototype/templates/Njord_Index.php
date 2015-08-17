<?php
/* @var $wikiData WikiDataModel */
/* @var $isAllowedToEdit bool */
?>

<div class="MainPageHeroHeader hero-image-wrapper no-edit-state">
	<div id="MainPageHero" class="MainPageHero">
		<div class="image-wrap <?php if ( $wikiData->imageSet ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
			<? if ($isAllowedToEdit): ?>
				<div class="upload-mask"></div>
				<div class="overlay">
					<div class="overlay-flex">
						<span class="overlay-text sg-sub-title"><?= wfMessage('hero-image-drop-here')->escaped(); ?></span>
					</div>
				</div>
				<div class="upload-wrap">
					<div class="upload">
						<div class="upload-group">
							<div class="upload-btn">
								<span class="upload-text sg-main"><?= wfMessage('hero-image-add-image')->escaped(); ?></span>
								<span class="upload-icon venus-icon venus-icon-upload-image"></span>
							</div>
							<div class="update-btn">
								<span class="update-text sg-main"><?= wfMessage('hero-image-update-image')->escaped(); ?></span>
								<span class="upload-icon venus-icon venus-icon-upload-image"></span>
							</div>
							<input name="file" type="file" hidden/>
						</div>
					</div>
				</div>
				<div class="position-info">
					<div class="position-text sg-main"><?= wfMessage('hero-image-position-image')->escaped(); ?></div>
				</div>
			<? endif; //isAlloweToEdit ?>
			<div class="image-window">
				<picture>
					<img class="hero-image" data-cropposition="<?= $wikiData->cropPosition ?>"
					     data-fullpath="<?= htmlspecialchars( $wikiData->originalImagePath ) ?>" src="<?= htmlspecialchars( $wikiData->imagePath ) ?>"
					     alt="<?= htmlspecialchars( $wikiData->title ) ?>">
				</picture>
			</div>
		</div>
	</div>
	<div class="image-save-bar btn-bar <?php if ( $wikiData->imageSet ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
		<span class="save-text sg-main"><?= wfMessage('hero-image-save-image')->escaped(); ?></span>
		<div class="new-btn discard-btn sg-sub"><?= wfMessage('hero-image-discard-btn')->escaped(); ?></div>
		<div class="new-btn save-btn sg-sub"><?= wfMessage('hero-image-publish-btn')->escaped(); ?></div>
	</div>
</div>
