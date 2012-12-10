<<<<<<< HEAD
<div class="grid-4 alpha wide">
	<?= F::app()->renderView(
			'MarketingToolbox',
			'FormField',
			array('inputData' => $fields['exploreTitle'])
		);
	?>
	<?= F::app()->renderView(
			'MarketingToolbox',
			'FormField',
			array('inputData' => $fields['exploreSectionHeader1'])
		);
	?>
	<?= F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkHeader1a'])
	);
	?>
	<?= F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkUrl1a'])
	);
	?>
	<?= F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkHeader1b'])
	);
	?>
	<?= F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkUrl1b'])
	);
	?>
	<?= F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkHeader1c'])
	);
	?>
	<?= F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkUrl1c'])
	);
	?>
	<?= F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkHeader1d'])
	);
	?>
	<?= F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['exploreLinkUrl1d'])
=======
<? $mockedInputData = array('label' => 'test', 'errorMessage' => '', 'type' => 'text', 'attributes' => '', 'isRequired' => false, 'name' => '', 'value' => ''); ?>

<div class="grid-2 alpha">
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $mockedInputData)
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $mockedInputData)
	);
	?>
	<?=F::app()->renderView(
	'MarketingToolbox',
	'FormField',
	array('inputData' => $mockedInputData)
);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $mockedInputData)
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $mockedInputData)
	);
	?>
</div>

<div class="grid-2 alpha">
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $mockedInputData)
	);
	?>
		<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $mockedInputData)
	);
	?>
		<? $fields['number3']['class'] = 'borderNone'; ?>
		<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $mockedInputData)
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $mockedInputData)
	);
	?>
	<?=F::app()->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $mockedInputData)
>>>>>>> bugid-84692: explore module: Templating / CSS
	);
	?>
</div>
