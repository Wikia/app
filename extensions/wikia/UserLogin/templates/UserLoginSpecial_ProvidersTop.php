	<div class="sso-login hidden">
		<?= $app->renderView( 'FacebookButton', 'index', array(
			'class' => 'sso-login-facebook',
			'text' => wfMessage( 'fbconnect-wikia-signup-w-facebook' )->escaped()
		) ) ?>
		<div class="sso-login-divider">
			<span><?= wfMessage( 'userlogin-provider-or' )->escaped() ?></span>
		</div>
	</div>