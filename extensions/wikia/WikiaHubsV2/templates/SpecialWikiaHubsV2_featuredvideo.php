<div class="title-wrapper">
	<h2><?= $headline; ?></h2>

	<?php if (!empty($sponsorThumb)): ?>
	<span class="sponsorbox"><ins><?= wfMsg('wikiahubs-sponsored-by', array($sponsorThumb)); ?></ins></span>
	<?php endif; ?>
</div>

<div class="sponsored-video-content">
	<?php if ($video): ?>
	<a href="<?= $video['href']; ?>" class="video-thumbnail lightbox" data-video-name="<?= $video['title']; ?>">
		<span class="Wikia-video-play-button" style="width: 300px; height: 168px;"></span>
		<img alt="<?= $video['href']; ?>" src="<?= $video['thumbSrc']; ?>" class="Wikia-video-thumb thumbimage"/>
	</a>
	<?php endif; ?>
	<h4>
		<span class="mw-headline" id="<?= $description['maintitle']; ?>"><b><?= $description['maintitle']; ?></b></span>
	</h4>
	<?php
		// todo: can we do it anyhow better for i18n?
		//
	?>
	<?= $description['subtitle']; ?> <a
	href="<?= $description['link']['href']; ?>"><?= $description['link']['anchor']; ?></a>
</div>
