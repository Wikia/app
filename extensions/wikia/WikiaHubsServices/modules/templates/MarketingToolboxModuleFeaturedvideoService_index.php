<div class="title-wrapper">
	<h2><?= $header; ?></h2>
	
	<?php if( !empty($sponsorThumb) ): ?>
		<span class="sponsorbox"><ins><?= wfMsg('wikiahubs-sponsored-by', array($sponsorThumb)); ?></ins></span>
	<?php endif; ?>
</div>
	
<div class="sponsored-video-content">
	<?= $video['thumbMarkup']; ?>
	<p><?= $description; ?></p>
</div>