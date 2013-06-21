<div class="module-explore">
	<div class="module-box grid-4 alpha">
		<div class="grid-3 alpha">
			<input type="button" class="wmu-show" value="<?= wfMessage('marketing-toolbox-hub-module-explore-add-photo')->text() ?>" />
			<span class="filename-placeholder alternative">
				<? $fileNameField = $form->getField('fileName'); ?>
				<? if (!empty($fileNameField['value'])): ?>
					<?= $fileNameField['value']; ?>
				<? else: ?>
					<?= wfMessage('marketing-toolbox-edithub-file-name')->text() ?>
				<? endif ?>
			</span>
			<p class="alternative">
				<?= wfMessage('marketing-toolbox-hub-module-explore-image-tip')->parse() ?>
			</p>

			<?=$form->renderField('fileName')?>
			<?=$form->renderField('exploreTitle')?>
			<?=$form->renderField('imageLink')?>

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
		<input class="secondary clear" type="button" value="Clear" />
	</div>
	<? for($i = 1; $i <= $sectionLimit; $i++): ?>
		<div class="module-box header-group grid-4 alpha">
			<div class="grid-2 alpha">
				<?=$form->renderField('exploreSectionHeader'.$i)?>
				<?=$form->renderField('exploreLinkText'.$i.'a')?>
				<?=$form->renderField('exploreLinkText'.$i.'b')?>
				<?=$form->renderField('exploreLinkText'.$i.'c')?>
				<?=$form->renderField('exploreLinkText'.$i.'d')?>
				<?=$form->renderField('exploreLinkText'.$i.'e')?>
			</div>
			<div class="grid-2 alpha url-group">
				<?=$form->renderField('exploreLinkUrl'.$i.'a')?>
				<?=$form->renderField('exploreLinkUrl'.$i.'b')?>
				<?=$form->renderField('exploreLinkUrl'.$i.'c')?>
				<?=$form->renderField('exploreLinkUrl'.$i.'d')?>
				<?=$form->renderField('exploreLinkUrl'.$i.'e')?>
			</div>
			<input class="secondary clear" type="button" value="Clear" />
		</div>
	<? endfor; ?>
</div>
