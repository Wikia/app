<div class="module-box grid-4 alpha sponsored-image">
	<div class="grid-3 alpha">
		<input type="button" class="wmu-show" value="<?= $wf->Msg('marketing-toolbox-edithub-sponsored-image') ?>" />
		<span class="filename-placeholder alternative">
			<?php if( !empty($inputData['value']) ): ?>
				<?= $inputData['value']; ?>
			<?php else: ?>
				<?= $wf->msg('marketing-toolbox-edithub-file-name') ?>
			<?php endif ?>
		</span>
		<?= $app->renderView(
			'MarketingToolbox',
			'FormField',
			array('inputData' => $inputData)
			); 
		?>
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
	<p class="alternative">
		<?= $wf->MsgExt('marketing-toolbox-hub-module-sponsored-image-tip', array('parseinline')) ?>
	</p>
	<input class="secondary remove-sponsored-image" type="button" value="<?= $wf->Msg('marketing-toolbox-edithub-sponsored-image-remove') ?>" />
</div>
