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
		<? if ( !empty( $returnto ) ): ?>
			<input type=hidden name=returnto value="<?= $returnto; ?>">
		<? endif; ?>
		<input type=text name=username class=wkInp
		       placeholder='<?= wfMessage( 'yourname' )->escaped()?>'<?= ( $username ) ? ' value="' . htmlspecialchars($username) . '"' : ''?><?= ( $userErr ) ? ' class=inpErr' : ''?>>
		<? if ( $userErr ) : ?>
		<div class=wkErr><?= $msg ?></div>
		<? endif; ?>
		<? if ( !$recoverPassword ) : ?>
		<input type=password name=password class=wkInp
		       placeholder='<?= wfMessage( 'yourpassword' )->escaped() ?>'<?= ( $password ) ? ' value="' . htmlspecialchars($password) . '"' : ''?><?= ( $pwdErr ) ? ' class=inpErr' : ''?>>
		<? if ( $pwdErr ) : ?>
			<div class=wkErr><?= $msg ?></div>
			<? endif; ?>
		<? endif;?>
		<a id=wkLgnRcvLnk
		   href="<?= $recoverLink ;?>"<?= ( $recoverPassword ) ? ' class=hide' : null ?>><?= wfMessage( 'userlogin-forgot-password' )->escaped() ;?></a>
		<input id=wkLgnBtn name=action type=submit value='<?= wfMessage( 'login' )->escaped() ?>'
		       class='wkBtn main<?= ( $recoverPassword ) ? ' hide' : null ?> round'>
		<input id=wkLgnRcvBtn name=action type=submit value='<?= wfMessage( 'wikiamobile-sendpassword-label' )->escaped() ?>'
		       class='wkBtn<?= ( $recoverPassword ) ? ' show' : null ?>'>
	</form>
</div>
