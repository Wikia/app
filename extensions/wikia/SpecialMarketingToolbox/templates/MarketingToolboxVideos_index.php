<a
        class="image video"
        href="<?=$video['fullUrl'];?>"
        data-video-name="<?=htmlspecialchars($video['title']);?>">

	<?
	if (!empty($video['duration'])) {
		$mins = floor($video['duration'] / 60);
		$secs = $video['duration'] % 60;
		$duration = $mins . ':' . (($secs < 10) ? '0' . $secs : $secs);
	} else {
		$duration = 0;
	}
	?>

	<? if (!empty($duration)): ?>
    <div class="timer"><?=$duration;?></div>
	<? endif; ?>

	<? if (!empty($video['isNew'])): ?>
    <div class="new"><?=wfMsg('related-videos-video-is-new');?>
        <div class="newRibbon"></div>
    </div>
	<? endif; ?>

    <span class="Wikia-video-play-button mid" style="width: <?= $video['thumbnailData']['width']; ?>px; height: <?= $video['thumbnailData']['height']; ?>px;"></span>

    <img class="Wikia-video-thumb" data-src="<?=$video['thumbnailData']['thumb'];?>"
         src="<?=$video['thumbnailData']['thumb'];?>"
            />
</a>
