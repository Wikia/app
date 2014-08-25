<div id="UserLoginDropdown" class="UserLoginDropdown">
	<div class="ajaxRegisterContainer"><?= $registerLink ?></div>
<?
	$tabIndex = 0;
	$cachedMessages = [
		'yourname' => wfMessage('yourname')->escaped(),
		'yourpassword' => wfMessage('yourpassword')->escaped(),
	];
	$form = array(
		'inputs' => array(
			array(
				'type' => 'hidden',
				'name' => 'loginToken',
				'value' => ''
			),
			array(
				'type' => 'hidden',
				'name' => 'returnto',
				'value' => Sanitizer::encodeAttribute( $returnto ),
			),
			array(
				'type' => 'hidden',
				'name' => 'returntoquery',
				'value' => Sanitizer::encodeAttribute( $returntoquery ),
			),
			array(
				'type' => 'text',
				'name' => 'username',
				'class' => 'hide-label',
				'isRequired' => true,
				'placeholder' => $cachedMessages[ 'yourname' ],
				'label' => $cachedMessages[ 'yourname' ],
				'tabindex' => ++$tabIndex,
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'class' => 'password-input hide-label',
				'isRequired' => true,
				'placeholder' => $cachedMessages[ 'yourpassword' ],
				'label' =>  $cachedMessages[ 'yourpassword' ],
				'tabindex' => ++$tabIndex,
			),
			array(
				'type' => 'custom',
				'output' => '<a href="#" class="forgot-password" tabindex="0">'.wfMessage('userlogin-forgot-password')->escaped().'</a>',
			),
			array(
				'type' => 'checkbox',
				'name' => 'keeploggedin',
				'class' => 'keep-logged-in',
				'value' => '1',
				'label' => wfMessage('userlogin-remembermypassword')->escaped(),
				'tabindex' => ++$tabIndex,
			),
			array(
				'type' => 'submit',
				'value' => wfMessage('login')->escaped(),
				'class' => 'login-button',
				'tabindex' => ++$tabIndex,
			),
		),
		'method' => 'post',
		'action' => $formPostAction,
	);

	$form['isInvalid'] = true;
	$form['errorMsg'] = '';

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));

	// 3rd party providers buttons
	echo $app->renderView('UserLoginSpecial', 'Providers', array('tabindex' => ++$tabIndex));
?>
</div>
