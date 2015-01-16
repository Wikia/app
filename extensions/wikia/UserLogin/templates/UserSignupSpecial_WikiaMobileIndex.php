<section class="WikiaSignup wkForm">
<?php
	$form = [
		'id' => 'WikiaSignupForm',
		'method' => 'post',
		'inputs' => [
			[
				'type' => 'hidden',
				'name' => 'signupToken',
				'value' => Sanitizer::encodeAttribute( $signupToken ),
			],
			[ //fake username field ( not in use )
				'type' => 'hidden',
				'name' => 'username',
				'value' => '',
				'label' => wfMessage( 'yourname' )->text(),
			],
			[ //actual username field
				'type' => 'text',
				'name' => 'userloginext01',
				'value' => htmlspecialchars( $username ),
				'placeholder' => wfMessage( 'yourname' )->text(),
				'isRequired' => true,
				'isInvalid' => ( !empty( $errParam ) && $errParam === 'username' ),
				'errorMsg' => ( !empty( $msg ) ? $msg : '' )
			],
			[
				'type' => 'email',
				'name' => 'email',
				'value' => Sanitizer::encodeAttribute( $email ),
				'placeholder' => wfMessage( 'email' )->text(),
				'isRequired' => true,
				'isInvalid' => ( !empty( $errParam ) && $errParam === 'email' ),
				'errorMsg' => ( !empty( $msg ) ? $msg : '' )
			],
			[ //fake password field ( not in use )
				'type' => 'hidden',
				'name' => 'password',
				'value' => '',
				'label' => wfMessage( 'yourpassword' )->text(),
			],
			[ //actual password field
				'type' => 'password',
				'name' => 'userloginext02',
				'value' => '',
				'placeholder' => wfMessage( 'yourpassword' )->text(),
				'isRequired' => true,
				'isInvalid' => ( !empty( $errParam ) && $errParam === 'password' ),
				'errorMsg' => ( !empty( $msg ) ? $msg : '' )
			],
			[
				'type' => 'hidden',
				'name' => 'wpRegistrationCountry',
				'value' => '',
			],
			[
				'type' => 'nirvanaview',
				'controller' => 'UserSignupSpecial',
				'view' => 'birthday',
				'isRequired' => true,
				'class' => 'birthday-group',
				'isInvalid' => ( !empty( $errParam ) && $errParam === 'birthyear' ) ||
					( !empty( $errParam ) && $errParam === 'birthmonth' ) ||
					( !empty( $errParam ) && $errParam === 'birthday' ),
				'errorMsg' => ( !empty( $msg ) ? $msg : '' ),
				'params' => [
					'birthyear' => $birthyear,
					'birthmonth' => $birthmonth,
					'birthday' => $birthday,
					'isEn' => $isEn
				],
			],
			[
				'type' => 'nirvanaview',
				'controller' => 'UserSignupSpecial',
				'view' => 'WikiaMobileSubmit',
				'class' => 'submit-pane',
				'params' => ['createAccountButtonLabel' => $createAccountButtonLabel]
			]
		]
	];

	$form['isInvalid'] = !empty( $result ) && $result === 'error' && empty( $errParam );
	$form['errorMsg'] = $form['isInvalid'] ? $msg : '';

	if( !empty( $returnto ) ) {
		$form['inputs'][] = [
			'type' => 'hidden',
			'name' => 'returnto',
			'value' => Sanitizer::encodeAttribute( $returnto )
		];
	}

	if( !empty( $byemail ) ) {
		$form['inputs'][] = [
			'type' => 'hidden',
			'name' => 'byemail',
			'value' => Sanitizer::encodeAttribute( $byemail )
		];
	}

	echo F::app()->renderView( 'WikiaStyleGuideForm', 'index', ['form' => $form] );
?>
</section>
