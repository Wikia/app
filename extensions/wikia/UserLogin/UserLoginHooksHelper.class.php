<?php 

class UserLoginHooksHelper {

	// set default user options and perform other actions after account creation
	public static function onAddNewAccount( User $user, $byEmail ) {
		$user->setOption( 'marketingallowed', 1 );
		$user->saveSettings();

		return true;
	}

	// send reconfirmation mail
	public static function onUserSendReConfirmationMail( &$user, &$result ) {
		$userLoginHelper = (new UserLoginHelper);
		$emailTextTemplate = $userLoginHelper->getReconfirmationEmailTempalte( $user );
		$result = $user->sendConfirmationMail( false, 'ReConfirmationMail', 'usersignup-reconfirmation-email', true, $emailTextTemplate );

		return true;
	}

	// get error message when abort new account
	public static function onAbortNewAccountErrorMessage( &$abortError, &$errParam ) {
		if ( $abortError == wfMessage('phalanx-user-block-new-account')->escaped() ) {
			$abortError = wfMessage( 'userlogin-error-user-not-allowed' )->escaped();
			$errParam = 'username';
		} else if ( $abortError == wfMessage('userexists')->escaped() ) {
			$abortError = wfMessage( 'userlogin-error-userexists' )->escaped();
			$errParam = 'username';
		} else if ( $abortError == wfMessage('captcha-createaccount-fail')->escaped() ) {
			$abortError = wfMessage( 'userlogin-error-captcha-createaccount-fail' )->escaped();
			$errParam = 'wpCaptchaWord';
		} else if ( $abortError == wfMessage('phalanx-help-type-user-email')->escaped() ) {
			$errParam = 'email';
		} else if ( $abortError == wfMessage('phalanx-email-block-new-account')->escaped()) {
			$errParam = 'email';
		}

		return true;
	}

	// save temp user and map temp user to user when mail password
	public static function onMailPasswordTempUser( &$u, &$tempUser ) {
		$tempUser = TempUser::getTempUserFromName( $u->getName() );
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
			$userLoginHelper = (new UserLoginHelper);
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
			$error = wfMessage( 'usersignup-error-empty-email' )->escaped();
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
			$user->invalidateEmail();
			if ( $app->wg->EmailAuthentication ) {
				$userLoginHelper = (new UserLoginHelper);
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

	/**
	 * @param array $vars
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript(Array &$vars) {
		$vars['wgEnableUserLoginExt'] = true;
		return true;
	}

}
