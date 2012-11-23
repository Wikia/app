<?= F::app()->renderView(
	'MarketingToolbox',
	'Header',
	$headerData
) ?>

<?= F::app()->renderView('LeftMenu',
	'Index',
	array('menuItems' => $leftMenuItems)
) ?>
<?= $app->renderView('MarketingToolbox','topNav',$app->wg->request->getValues()) ?>
<?= $app->renderView('MarketingToolbox','leftMenu',$app->wg->request->getValues()) ?>
editHub
<?= $app->renderView('MarketingToolbox','footer',$app->wg->request->getValues()) ?>
