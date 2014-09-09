<?php
/* @var $wikiData WikiDataModel */
?>

<header id="MainPageHero" class="MainPageHero">
	<div class="overlay"></div>
	<div class="upload">
		<div>Drag&drop image</div>
		<input name="file" type="file" hidden/>

		<div class="upload-btn new-btn">Upload image</div>
	</div>
	<picture>
		<img class="hero-image" src="<?= $wikiData->imagePath ?>" alt="<?= $wikiData->title ?>">
	</picture>
	<h1 class="hero-title"><?= $wikiData->title ?></h1>
	<span class="hero-description"><?= $wikiData->description ?></span>
	<section id="WikiaSearchHeader" class="WikiaSearchHeader">
		<?= F::app()->renderView( 'Search', 'Index', array( 'searchFormId' => 'WikiaSearch' ) ) ?>
	</section>
	<div class="edit-btn new-btn">edit</div>
</header>
