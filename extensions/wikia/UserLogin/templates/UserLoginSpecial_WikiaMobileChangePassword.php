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
		<div id=wkLgnMsg><?= $msg ; ?></div>
	<? endif ; ?>
	<form method=post action="<?= $formPostAction ?>">
		<input type=hidden name=editToken value="<?= Sanitizer::encodeAttribute( $editToken ) ; ?>">
		<input type=hidden name=username value="<?= htmlspecialchars( $username ) ; ?>">
		<input type=hidden name=returnto value="<?= Sanitizer::encodeAttribute( $returnto ); ?>">

		<label for=password><?= wfMessage( 'userlogin-oldpassword' )->escaped() ; ?></label>
		<input type=password name=password<?= ( $password ) ? ' value="' . htmlspecialchars( $password ) . '"' : ''?><?= ( $oldErr ) ? ' class=inpErr' : ''?>>
		<? if ( $oldErr ) : ?><div class=wkErr><?= $msg ?></div><? endif; ?>

		<label for=newpassword><?= wfMessage( 'userlogin-newpassword' )->escaped() ; ?></label>
		<input type=password name=newpassword <?= ( $newErr ) ? ' class=inpErr' : ''?>>
		<? if ( $newErr ) : ?><div class=wkErr><?= $msg ?></div><? endif; ?>

		<label for=retype><?= wfMessage( 'userlogin-retypenew' )->escaped() ; ?></label>
		<input type=password name=retype <?= ( $retErr ) ? ' class=inpErr' : ''?>>
		<? if ( $retErr ) : ?><div class=wkErr><?= $msg ?></div><? endif; ?>

		<input id=wkLgnBtn name=action type=submit value='<?= wfMessage( 'resetpass_submit' )->escaped() ?>' class='wkBtn main'>
	</form>
</div>
