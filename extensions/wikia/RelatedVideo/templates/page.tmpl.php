<div class="related-video" >
	<div class="related-video-right-rail">
		<div class="related-video-box-advert" id="fiveMinAdaptvCompanionDiv"><?=$boxAdvert; ?></div>
		<div id="video_companion"></div>
	</div>
	<div class="related-video-main">
		<a name="RelatedVideoTitle"></a><h1 class="related-video-title"><? echo $embededTitle; ?></h1>
		<div class="related-video-player">
			<? echo $embededVideo; ?>
		</div>
		<? if (!empty( $related )){ ?>
		<div class="related-video-gallery">
			<h3><?= wfMsg('related-video-related')?></h3>
			<? foreach( $related as $element){ ?>
				<div class="related-video-gallery-item ">
					<a href="<?=$server.'/wiki/Special:RelatedVideo/'.$element['id'].'#RelatedVideoTitle'; ?>" title="">
						<div class="related-video-gallery-item-image">
							<?php if (!empty($element['thumbnail'])) {?>
								<div class="related-video-gallery-item-play"></div>
								<img src="<?=$element['thumbnail'] ?>" alt="<?=$element['title'] ?>" />
							<?php } ?>

						</div>
						<span class="details"><?=$element['title'] ?></span>
					</a>
				</div>
			<? } ?>
		</div>
		<? } ?>
	</div>

</div>
