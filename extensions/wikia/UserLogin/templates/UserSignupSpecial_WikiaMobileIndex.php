<section class="WikiaSignup wkForm">
<?php
	$form = array(
		'id' => 'WikiaSignupForm',
		'method' => 'post',
		'inputs' => array(
			array(
				'type' => 'hidden',
				'name' => 'signupToken',
				'value' => $signupToken
			),
			array( //fake username field (not in use)
				'type' => 'hidden',
				'name' => 'username',
				'value' => '',
				'label' => wfMessage('yourname')->text(),
			),
			array( //actual username field
				'type' => 'text',
				'name' => 'userloginext01',
				'value' => htmlspecialchars($username),
				'placeholder' => wfMessage('yourname')->text(),
				'isRequired' => true,
				'isInvalid' => (!empty($errParam) && $errParam === 'username'),
				'errorMsg' => (!empty($msg) ? $msg : '')
			),
			array(
				'type' => 'text',
				'name' => 'email',
				'value' => Sanitizer::encodeAttribute( $email ),
				'placeholder' => wfMessage('email')->text(),
				'isRequired' => true,
				'isInvalid' => (!empty($errParam) && $errParam === 'email'),
				'errorMsg' => (!empty($msg) ? $msg : '')
			),
			array( //fake password field (not in use)
				'type' => 'hidden',
				'name' => 'password',
				'value' => '',
				'label' => wfMessage('yourpassword')->text(),
			),
			array( //actual password field
				'type' => 'password',
				'name' => 'userloginext02',
				'value' => '',
				'placeholder' => wfMessage('yourpassword')->text(),
				'isRequired' => true,
				'isInvalid' => (!empty($errParam) && $errParam === 'password'),
				'errorMsg' => (!empty($msg) ? $msg : '')
			),
			array(
				'type' => 'nirvanaview',
				'controller' => 'UserSignupSpecial',
				'view' => 'birthday',
				'isRequired' => true,
				'isInvalid' => (!empty($errParam) && $errParam === 'birthyear') || (!empty($errParam) && $errParam === 'birthmonth') || (!empty($errParam) && $errParam === 'birthday'),
				'errorMsg' => (!empty($msg) ? $msg : ''),
				'params' => array('birthyear' => $birthyear, 'birthmonth' => $birthmonth, 'birthday' => $birthday, 'isEn' => $isEn),
			),
			array(
				'type' => 'nirvanaview',
				'controller' => 'UserSignupSpecial',
				'view' => 'WikiaMobileSubmit',
				'class' => 'submit-pane',
				'params' => array('createAccountButtonLabel' => $createAccountButtonLabel)
			)
		)
	);

	$form['isInvalid'] = !empty($result) && $result === 'error' && empty($errParam);
	$form['errorMsg'] = $form['isInvalid'] ? $msg : '';

	if(!empty($returnto)) {
		$form['inputs'][] = array(
			'type' => 'hidden',
			'name' => 'returnto',
			'value' => Sanitizer::encodeAttribute( $returnto )
		);
	}

	if(!empty($byemail)) {
		$form['inputs'][] = array(
			'type' => 'hidden',
			'name' => 'byemail',
			'value' => Sanitizer::encodeAttribute( $byemail )
		);
	}

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>
</section>
