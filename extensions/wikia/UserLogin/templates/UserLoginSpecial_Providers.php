	<div class="sso-login">
		<div class="sso-login-divider">
			<span><?= wfMessage('userlogin-provider-or')->escaped() ?></span>
		</div>

		<?= $app->renderView('FacebookButton', 'index', array(
			'class' => 'sso-login-facebook',
			'text' => wfMessage( F::app()->wg->EnableFacebookClientExt ? 'facebookclient-connect-simple' : 'fbconnect-connect-simple')->escaped(),
			'tabindex' => $tabindex,
		)) ?>
	</div>