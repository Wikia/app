<noscript>This page is not supported with Javascript turned off.</noscript>
<div class="WikiaGrid VPTForms">
	<div class="grid-2 alpha">
		<?= $app->renderView('LeftMenu',
			'Index',
			array('menuItems' => $leftMenuItems)
		) ?>
	</div>
	<div class="grid-4">

		<? if( !empty( $error ) ): ?>
			<? // TODO: Error message goes here ?>
			<p class="error" id="vpt-form-error">Error</p>
		<? endif; ?>

		<? if( !empty( $success ) ): ?>
			<? // TODO: Success message goes here ?>
			<p class="success" id="vpt-form-success">Success</p>
		<? endif; ?>

		<?= $moduleView ?>
	</div>
	<div class="publish">
		<button class="big"><?= wfMessage( 'videopagetool-publish-button' )->text() ?></button>
	</div>
</div>