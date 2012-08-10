<a class="video-thumbnail video-hubs-video <?= $videoPlay ?>" data-wiki="<?= $data['wiki']; ?>" data-video-name="<?= $data['video-name']; ?>" data-ref="<?= $data['ref']; ?>" href="<?= $href; ?>">
	<?php if( !empty($duration) ): ?>
		<div class="timer"><?= $duration; ?></div>
	<?php endif; ?>
	<div class="playButton"></div>
	<img class="Wikia-video-thumb" src="<?= $imgUrl; ?>" data-src="<?= $imgUrl; ?>" />
</a>
<div class="description"><?= $description; ?></div>
<div class="info"><?= $info; ?></div>