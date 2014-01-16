<section class="grid-2 wikiahomepage-hubs-section <?= $classname ?>">
	<?php if(!empty($herourl )): ?>
		<h2><a href="<?= $herourl ?>"><?= $heading ?></a></h2>
		<? if (!empty($heroimageurl)): ?>
			<a href="<?= $herourl ?>"><img class="wikiahomepage-hubs-hero-image" src="<?= $heroimageurl ?>"></a>
		<? endif ?>
	<? else: ?>
		<h2><?= $heading ?></h2>
	<?php endif; ?>
	<p><?= $creative ?></p>
	<h4><?= $moreheading ?></h4>
	<?= $morelist ?>
</section>
