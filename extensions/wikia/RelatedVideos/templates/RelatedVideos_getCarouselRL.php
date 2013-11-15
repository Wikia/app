<? $pageCount = ceil((count($videos)+1)/3); // Added +1 for video placeholder ?>

<div class="RelatedVideos RelatedVideosHidden noprint" id="RelatedVideosRL" data-count="<?=$pageCount;?>">
	<h1><?= wfMsg('related-videos-tally'); ?></h1>
	<div class="deleteConfirmTitle messageHolder"><?=wfMsg('related-videos-remove-confirm-title');?></div>
	<div class="deleteConfirm messageHolder">
		<span><?=wfMsg('related-videos-remove-confirm');?></span>
		<label>
			<input type="checkbox" name="delete-from-wiki" value="1">
			<?=wfMessage('related-videos-delete-from-wiki');?>
		</label>
	</div>
	<div class="removingProcess messageHolder"><?=wfMsg('related-videos-remove-call');?></div>
	<div class="errorWhileLoading messageHolder"><?=wfMsg('videos-error-while-loading');?></div>
	<div class="RVHeader">
		<div class="tally">
			<em><?= $totalVideos ?></em>
			<span class="fixedwidth"><?=wfMsg('related-videos-tally-wiki') ?></span>
		</div>
		<? if ( $canAddVideo ) { ?>
		<a class="button addVideo" href="#" rel="tooltip" title="<?=wfMsg('related-videos-tooltip-add');?>"><img src="<?=wfBlankImgUrl();?>" class="sprite addRelatedVideo" /> <?=wfMsg('related-videos-add-video')?></a>
		<? } ?>
	</div>
	<div class="RVBody">
		<div class="wrapper">
			<div class="container">
				<? 
				if( isset($videos) && is_array($videos) ){
					
					$videoArray = array();
					$i = 1;

					echo '<div class="group">';

					foreach( $videos as $id => $video ){
						// Cache video ids in their already randomized order
						$videoArray[] = array(
							"key" => $video['key'], 
							"title" => $video['title'], 
							"thumb" => $video['thumbnailData']['thumb'],
						);

						if( $i <= 6 ) {
							echo F::app()->renderView(
								'RelatedVideos',
								'getCarouselElementRL',
								array(
									'video' => $video,
									'preloaded' => true,
								)
							);
	
							// Start next page
							if( $i == 3 ) {
								echo '</div><div class="group">';
							}
							$i++;
						}
					}
					echo '</div>';
					
					// RelatedVideosIds used in RelatedVideos.js and Lightbox.js
					echo '<script type="text/javascript"> window.RelatedVideosIds = ' . json_encode($videoArray) . '</script>';
					
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
				<?=wfMsg('related-videos-see-all')?> &gt;
			</a>
		</div>
		<div class="seeMorePlaceholder">
			<a href="<?= $linkToSeeMore ?>" class="see-more-videos-placeholder"><?= wfMsg('related-videos-see-all') ?></a>
		</div>
	</div>
</div>
