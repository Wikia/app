<div class="module-box grid-4 alpha sponsored-image">
	<div class="grid-3 alpha">
		<input type="button" class="wmu-show" value="<?= $wf->Msg('marketing-toolbox-edithub-sponsored-image') ?>" />
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
		); ?>
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
