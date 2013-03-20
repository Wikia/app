<div class="module-explore">
	<div class="module-box grid-4 alpha">
		<div class="grid-3 alpha">
			<input type="button" class="wmu-show" value="<?= $wf->Msg('marketing-toolbox-hub-module-explore-add-photo') ?>" />
			<span class="filename-placeholder alternative">
				<? if (!empty($fields['fileName']['value'])): ?>
					<?= $fields['fileName']['value']; ?>
				<? else: ?>
					<?= $wf->msg('marketing-toolbox-edithub-file-name') ?>
				<? endif ?>
			</span>
            <p class="alternative">
				<?= $wf->MsgExt('marketing-toolbox-hub-module-explore-image-tip', array('parseinline')) ?>
            </p>
			<?=$app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['fileName'])
			);
			?>
			<?=$app->renderView(
			'MarketingToolbox',
			'FormField',
			array('inputData' => $fields['exploreTitle'])
		);
			?>
			<?=$app->renderView(
			'MarketingToolbox',
			'FormField',
			array('inputData' => $fields['imageLink'])
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
		<input class="secondary clear" type="button" value="Clear" />
	</div>
	<? for($i = 1; $i <= $sectionLimit; $i++): ?>
		<div class="module-box header-group grid-4 alpha">
			<div class="grid-2 alpha">
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreSectionHeader'.$i])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkText'.$i.'a'])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkText'.$i.'b'])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkText'.$i.'c'])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkText'.$i.'d'])
				);
				?>
			</div>
			<div class="grid-2 alpha url-group">
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkUrl'.$i.'a'])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkUrl'.$i.'b'])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkUrl'.$i.'c'])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkUrl'.$i.'d'])
				);
				?>
			</div>
			<input class="secondary clear" type="button" value="Clear" />
		</div>
	<? endfor; ?>
</div>
