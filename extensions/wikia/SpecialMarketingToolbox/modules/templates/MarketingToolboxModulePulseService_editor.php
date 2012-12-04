<?

/*
echo $app->renderView(
	'WikiaStyleGuideForm',
	'index',
	array('form' => $data['form'])
);*/
?>

<div class="grid-4 alpha url-and-topic">
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

<div class="grid-2 alpha">
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['stat1'])
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['stat2'])
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['stat3'])
	);
	?>
</div>

<div class="grid-2 alpha">
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['number1'])
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['number2'])
	);
	?>
	<? $fields['number3']['class'] = 'test'; ?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['number3'])
	);
	?>
</div>