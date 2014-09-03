<?php
	/* @var $wikiData WikiDataModel */
?>

<header id="MainPageHero" class="MainPageHero">
	<picture>
		<img src="<?=$wikiData->getImagePath() ?>" alt="<?= $wikiData->getTitle() ?>" >
	</picture>
	<h1 contenteditable="true"><?= $wikiData->getTitle() ?></h1>
	<span contenteditable="true" class="descrption"><?= $wikiData->getDescription() ?></span>
	<section id="WikiaSearchHeader" class="WikiaSearchHeader">
		<?=  F::app()->renderView('Search', 'Index', array('searchFormId' => 'WikiaSearch')) ?>
	</section>
</header>
