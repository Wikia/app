<div class="module-popular-videos">
	<div class="module-box first-box">
		<div class="module-right-box grid-4 alpha">
			<?= $app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['header'])
				);
			?>
		</div>
	</div>
	
	<div class="module-box first-box">
		<h3 class="alternative">1.</h3>
		<div class="module-right-box grid-4 alpha">
			<input type="button" class="vet-show" value="<?= $wf->Msg('marketing-toolbox-edithub-add-video-button') ?>" />
		</div>
	</div>
	
	<?php foreach($videos as $idx => $video): ?>
		<div class="module-box">
			<h3 class="alternative"><?= $video['section-no'] . '.'; ?></h3>
			<div class="module-right-box grid-4 alpha">
				<div class="module-input-box">
					<h4 class="video-title"><?= $video['title']; ?></h4>
					<time class="timeago"><?= wfTimeFormatAgo($video['timestamp']); ?></time>
					<a href="<?= $video['fullUrl']; ?>" target="_blank" class="video-url alternative"><?= $video['fullUrl']; ?></a>
					<?= $app->renderView(
							'MarketingToolbox',
							'FormField',
							array(
								'inputData' => array_merge(
									$fields['video'],
									array('index' => $idx)
								)
							)
						);
					?>
				</div>
				
				<div class="module-image-box">
					<div class="image-placeholder">
						<?php if( !empty($video['thumbnailData']) ): ?>
							<img width="<?= $video['thumbnailData']['width']; ?>" height="<?= $video['thumbnailData']['height']; ?>" src="<?= $video['thumbnailData']['thumb']; ?>" />
						<?php else: ?>
							<img src="<?= $wg->BlankImgUrl; ?>" />
						<?php endif ?>
					</div>
				</div>
	
				<div class="module-input-box buttons">
					<input type="button" class="delete" value="<?= $wf->msg('marketing-toolbox-edithub-delete-button'); ?>" />
					<input class="secondary clear" type="button" value="<?= $wf->msg('marketing-toolbox-edithub-clear-button')?>" />
				</div>
				
				<button class="secondary navigation nav-up"><img class="chevron chevron-up" src="<?= $wg->BlankImgUrl; ?>"></button>
				<button class="secondary navigation nav-down"><img class="chevron chevron-down" src="<?= $wg->BlankImgUrl; ?>"></button>
			</div>
		</div>
	<?php endforeach; ?>
</div>