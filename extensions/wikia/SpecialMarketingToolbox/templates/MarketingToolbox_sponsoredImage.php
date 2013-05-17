<div class="module-box grid-4 alpha sponsored-image">
	<div class="grid-3 alpha">
		<input type="button" class="wmu-show" value="<?= wfMessage('marketing-toolbox-edithub-sponsored-image')->text() ?>" />
		<span class="filename-placeholder alternative">
			<? $field = $form->getField($fieldName); ?>
			<?php if( !empty($field['value']) ): ?>
				<?= $field['value']; ?>
			<?php else: ?>
				<?= wfMessage('marketing-toolbox-edithub-file-name')->text() ?>
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
		<?= wfMessage('marketing-toolbox-hub-module-sponsored-image-tip')->parse() ?>
	</p>
	<input class="secondary remove-sponsored-image" type="button" value="<?= wfMessage('marketing-toolbox-edithub-remove')->text() ?>" />
</div>
