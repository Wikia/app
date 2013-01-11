<div id="UserLoginDropdown" class="UserLoginDropdown subnav">
<?php
	$tabindex = 0;
	
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
				'tabindex' => ++$tabindex,
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'class' => 'password-input',
				'isRequired' => true,
				'label' => wfMsg('yourpassword'),
				'tabindex' => ++$tabindex,
			),
			array(
				'type' => 'custom',
				'class' => 'forgot-password',
				'output' => '<a href="#" class="forgot-password">'.wfMsg('userlogin-forgot-password').'</a>',
			),
			array(
				'type' => 'checkbox',
				'name' => 'keeploggedin',
				'class' => 'keep-logged-in',
				'value' => '1',
				'label' => wfMsg('userlogin-remembermypassword'),
				'tabindex' => ++$tabindex,
			)
		),
		'method' => 'post',
		'action' => $formPostAction,
		'submits' => array(
			array(
				'value' => wfMsg('login'),
				'tabindex' => ++$tabindex,
			)
		)
	);

	$form['isInvalid'] = true;
	$form['errorMsg'] = '';

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));

	// 3rd party providers buttons
	echo $app->renderView('UserLoginSpecial', 'Providers', array('tabindex' => ++$tabindex));
?>
</div>
