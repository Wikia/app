<? $pageCount = ceil((count($videos))/3); ?>
<div class="RelatedVideos RelatedVideosHidden noprint" id="RelatedVideosRL" data-count="<?=$pageCount;?>">
	<h1><?= wfMsg('related-videos-tally'); ?></h1>
	<div class="deleteConfirm messageHolder"><?=wfMsg('related-videos-remove-confirm');?></div>
	<div class="removingProcess messageHolder"><?=wfMsg('related-videos-remove-call');?></div>
	<!--div class="addVideoTooltip messageHolder"><?=wfMsg('related-videos-tooltip-add');?></div-->
	<div class="removeVideoTooltip messageHolder"><?=wfMsg('related-videos-tooltip-remove');?></div>
	<div class="embedCodeTooltip messageHolder"><?=wfMsg('related-videos-tooltip-embed');?></div>
	<div class="errorWhileLoading messageHolder"><?=wfMsg('related-videos-error-while-loading');?></div>
	<div class="RVHeader">
		<div class="tally">
			<em><?=$totalVideos?></em>
			<span class="fixedwidth"><?=wfMsg('related-videos-tally-wiki') ?></span>
		</div>
		<a class="button addVideo" href="#" rel="tooltip" title="<?=wfMsg('related-videos-tooltip-add');?>"><img src="<?=wfBlankImgUrl();?>" class="sprite addRelatedVideo" /> <?=wfMsg('related-videos-add-video')?></a>
	</div>
	<div class="RVBody">
		<div class="wrapper">
			<div class="container">
				<? $i = 0;
				if( isset($videos) && is_array($videos) ){
					$videosGrouped = array();
					$j = -1;
					foreach( $videos as $id => $video ){
						if( $i % 3 == 0 ) {
							$j++;
							$videosGrouped[$j] = array();
						}
						$videosGrouped[$j][$id] = $video;
						$i++;
					}
					$i = 0;
					foreach( $videosGrouped as $id => $videos ){
						$i++; 
						echo '<div class="group">';
						foreach( $videos as $id => $video ){
							echo F::app()->renderView(
								'RelatedVideos',
								'getCaruselElementRL',
								array(
									'video' => $video,
									'preloaded' => ( $i <= 2 )
								)
							);
						}
						echo '</div>';
					}
				} ?>
			</div>
		</div>
		<div class="novideos" <? if(count($videos)!=0):?>style="display: none"<?endif?>><?= wfMsg('related-videos-empty');?></div>
		<div class="paginationbar">
			<div class="scrollleft" >
				<img src="<?=wfBlankImgUrl();?>" class="chevron" />
			</div>
			<div class="left scrollright">
				<img src="<?=wfBlankImgUrl();?>" class="chevron" />
			</div>
			<div class="pagecount">
				<?= wfMsg(
					'related-videos-pagination',
					'<span class="page">1</span>',
					'<span class="maxcount">'.($pageCount > 0 ? $pageCount : '1').'</span>');?>
			</div>
		</div>

		<div class="seemore">
			<a href="<?= $linkToSeeMore ?>" class="more">
				<?=wfMsg('related-videos-see-more')?> &gt;
			</a>
		</div>
	</div>
</div>