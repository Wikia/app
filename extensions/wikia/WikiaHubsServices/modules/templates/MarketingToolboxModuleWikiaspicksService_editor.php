<div class="module-mediabox">
	<?= $app->renderView(
			'MarketingToolbox',
			'sponsoredImage',
			array(
				'inputData' => $fields['sponsoredImage'],
				'fileUrl' => (isset($sponsoredImage->url) ? $sponsoredImage->url : ''),
				'imageWidth' => (isset($sponsoredImage->width) ? $sponsoredImage->width : ''),
				'imageHeight' => (isset($sponsoredImage->height) ? $sponsoredImage->height : ''),
			)
		);
	?>
	<div class="module-box grid-4 alpha">
		<div class="grid-3 alpha">
			<input type="button" class="wmu-show" value="<?= $wf->Message('marketing-toolbox-hub-module-explore-add-photo')->text() ?>" />
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
					array('inputData' => $fields['moduleTitle'])
				);
			?>
			<?= $app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['imageLink'])
				);
			?>
			<?= $app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['text'])
				);
			?>
			<p class="alternative"><?= $wf->Message('marketing-toolbox-hub-module-html-text-tip')->parse(); ?></p>
		</div>
		<div class="grid-1 alpha">
			<div class="image-placeholder">
				<?php if( !empty($file->url) ): ?>
					<img width="<?= $file->width; ?>" height="<?= $file->height; ?>" src="<?= $file->url; ?>" />
				<?php else: ?>
					<img src="<?= $wg->BlankImgUrl; ?>" />
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>