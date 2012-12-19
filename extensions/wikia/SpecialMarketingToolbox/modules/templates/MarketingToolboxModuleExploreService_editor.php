<div class="module-explore">
	<div class="module-box grid-4 alpha">
		<div class="grid-3 alpha">
			<input type="button" class="wmu-show" value="<?= $wf->Msg('marketing-toolbox-hub-module-explore-add-photo') ?>" />
			<span class="filename-placeholder alternative">
				<?= $wf->msg('marketing-toolbox-edithub-file-name') ?>
			</span>
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
		</div>
		<div class="grid-1 alpha">
			<div class="image-placeholder">
				<img src="<?= $wg->BlankImgUrl; ?>" />
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
