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
			<p class="success"><?=$flashMessage ?></p>
		<? endif ?>

		<? if (!empty($errorMessage)): ?>
			<p class="error"><?=$errorMessage ?></p>
		<? endif ?>

		<form id="marketing-toolbox-form" method="post" name="upload-tool" class="WikiaForm" enctype="multipart/form-data">
			<?=$moduleContent?>

			<div class="submits">
				<input id="marketing-toolbox-clearall" class="secondary" type="button" value="<?= $wf->msg('marketing-toolbox-edithub-clearall-button'); ?>" />
				<input type="submit" value="<?= wfMsg('marketing-toolbox-edithub-save-button'); ?>" disabled="disabled" />
			</div>
		</form>
	</div>
</section>

<?= F::app()->renderView(
	'MarketingToolbox',
	'Footer'
) ?>