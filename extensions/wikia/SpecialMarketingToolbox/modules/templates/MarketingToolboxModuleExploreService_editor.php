<div class="module-explore">
	<div class="photo-group grid-4 alpha">
		<div class="grid-3 alpha">
			<input type="button" class="wmu-show" value="<?= $wf->Msg('marketing-toolbox-hub-module-explore-add-photo') ?>" />
			<p class="wmu-file-name">
				<?= $wf->msg('marketing-toolbox-edithub-file-name') ?>
			</p>
			<?=$app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['exploreTitle'])
			);
			?>
		</div>
		<div class="grid-1 alpha">
			<div class="placeholder"></div>
		</div>
	</div>
	<? for($i = 1; $i <= $sectionLimit; $i++): ?>
		<div class="header-group grid-4 alpha">
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
		</div>
	<? endfor; ?>
</div>
