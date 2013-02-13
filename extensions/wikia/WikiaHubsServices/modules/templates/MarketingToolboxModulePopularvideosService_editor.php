<?= $app->renderView(
	'MarketingToolbox',
	'FormField',
	array('inputData' => $fields['header'])
);
?>
<?= $app->renderView(
	'MarketingToolbox',
	'FormField',
	array('inputData' => array_merge(
			$fields['video'],
			array('index' => 0)
		)
	)
);
?>
<?= $app->renderView(
	'MarketingToolbox',
	'FormField',
	array('inputData' => array_merge(
		$fields['video'],
		array('index' => 1)
		)
	)
);
?>