<?php
$userErr = $pwdErr = $toastErr = false;

if ( !empty( $result ) ) {
	if ( $result == 'error' ) {
		if ( !empty( $errParam ) ) {
			if ( $errParam == 'username' ) {
				$userErr = true;
			} else {
				$pwdErr = true;
			}
		} elseif ( !empty( $msg ) ) {
			//error from send new password
			$userErr = true;
		}
	} else {
		$toastErr = true;
	}
}
?>
<div id=wkLgn>
	<? if ( $toastErr ) : ?>
	<div id=wkLgnMsg><?= $msg ;?></div>
	<? endif;?>
	<? if ( !$recoverPassword ) : ?>
	<div id=fb-root></div>
	<?= $app->renderView( 'UserLoginSpecial', 'Providers' ) ;?>
	<? endif;?>
	<form method=post action="<?= $formPostAction ?>">
		<input type=hidden name=loginToken value='<?= $loginToken ?>'>
		<input type=hidden name=keeploggedin value=true>
		<input type=text name=username class=wkInp
		       placeholder='<?= $wf->Msg( 'yourname' )?>'<?= ( $username ) ? ' value="' . htmlspecialchars($username) . '"' : ''?><?= ( $userErr ) ? ' class=inpErr' : ''?>>
		<? if ( $userErr ) : ?>
		<div class=wkErr><?= $msg ?></div>
		<? endif; ?>
		<? if ( !$recoverPassword ) : ?>
		<input type=password name=password class=wkInp
		       placeholder='<?= $wf->Msg( 'yourpassword' ) ?>'<?= ( $password ) ? ' value="' . htmlspecialchars($password) . '"' : ''?><?= ( $pwdErr ) ? ' class=inpErr' : ''?>>
		<? if ( $pwdErr ) : ?>
			<div class=wkErr><?= $msg ?></div>
			<? endif; ?>
		<? endif;?>
		<a id=wkLgnRcvLnk
		   href="<?= $recoverLink ;?>"<?= ( $recoverPassword ) ? ' class=hide' : null ?>><?= $wf->Msg( 'userlogin-forgot-password' ) ;?></a>
		<input id=wkLgnBtn name=action type=submit value='<?= $wf->Msg( 'login' ) ?>'
		       class='wkBtn main<?= ( $recoverPassword ) ? ' hide' : null ?>'>
		<input id=wkLgnRcvBtn name=action type=submit value='<?= $wf->Msg( 'wikiamobile-sendpassword-label' ) ?>'
		       class='wkBtn<?= ( $recoverPassword ) ? ' show' : null ?>'>
	</form>
</div>
