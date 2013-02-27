<div class="title-wrapper">
	<h2><?= $header; ?></h2>
	
	<?php if( !empty($sponsoredImageMarkup) ): ?>
		<span class="sponsorbox"><ins><?= wfMessage('wikiahubs-sponsored-by')->rawParams($sponsoredImageMarkup)->escaped(); ?></ins></span>
	<?php endif; ?>
</div>
	
<div class="sponsored-video-content">
	<?= $video['thumbMarkup']; ?>
	<p><?= $description; ?></p>
</div>