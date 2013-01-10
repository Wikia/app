<div class="UserLogin">
<?php
	$tabindex = 5;
	
	$loginTokenInput = array(
		'type' => 'hidden',
		'name' => 'loginToken',
		'value' => $loginToken
	);

	$userNameInput = array(
		'type' => 'text',
		'name' => 'username',
		'isRequired' => true,
		'label' => wfMsg('yourname'),
		'isInvalid' => (!empty($errParam) && $errParam === 'username'),
		'value' => htmlspecialchars($username),
		'tabindex' => ++$tabindex,
	);
	$userNameInput['errorMsg'] = $userNameInput['isInvalid'] ? $msg : '';

	$passwordInput = array(
		'type' => 'password',
		'name' => 'password',
		'isRequired' => true,
		'label' => wfMsg('yourpassword'),
		'isInvalid' => (!empty($errParam) && $errParam === 'password'),
		'value' => htmlspecialchars($password),
		'tabindex' => ++$tabindex,
	);
	$passwordInput['errorMsg'] = $passwordInput['isInvalid'] ? $msg : '';

	$forgotPassword = array(
		'type' => 'custom',
		'output' => '<a href="#" class="forgot-password" tabindex="0">'.wfMsg('userlogin-forgot-password').'</a>',
	);

	$rememberMeInput = array(
		'type' => 'checkbox',
		'name' => 'keeploggedin',
		'isRequired' => false,
		'value' => '1',
		'checked' => $keeploggedin,
		'label' => wfMsg('userlogin-remembermypassword'),
		'tabindex' => ++$tabindex,
	);

	$loginButton = array(
		'type' => 'submit',
		'value' => wfMsg('login'),
		'class' => 'login-button big',
		'tabindex' => ++$tabindex,
	);

	$specialSignupLink = SpecialPage::getTitleFor('UserSignup')->getLocalURL();
	$createAccount = array(
		'type' => 'custom',
		'output' => wfMsgExt('userlogin-get-account', 'content', array($specialSignupLink, ++$tabindex)),
		'class' => 'get-account'
	);

	$form = array(
		'inputs' => array(
			$loginTokenInput,
			$userNameInput,
			$passwordInput,
			$forgotPassword,
			$rememberMeInput,
			$loginButton,
			$createAccount,
		),
		'method' => 'post',
	);

	$form['isInvalid'] = !empty($result) && empty($errParam) && !empty($msg);
	$form['errorMsg'] = !empty($msg) ? $msg : '';

	if(!empty($returnto)) {
		$form['inputs'][] = array(
			'type' => 'hidden',
			'name' => 'returnto',
			'value' => $returnto
		);
	}

	if(!empty($returntoquery)) {
		$form['inputs'][] = array(
			'type' => 'hidden',
			'name' => 'returntoquery',
			'value' => $returntoquery
		);
	}

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));

	// 3rd party providers buttons
	if (!$isMonobookOrUncyclo) echo $app->renderView('UserLoginSpecial', 'Providers', array('tabindex' => ++$tabindex));
?>
</div>
