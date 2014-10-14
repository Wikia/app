<?	$elementHeight = 90;
	$maxDescriptionLength = 45;
?>
<div class="item">
	<a class="video lightbox" style="height:<?=$elementHeight; ?>px" href="<?=$video['fullUrl'];?>" data-ref="<?=$video['prefixedUrl'];?>" data-external="<?=$video['external'];?>" data-video-name="<?=htmlspecialchars($video['title']);?>" >
		<?
		if ( !empty( $video['duration'] ) ) {
			$mins = floor ($video['duration'] / 60);
			$secs = $video['duration'] % 60;
			$duration = $mins.':'.( ( $secs < 10 ) ? '0'.$secs : $secs );
		} else {
			$duration = 0;
		}
		if( !empty( $duration ) ){  ?><div class="timer"><?=$duration;?></div><? }
		if( !empty( $video['isNew'] ) ){  ?><div class="new"><?=wfMsg('related-videos-video-is-new');?><div  class="newRibbon" ></div></div><? } ?>
		<div class="playButton"></div>
		<img class="Wikia-video-thumb" data-src="<?=$video['thumbnailData']['thumb'];?>" src="<?=( $preloaded ) ? $video['thumbnailData']['thumb'] : wfBlankImgUrl();?>" style="margin-top:<?= floor( ( $elementHeight - $video['thumbnailData']['height'] ) / 2 ); ?>px; height:<?=$video['thumbnailData']['height'];?>px; width:<?=$video['thumbnailData']['width'];?>px;" />
	</a>
	<div class="description">
		<?=( mb_strlen( $video['title'] ) > $maxDescriptionLength )
			? mb_substr( $video['title'], 0, $maxDescriptionLength).'&#8230;'
			: $video['title'];
		?>
	</div>
	<div class="info">
		<?
			$owner = $video['owner'];
			if ( !empty( $owner ) ){
				echo wfMsg('related-videos-added-by') . " ";
				if ( empty( $video['external'] ) || isset( $video['externalByUser'] ) ){
					$ownerUrl = $video['ownerUrl'];
					if ( !empty( $ownerUrl ) ) {
						?><a class="added-by" data-owner="<?=$video['owner'];?>" href="<?=$video['ownerUrl'];?>"><?=$video['owner'];?></a><?
					} else {
						echo $video['owner'];
					}
				} else {
					?><a href="<?=F::app()->wg->wikiaVideoCategoryPath;?>" /><?=wfMsg('related-videos-repo-name');?></a><?
				}
			}
		?>
	</div>
	<div class="options">
		<img src="<?=wfBlankImgUrl();?>" /><a class="remove" href="#"><?=wfMsg('related-videos-remove'); ?></a>
	</div>
</div>