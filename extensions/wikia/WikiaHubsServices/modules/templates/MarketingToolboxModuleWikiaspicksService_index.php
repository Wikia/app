<h2>
	<?php if( !empty($sponsoredImageMarkup) ): ?>
		<span class="sponsorbox"><ins><?= wfMessage('wikiahubs-sponsored-by')->rawParams($sponsoredImageMarkup)->escaped(); ?></ins></span>
	<?php endif; ?>
	<?= $title ?>
</h2>
<p>
	<?php if( !is_null($imageLink) ): ?>
		<a href="<?= $imageLink ?>">
	<?php endif; ?>
	
	<img class="floatright" src="<?= $imageUrl ?>" alt="<?= $imageAlt ?>" />
	
	<?php if( !is_null($imageLink) ): ?>
		</a>
	<?php endif; ?>
	
	<?= $text ?>
</p>

