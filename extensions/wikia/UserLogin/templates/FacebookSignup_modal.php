<?php

// Form for connecting current user with facebook
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
			'name' => 'returntourl',
			'value' => Sanitizer::encodeAttribute( $returnToUrl ),
		],
		[
			'type' => 'nirvanaview',
			'controller' => 'UserLogin',
			'view' => 'forgotPasswordLink',
			'class' => 'forgot-password-container',
		],
		[
			'type' => 'hidden',
			'name' => 'loginToken',
			'value' => Sanitizer::encodeAttribute( $loginToken ),
		],
	],
	'submits' => [
		[
			'value' => wfMessage( 'userlogin-login-heading' )->escaped(),
			'name' => 'action',
			'class' => 'big login-button',
		]
	],
	'method' => 'post',
];


// Form for creating new user with facebook
$signupForm = [
	'inputs' => [
		[
			'type' => 'text',
			'name' => $usernameKey,
			'isRequired' => true,
			'label' => wfMessage( 'yourname' )->escaped(),
		],
		[
			'type' => 'password',
			'name' => $passwordKey,
			'isRequired' => true,
			'label' => wfMessage( 'yourpassword' )->escaped(),
		],
		[
			'type' => 'hidden',
			'name' => 'returntourl',
			'value' => Sanitizer::encodeAttribute( $returnToUrl ),
		],
		[
			'type' => 'hidden',
			'name' => 'wpRegistrationCountry',
			'value' => '',
		],
		[
			'type' => 'hidden',
			'name' => 'signupToken',
			'value' => Sanitizer::encodeAttribute( $loginToken ),
		],
	],
	'method' => 'post',
];

// Facebook may or may not provide the user's email
if ( trim( $fbEmail ) == '' ) {
	$emailInput = [
		'type' => 'email',
		'name' => 'email',
		'isRequired' => true,
		'label' => wfMessage( 'email' )->escaped(),
	];

	// insert the email input after the username input for consistency with other forms.
	array_splice( $signupForm['inputs'], 1, 0, [$emailInput] );
} else {
	// add email view at the end of the form
	$signupForm['inputs'][] = [
		'type' => 'nirvana',
		'class' => 'email',
		'controller' => 'WikiaStyleGuideTooltipIconController',
		'method' => 'index',
		'params' => [
			'text' => wfMessage( 'email' )->escaped(),
			'tooltipIconTitle' => wfMessage( 'usersignup-facebook-email-tooltip' )->text(),
		],
	];

	$signupForm['inputs'][] = [
		'type' => 'custom',
		'output' => '<strong>' . htmlspecialchars( $fbEmail ) . '</strong>'
	];
}

$signupForm['inputs'][] = [
	'class' => 'opt-in-container hidden',
	'type' => 'checkbox',
	'name' => 'wpMarketingOptIn',
	'label' => wfMessage( 'userlogin-opt-in-label' )->escaped(),
];

$signupForm['inputs'][] = [
	'type' => 'custom',
	'class' => 'wikia-terms',
	'output' => wfMessage('prefs-help-terms')->parse()
];

$signupForm['submits'] = [
	[
		'value' => wfMessage( 'createaccount' )->escaped(),
		'name' => 'submit',
		'class' => 'big login-button',
	]
];
?>

<div class="UserLoginFacebook">
	<section class="UserLoginFacebookWrapper">
		<section class="UserLoginFacebookLeft">
			<?=  F::app()->renderView( 'WikiaStyleGuideForm', 'index', ['form' => $signupForm] ); ?>
		</section>

		<section class="UserLoginFacebookRight">
			<?= F::app()->renderView( 'WikiaStyleGuideForm', 'index', ['form' => $loginForm] ); ?>
		</section>
	</section>
</div>