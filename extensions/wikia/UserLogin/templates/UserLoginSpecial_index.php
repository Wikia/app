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
		'value' => htmlspecialchars($username)
	);
	$userNameInput['errorMsg'] = $userNameInput['isInvalid'] ? $msg : '';

	$passwordInput = array(
		'type' => 'password',
		'name' => 'password',
		'class' => 'password-input',
		'isRequired' => true,
		'label' => wfMsg('yourpassword'),
		'isInvalid' => (!empty($errParam) && $errParam === 'password'),
		'value' => htmlspecialchars($password)
	);
	$passwordInput['errorMsg'] = $passwordInput['isInvalid'] ? $msg : '';
	
	$forgotPasswordLink = array(
		'type' => 'custom',
		'output' => '<a href="#" class="forgot-password">'.wfMsg('userlogin-forgot-password').'</a>',
	);

	$rememberMeInput = array(
		'type' => 'checkbox',
		'name' => 'keeploggedin',
		'class' => 'keep-logged-in',
		'isRequired' => false,
		'value' => '1',
		'checked' => $keeploggedin,
		'label' => wfMsg('userlogin-remembermypassword')
	);

	$loginBtn = array(
		'type' => 'submit',
		'value' => wfMsg('login'),
		'class' => 'login-button big'
	);

	$createAccount = array(
		'type' => 'custom',
		'output' => wfMsgExt('userlogin-get-account', 'parseinline'),
		'class' => 'get-account'
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
	if (!$isMonobookOrUncyclo) echo $app->renderView('UserLoginSpecial', 'Providers');
?>
</div>
