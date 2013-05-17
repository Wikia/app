<div class="module-mediabox">
	<?= $app->renderView(
			'MarketingToolbox',
			'sponsoredImage',
			array(
				'form' => $form,
				'fieldName' => 'sponsoredImage',
				'fileUrl' => (isset($sponsoredImage->url) ? $sponsoredImage->url : ''),
				'imageWidth' => (isset($sponsoredImage->width) ? $sponsoredImage->width : ''),
				'imageHeight' => (isset($sponsoredImage->height) ? $sponsoredImage->height : ''),
			)
		);
	?>
	<div class="module-box grid-4 alpha">
		<div class="grid-3 alpha">
			<input type="button" class="wmu-show" value="<?= wfMessage('marketing-toolbox-hub-module-explore-add-photo')->text() ?>" />
			<span class="filename-placeholder alternative">
				<? $fileNameField = $form->getField('fileName');?>
				<?php if( !empty($fileNameField['value']) ): ?>
					<?= $fileNameField['value']; ?>
				<?php else: ?>
					<?= wfMessage('marketing-toolbox-edithub-file-name')->text() ?>
				<?php endif ?>
			</span>

			<?=$form->renderField('fileName'); ?>
			<?=$form->renderField('moduleTitle'); ?>
			<?=$form->renderField('imageLink'); ?>
			<?=$form->renderField('text'); ?>

			<p class="alternative"><?= wfMessage('marketing-toolbox-hub-module-html-text-tip')->parse(); ?></p>
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