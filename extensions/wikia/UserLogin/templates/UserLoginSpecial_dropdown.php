<div id="UserLoginDropdown" class="UserLoginDropdown subnav">
<?
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
				'tabindex' => 1,
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'isRequired' => true,
				'label' => wfMsg('yourpassword'),
				'tabindex' => 2,
			),
			array(
				'type' => 'custom',
				'output' => '<a href="#" class="forgot-password">'.wfMsg('userlogin-forgot-password').'</a>',
			),
			array(
				'type' => 'checkbox',
				'name' => 'keeploggedin',
				'value' => '1',
				'label' => wfMsg('userlogin-remembermypassword'),
				'tabindex' => 3,
			)
		),
		'method' => 'post',
		'action' => $formPostAction,
		'submits' => array(
			array(
				'value' => wfMsg('login'),
				'tabindex' => 4,
			)
		)
	);

	$form['isInvalid'] = true;
	$form['errorMsg'] = '';

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));

	// 3rd party providers buttons
	echo $app->renderView('UserLoginSpecial', 'Providers', array('dropdown' => true));
?>
</div>
