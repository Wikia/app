<?= F::app()->renderView(
	'MarketingToolbox',
	'Header',
	$headerData
) ?>

<?= F::app()->renderView('LeftMenu',
	'Index',
	array('menuItems' => $leftMenuItems)
) ?>
<section class="MarketingToolboxMain">
edithub
</section>

<?= F::app()->renderView(
	'MarketingToolbox',
	'Footer'
) ?>