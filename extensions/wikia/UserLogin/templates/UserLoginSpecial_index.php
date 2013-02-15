<div class="UserLogin">
<?php
	$tabIndex = 5;
	
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
		'tabindex' => ++$tabIndex,
	);
	$userNameInput['errorMsg'] = $userNameInput['isInvalid'] ? $msg : '';

	$passwordInput = array(
		'type' => 'password',
		'name' => 'password',
		'class' => 'password-input',
		'isRequired' => true,
		'label' => wfMsg('yourpassword'),
		'isInvalid' => (!empty($errParam) && $errParam === 'password'),
		'value' => htmlspecialchars($password),
		'tabindex' => ++$tabIndex,
	);
	$passwordInput['errorMsg'] = $passwordInput['isInvalid'] ? $msg : '';

	$forgotPasswordLinkUrl = SpecialPage::getTitleFor('UserLogin')->getLocalURL(array('type' => 'forgotPassword'));

	$forgotPasswordLink = array(
		'type' => 'custom',
		'output' => '<a href="'. $forgotPasswordLinkUrl .'" class="forgot-password" tabindex="0">'
			. wfMsg('userlogin-forgot-password')
			. '</a>',
	);

	$rememberMeInput = array(
		'type' => 'checkbox',
		'name' => 'keeploggedin',
		'class' => 'keep-logged-in',
		'isRequired' => false,
		'value' => '1',
		'checked' => $keeploggedin,
		'label' => wfMsg('userlogin-remembermypassword'),
		'tabindex' => ++$tabIndex,
	);

	$loginBtn = array(
		'type' => 'submit',
		'value' => wfMsg('login'),
		'class' => 'login-button big',
		'tabindex' => ++$tabIndex,
	);

	$specialSignupLink = SpecialPage::getTitleFor('UserSignup')->getLocalURL();
	$createAccount = array(
		'type' => 'custom',
		'output' => wfMsgExt('userlogin-get-account', 'content', array($specialSignupLink, ++$tabIndex)),
		'class' => 'get-account',
		'tabindex' => ++$tabIndex,
	);

	$form = array(
		'inputs' => array(
			$loginTokenInput,
			$userNameInput,
			$passwordInput,
			$forgotPasswordLink,
			$rememberMeInput,
			$loginBtn,
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
	if (!$isMonobookOrUncyclo) echo $app->renderView('UserLoginSpecial', 'Providers', array( 'tabindex' => ++$tabIndex ));
?>
</div>
