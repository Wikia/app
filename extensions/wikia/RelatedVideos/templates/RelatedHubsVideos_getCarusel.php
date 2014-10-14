<div class="RelatedVideos RelatedVideosHidden RelatedHubsVideos noprint" id="RelatedVideos" data-count="<?=ceil(count($videos)/3);?>">
	<div class="embedCodeTooltip messageHolder"><?=wfMsg('related-videos-tooltip-embed');?></div>
	<div class="errorWhileLoading messageHolder"><?=wfMsg('videos-error-while-loading');?></div>
	<div class="RVBody">
		<div class="button vertical secondary scrollleft" >
			<img src="<?=wfBlankImgUrl();?>" class="chevron" />
		</div>
		<div class="wrapper">
			<div class="container">
				<? $i = 0;
				if( isset($videos) && is_array($videos) ){
					foreach( $videos as $id => $video ) {
						$i++;
						echo F::app()->renderView(
							'RelatedHubsVideos',
							'getCaruselElement',
							array(
								'video' => $video,
								'preloaded' => ( $i <= 6 )
							)
						);
					}
				} ?>
			</div>
		</div>
		<div class="button vertical secondary left scrollright">
			<img src="<?=wfBlankImgUrl();?>" class="chevron" />
		</div>
	</div>
</div>