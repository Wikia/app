<div class="module-mediabox">
	<?= $app->renderView(
			'MarketingToolbox',
			'sponsoredImage',
			array(
				'inputData' => $fields['sponsoredImage'],
				'fileUrl' => (isset($sponsoredImageUrl) ? $sponsoredImageUrl : ''),
				'imageWidth' => (isset($sponsoredImageWidth) ? $sponsoredImageWidth : ''),
				'imageHeight' => (isset($sponsoredImageHeight) ? $sponsoredImageHeight : ''),
			)
		); 
	?>
	<div class="module-box grid-4 alpha">
		<div class="grid-3 alpha">
			<input type="button" class="wmu-show" value="<?= $wf->Msg('marketing-toolbox-hub-module-explore-add-photo') ?>" />
			<span class="filename-placeholder alternative">
				<?php if( !empty($fields['fileName']['value']) ): ?>
					<?= $fields['fileName']['value']; ?>
				<?php else: ?>
					<?= $wf->msg('marketing-toolbox-edithub-file-name') ?>
				<?php endif ?>
			</span>
			<?= $app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['fileName'])
				);
			?>
			<?= $app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['module-title'])
				);
			?>
			<?= $app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['text'])
				);
			?>
			<p class="alternative"><?= $wf->MsgExt('marketing-toolbox-hub-module-html-text-tip', array('parseinline')); ?></p>
		</div>
		<div class="grid-1 alpha">
			<div class="image-placeholder">
				<?php if( !empty($fileUrl) ): ?>
					<img width="<?= $imageWidth; ?>" height="<?= $imageHeight; ?>" src="<?= $fileUrl; ?>" />
				<?php else: ?>
					<img src="<?= $wg->BlankImgUrl; ?>" />
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>