<div class="UserLogin UserConfirm">
<? if(!empty($pageHeading)) { ?>
	<h1 class="pageheading"><?= $pageHeading ?></h1>
<? } ?>
	<h2 class="subheading"><?= wfMsg('wikiaconfirmemail-subheading') ?></h2>
<?
	$form = array(
		'method' => 'post',
		'inputs' => array(
			array(
				'type' => 'hidden',
				'name' => 'code',
				'value' => $code
			),
			array(
				'type' => 'text',
				'name' => 'username',
				'label' => wfMsg('wikiaconfirmemail-username'),
				'value' => $username,
				'isInvalid' => !empty($errParam) && $errParam === 'username',
				'errorMsg' => !empty($msg) ? $msg : ''
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'label' => wfMsg('yourpassword'),
				'isInvalid' => !empty($errParam) && $errParam === 'password',
				'errorMsg' => !empty($msg) ? $msg : ''
			)
		),
		'submits' => array(
			array(
				'name' => 'action',
				'value' => wfMsg('wikiaconfirmemail-login-button'),
				'class' => 'big login-button'
			)
		)
	);

	$form['isInvalid'] = !empty($result) && empty($errParam) && !empty($msg);
	$form['errorMsg'] = !empty($msg) ? $msg : '';

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>
</div>
