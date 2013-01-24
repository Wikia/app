<?
	echo $intro;

	if ( $isLoggedIn ) {
		echo wfMsgExt( 'specialcontact-logged-in-as', array( 'parse' ), $encName );
		echo wfMsgExt( 'specialcontact-mail-on-file', array( 'parse' ), $encEmail );
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
	<label for=wpUserName><?= wfMsg( 'specialcontact-username' ) ?></label>
	<input id=wpUserName name=wpUserName requireds value="<?= $userName ?>"/>

	<label for=wpEmail><?= wfMsg( 'specialcontact-yourmail' ) ?></label>
	<input id=wpEmail name=wpEmail type=email requireds value="<?= $email ?>"<?= !empty($errors['wpEmail']) ? " class=inpErr " : "" ?>/>
<? endif; ?>
	<label for=wpSubject><?= wfMsg( 'specialcontact-problem' ); ?></label>
	<input id=wpSubject name=wpContactSubject requireds value="<?= $subject ?>"/>

	<label for=wpConctactDesc><?= wfMsg( 'specialcontact-problemdesc' ); ?></label>
	<textarea id=wpConctactDesc name=wpContactDesc requireds <?= !empty($errors['wpContactDesc']) ? " class=inpErr " : "" ?>><?= $content ?></textarea>

	<div class=filesUpload>
		<label for=wpScreenshot1><?= wfMsg( 'specialcontact-label-screenshot' ) ?></label>
		<input id=wpScreenshot1 name=wpScreenshot[] type=file accept="image/*" />

		<label for=wpScreenshot2><?= wfMsg( 'specialcontact-label-additionalscreenshot' ) ?></label>
		<input id=wpScreenshot2 name=wpScreenshot[] type=file accept="image/*" />

		<label for=wpScreenshot3><?= wfMsg( 'specialcontact-label-additionalscreenshot' ) ?></label>
		<input id=wpScreenshot3 name=wpScreenshot[] type=file accept="image/*" />
	</div>
<? if( !empty( $captchaForm ) ) : ?>
	<div class=captcha>
<?=
		wfMsg( 'specialcontact-captchatitle' ) .
		$captchaForm
?>
	</div>
<? endif; ?>
	<input type=submit class="wkBtn main round" id=contactSub value="<?= wfMsg( 'specialcontact-mail' ) ?>" />
<?
	if( $isLoggedIn && $encEmail ) {
		if( $hasEmailConf ) {
			echo "<input type=checkbox name=wgCC value=1 id=wgCC " . ( !empty($cc) ? 'checked ' : '' ) . "/><label for=wgCC>" . wfMsg('specialcontact-ccme') . '</label>';
		}
		else {
			echo "<span class=notValidEmail>" . wfMsg('specialcontact-ccme') . "</span>". wfMsgExt('specialcontact-ccdisabled', array('parse') );
		}
	}
?>
</form>