<? for ($i = 1; $i <= $slidesCount; $i++): ?>

	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['photo' . $i])
	);
	?>
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['shortDesc' . $i])
	);
	?>
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['longDesc' . $i])
	);
	?>
	<?=$app->renderView(
		'MarketingToolbox',
		'FormField',
		array('inputData' => $fields['url' . $i])
	);
	?>

<? endfor ?>