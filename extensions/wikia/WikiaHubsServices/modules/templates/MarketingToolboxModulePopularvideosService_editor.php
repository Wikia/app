<div class="module-popular-videos">
	<div class="one-input-box">
		<div class="module-right-box grid-4 alpha">
			<?= $form->renderField('header') ?>
		</div>
	</div>
	
	<div class="one-input-box">
		<h3 class="alternative">1.</h3>
		<div class="module-right-box grid-4 alpha">
			<input type="button" class="vet-show" value="<?= $wf->Message('marketing-toolbox-edithub-add-video-button')->text() ?>" />
		</div>
	</div>

	<div class="popular-videos-list">
		<?php if( !empty($videos) ): ?>
				<?php foreach($videos as $idx => $video): ?>
					<?= $app->renderView(
							'MarketingToolboxVideosController',
							'popularVideoRow',
							array(
								'video' => $video,
								'errorMsg' => (isset($fields['videoUrl']['errorMessage'][$idx]) ? $fields['videoUrl']['errorMessage'][$idx] : ''),
							)
						);
					?>
				<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
