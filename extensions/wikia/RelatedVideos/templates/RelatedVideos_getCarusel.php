<div class="RelatedVideos RelatedVideosHidden noprint" id="RelatedVideos" data-count="<?=ceil((count($videos)+1)/3);?>">
	<div class="deleteConfirm messageHolder"><?=wfMsg('related-videos-remove-confirm');?></div>
	<div class="removingProcess messageHolder"><?=wfMsg('related-videos-remove-call');?></div>
	<div class="addVideoTooltip messageHolder"><?=wfMsg('related-videos-tooltip-add');?></div>
	<div class="embedCodeTooltip messageHolder"><?=wfMsg('related-videos-tooltip-embed');?></div>
	<div class="errorWhileLoading messageHolder"><?=wfMsg('related-videos-error-while-loading');?></div>
	<div class="RVHeader">
		<div class="tally">
			<em><?=count($videos);?></em>
			<span class="fixedwidth"><?=wfMsg('related-videos-tally') ?></span>
		</div>
		<a class="button addVideo"><img src="<?=wfBlankImgUrl();?>" class="sprite addRelatedVideo" /> <?=wfMsg('related-videos-add-video')?></a>
		<a class="beta"><?=wfMsg('related-videos-beta-feature')?></a>
		<a class="feedback" target="_blank" href="<?=RelatedVideosController::SURVEY_URL?>"><?=wfMsg('related-videos-leave-feedback')?></a>
	</div>
	<div class="RVBody">
		<div class="button vertical secondary scrollleft" >
			<img src="<?=wfBlankImgUrl();?>" class="chevron" />
		</div>
		<div class="wrapper">
			<div class="container">
				<? $i = 0;
				if( isset($videos) && is_array($videos) ){
					foreach( $videos as $id => $video ){
						$i++;
						echo F::app()->renderView(
							'RelatedVideos',
							'getCaruselElement',
							array(
								'video' => $video,
								'preloaded' => ( $i <= 6 )
							)
						);
					}
				} ?>
				<div class="action">
					<a class="video-thumbnail" href="#" >
						<div class="addVideo"></div>
					</a>
				</div>
			</div>
		</div>
		<div class="button vertical secondary left scrollright">
			<img src="<?=wfBlankImgUrl();?>" class="chevron" />
		</div>
	</div>
</div>