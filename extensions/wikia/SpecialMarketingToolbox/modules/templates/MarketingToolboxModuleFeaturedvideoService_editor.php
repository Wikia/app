<div class="module-mediabox">
	<div class="module-box grid-4 alpha">
		<div class="grid-3 alpha">
			<input type="button" class="vet-show" value="<?= $wf->Msg('marketing-toolbox-edithub-add-video-button') ?>" />
			<span class="filename-placeholder alternative">
				<?php if( !empty($fields['video']) ): ?>
				<?= $fields['video']['value']; ?>
				<?php else: ?>
				<?= $wf->msg('marketing-toolbox-edithub-video-name') ?>
				<?php endif ?>
			</span>
			<?= $app->renderView(
			'MarketingToolbox',
			'FormField',
			array('inputData' => $fields['video'])
		);
			?>
			<?= $app->renderView(
			'MarketingToolbox',
			'FormField',
			array('inputData' => $fields['header'])
		);
			?>
			<?= $app->renderView(
			'MarketingToolbox',
			'FormField',
			array('inputData' => $fields['description'])
		);
			?>
		</div>
		<div class="grid-1 alpha">
			<div class="image-placeholder">
				<?= $app->renderView(
					'MarketingToolboxVideos',
					'index',
					array('video' => $videoData)
				);
				?>
			</div>
		</div>
	</div>
</div>