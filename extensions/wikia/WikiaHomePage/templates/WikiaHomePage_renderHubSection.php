<section class="grid-2 wikiahomepage-hubs-section <?= $classname ?>">
	<h2><?= $heading ?></h2>
	<?php if(!empty($herourl )): ?><a href="<?= $herourl ?>"><?php endif; ?>
		<? if (!empty($heroimageurl)): ?>
			<img class="wikiahomepage-hubs-hero-image" src="<?= $heroimageurl ?>">
		<? else: ?>
			<?= $heading ?>
		<? endif ?>
	<?php if(!empty($herourl )): ?></a><?php endif; ?>
	<p><?= $creative ?></p>
	<h4><?= $moreheading ?></h4>
	<?= $morelist ?>
</section>