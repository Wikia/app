<div class="UserLoginModal">
	<h1><?= wfMsg('userlogin-login-heading') ?></h1>
<?php
	$tabindex = 5;
	$specialSignupLink = SpecialPage::getTitleFor('UserSignup')->getLocalURL();
	
	$form = array(
		'inputs' => array(
			array(
				'type' => 'hidden',
				'name' => 'loginToken',
				'value' => $loginToken,
			),
			array(
				'type' => 'hidden',
				'name' => 'returnto',
				'value' => ''
			),
			array(
				'type' => 'text',
				'name' => 'username',
				'isRequired' => true,
				'label' => wfMsg('yourname'),
				'tabindex' => ++$tabindex,
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'isRequired' => true,
				'label' => wfMsg('yourpassword'),
				'tabindex' => ++$tabindex,
			),
			array(
				'type' => 'custom',
				'output' => '<a href="#" class="forgot-password" tabindex="0">'.wfMsg('userlogin-forgot-password').'</a>',
			),
			array(
				'type' => 'checkbox',
				'name' => 'keeploggedin',
				'value' => '1',
				'label' => wfMsg('userlogin-remembermypassword'),
				'class' => 'keeploggedin',
				'tabindex' => ++$tabindex,
			),
			array(
				'type' => 'submit',
				'value' => wfMsg('login'),
				'class' => 'login-button big',
				'tabindex' => ++$tabindex,
			),
			array(
				'type' => 'custom',
				'output' => wfMsgExt('userlogin-get-account', 'content', array($specialSignupLink, ++$tabindex)),
				'class' => 'get-account'
			),
		),
		'method' => 'post',
		'action' => $formPostAction,
	);

	//$form['isInvalid'] = true;
	//$form['errorMsg'] = '';

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
	echo $app->renderView('UserLoginSpecial', 'Providers', array('tabindex' => ++$tabindex));
?>
</div>
