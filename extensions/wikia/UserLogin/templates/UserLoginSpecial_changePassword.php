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
				'value' => htmlspecialchars( $editToken )
			),
			array(
				'type' => 'hidden',
				'name' => 'loginToken',
				'value' => htmlspecialchars( $loginToken ),
			),
			array(
				'type' => 'hidden',
				'name' => 'username',
				'value' => htmlspecialchars( $username )
			),
			array(
				'type' => 'hidden',
				'name' => 'returnto',
				'value' => Sanitizer::encodeAttribute( $returnto ),
			),
			array(
				'type' => 'custom',
				'output' => '<label>'.wfMessage('yourname')->escaped().'</label><p class="username">'.htmlspecialchars($username).'</p>'
			),
			array(
				'type' => 'password',
				'name' => 'password',
				'id' => 'password',
				'label' => wfMessage('userlogin-oldpassword')->escaped(),
				'value' => htmlspecialchars($password),
			),
			array(
				'type' => 'password',
				'name' => 'newpassword',
				'id' => 'newpassword',
				'label' => wfMessage('userlogin-newpassword')->escaped(),
			),
			array(
				'type' => 'password',
				'name' => 'retype',
				'id' => 'retype',
				'label' => wfMessage('userlogin-retypenew')->escaped(),
			)
		),
		'submits' => array(
			array(
				'value' => wfMessage('resetpass_submit')->escaped(),
				'name' => 'action',
				'class' => 'big login-button'
			)
		)
	);

	$form['isInvalid'] = $result == 'error';
	$form['errorMsg'] = !empty( $msg ) ? $msg : '';

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
	?>
</div>
