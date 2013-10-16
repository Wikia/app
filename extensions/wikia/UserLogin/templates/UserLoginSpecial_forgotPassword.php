<div class="UserLogin">
	<?
	$userNameInput = array(
		'type' => 'text',
		'name' => 'username',
		'isRequired' => true,
		'label' => wfMessage('yourname')->escaped(),
		'value' => ''
	);

	$forgotPasswordBtn = array(
		'type' => 'submit',
		'value' => wfMessage('userlogin-forgot-password-button')->escaped(),
		'class' => 'login-button big',
	);

	$backToLoginLink = array(
		'type' => 'custom',
		'output' => wfMessage('userlogin-forgot-password-go-to-login')->parse(),
	);

	if (isset($result) && ($result == 'error')) {
		$userNameInput['isInvalid'] = true;
		$userNameInput['errorMsg'] = $msg;
	}

	$form = array(
		'inputs' => array(
			$userNameInput,
			$forgotPasswordBtn,
			$backToLoginLink
		),
		'method' => 'post',
	);

	if (isset($result) && ($result == 'ok')) {
		$form['success'] = true;
		$form['errorMsg'] = $msg;
	}

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
	?>
</div>
