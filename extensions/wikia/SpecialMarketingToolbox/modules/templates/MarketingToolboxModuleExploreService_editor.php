<div class="module-explore">
<div class="header-group grid-4 alpha">
<div class="grid-2 alpha">
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreSectionHeader1'])
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkHeader1a'])
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkHeader1b'])
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkHeader1c'])
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkHeader1d'])
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
		array('inputData' => $fields['exploreLinkUrl1b'])
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkUrl1c'])
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkUrl1d'])
	);
	?>
</div>
</div>
</div>
