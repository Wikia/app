<?php
	/* @var $wikiData WikiDataModel */
?>

<header class="MainpageHero">
	<picture>
		<img src="<?=$wikiData->getImagePath() ?>" alt="<?= $wikiData->getTitle() ?>" >
	</picture>
	<h1 contenteditable="true"><?= $wikiData->getTitle() ?></h1>
	<span contenteditable="true" class="descrption"><?= $wikiData->getDescription() ?></span>
</header>
