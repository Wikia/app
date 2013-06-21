<div class="UserLogin">
	<?
	$userNameInput = array(
		'type' => 'text',
		'name' => 'username',
		'isRequired' => true,
		'label' => wfMsg('yourname'),
		'value' => ''
	);

	$forgotPasswordBtn = array(
		'type' => 'submit',
		'value' => wfMsg('userlogin-forgot-password-button'),
		'class' => 'login-button big',
	);

	$backToLoginLink = array(
		'type' => 'custom',
		'output' => wfmsgExt('userlogin-forgot-password-go-to-login', 'parseinline'),
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
