<?
	echo $intro;

	if ( $isLoggedIn ) {
		echo wfMessage( 'specialcontact-logged-in-as', $encName )->parseAsBlock();
		echo wfMessage( 'specialcontact-mail-on-file', $encEmail )->parseAsBlock();
	}
?>
<? if(!empty($errMessages)) : ?>
<div class=errMessages>
<?
	foreach($errMessages as $msg) {
		echo '<p>' . $msg . '</p>';
	}
?>
</div>
<? endif; ?>
<form method=post action="" enctype="multipart/form-data" class=wkForm id=wkContactForm>
	<input name=wpBrowser type=hidden  value="<?= $_SERVER['HTTP_USER_AGENT']; ?>" />
<? if ( $referral != null ) : ?>
	<input name=wpReferral type=hidden value="<?= $referral ?>" />
<? endif; ?>
<? if ( $isLoggedIn ) : ?>
	<input name=wpUserName type=hidden value="<?= $encName; ?>"/>
	<input name=wpEmail type=hidden value="<?= $encEmail; ?>"/>
<? else : ?>
	<label for=wpUserName><?= wfMessage( 'specialcontact-username' )->escaped() ?></label>
	<input id=wpUserName name=wpUserName requireds value="<?= $userName ?>"/>

	<label for=wpEmail><?= wfMessage( 'specialcontact-yourmail' )->escaped() ?></label>
	<input id=wpEmail name=wpEmail type=email requireds value="<?= $email ?>"<?= !empty($errors['wpEmail']) ? " class=inpErr " : "" ?>/>
<? endif; ?>
	<label for=wpSubject><?= wfMessage( 'specialcontact-problem' )->escaped(); ?></label>
	<input id=wpSubject name=wpContactSubject requireds value="<?= $subject ?>"/>

	<label for=wpConctactDesc><?= wfMessage( 'specialcontact-problemdesc' )->escaped(); ?></label>
	<textarea id=wpConctactDesc name=wpContactDesc requireds <?= !empty($errors['wpContactDesc']) ? " class=inpErr " : "" ?> style="font: inherit"><?= $content ?></textarea>

	<div class=filesUpload>
		<label for=wpScreenshot1><?= wfMessage( 'specialcontact-label-screenshot' )->escaped() ?></label>
		<input id=wpScreenshot1 name=wpScreenshot[] type=file accept="image/*" />

		<label for=wpScreenshot2><?= wfMessage( 'specialcontact-label-additionalscreenshot' )->escaped() ?></label>
		<input id=wpScreenshot2 name=wpScreenshot[] type=file accept="image/*" />

		<label for=wpScreenshot3><?= wfMessage( 'specialcontact-label-additionalscreenshot' )->escaped() ?></label>
		<input id=wpScreenshot3 name=wpScreenshot[] type=file accept="image/*" />
	</div>
<? if( !empty( $captchaForm ) ) : ?>
	<div class=captcha>
<?=
		wfMessage( 'specialcontact-captchatitle' )->escaped() .
		$captchaForm
?>
	</div>
<? endif; ?>
	<input type=submit class="wkBtn main round" id=contactSub value="<?= wfMessage( 'specialcontact-mail' )->escaped() ?>" />
<?
	if( $isLoggedIn && $encEmail ) {
		if( $hasEmailConf ) {
			echo "<input type=checkbox name=wgCC value=1 id=wgCC " . ( !empty($cc) ? 'checked ' : '' ) . "/><label for=wgCC>" . wfMessage( 'specialcontact-ccme' )->escaped() . '</label>';
		}
		else {
			echo "<span class=notValidEmail>" . wfMessage( 'specialcontact-ccme' )->escaped() . "</span>". wfMessage( 'specialcontact-ccdisabled' )->parse();
		}
	}
?>
</form>