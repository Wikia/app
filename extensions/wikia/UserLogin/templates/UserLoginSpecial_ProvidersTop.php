	<div class="sso-login">
		<?= $app->renderView('FacebookButton', 'index', array(
			'class' => 'sso-login-facebook',
			'text' => wfMsg('fbconnect-wikia-signup-w-facebook'),
			'tooltip' => (!empty($context) && $context === 'signup' ? 
				wfMsg('userlogin-provider-tooltip-facebook-signup') : 
				wfMsg('userlogin-provider-tooltip-facebook'))
		)) ?>
		<div class="sso-login-divider">
			<span><?= wfMsg('userlogin-provider-or') ?></span>
		</div>
	</div>