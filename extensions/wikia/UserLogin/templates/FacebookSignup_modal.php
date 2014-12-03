<div class="UserLoginFacebook">
	<section class="UserLoginFacebookWrapper">
		<section class="UserLoginFacebookLeft">

<?php
	$form = [
		'inputs' => [
			[
				'type' => 'text',
				'name' => 'username',
				'isRequired' => true,
				'label' => wfMessage( 'yourname' )->escaped(),
			],
			[
				'type' => 'password',
				'name' => 'password',
				'isRequired' => true,
				'label' => wfMessage( 'yourpassword' )->escaped(),
			],
			[
				'type' => 'hidden',
				'name' => 'loginToken',
				'value' => Sanitizer::encodeAttribute( $loginToken ),
			],
			[
				'type' => 'hidden',
				'name' => 'returntourl',
				'value' => Sanitizer::encodeAttribute( $returnToUrl ),
			],
		],
		'method' => 'post',
	];

	if ( trim( $fbEmail ) == '' ) {
		$form['inputs'][] = [
			'type' => 'email',
			'name' => 'email',
			'isRequired' => true,
			'label' => wfMessage( 'email' )->escaped(),
		];
	} else {
		$form['inputs'][] = [
			'type' => 'nirvana',
			'class' => 'email',
			'controller' => 'WikiaStyleGuideTooltipIconController',
			'method' => 'index',
			'params' => [
				'text' => wfMessage('email')->escaped(),
				'tooltipIconTitle' => wfMessage( 'usersignup-facebook-email-tooltip' )->plain(),
			],
		];

		$form['inputs'][] = [
			'type' => 'custom',
			'output' => '<strong>' . htmlspecialchars( $fbEmail ) . '</strong>'
		];
	}

	$form['inputs'][] = [
		'type' => 'nirvanaview',
		'controller' => 'UserSignupSpecial',
		'view' => 'submit',
		'class' => 'submit-pane error modal-pane',
		'params' => ['createAccountButtonLabel' => wfMessage( 'createaccount' )->escaped()]
	];

	echo F::app()->renderView( 'WikiaStyleGuideForm', 'index', ['form' => $form] );

	// A temporary hacky dup template, just to make sign in works, follows!
	$loginForm = [
		'inputs' => [
			[
				'type' => 'text',
				'name' => 'username',
				'isRequired' => true,
				'label' => wfMessage( 'yourname' )->escaped(),
			],
			[
				'type' => 'password',
				'name' => 'password',
				'isRequired' => true,
				'label' => wfMessage( 'yourpassword' )->escaped(),
			],
			[
				'type' => 'hidden',
				'name' => 'loginToken',
				'value' => Sanitizer::encodeAttribute( $loginToken ),
			],
			[
				'type' => 'hidden',
				'name' => 'returntourl',
				'value' => Sanitizer::encodeAttribute( $returnToUrl ),
			],
			[
				'type' => 'nirvanaview',
				'controller' => 'UserSignupSpecial',
				'view' => 'submit',
				'class' => 'submit-pane error modal-pane',
				'params' => [
					'createAccountButtonLabel' => strtoupper(
						wfMessage( 'userlogin-login-heading' )->escaped()
					)
				],
			],
		],
		'method' => 'post',
	];

?>
		</section>

		<section class="UserLoginFacebookRight">
			<h1><?= wfMessage( 'usersignup-facebook-have-an-account-heading' )->escaped() ?></h1>
			<p><?= wfMessage( 'usersignup-facebook-have-an-account' )->escaped() ?></p>
			<?= F::app()->renderView( 'WikiaStyleGuideForm', 'index', ['form' => $loginForm] ); ?>
		</section>
	</section>
</div>