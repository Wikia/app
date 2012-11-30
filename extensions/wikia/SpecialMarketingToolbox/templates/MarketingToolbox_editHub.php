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
		<form method="post" name="upload-tool" class="WikiaForm" enctype="multipart/form-data">
			<?=$moduleContent?>

			<input type="submit" value="<?= wfMsg('marketing-toolbox-edithub-save-button'); ?>" />
		</form>
	</div>
</section>

<?= F::app()->renderView(
	'MarketingToolbox',
	'Footer'
) ?>