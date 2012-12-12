<div class="grid-4 alpha wide">
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['boardUrl'])
	);
	?>
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['boardTitle'])
	);
	?>
</div>

<div class="grid-2 alpha">
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['stat1'])
	);
	?>
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['stat2'])
	);
	?>
	<? $fields['stat3']['class'] = 'borderNone'; ?>
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['stat3'])
	);
	?>
</div>

<div class="grid-2 alpha">
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['number1'])
	);
	?>
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['number2'])
	);
	?>
	<? $fields['number3']['class'] = 'borderNone'; ?>
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['number3'])
	);
	?>
</div>