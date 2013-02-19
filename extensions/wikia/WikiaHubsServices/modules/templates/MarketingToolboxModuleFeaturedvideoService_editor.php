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
			<input type="button" class="vet-show" value="<?= $wf->Msg('marketing-toolbox-edithub-add-video-button') ?>" />
			<span class="filename-placeholder alternative">
				<?php if( !empty($fields['video']['value']) ): ?>
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
					array('inputData' => $fields['articleUrl'])
				);
			?>
			<?= $app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['description'])
				);
			?>
			<p class="alternative"><?= $wf->MsgExt('marketing-toolbox-hub-module-html-text-tip', array('parseinline')); ?></p>
		</div>
		<div class="grid-1 alpha">
			<div class="image-placeholder video">
				<? if (!empty($videoData)): ?>
					<?= $videoData ?>
				<? endif ?>
			</div>
		</div>
	</div>
</div>