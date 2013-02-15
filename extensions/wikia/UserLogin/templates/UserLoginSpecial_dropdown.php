<div id="UserLoginDropdown" class="UserLoginDropdown subnav">
<?
	$tabIndex = 0;
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
				'value' => ''
			),
			array(
				'type' => 'hidden',
				'name' => 'returntoquery',
				'value' => $returntoquery
			),
			array(
				'type' => 'text',
				'name' => 'username',
				'isRequired' => true,
				'label' => wfMsg('yourname'),
				'tabindex' => ++$tabIndex,
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'class' => 'password-input',
				'isRequired' => true,
				'label' => wfMsg('yourpassword'),
				'tabindex' => ++$tabIndex,
			),
			array(
				'type' => 'custom',
				'class' => 'forgot-password',
				'output' => '<a href="#" class="forgot-password" tabindex="0">'.wfMsg('userlogin-forgot-password').'</a>',
			),
			array(
				'type' => 'checkbox',
				'name' => 'keeploggedin',
				'class' => 'keep-logged-in',
				'value' => '1',
				'label' => wfMsg('userlogin-remembermypassword'),
				'tabindex' => ++$tabIndex,
			),
			array(
				'type' => 'submit',
				'value' => wfMsg('login'),
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
