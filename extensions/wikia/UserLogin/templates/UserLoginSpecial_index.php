<div class="UserLogin">
<?
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
		'isRequired' => true,
		'label' => wfMsg('yourpassword'),
		'isInvalid' => (!empty($errParam) && $errParam === 'password'),
		'value' => htmlspecialchars($password)
	);
	$passwordInput['errorMsg'] = $passwordInput['isInvalid'] ? $msg : '';

	$rememberMeInput = array(
		'type' => 'checkbox',
		'name' => 'keeploggedin',
		'isRequired' => false,
		'value' => '1',
		'checked' => $keeploggedin,
		'label' => wfMsg('userlogin-remembermypassword')
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
			$rememberMeInput,
			$createAccount
		),
		'method' => 'post',
		'submits' => array(
			array(
				'value' => wfMsg('login'),
				'class' => 'login-button big'
			),
			array(
				'value' => wfMsg('userlogin-forgot-password'),
				'class' => 'forgot-password link',
				'name' => 'action'
			)
		)
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
