<div class="UserLoginModal">
	<h1><?= wfMsg('userlogin-login-heading') ?></h1>
<?php
	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));

	// 3rd party providers buttons
	echo $app->renderView('UserLoginSpecial', 'Providers', array('tabindex' => ++$tabindex));
?>
</div>
