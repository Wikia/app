<div class="module-popular-videos">
	<div class="module-box one-input-box">
		<div class="module-right-box grid-4 alpha">
			<?= $app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['header'])
				);
			?>
		</div>
	</div>
	
	<div class="module-box one-input-box">
		<h3 class="alternative">1.</h3>
		<div class="module-right-box grid-4 alpha">
			<input type="button" class="vet-show" value="<?= $wf->Msg('marketing-toolbox-edithub-add-video-button') ?>" />
		</div>
	</div>
	
	<?php if( !empty($videos) ): ?>
		<div class="popular-videos-list">
			<?php foreach($videos as $idx => $video): ?>
				<?= $app->renderView(
						'MarketingToolboxVideosController',
						'popularVideoRow',
						array(
							'idx' => $idx,
							'video' => $video,
							'fields' => $fields,
						)
					);
				?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>