<h2>
	<?php if( !empty($sponsoredImageMarkup) ): ?>
		<span class="sponsorbox"><ins><?= wfMessage('wikiahubs-sponsored-by')->rawParams($sponsoredImageMarkup)->escaped(); ?></ins></span>
	<?php endif; ?>
	<?= $header; ?>
</h2>
	
<div class="featured-video-content">
	<figure class="thumb"><?= $video['thumbMarkup']; ?></figure>
	<p><?= $description; ?></p>
</div>