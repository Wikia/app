<div class="module-box grid-4 alpha sponsored-image">
	<div class="grid-3 alpha">
		<input type="button" class="wmu-show" value="<?= wfMessage('wikia-hubs-sponsored-image')->text() ?>" />
		<span class="filename-placeholder alternative">
			<? $field = $form->getField($fieldName); ?>
			<?php if( !empty($field['value']) ): ?>
				<?= $field['value']; ?>
			<?php else: ?>
				<?= wfMessage('wikia-hubs-file-name')->text() ?>
			<?php endif ?>
		</span>
		<?= $form->renderField($fieldName);?>
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
		<?= wfMessage('wikia-hubs-module-sponsored-image-tip')
			->numParams(
				AbstractMarketingToolboxModel::MAX_SPONSOR_IMAGE_WIDTH,
				AbstractMarketingToolboxModel::MAX_SPONSOR_IMAGE_HEIGHT
			)
			->parse()
		?>
	</p>
	<input class="secondary remove-sponsored-image" type="button" value="<?= wfMessage('wikia-hubs-remove')->text() ?>" />
</div>
