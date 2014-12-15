<?php
/**
 * Both login and signup forms share the following inputs
 */
$baseForm = [
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

$loginForm = $baseForm;
$signpuForm = $baseForm;

/**
 * Add form fields to signup form
 */

// Facebook may or may not provide the user's email
if ( trim( $fbEmail ) == '' ) {
	$signpuForm['inputs'][] = [
		'type' => 'email',
		'name' => 'email',
		'isRequired' => true,
		'label' => wfMessage( 'email' )->escaped(),
	];
} else {
	$signpuForm['inputs'][] = [
		'type' => 'nirvana',
		'class' => 'email',
		'controller' => 'WikiaStyleGuideTooltipIconController',
		'method' => 'index',
		'params' => [
			'text' => wfMessage('email')->escaped(),
			'tooltipIconTitle' => wfMessage( 'usersignup-facebook-email-tooltip' )->plain(),
		],
	];

	$signpuForm['inputs'][] = [
		'type' => 'custom',
		'output' => '<strong>' . htmlspecialchars( $fbEmail ) . '</strong>'
	];
}

$signpuForm['inputs'][] = [
	'type' => 'custom',
	'class' => 'wikia-terms',
	'output' => wfMessage('prefs-help-terms')->parse()
];

$signpuForm['submits'] = [
	[
		'value' => wfMessage( 'createaccount' )->escaped(),
		'name' => 'submit',
		'class' => 'big login-button',
	]
];

/**
 * Add form fields to login form
 */

$loginForm['inputs'][] = [
	'type' => 'nirvanaview',
	'controller' => 'UserLogin',
	'view' => 'forgotPasswordLink',
	'class' => 'forgot-password-container',
];

$loginForm['submits'] = [
	[
		'value' => wfMessage( 'userlogin-login-heading' )->escaped(),
		'name' => 'action',
		'class' => 'big login-button',
	]
];
?>

<div class="UserLoginFacebook">
	<section class="UserLoginFacebookWrapper">
		<section class="UserLoginFacebookLeft">
			<?=  F::app()->renderView( 'WikiaStyleGuideForm', 'index', ['form' => $signpuForm] ); ?>
		</section>

		<section class="UserLoginFacebookRight">
			<?= F::app()->renderView( 'WikiaStyleGuideForm', 'index', ['form' => $loginForm] ); ?>
		</section>
	</section>
</div>