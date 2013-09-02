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
<div class=wkForm id=wkLgn>
	<? if ( $toastErr ) : ?>
	<div id=wkLgnMsg><?= $msg ;?></div>
	<? endif;?>
	<? if ( !$recoverPassword ) : ?>
	<?= $app->renderView( 'UserLoginSpecial', 'Providers' ) ;?>
	<? endif;?>
	<form method=post action="<?= $formPostAction ?>">
		<input type=hidden name=loginToken value='<?= $loginToken ?>'>
		<input type=hidden name=keeploggedin value=true>
		<input type=text name=username class=wkInp
		       placeholder='<?= wfMsg( 'yourname' )?>'<?= ( $username ) ? ' value="' . htmlspecialchars($username) . '"' : ''?><?= ( $userErr ) ? ' class=inpErr' : ''?>>
		<? if ( $userErr ) : ?>
		<div class=wkErr><?= $msg ?></div>
		<? endif; ?>
		<? if ( !$recoverPassword ) : ?>
		<input type=password name=password class=wkInp
		       placeholder='<?= wfMsg( 'yourpassword' ) ?>'<?= ( $password ) ? ' value="' . htmlspecialchars($password) . '"' : ''?><?= ( $pwdErr ) ? ' class=inpErr' : ''?>>
		<? if ( $pwdErr ) : ?>
			<div class=wkErr><?= $msg ?></div>
			<? endif; ?>
		<? endif;?>
		<a id=wkLgnRcvLnk
		   href="<?= $recoverLink ;?>"<?= ( $recoverPassword ) ? ' class=hide' : null ?>><?= wfMsg( 'userlogin-forgot-password' ) ;?></a>
		<input id=wkLgnBtn name=action type=submit value='<?= wfMsg( 'login' ) ?>'
		       class='wkBtn main<?= ( $recoverPassword ) ? ' hide' : null ?> round'>
		<input id=wkLgnRcvBtn name=action type=submit value='<?= wfMsg( 'wikiamobile-sendpassword-label' ) ?>'
		       class='wkBtn<?= ( $recoverPassword ) ? ' show' : null ?>'>
	</form>
</div>
