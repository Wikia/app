<div class="module-popular-videos">
	<div class="one-input-box">
		<div class="module-right-box grid-4 alpha">
			<?= $form->renderField('header') ?>
		</div>
	</div>
	
	<div class="one-input-box">
		<h3 class="alternative">1.</h3>
		<div class="module-right-box grid-4 alpha">
			<input type="button" class="vet-show" value="<?= wfMessage('marketing-toolbox-edithub-add-video-button')->text() ?>" />
		</div>
	</div>

	<div class="popular-videos-list">
		<? if( !empty($videos) ): ?>
				<? foreach($videos as $idx => $video): ?>
					<? $videoUrlField = $form->getField('videoUrl')?>
					<?= $app->renderView(
							'MarketingToolboxVideosController',
							'popularVideoRow',
							array(
								'video' => $video,
								'errorMsg' => (isset($videoUrlField['errorMessage'][$idx]) ? $videoUrlField['errorMessage'][$idx] : ''),
							)
						);
					?>
				<? endforeach; ?>
		<? endif; ?>
	</div>
</div>
