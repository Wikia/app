<div class="grid-4 alpha wide">
	<?=F::app()->renderView(
	'MarketingToolbox',
	'FormField',
	array('inputData' => $fields['boardTitle'])
);
	?>
	<?=F::app()->renderView(
	'MarketingToolbox',
	'FormField',
	array('inputData' => $fields['boardDescription'])
);
	?>
</div>