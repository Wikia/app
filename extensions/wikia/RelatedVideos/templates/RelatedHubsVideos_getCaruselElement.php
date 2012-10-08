<?	$elementHeight = 90;
	$maxDescriptionLength = 45;
?>
<div class="item"><a class="video-thumbnail  video-hubs-video lightbox" style="height:<?=$elementHeight; ?>px" href="<?=$video['fullUrl'];?>" data-ref="<?=$video['prefixedUrl'];?>" data-external="<?=$video['external'];?>" data-video-name="<?= htmlspecialchars($video['title']) ?>" data-wiki="<?=$video['wiki'];?>"><?
		if ( !empty( $video['duration'] ) ) {
			$mins = floor ($video['duration'] / 60);
			$secs = $video['duration'] % 60;
			$duration = $mins.':'.( ( $secs < 10 ) ? '0'.$secs : $secs );
		} else {
			$duration = 0;
		}if( !empty( $duration ) ){  ?><div class="timer"><?=$duration;?></div><? }if( !empty( $video['isNew'] ) ){  ?><div class="new"><?=wfMsg('related-videos-video-is-new');?><div  class="newRibbon" ></div></div><? } ?><div class="playButton"></div><img class="Wikia-video-thumb" data-src="<?=$video['thumbnailData']['thumb'];?>" src="<?=( $preloaded ) ? $video['thumbnailData']['thumb'] : wfBlankImgUrl();?>" style="margin-top:<?= floor( ( $elementHeight - $video['thumbnailData']['height'] ) / 2 ); ?>px; height:<?=$video['thumbnailData']['height'];?>px; width:<?=$video['thumbnailData']['width'];?>px;" /></a>
	<div class="description"><?= $video['truncatedTitle'] ?></div>
	<div class="info">
		<?php $owner = $video['owner']; ?>
		<?php if ( !empty( $owner ) ): ?>
			<?php if( empty($video['external']) || isset($video['externalByUser']) ): ?>
				<?= wfMsg('related-videos-hubs-suggested-by', array($owner)); ?>
			<?php else: ?>
				<a href="<?= F::app()->wg->wikiaVideoCategoryPath; ?>" /><?= wfMsg('related-videos-repo-name'); ?></a>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>