<?php
if ( empty( $code ) ) {
	echo "<p class=\"error\">$resultMessage</p>";
} else {
?>
<div class="UserLogin UserConfirm">
	<h2 class="subheading"><?= wfMessage( 'wikiaconfirmemail-subheading' )->escaped() ?></h2>
<?php
	$form = [
		'method' => 'post',
		'inputs' => [
			[
				'type' => 'hidden',
				'name' => 'code',
				'value' => $code,
			],
			[
				'type' => 'text',
				'name' => 'username',
				'label' => wfMessage( 'wikiaconfirmemail-username' )->escaped(),
				'value' => $username,
				'isInvalid' => !empty( $errParam ) && $errParam === 'username',
				'errorMsg' => !empty( $resultMessage ) ? $resultMessage : '',
			],
			[
				'type' => 'password',
				'name' => 'password',
				'label' => wfMessage( 'yourpassword' )->escaped(),
				'isInvalid' => !empty( $errParam ) && $errParam === 'password',
				'errorMsg' => !empty( $resultMessage ) ? $resultMessage : '',
			]
		],
		'submits' => [
			[
				'name' => 'action',
				'value' => wfMessage( 'wikiaconfirmemail-login-button' )->escaped(),
				'class' => 'big login-button',
			]
		]
	];

	$form['isInvalid'] = empty( $success ) && empty( $errParam ) && !empty( $resultMessage );
	$form['errorMsg'] = !empty( $resultMessage ) ? $resultMessage : '';

	echo F::app()->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => $form ] );
?>
</div>
<?php } ?>
