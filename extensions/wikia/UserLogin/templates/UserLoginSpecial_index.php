<div class="UserLogin">
<?php
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
		'tabindex' => 6,
	);
	$userNameInput['errorMsg'] = $userNameInput['isInvalid'] ? $msg : '';

	$passwordInput = array(
		'type' => 'password',
		'name' => 'password',
		'isRequired' => true,
		'label' => wfMsg('yourpassword'),
		'isInvalid' => (!empty($errParam) && $errParam === 'password'),
		'value' => htmlspecialchars($password),
		'tabindex' => 7,
	);
	$passwordInput['errorMsg'] = $passwordInput['isInvalid'] ? $msg : '';

	$forgotPassword = array(
		'type' => 'custom',
		'output' => '<a href="#" class="forgot-password">'.wfMsg('userlogin-forgot-password').'</a>',
	);

	$rememberMeInput = array(
		'type' => 'checkbox',
		'name' => 'keeploggedin',
		'isRequired' => false,
		'value' => '1',
		'checked' => $keeploggedin,
		'label' => wfMsg('userlogin-remembermypassword'),
		'tabindex' => 8,
	);

	$loginButton = array(
		'type' => 'submit',
		'value' => wfMsg('login'),
		'class' => 'login-button big',
		'tabindex' => 9,
	);

	$specialSignupLink = SpecialPage::getTitleFor('UserSignup')->getLocalURL();
	$specialSignupLinkTabindex = 10;
	$createAccount = array(
		'type' => 'custom',
		'output' => wfMsgExt('userlogin-get-account', 'content', array($specialSignupLink, $specialSignupLinkTabindex)),
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
	if (!$isMonobookOrUncyclo) echo $app->renderView('UserLoginSpecial', 'Providers');
?>
</div>
