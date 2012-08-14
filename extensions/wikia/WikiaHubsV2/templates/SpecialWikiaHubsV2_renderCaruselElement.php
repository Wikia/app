<a class="video-thumbnail video-hubs-video lightbox" data-wiki="<?= $video->data['wiki']; ?>" data-video-name="<?= $video->data['video-name']; ?>" data-ref="<?= $video->data['ref']; ?>" href="<?= $video->href; ?>">
	<?php if( !empty($video->duration) ): ?>
		<div class="timer"><?= $video->duration; ?></div>
	<?php endif; ?>
	<div class="playButton"></div>
	<img class="Wikia-video-thumb" src="<?= $video->imgUrl; ?>" data-src="<?= $video->imgUrl; ?>" />
</a>
<div class="description"><?= $video->description; ?></div>
<div class="info"><?= $video->info; ?></div>