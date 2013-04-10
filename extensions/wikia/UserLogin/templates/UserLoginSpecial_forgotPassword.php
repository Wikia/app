<div class="UserLogin">
	<?
	$userNameInput = array(
		'type' => 'text',
		'name' => 'username',
		'isRequired' => true,
		'label' => wfMsg('yourname'),
		'isInvalid' => (!empty($errParam) && $errParam === 'username'),
		'value' => ''
	);
	$userNameInput['errorMsg'] = $userNameInput['isInvalid'] ? $msg : '';

	$forgotPasswordBtn = array(
		'type' => 'submit',
		'value' => wfMsg('userlogin-forgot-password-button'),
		'class' => 'login-button big',
	);

	$backToLoginLink = array(
		'type' => 'custom',
		'output' => $wf->msgExt('userlogin-forgot-password-go-to-login', 'parseinline'),
	);

	$form = array(
		'inputs' => array(
			$userNameInput,
			$forgotPasswordBtn,
			$backToLoginLink
		),
		'method' => 'post',
	);

	$form['isInvalid'] = !empty($result) && empty($errParam) && !empty($msg);
	$form['errorMsg'] = !empty($msg) ? $msg : '';

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
	?>
</div>
