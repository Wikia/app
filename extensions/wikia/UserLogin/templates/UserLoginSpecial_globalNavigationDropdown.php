<div id="UserLoginDropdown" class="UserLoginDropdown global-nav-dropdown">
	<div class="ajaxRegisterContainer"><?= $registerLink ?></div>
	<?
	$tabIndex = 0;
	$cachedMessages = [
		'yourname' => wfMessage( 'yourname' )->escaped(),
		'yourpassword' => wfMessage( 'yourpassword' )->escaped(),
	];
	$form = [
		'inputs' => [
			[
				'type' => 'hidden',
				'name' => 'loginToken',
				'value' => ''
			],
			[
				'type' => 'hidden',
				'name' => 'returnto',
				'value' => Sanitizer::encodeAttribute( $returnto ),
			],
			[
				'type' => 'hidden',
				'name' => 'returntoquery',
				'value' => Sanitizer::encodeAttribute( $returntoquery ),
			],
			[
				'id' => 'usernameInput',
				'type' => 'text',
				'name' => 'username',
				'class' => 'hide-label',
				'isRequired' => true,
				'placeholder' => $cachedMessages[ 'yourname' ],
				'label' => $cachedMessages[ 'yourname' ],
				'tabindex' => ++$tabIndex,
			],
			[
				'id' => 'passwordInput',
				'type' => 'password',
				'name' => 'password',
				'class' => 'hide-label',
				'isRequired' => true,
				'placeholder' => $cachedMessages[ 'yourpassword' ],
				'label' =>  $cachedMessages[ 'yourpassword' ],
				'tabindex' => ++$tabIndex,
			],
			[
				'type' => 'nirvanaview',
				'controller' => 'UserLogin',
				'view' => 'forgotPasswordLink',
			],
			[
				'type' => 'checkbox',
				'name' => 'keeploggedin',
				'class' => 'keep-logged-in',
				'value' => '1',
				'label' => wfMessage( 'userlogin-remembermypassword' )->escaped(),
				'tabindex' => ++$tabIndex,
			],
			[
				'type' => 'submit',
				'value' => wfMessage( 'login' )->escaped(),
				'class' => 'login-button',
				'tabindex' => ++$tabIndex,
			],
		],
		'method' => 'post',
		'action' => $formPostAction,
	];

	$form[ 'isInvalid' ] = true;
	$form[ 'errorMsg' ] = '';

	echo $app->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => $form ] );

	// 3rd party providers buttons
	echo $app->renderView( 'UserLoginSpecial', 'Providers', [ 'tabindex' => ++$tabIndex ] );
	?>
</div>
