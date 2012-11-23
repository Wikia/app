<?= F::app()->renderView(
	'MarketingToolbox',
	'Header',
	$headerData
) ?>

<?= F::app()->renderView('LeftMenu',
	'Index',
	array('menuItems' => $leftMenuItems)
) ?>
editHub
