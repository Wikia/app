<div class="UserLogin ChangePassword">
<? if(!empty($pageHeading)) { ?>
	<h1><?= $pageHeading ?></h1>
<? } ?>
<? if(!empty($subheading)) { ?>
	<h2 class="subheading"><?= $subheading ?></h2>
<? } ?>
<?
	$form = array(
		'method' => 'post',
		'action' => $formPostAction,
		'inputs' => array(
			array(
				'type' => 'hidden',
				'name' => 'editToken',
				'value' => $editToken

			),
			array(
				'type' => 'hidden',
				'name' => 'username',
				'value' => htmlspecialchars($username)
			),
			array(
				'type' => 'hidden',
				'name' => 'returnto',
				'value' => $returnto
			),
			array(
				'type' => 'custom',
				'output' => '<label>'.wfMsg('yourname').'</label><p class="username">'.htmlspecialchars($username).'</p>'
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'id' => 'password',
				'label' => wfMsg('userlogin-oldpassword'),
				'value' => htmlspecialchars($password),
				'isInvalid' => !empty($errParam) && $errParam === 'password',
				'errorMsg' => !empty($msg) ? $msg : ''
			),
			array(
				'type' => 'password',
				'name' => 'newpassword',
				'id' => 'newpassword',
				'label' => wfMsg('userlogin-newpassword'),
				'isInvalid' => !empty($errParam) && $errParam === 'newpassword',
				'errorMsg' => !empty($msg) ? $msg : ''
			),
			array(
				'type' => 'password',
				'name' => 'retype',
				'id' => 'retype',
				'label' => wfMsg('userlogin-retypenew'),
				'isInvalid' => !empty($errParam) && $errParam === 'retype',
				'errorMsg' => !empty($msg) ? $msg : ''
			)
		),
		'submits' => array(
			array(
				'value' => wfMsg('resetpass_submit'),
				'name' => 'action',
				'class' => 'big login-button'
			)
		)
	);

	$form['isInvalid'] = !empty($result) && empty($errParam) && !empty($msg);
	$form['errorMsg'] = !empty($msg) ? $msg : '';

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>
</div>
