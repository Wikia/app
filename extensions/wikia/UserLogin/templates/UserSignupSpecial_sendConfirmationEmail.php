<section class="WikiaSignup ConfirmEmail">
<? if(!$isMonobookOrUncyclo) { ?>
	<h2 class="pageheading"><?= $heading ?></h2>
	<h3 class="subheading"><?= $subheading ?></h3>
	<?= F::app()->renderView('WikiHeader', 'Wordmark') ?>
<? } ?>
	<div class="general-messaging">
		<?= $msg ?>
	</div>

<? if ( !$byemail && $result != 'confirmed' ) { ?>
	<form action="" method="post" class="WikiaForm ResendConfirmation" id="ResendConfirmation">
		<fieldset>
			<div class="input-group">
				<input type="hidden" name="action" value="resendconfirmation">
				<input type="hidden" name="username" value="<?=$username?>">
				<input type="submit" value="<?= wfMessage('usersignup-confirm-email-resend-email')->escaped() ?>" class="link">
			</div>
		</fieldset>
	</form>
<? if(!$isMonobookOrUncyclo) { ?>
	<p>
		<?= $app->sendRequest(
				'WikiaStyleGuideTooltipIconController',
				'index',
				array(
					'text' => wfMessage('usersignup-confirm-email-change-email-content'),
					'classes' => 'email-tooltip',
					'tooltipIconTitle' => wfMessage('usersignup-confirm-email-tooltip')->escaped(),
				)
			);
		?>
	</p>
	<p>
		<a href="#" class="change-email-link"><?= wfMessage('usersignup-confirm-email-change-email')->escaped() ?></a>
	</p>
<?
	$form = array(
		'method' => 'post',
		'class' => 'email-form'.(!empty($msgEmail) ? ' show' : ''),
		'inputs' => array(
			array(
				'type' => 'hidden',
				'name' => 'action',
				'value' => 'changeemail'
			),
			array(
				'type' => 'hidden',
				'name' => 'username',
				'value' => htmlspecialchars($username)
			),
			array(
				'type' => 'text',
				'label' => wfMessage('usersignup-confirm-email-new-email-label')->escaped(),
				'name' => 'email',
				'isInvalid' => (!empty($errParam) && $errParam === 'email'),
				'value' => !empty($email) ? $email : '',
				'errorMsg' => !empty($msgEmail) ? $msgEmail : ''
			)
		),
		'submits' => array(
			array(
				'value' => wfMessage('usersignup-confirm-email-update')->escaped(),
				'class' => 'update-button'
			)
		)
	);

	echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));

} //$isMonobookOrUncyclo

} //$isbyemail
?>
</section>
