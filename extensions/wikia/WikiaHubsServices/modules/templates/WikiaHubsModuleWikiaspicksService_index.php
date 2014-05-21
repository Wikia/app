<h2>
	<?php if( !empty($sponsoredImageMarkup) ): ?>
		<span class="sponsorbox"><ins><?= wfMessage('wikiahubs-v3-sponsored-by')->rawParams($sponsoredImageMarkup)->escaped(); ?></ins></span>
	<?php endif; ?>
	<?= $title ?>
</h2>
<p class="wikias-picks-content">
	<?php if( !is_null($imageLink) ): ?>
		<a class="wikias-picks-image" href="<?= $imageLink ?>">
	<?php endif; ?>
	
	<img class="floatright" src="<?= $imageUrl ?>" alt="<?= $imageAlt ?>" />
	
	<?php if( !is_null($imageLink) ): ?>
		</a>
	<?php endif; ?>
	
	<?= $text ?>
</p>

