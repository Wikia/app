<section class="WikiaSignup ConfirmEmail">
<? if(!$isMonobook) { ?>
	<h2 class="pageheading"><?= $heading ?></h2>
	<h3 class="subheading"><?= $subheading ?></h3>
	<?= wfRenderModule('WikiHeader', 'Wordmark') ?>
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
				<input type="submit" value="<?= wfMsg('usersignup-confirm-email-resend-email') ?>" class="link">
			</div>
		</fieldset>
	</form>
<? if(!$isMonobook) { ?>
	<p>
		<span class="change-email-msg">
			<?= wfMsg('usersignup-confirm-email-change-email-content') ?>
			<span class="email-tooltip">?</span>
			<span class="email-tooltip-content"><?= wfMsg('usersignup-confirm-email-tooltip') ?></span>
		</span>
	</p>

	<a href="#" class="change-email-link"><?= wfMsg('usersignup-confirm-email-change-email') ?></a>

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
				'label' => wfMsg('usersignup-confirm-email-new-email-label'),
				'name' => 'email',
				'isInvalid' => (!empty($errParam) && $errParam === 'email'),
				'value' => !empty($email) ? $email : '',
				'errorMsg' => !empty($msgEmail) ? $msgEmail : ''
			)
		),
		'submits' => array(
			array(
				'value' => wfMsg('usersignup-confirm-email-update'),
				'class' => 'update-button'
			)
		)
	);

	echo wfRenderModule('WikiaForm', 'Index', array('form' => $form));

} //$isMonobook

} //$isbyemail
?>
</section>
