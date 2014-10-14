<div class="module-popular-videos">
	<div class="one-input-box">
		<div class="module-right-box grid-4 alpha">
			<?= $form->renderField('header') ?>
		</div>
	</div>
	
	<div class="one-input-box">
		<h3 class="alternative">1.</h3>
		<div class="module-right-box grid-4 alpha">
			<input type="button" class="vet-show" value="<?= wfMessage('wikia-hubs-add-video-button')->text() ?>" />
		</div>
	</div>

	<div class="popular-videos-list">
		<? if( !empty($videos) ): ?>
				<? foreach($videos as $idx => $video): ?>
					<? $videoUrlField = $form->getField('videoUrl')?>
					<?=(new Wikia\Template\MustacheEngine())->setData([
						'blankImgUrl' => $wg->BlankImgUrl,
						'removeMsg' => wfMessage('wikia-hubs-remove')->text(),
						'errorMsg' => (isset($videoUrlField['errorMessage'][$idx])) ? $videoUrlField['errorMessage'][$idx] : '',
						'sectionNo' => (isset($video['section-no'])) ? $video['section-no'] : null,
						'videoTitle' => (isset($video['title'])) ? $video['title'] : null,
						'videoFullUrl' => (isset($video['fullUrl'])) ? $video['fullUrl'] : null,
						'videoTime' => (isset($video['videoTime'])) ? $video['videoTime'] : null,
						'videoThumbnail' => (isset($video['videoThumb'])) ? $video['videoThumb'] : null,
					])->render( dirname(__FILE__) . '/MarketingToolbox_popularVideoRow.mustache' );
					?>


				<? endforeach; ?>
		<? endif; ?>
	</div>
</div>
