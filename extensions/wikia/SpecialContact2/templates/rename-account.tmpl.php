<?php
if ( !empty($err) ) {
        print $err;
}

echo wfMessage( 'specialcontact-intro-rename-account' )->parseAsBlock();
?>

<h2><?= wfMessage( 'specialcontact-form-header' )->escaped() ?></h2>

<form id="contactform" method="post" action="">
<input name="wpEmail" type="hidden" value="<?= $encEmail ?>" />
<input name="wpUserName" type="hidden" value="<?= $encName ?>" />
<input name="wpEditToken" type="hidden" value="<?= Sanitizer::encodeAttribute( $editToken ) ?>" />

<?= wfMessage( 'specialcontact-logged-in-as', $encName )->parseAsBlock() ?>

<?= wfMessage( 'specialcontact-mail-on-file', $encEmail )->parseAsBlock() ?>

<p>
<label for="wpUserNameNew"><?= wfMessage( 'specialcontact-label-rename-newusername' )->escaped() ?></label>
<input name="wpUserNameNew" required />
<img id="error-img" src="<?= wfBlankImgUrl(); ?>" alt="availability" />
<span id="error-container" class="error"></span>
</p>

<p>
<input type="checkbox" name="wpConfirm" required />
<label for="wpConfirm"><?= wfMessage( 'specialcontact-label-rename-account-confirm' )->escaped() ?></label>
</p>

<p>
<input type="checkbox" name="wpReadHelp" required />
<label for="wpReadHelp"><?= wfMessage( 'specialcontact-label-rename-account-read-help' )->parse() ?></label>
</p>

<input type="submit" value="<?= wfMessage( 'specialcontact-mail' )->escaped() ?>" />

<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?= Sanitizer::encodeAttribute( $_SERVER['HTTP_USER_AGENT'] ); ?>" />
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
						field: 'userloginext01',
						userloginext01: newUsername
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
