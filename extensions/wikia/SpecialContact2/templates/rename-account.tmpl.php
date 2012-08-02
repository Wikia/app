<?php
if ( !empty($err) ) {
        print $err;
}

echo wfMsgExt( 'specialcontact-intro-rename-account', array( 'parse' ) );
?>

<h2><?= wfMsg( 'specialcontact-form-header' ) ?></h2>

<form id="contactform" method="post" action="">
<input name="wpEmail" type="hidden" value="<?= $encEmail ?>" />
<input name="wpUserName" type="hidden" value="<?= $encName ?>" />

<?= wfMsgExt( 'specialcontact-logged-in-as', array( 'parse' ), $encName, 'link' ) ?>
        
<?= wfMsgExt( 'specialcontact-mail-on-file', array( 'parse' ), $encEmail, 'link' ) ?>

<p>
<label for="wpUserNameNew"><?= wfMsg( 'specialcontact-label-rename-newusername' ) ?></label>
<input name="wpUserNameNew" required />
<img id="error-img" src="<?= wfBlankImgUrl(); ?>" alt="availability" />
<span id="error-container" class="error"></span>
</p>

<p>
<input type="checkbox" name="wpConfirm" required />
<label for="wpConfirm"><?= wfMsg( 'specialcontact-label-rename-account-confirm' ) ?></label>
</p>

<p>
<input type="checkbox" name="wpReadHelp" required />
<label for="wpReadHelp"><?= wfMsgExt( 'specialcontact-lable-rename-account-read-help', array( 'parseinline' ) ) ?></label>
</p>

<input type="submit" value="<?= wfMsg( 'specialcontact-mail' ) ?>" />

<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" />
<input type="hidden" id="wpAbTesting" name="wpAbTesting" value="[unknown]" />
</form>
<script type="text/javascript">
( function ( mw, $ ) {
	var UserRenameValidation = {
		init: function () {
			var	$contactForm = $( '#contactform' ),
				$usernameInput = $contactForm.find( 'input[name="wpUserNameNew"]' ),
				$submitButton = $contactForm.find( 'input[type="submit"]' );
			$usernameInput.blur( function () {
				var newUsername = $( this ).val(),
					$resultContainer = $( this ).siblings( '#error-container' ),
					$resultImage = $( this ).siblings( '#error-img' ),
					params = {
						controller: 'UserSignupSpecial',
						method: 'formValidation',
						format: 'json',
						field: 'username',
						username: newUsername
					};
				$resultContainer.text( '' );
				$resultImage.removeClass().addClass( 'sprite progress' );

				if ( newUsername !== '' ) {
					$.post( mw.config.get( 'wgScriptPath' ) + '/wikia.php', params, function ( res ) {
						if ( res['result'] === 'ok' ) {
							$resultImage.removeClass().addClass( 'sprite ok' );
							$submitButton.prop( 'disabled', false );
						} else {
							$resultImage.removeClass().addClass( 'sprite error' );
							$submitButton.prop( 'disabled', true );
							$resultContainer.text( res['msg'] );
						}
					} );
				}
			} );
		}
	};

	$( function () {
		UserRenameValidation.init();
	} );
}( mediaWiki, jQuery ) );
</script>
