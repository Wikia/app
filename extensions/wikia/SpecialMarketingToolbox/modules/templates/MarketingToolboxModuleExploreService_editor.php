<div class="module-explore">
	<div class="photo-group grid-4 alpha">
		<div class="grid-3 alpha">
			photo editor (work in progress)
			<?=$app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['exploreTitle'])
			);
			?>
		</div>
		<div class="grid-1 alpha">
			placeholder (work in progress)
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
					array('inputData' => $fields['exploreLinkHeader'.$i.'a'])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkHeader'.$i.'b'])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkHeader'.$i.'c'])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkHeader'.$i.'d'])
				);
				?>
			</div>
			<div class="grid-2 alpha url-group">
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
						array('inputData' => $fields['exploreLinkUrl1a'])
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
