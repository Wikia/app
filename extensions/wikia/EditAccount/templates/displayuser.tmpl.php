<!-- s:<?= __FILE__ ?> -->
<small><a href="<?php print $returnURL; ?>">Return</a>
	<?= wfMessage( 'pipe-separator' )->escaped() . $logLink ?>
	<?= wfMessage( 'pipe-separator' )->escaped() . $mailLogLink ?></small>
<?php if (!is_null($status)) { ?>
<fieldset>
	<legend><?= wfMessage( 'editaccount-status' )->escaped(); ?></legend>
	<?php echo $status ? Wikia::successmsg($statusMsg) : Wikia::errormsg($statusMsg) ?>
	<?php if( !empty($statusMsg2) ){ echo Wikia::errormsg($statusMsg2); } ?>
</fieldset>
<?php } ?>
<fieldset>
	<legend><?= wfMessage( 'editaccount-frame-account', $user )->escaped(); ?></legend>
	<?php echo $userEncoded ?><br />
	ID: <?php echo $userId; ?><br />
	Reg: <?php echo $userReg ; ?><br />
	<?= wfMessage( 'editaccount-labal-account-status' )->escaped(); ?>: <?php echo $userStatus; ?><br />
	<?= wfMessage( 'editaccount-labal-email-status' )->escaped(); ?>: <?php echo $emailStatus; ?><br />
	<?= $changeEmailRequested; ?><br />
	<form method="post" action="" id="EditAccountForm">
		<div>
			<input type="radio" id="wpActionSetEmail" name="wpAction" value="setemail" />
			<label for="wpActionSetEmail"><?= wfMessage( 'editaccount-label-email' )->escaped() ?></label>
			<input type="text" name="wpNewEmail" value="<?= $userEmail ?>" />
		</div>

		<div>
			<input type="radio" id="wpActionSetPass" name="wpAction" value="setpass" />
			<label for="wpActionSetPass"><?= wfMessage( 'editaccount-label-pass' )->escaped() ?></label>
			<input type="text" name="wpNewPass" />
		</div>

		<div>
			<input type="radio" id="wpActionSetRealName" name="wpAction" value="setrealname" <?= $disabled; ?> />
			<label for="wpActionSetRealName"><?= wfMessage( 'editaccount-label-realname' )->escaped() ?></label>
			<input type="text" name="wpNewRealName" value="<?= $userRealName ?>" <?= $disabled; ?> />
		</div>

		<div>
			<input type="radio" id="wpActionToggleAdopt" name="wpAction" value="toggleadopter" />
			<label for="wpActionToggleAdopt"><?= wfMessage( 'editaccount-label-toggleadopt' )->escaped() ?></label>
			<span><?= ( $isAdopter ) ? wfMessage( 'editaccount-label-toggleadopt-prevent' )->escaped() : wfMessage( 'editaccount-label-toggleadopt-allow' )->escaped() ?></span>
		</div>

		<?php if( $isUnsub ) { ?>
		<div>
			<input type="radio" id="wpActionClearUnsub" name="wpAction" value="clearunsub" <?= $disabled; ?> />
			<label for="wpActionClearUnsub"><?= wfMessage( 'editaccount-submit-clearunsub' )->escaped() ?></label>
		</div>
		<?php } //end unsub ?>

		<div>
			<label for="wpReason"><?= wfMessage( 'editaccount-label-reason' )->escaped() ?></label>
			<input id="wpReason" name="wpReason" type="text" />
		</div>

		<div>
			<input type="submit" value="<?= wfMessage( 'editaccount-submit-button' )->escaped() ?>" />
		</div>

		<input type="hidden" name="wpUserName" value="<?= $user_hsc ?>" />
		<input type="hidden" name="wpToken" value="<?= htmlspecialchars( $editToken ); ?>" />
	</form>

</fieldset>

<fieldset>
	<legend><?= wfMessage( 'editaccount-frame-logout', $user )->escaped(); ?></legend>
	<p><?= wfMessage( 'editaccount-usage-logout' )->escaped(); ?></p>
	<form method="post" action="">
		<input type="submit" value="<?= wfMessage( 'editaccount-submit-logout' )->escaped(); ?>" <?= $disabled; ?> />
		<input type="hidden" name="wpAction" value="logout" />
		<input type="hidden" name="wpUserName" value="<?php echo $user_hsc ?>" />
		<input type="hidden" name="wpToken" value="<?= htmlspecialchars( $editToken ); ?>" />
	</form>
</fieldset>

<fieldset>
	<legend><?= wfMessage( 'editaccount-frame-close', $user )->escaped(); ?></legend>
<?php if ( $isClosureRequested ) { ?>
	<?= wfMessage( 'editaccount-closure-requested' )->parseAsBlock(); ?>
	<form method="post" action="">
		<input type="submit" value="<?= wfMessage( 'editaccount-submit-clearclosurerequest' )->escaped(); ?>" <?= $disabled; ?> />
		<input type="hidden" name="wpAction" value="clearclosurerequest" />
		<input type="hidden" name="wpUserName" value="<?= $user_hsc ?>" />
		<input type="hidden" name="wpToken" value="<?= htmlspecialchars( $editToken ); ?>" />
	</form>
<?php } ?>
	<p><?= wfMessage( 'editaccount-usage-close' )->escaped(); ?></p>
	<form method="post" action="">
		<input type="submit" value="<?= wfMessage( 'editaccount-submit-close' )->escaped(); ?>" <?= $disabled; ?> />
		<input type="hidden" name="wpAction" value="closeaccount" />
		<input type="hidden" name="wpUserName" value="<?php echo $user_hsc ?>" />
		<input type="hidden" name="wpToken" value="<?= htmlspecialchars( $editToken ); ?>" />
	</form>
<?php if( $isDisabled ) { ?>
<?= wfMessage( 'edit-account-closed-flag' )->parse(); ?>
	<form method="post" action="">
		<input type="submit" value="<?= wfMessage( 'editaccount-submit-cleardisable' )->escaped(); ?>" <?= $disabled; ?> />
		<input type="hidden" name="wpAction" value="cleardisable" />
		<input type="hidden" name="wpUserName" value="<?php echo $user_hsc ?>" />
		<input type="hidden" name="wpToken" value="<?= htmlspecialchars( $editToken ); ?>" />
	</form>
<?php } //end undisable ?>
</fieldset>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
	$( '#EditAccountForm' ).find( 'input[type="text"]' ).focus( function() {
		if ( $( this ).siblings( 'input[type="radio"]' ).length ) {
			$( this ).siblings( 'input[type="radio"]' ).prop( 'checked', true );
		}
	} );
} );
</script>
<!-- e:<?= __FILE__ ?> -->
