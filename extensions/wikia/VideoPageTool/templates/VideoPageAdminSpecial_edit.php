<noscript>This page is not supported with Javascript turned off.</noscript>
<p><?= wfMessage( 'videopagetoo-date-header' ) ->params( $publishDate )->plain() ?></p>
<div class="WikiaGrid VPTForms">
	<div class="grid-2 alpha">
		<?= $app->renderView('LeftMenu',
			'Index',
			array('menuItems' => $leftMenuItems)
		) ?>
	</div>
	<div class="grid-4">

		<? if ( $result == 'error' ): ?>
			<p class="error" id="vpt-form-error"><?= $msg ?></p>
		<? elseif ( $result == 'ok' ): ?>
			<p class="success" id="vpt-form-success"><?= $msg ?></p>
		<? endif; ?>

		<?= $moduleView ?>
	</div>
	<div class="publish">
		<form class="WikiaForm" method="post" action="<?= $publishUrl ?>">
			<button type="submit" class="big" name="action" value="publish" <?= $publishButton ?>><?= wfMessage( 'videopagetool-publish-button' )->text() ?></button>
		</form>
	</div>
</div>