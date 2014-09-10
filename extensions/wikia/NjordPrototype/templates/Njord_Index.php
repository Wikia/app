<?php
/* @var $wikiData WikiDataModel */
?>

<header id="MainPageHero" class="MainPageHero">
	<div class="edit-area">
		<div class="overlay">
			<div class="upload">
				<div class="upload-mask"></div>
				<input name="file" type="file" hidden/>

				<div class="upload-group">
					<div class="upload-text">Drag&drop image</div>
					<div class="upload-btn new-btn">Upload image</div>
				</div>
				<div class="btn-group-top">
					<div class="toggle-upload-btn new-btn">X</div>
				</div>
			</div>
		</div>
		<div class="btn-group-top toggle-btn">
			<div class="toggle-upload-btn new-btn">Upload</div>
		</div>
		<div class="btn-group-bottom">
			<div class="discard-btn new-btn">Discard</div>
			<div class="save-btn new-btn">Save changes</div>
		</div>
	</div>
	<picture>
		<img class="hero-image" data-cropposition="<?= $wikiData->cropPosition ?>"
			 data-fullpath="<?= $wikiData->originalImagePath ?>" src="<?= $wikiData->imagePath ?>"
			 alt="<?= $wikiData->title ?>">
	</picture>
	<h1 class="hero-title"><?= $wikiData->title ?></h1>
	<span class="hero-description"><?= $wikiData->description ?></span>

	<div class="edit-btn new-btn">edit</div>
</header>
