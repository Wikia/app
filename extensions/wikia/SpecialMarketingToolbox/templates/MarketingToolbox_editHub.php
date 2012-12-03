<?= F::app()->renderView(
	'MarketingToolbox',
	'Header',
	$headerData
) ?>

<section class="MarketingToolboxMain WikiaGrid">
	<div class="grid-2">
		<?= F::app()->renderView('LeftMenu',
			'Index',
			array('menuItems' => $leftMenuItems)
		) ?>
	</div>
	<div class="grid-4 alpha">
		<? if (!empty($flashMessage)): ?>
			<p><?=$flashMessage ?></p>
		<? endif ?>

		<? if (!empty($errorMessage)): ?>
			<p class="error"><?=$errorMessage ?></p>
		<? endif ?>

		<input type="button" class="wmu-show" value="WMU test" />
		<?=$moduleContent?>
	</div>
</section>

<?= F::app()->renderView(
	'MarketingToolbox',
	'Footer'
) ?>