<?php
	/* @var $wikiData WikiDataModel */
?>

<header class="MainpageHero">
	<picture>
		<source media="(min-width: 45em)" srcset="large.jpg">
		<source media="(min-width: 32em)" srcset="med.jpg">
		<img contenteditable="true" src="<?=$wikiData->getImagePath() ?>" alt="<?= $wikiData->getTitle() ?>" >
	</picture>
	<h1 contenteditable="true"><?= $wikiData->getTitle() ?></h1>
	<span contenteditable="true" class="descrption"><?= $wikiData->getDescription() ?></span>
</header>
