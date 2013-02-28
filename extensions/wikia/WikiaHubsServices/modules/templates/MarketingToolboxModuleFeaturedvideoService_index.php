<h2>
	<?php if( !empty($sponsoredImageMarkup) ): ?>
		<span class="sponsorbox"><ins><?= wfMessage('wikiahubs-sponsored-by')->rawParams($sponsoredImageMarkup)->escaped(); ?></ins></span>
	<?php endif; ?>
	<?= $header; ?>
</h2>
	
<div class="featured-video-content">
	<?= $video['thumbMarkup']; ?>
	<p><?= $description; ?></p>
</div>