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
<?=$moduleContent?>
<input type="button" class="wmu-show" value="WMU test" />
</section>

<?= F::app()->renderView(
	'MarketingToolbox',
	'Footer'
) ?>