<?php 

class UserLoginHooksHelper {

	// send reconfirmation mail
	public static function onUserSendReConfirmationMail( &$user, &$result ) {
		$userLoginHelper = F::build( 'UserLoginHelper' );
		$emailTextTemplate = $userLoginHelper->getReconfirmationEmailTempalte( $user );
		$result = $user->sendConfirmationMail( false, 'ReConfirmationMail', 'usersignup-reconfirmation-email', true, $emailTextTemplate );

		return true;
	}

	// get error message when abort new account
	public static function onAbortNewAccountErrorMessage( &$abortError, &$errParam ) {
		$app = F::app();
		if ( $abortError == $app->wf->Msg('phalanx-user-block-new-account') ) {
			$abortError = $app->wf->Msg( 'userlogin-error-user-not-allowed' );
			$errParam = 'username';
		} else if ( $abortError == $app->wf->Msg('userexists') ) {
			$abortError = $app->wf->Msg( 'userlogin-error-userexists' );
			$errParam = 'username';
		} else if ( $abortError == $app->wf->Msg('captcha-createaccount-fail') ) {
			$abortError = $app->wf->Msg( 'userlogin-error-captcha-createaccount-fail' );
			$errParam = 'wpCaptchaWord';
		}

		return true;
	}

	// save temp user and map temp user to user when mail password
	public static function onMailPasswordTempUser( &$u, &$tempUser ) {
		$tempUser = F::build( 'TempUser', array( $u->getName() ), 'getTempUserFromName' );
		if ( $tempUser ) {
			$tempUser->saveSettingsTempUserToUser( $u );
			$u = $tempUser->mapTempUserToUser();
		}

		return true;
	}

	// show request form for Special:ConfirmEmail
	public static function onConfirmEmailShowRequestForm( &$pageObj, &$show ) {
		$show = false;
		if( Sanitizer::validateEmail( $pageObj->getUser()->getEmail() ) ) {
			$userLoginHelper = F::build( 'UserLoginHelper' );
			$userLoginHelper->showRequestFormConfirmEmail( $pageObj );
		} else {
			$pageObj->getOutput()->addWikiMsg( 'usersignup-user-pref-confirmemail_noemail' );
		}

		return true;
	}

	// set parameters for User::sendConfirmationEmail()
	public static function onUserSendConfirmationMail( &$user, &$args, &$priority, &$url, $token, $ip_arg ) {
		$priority = 1;  // confirmation emails are higher than default priority of 0
		$url = $user->wikiaConfirmationTokenUrl( $token );
		if ( !$ip_arg ) {
			$args[1] = $url;
		} else {
			$args[2] = $url;
		}

		return true;
	}

	// get email authentication for Preferences::profilePreferences
	public static function onGetEmailAuthentication( &$user, $context, &$disableEmailPrefs, &$emailauthenticated ) {
		if ( $user->getEmail() ) {
			$emailTimestamp = $user->getEmailAuthenticationTimestamp();
			$optionNewEmail = $user->getOption( 'new_email' );
			$msgKeyPrefixEmail = ( empty($optionNewEmail) && !$emailTimestamp ) ? 'usersignup-user-pref-unconfirmed-' : 'usersignup-user-pref-';
			if( empty($optionNewEmail) && $emailTimestamp ) {
				$lang = $context->getLanguage();
				$displayUser = $context->getUser();
				$time = $lang->userTimeAndDate( $emailTimestamp, $displayUser );
				$d = $lang->userDate( $emailTimestamp, $displayUser );
				$t = $lang->userTime( $emailTimestamp, $displayUser );
				$emailauthenticated = $context->msg( $msgKeyPrefixEmail.'emailauthenticated', $time, $d, $t )->parse() . '<br />';
				$disableEmailPrefs = false;
			} else {
				$disableEmailPrefs = true;
				$emailauthenticated = $context->msg( $msgKeyPrefixEmail.'emailnotauthenticated', array($optionNewEmail) )->parse() . '<br />' .
					Linker::linkKnown(
						SpecialPage::getTitleFor( 'Confirmemail' ),
						$context->msg( 'usersignup-user-pref-emailconfirmlink' )->escaped()
					) . '<br />';
			}
		} else {
			$disableEmailPrefs = true;
			$emailauthenticated = $context->msg( 'usersignup-user-pref-noemailprefs' )->escaped();
		}

		return true;
	}

	// check if email is empty
	public static function onSavePreferences( &$formData, &$error ) {
		if ( array_key_exists( 'emailaddress', $formData ) && empty( $formData['emailaddress'] ) ) {
			$error = F::app()->wf->msg( 'usersignup-error-empty-email' );
			return false;
		}

		return true;
	}

	// set user email for Preferences::trySetUserEmail
	public static function onSetUserEmail( $user, $newEmail, &$result, &$info ) {
		$app = F::app();
		$oldEmail = $user->getEmail();
		$optionNewEmail = $user->getOption( 'new_email' );
		if ( ( empty($optionNewEmail) &&  $newEmail != $oldEmail ) || ( !empty($optionNewEmail) &&  $newEmail != $optionNewEmail ) ) {
			$user->setOption( 'new_email', $newEmail );
			if ( $app->wg->EmailAuthentication ) {
				$userLoginHelper = F::build( 'UserLoginHelper' );
				$result = $userLoginHelper->sendReconfirmationEmail( $user, $newEmail );
				if ( $result->isGood() ) {
					$info = 'eauth';
				}
			}
		} elseif ( $newEmail != $oldEmail ) { // if the address is the same, don't change it
			$user->setEmail( $newEmail );
		}

		return true;
	}

	public static function isValidEmailAddr($addr) {
		return preg_match('/^[a-z0-9._%+-]+@(?:[a-z0-9\-]+\.)+[a-z]{2,4}$/i', $addr) !== 0;
	}


}