<?
echo F::app()->renderView(
	'MarketingToolbox',
	'FormField'
);

echo $app->renderView(
	'WikiaStyleGuideForm',
	'index',
	array('form' => $data['form'])
);
?>