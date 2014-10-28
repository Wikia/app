<?php
/* @var $wikiData WikiDataModel */
?>

<header class="MainPageHeroHeader no-edit-state">
	<div id="MainPageHero" class="MainPageHero">
		<div class="image-wrap <?php if ( $wikiData->imageSet ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
			<div class="upload-mask"></div>
			<div class="overlay">
				<div class="overlay-flex">
					<span class="overlay-text sg-sub-title">drop an image here</span>
				</div>
			</div>
			<div class="upload-wrap">
				<div class="upload">
					<div class="upload-group">
						<div class="upload-btn">
							<img class="upload-icon" src="/extensions/wikia/NjordPrototype/images/addImage.svg">
							<span class="upload-text sg-main">add an cover image</span>
						</div>
						<div class="update-btn">
							<img class="upload-icon" src="/extensions/wikia/NjordPrototype/images/addImage.svg">
							<span class="update-text sg-main">update image</span>
						</div>
						<input name="file" type="file" hidden/>
						<span class="upload-desc sg-sub">or, drop an image here (1600x600px minimum)</span>
					</div>
				</div>
			</div>
			<div class="position-info">
				<div class="position-text sg-main">drag to reposition this image</div>
			</div>
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
				<span class="hero-title" contenteditable="true"><?= $wikiData->title ?></span>
				<div class="btn-bar">
					<div class="new-btn discard-btn sg-sub">Discard</div>
					<div class="new-btn save-btn sg-sub">Publish</div>
				</div>
			</div>
			<span class="title-text"><?= $wikiData->title ?></span>
			<span class="title-default-text">Wikia name can goes three lines (50 characters max)</span>
			<img class="title-edit-btn" src="/extensions/wikia/NjordPrototype/images/pencil.svg">
		</h1>
	</div>
	<div class="image-save-bar btn-bar <?php if ( $wikiData->imageSet ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
		<span class="save-text sg-main">Your cover image will be used to promote your page in search results and on other promotional areas.</span>
		<div class="new-btn discard-btn sg-sub">Discard</div>
		<div class="new-btn save-btn sg-sub">Publish</div>
	</div>
	<div class="hero-description <?php if ( isset( $wikiData->description ) ) : ?>filled-state<? else : ?>zero-state<?php endif; ?>">
		<div class="edit-box">
			<span class="edited-text sg-main" contenteditable="true"><?= $wikiData->description ?></span>
			<div class="btn-bar">
				<div class="new-btn discard-btn sg-sub">Cancel</div>
				<div class="new-btn save-btn sg-sub">Done</div>
			</div>
		</div>
		<span class="hero-description_text sg-main">
		<?php if ( isset( $wikiData->description ) ) { ?>
			<?= $wikiData->description; ?>
			<? } else { ?>Add a summary that will be used to
			promote your page in search results and on other promotional areas. (160 characters maximum)
		<? } ?>
		</span>
		<img class="edit-btn" src="/extensions/wikia/NjordPrototype/images/pencil_b.svg"/>
	</div>
</header>

