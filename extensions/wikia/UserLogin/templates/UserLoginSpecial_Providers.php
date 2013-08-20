	<div class="sso-login">
		<div class="sso-login-divider">
			<span><?= wfMessage('userlogin-provider-or')->escaped() ?></span>
		</div>

		<?= $app->renderView('FacebookButton', 'index', array(
			'class' => 'sso-login-facebook',
			'text' => wfMessage('fbconnect-connect-simple')->escaped(),
			'tooltip' => (!empty($requestType) && $requestType === 'signup' ? 
				wfMessage('userlogin-provider-tooltip-facebook-signup')->escaped() : 
				wfMessage('userlogin-provider-tooltip-facebook')->escaped()),
			'tabindex' => $tabindex,
		)) ?>
	</div>