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
	
	<div class="module-box">
		<h3 class="alternative">2.</h3>
		<div class="module-right-box grid-4 alpha">
			<div class="module-input-box">
				<h4 class="video-title">Star Wars vs. Star Trek</h4>
				<time class="timeago">2 days ago</time>
				<a href="#" class="video-url alternative">http://darksiders.wikia.com/wiki/File:Wii_U_-_Darksiders_II_Death_Lives</a>
				<?= $app->renderView(
						'MarketingToolbox',
						'FormField',
						array(
							'inputData' => array_merge(
								$fields['video'],
								array('index' => 0)
							)
						)
					);
				?>
			</div>
			
			<div class="module-image-box">
				<div class="image-placeholder">
					<?php if( !empty($video['thumb']) ): ?>
						<img width="<?= $video['thumb']['imageWidth']; ?>" height="<?= $video['thumb']['imageHeight']; ?>" src="<?= $video['thumb']['url']; ?>" />
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
			<button class="secondary navigation nav-down"><img class="chevron chevron-down" src="<?= $wg->BlankImgUrl; ?>"></span></button>
		</div>
	</div>
</div>