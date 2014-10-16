<?= $app->renderView(
	'EditHub',
	'Header',
	$headerData
) ?>

<section class="EditHubMain WikiaGrid">
	<div class="grid-2">
		<?= $app->renderView('LeftMenu',
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

		<form id="edit-hub-form" data-module-name="<?= $moduleName ?>" method="post" name="upload-tool" class="WikiaForm" enctype="multipart/form-data">
			<?=$moduleContent?>

			<div class="submits">
				<?php if( $selectedModuleId == WikiaHubsModulePopularvideosService::MODULE_ID ): ?>
					<input id="edit-hub-removeall" name="removeall" class="secondary" type="button" value="<?= wfMessage('edit-hub-edithub-removeall-button')->escaped(); ?>" />
				<?php else: ?>
                	<input id="edit-hub-clearall" name="clearall" class="secondary" type="button" value="<?= wfMessage('edit-hub-edithub-clearall-button')->escaped(); ?>" />
				<?php endif; ?>

				<input type="submit" value="<?= wfMessage('edit-hub-edithub-save-button')->escaped(); ?>" />
			</div>
		</form>
	</div>
</section>

<?= $app->renderView(
	'EditHub',
	'Footer',
	$footerData
) ?>
