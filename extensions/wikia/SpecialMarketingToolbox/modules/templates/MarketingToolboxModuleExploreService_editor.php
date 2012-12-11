<div class="module-explore">
	<div class="photo-group grid-4 alpha">
		<div class="grid-3 alpha">
			photo editor (work in progress)
			<?=F::app()->renderView(
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
				<?=F::app()->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreSectionHeader'.$i])
				);
				?>
				<?=F::app()->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkHeader'.$i.'a'])
				);
				?>
				<?=F::app()->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkHeader'.$i.'b'])
				);
				?>
				<?=F::app()->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkHeader'.$i.'c'])
				);
				?>
				<?=F::app()->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkHeader'.$i.'d'])
				);
				?>
			</div>
			<div class="grid-2 alpha url-group">
				<?=F::app()->renderView(
					'MarketingToolbox',
					'FormField',
						array('inputData' => $fields['exploreLinkUrl1a'])
					);
				?>
				<?=F::app()->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkUrl'.$i.'b'])
				);
				?>
				<?=F::app()->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkUrl'.$i.'c'])
				);
				?>
				<?=F::app()->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['exploreLinkUrl'.$i.'d'])
				);
				?>
			</div>
		</div>
	<? endfor; ?>
</div>
