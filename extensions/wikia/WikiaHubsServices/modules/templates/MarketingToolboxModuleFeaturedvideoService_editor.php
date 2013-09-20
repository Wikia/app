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
			<input type="button" class="vet-show" value="<?= wfMessage('marketing-toolbox-edithub-add-video-button')->text() ?>" />
			<span class="filename-placeholder alternative">
				<?php if( !empty($fields['video']['value']) ): ?>
				<?= $fields['video']['value']; ?>
				<?php else: ?>
				<?= wfMessage('marketing-toolbox-edithub-video-name')->text() ?>
				<?php endif ?>
			</span>
			<?=$form->renderField('video')?>
			<?=$form->renderField('header')?>
			<?=$form->renderField('articleUrl')?>
			<?=$form->renderField('description')?>
			<p class="alternative"><?= wfMessage('marketing-toolbox-hub-module-html-text-tip')->parse(); ?></p>
		</div>
		<div class="grid-1 alpha">
			<div class="image-placeholder video">
				<? if (!empty($videoThumb)): ?>
					<?= $videoThumb ?>
				<? endif ?>
			</div>
		</div>
	</div>
</div>