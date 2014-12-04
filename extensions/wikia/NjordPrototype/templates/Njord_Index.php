<?php
/* @var $wikiData WikiDataModel */
/* @var $isAllowedToEdit bool */
?>

<header class="MainPageHeroHeader no-edit-state">
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
							<img class="upload-icon" src="/extensions/wikia/NjordPrototype/images/addImage.svg">
							<span class="upload-text sg-main"><?= wfMessage('hero-image-add-image')->escaped(); ?></span>
						</div>
						<div class="update-btn">
							<img class="upload-icon" src="/extensions/wikia/NjordPrototype/images/addImage.svg">
							<span class="update-text sg-main"><?= wfMessage('hero-image-update-image')->escaped(); ?></span>
						</div>
						<input name="file" type="file" hidden/>
						<span class="upload-desc sg-sub"><?= wfMessage('hero-image-dd-image')->escaped(); ?></span>
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
						 data-fullpath="<?= $wikiData->originalImagePath ?>" src="<?= $wikiData->imagePath ?>"
						 alt="<?= $wikiData->title ?>">
				</picture>
			</div>
		</div>
		<h1 class="title-wrap sg-title <?php if ( isset( $wikiData->title ) ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
			<div class="edit-box">
				<div class="hero-title" contenteditable="true"><?= $wikiData->title ?></div>
				<div class="btn-bar">
					<div class="new-btn discard-btn sg-sub"><?= wfMessage('hero-image-discard-btn')->escaped(); ?></div>
					<div class="new-btn save-btn sg-sub"><?= wfMessage('hero-image-publish-btn')->escaped(); ?></div>
				</div>
			</div>
			<span class="title-text"><?= $wikiData->title ?></span>
			<span class="title-default-text"><?= wfMessage('hero-image-default-title')->escaped(); ?></span>
			<? if ($isAllowedToEdit): ?>
			<img class="title-edit-btn" src="/extensions/wikia/NjordPrototype/images/pencil.svg">
			<?endif;?>
		</h1>
	</div>
	<div class="image-save-bar btn-bar <?php if ( $wikiData->imageSet ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
		<span class="save-text sg-main"><?= wfMessage('hero-image-save-image')->escaped(); ?></span>
		<div class="new-btn discard-btn sg-sub"><?= wfMessage('hero-image-discard-btn')->escaped(); ?></div>
		<div class="new-btn save-btn sg-sub"><?= wfMessage('hero-image-publish-btn')->escaped(); ?></div>
	</div>
	<div class="hero-description <?php if ( isset( $wikiData->description ) ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
		<div class="edit-box">
			<span class="edited-text sg-main" contenteditable="true"><?= $wikiData->description ?></span>
			<div class="btn-bar">
				<div class="new-btn discard-btn sg-sub"><?= wfMessage('hero-image-discard-btn')->escaped(); ?></div>
				<div class="new-btn save-btn sg-sub"><?= wfMessage('hero-image-publish-btn')->escaped(); ?></div>
			</div>
		</div>
		<span class="hero-description-text sg-main">
		<?php if ( isset( $wikiData->description ) ) { ?>
			<?= $wikiData->description; ?>
		<? } ?>
		</span>
		<?php if ( !isset ( $wikiData->description ) ) { ?>
			<span class="hero-description-default-text sg-main"><?= wfMessage('hero-image-default-description')->escaped(); ?></span>
		<? } ?>
		<? if ($isAllowedToEdit): ?>
		<img class="edit-btn" src="/extensions/wikia/NjordPrototype/images/pencil_b.svg"/>
		<? endif; ?>
	</div>
	<div class="global-edit-wrap">
		<a href="<?= $editLink ?>" <?php if ( $editor == 2 ): ?>data-id="ve-edit" id="ca-ve-edit"<?php endif; ?>>
			<?php if ( !$source ) : ?>
				<img class="global-edit-btn" src="/extensions/wikia/NjordPrototype/images/pencil_b.svg"/>
			<?php endif; ?>
			<span class="edit-link sg-main" href=""><?= $name ?></span>
		</a>
	</div>
</header>

