	<div class="sso-login">
		<div class="sso-login-divider">
			<span><?= wfMsg('userlogin-provider-or') ?></span>
		</div>

		<?= $app->renderView('FacebookButton', 'index', array(
			'class' => 'sso-login-facebook',
			'text' => wfMsg('fbconnect-connect-simple'),
			'tabindex' => (!empty($dropdown) ? 5 : 10), //tabindex=5 in dropdown, 10 on Special:UserLogin
			'tooltip' => (!empty($requestType) && $requestType === 'signup' ? 
				wfMsg('userlogin-provider-tooltip-facebook-signup') : 
				wfMsg('userlogin-provider-tooltip-facebook'))
		)) ?>
	</div>