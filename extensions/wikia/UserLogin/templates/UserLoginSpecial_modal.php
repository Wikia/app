<div class="UserLoginModal">
<?php
	$tabIndex = 5;
	$specialSignupLink = SpecialPage::getTitleFor( 'UserSignup' )->getLocalURL();

	$form = array(
		'inputs' => array(
			array(
				'type' => 'hidden',
				'name' => 'loginToken',
				'value' => Sanitizer::encodeAttribute( $loginToken ),
			),
			array(
				'type' => 'hidden',
				'name' => 'returnto',
				'value' => ''
			),
			array(
				'type' => 'text',
				'name' => $usernameKey,
				'isRequired' => true,
				'label' => wfMessage( 'yourname' )->escaped(),
				'tabindex' => ++$tabIndex,
			),
			array(
				'type' => 'password',
				'name' => $passwordKey,
				'class' => 'password-input',
				'isRequired' => true,
				'label' => wfMessage( 'yourpassword' )->escaped(),
				'tabindex' => ++$tabIndex,
			),
			array(
				'type' => 'custom',
				'output' => '<a href="#" class="forgot-password" tabindex="0">' . wfMessage( 'userlogin-forgot-password' )->escaped() . '</a>',
			),
			array(
				'type' => 'checkbox',
				'name' => 'keeploggedin',
				'value' => '1',
				'label' => wfMessage( 'userlogin-remembermypassword' )->escaped(),
				'class' => 'keep-logged-in',
				'tabindex' => ++$tabIndex,
			),
			array(
				'type' => 'submit',
				'value' => wfMessage( 'login' )->escaped(),
				'class' => 'login-button big',
				'tabindex' => ++$tabIndex,
			),
			array(
				'type' => 'custom',
				'output' => wfMessage( 'userlogin-get-account', [ $specialSignupLink, ++$tabIndex ] )
					->inContentLanguage()
					->text(),
				'class' => 'get-account',
				'tabindex' => ++$tabIndex,
			)
		),
		'method' => 'post',
		'action' => $formPostAction,
	);

	echo $app->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => $form ] );
	echo $app->renderView( 'UserLoginSpecial', 'Providers', [ 'tabindex' => ++$tabIndex ] );
?>
</div>
