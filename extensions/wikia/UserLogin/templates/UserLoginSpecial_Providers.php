	<div class="sso-login">
		<div class="sso-login-divider">
			<span><?= wfMsg('userlogin-provider-or') ?></span>
		</div>

		<?= $app->renderView('FacebookButton', 'index', array(
			'class' => 'sso-login-facebook',
			'text' => wfMsg('fbconnect-connect-simple'),
			'tooltip' => (!empty($context) && $context === 'signup' ? 
				wfMsg('userlogin-provider-tooltip-facebook-signup') : 
				wfMsg('userlogin-provider-tooltip-facebook'))
		)) ?>
	</div>