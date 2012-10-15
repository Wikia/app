<? if ( count( $suggested_videos ) > 0 ) { ?>
<?= wfMsg('related-videos-suggestions'); ?>

<div class="RVSuggestPreviewVideo"></div>
<div class="RelatedVideos RVSuggestionCont" data-count="<?=ceil((count($suggested_videos)+1)/3);?>">
	<div class="RVBody">
		<div class="button vertical secondary scrollleft" >
			<img src="<?=wfBlankImgUrl();?>" class="chevron" />
		</div>
		<div class="wrapper">
			<div class="container">
				<?	$i = 0; ?>
				<? foreach ( $suggested_videos as $vid ) { ?>
					<? $i++; ?>
					<div class="item">
						<?= $vid['thumbnail']; ?>
						<div class="item-title" data-dbkey="<?=$vid['dbKey']?>"><?=$vid['title']?></div>
						<div class="add-this-video"><a><?= wfMsg('related-videos-add-this'); ?></a></div>
					</div>
				<? } ?>
			</div>
		</div>
		<div class="button vertical secondary left scrollright">
			<img src="<?=wfBlankImgUrl();?>" class="chevron" />
		</div>
	</div>
</div>


<? } ?>