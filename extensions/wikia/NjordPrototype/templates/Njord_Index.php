<?php
/* @var $wikiData WikiDataModel */
?>

<header id="MainPageHero" class="MainPageHero">
	<div class="overlay">
		<div class="upload">
			<div>Drag&drop image</div>
			<input name="file" type="file" hidden/>

			<div class="upload-btn new-btn">Upload image</div>
		</div>
		<div class="btn-group">
			<div class="discard-btn new-btn">Discard</div>
			<div class="save-btn new-btn">Save changes</div>
		</div>
	</div>
	<picture>
		<img class="hero-image" data-cropposition="<?= $wikiData->cropPosition ?>" data-fullpath="<?= $wikiData->originalImagePath ?>" src="<?= $wikiData->imagePath ?>" alt="<?= $wikiData->title ?>">
	</picture>
	<h1 class="hero-title"><?= $wikiData->title ?></h1>
	<span class="hero-description"><?= $wikiData->description ?></span>
	<div class="edit-btn new-btn">edit</div>
</header>
