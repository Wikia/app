<?php
$oldErr = $newErr = $retErr = $toastErr = false;

if ( !empty( $result ) && $result == 'error' ) {
	if ( !empty( $errParam ) ) {
		switch ( $errParam ) {
			case 'password':
				$oldErr = true;
				break;
			case 'newpassword':
				$newErr = true;
				break;
			case 'retype':
				$retErr = true;
				break;
		}
	} else {
		$toastErr = true;
	}
}
?>
<div id=wkLgn>
	<div id=fb-root></div>
	<? if ( $toastErr ) :?>
		<div id=wkLgnMsg><?= $msg ;?></div>
	<? endif ;?>
	<form method=post action="<?= $formPostAction ?>">
		<input type=hidden name=editToken value="<?= $editToken ;?>">
		<input type=hidden name=username value="<?= htmlspecialchars($username) ;?>">
		<input type=hidden name=returnto value="<?= $returnto ;?>">

		<label for=password><?= wfMsg( 'userlogin-oldpassword' ) ;?></label>
		<input type=password name=password<?= ($password) ? ' value="'.htmlspecialchars($password).'"' : ''?><?= ($oldErr) ? ' class=inpErr' : ''?>>
		<? if( $oldErr ) : ?><div class=wkErr><?= $msg ?></div><? endif; ?>

		<label for=newpassword><?= wfMsg( 'userlogin-newpassword' ) ;?></label>
		<input type=password name=newpassword <?= ($newErr) ? ' class=inpErr' : ''?>>
		<? if( $newErr ) : ?><div class=wkErr><?= $msg ?></div><? endif; ?>

		<label for=retype><?= wfMsg( 'userlogin-retypenew' ) ;?></label>
		<input type=password name=retype <?= ($retErr) ? ' class=inpErr' : ''?>>
		<? if( $retErr ) : ?><div class=wkErr><?= $msg ?></div><? endif; ?>

		<input id=wkLgnBtn name=action type=submit value='<?= wfMsg( 'resetpass_submit' ) ?>' class='wkBtn main'>
	</form>
</div>
