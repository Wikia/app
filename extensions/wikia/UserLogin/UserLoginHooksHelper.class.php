<?php

class UserLoginHooksHelper {

	// get error message when abort new account
	public static function onAbortNewAccountErrorMessage( &$abortError, &$errParam ) {
		if ( $abortError == wfMessage( 'phalanx-user-block-new-account' )->escaped() ) {
			$abortError = wfMessage( 'userlogin-error-user-not-allowed' )->escaped();
			$errParam = 'username';
		} else if ( $abortError == wfMessage( 'userexists' )->escaped() ) {
			$abortError = wfMessage( 'userlogin-error-userexists' )->escaped();
			$errParam = 'username';
		} else if ( $abortError == wfMessage( 'captcha-createaccount-fail' )->escaped() ) {
			$abortError = wfMessage( 'userlogin-error-captcha-createaccount-fail' )->escaped();
			$errParam = 'wpCaptchaWord';
		} else if ( $abortError == wfMessage( 'phalanx-help-type-user-email' )->escaped() ) {
			$errParam = 'email';
		} else if ( $abortError == wfMessage( 'phalanx-email-block-new-account' )->escaped() ) {
			$errParam = 'email';
		}

		return true;
	}

	// show request form for Special:ConfirmEmail
	public static function onConfirmEmailShowRequestForm( EmailConfirmation &$pageObj, &$show ) {
		$show = false;
		if (
			Sanitizer::validateEmail( $pageObj->getUser()->getEmail() )
			|| !empty( $pageObj->getUser()->getNewEmail() )
		) {
			$userLoginHelper = new UserLoginHelper();
			$userLoginHelper->showRequestFormConfirmEmail( $pageObj );
		} else {
			$pageObj->getOutput()->addWikiMsg( 'usersignup-user-pref-confirmemail_noemail' );
		}

		return true;
	}

	// set parameters for User::sendConfirmationEmail()
	public static function onUserSendConfirmationMail( User &$user, &$args, &$priority, &$url, $token, $ip_arg, $type ) {
		if ( $type !== 'reactivateaccount' ) {
			$priority = 1;  // confirmation emails are higher than default priority of 0
			$url = $user->wikiaConfirmationTokenUrl( $token );
			if ( !$ip_arg ) {
				$args[1] = $url;
			} else {
				$args[2] = $url;
			}
		}

		return true;
	}

	// get email authentication for Preferences::profilePreferences
	public static function onGetEmailAuthentication( User &$user, IContextSource $context, &$disableEmailPrefs, &$emailauthenticated ) {
		$optionNewEmail = $user->getNewEmail();
		if ( $user->getEmail() || $optionNewEmail ) {
			$emailTimestamp = $user->getEmailAuthenticationTimestamp();
			$msgKeyPrefixEmail = ( empty( $optionNewEmail ) && !$emailTimestamp ) ? 'usersignup-user-pref-unconfirmed-' : 'usersignup-user-pref-';
			if ( empty( $optionNewEmail ) && $emailTimestamp ) {
				$lang = $context->getLanguage();
				$displayUser = $context->getUser();
				$time = $lang->userTimeAndDate( $emailTimestamp, $displayUser );
				$d = $lang->userDate( $emailTimestamp, $displayUser );
				$t = $lang->userTime( $emailTimestamp, $displayUser );
				$emailauthenticated = $context->msg( $msgKeyPrefixEmail . 'emailauthenticated', $time, $d, $t )->parse() . '<br />';
				$disableEmailPrefs = false;
			} else {
				$disableEmailPrefs = true;
				$emailauthenticated = $context->msg( $msgKeyPrefixEmail . 'emailnotauthenticated', array( $optionNewEmail ) )->parse() . '<br />' .
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
	public static function onSetUserEmail( User $user, $newEmail, &$result, &$info ) {
		$app = F::app();
		$oldEmail = $user->getEmail();
		$optionNewEmail = $user->getNewEmail();
		if ( ( empty( $optionNewEmail ) &&  $newEmail != $oldEmail ) || ( !empty( $optionNewEmail ) &&  $newEmail != $optionNewEmail ) ) {
			$user->setNewEmail( $newEmail );
			$user->invalidateEmail();
			if ( $app->wg->EmailAuthentication ) {
				$userLoginHelper = new UserLoginHelper();
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

	public static function isValidEmailAddr( $addr ) {
		// this validation match Helios email validation
		// [see: https://github.com/Wikia/helios/blob/ce490394ae10eb248afd2a063dc465d8eb4efb01/domain/user_validator_funs.go#L29]
		return preg_match(
			'/^[\w!#$%&\'*+\/=?^_`{|}~-]+(?:\.[\w!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[a-zA-Z0-9](?:[\w-]*[\w])?$/i',
			$addr
		) !== 0;
	}

	/**
	 * @param array $vars
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript( Array &$vars ) {
		$app = F::app();

		if ( $app->checkSkin( 'wikiamobile' ) ) {
			$vars['wgLoginToken'] = UserLoginHelper::readLoginToken();
		}

		// Max and min password lengths for JS validation
		$vars['wgWikiaMaxNameChars'] = $app->wg->WikiaMaxNameChars;
		$vars['wgMinimalPasswordLength'] = $app->wg->MinimalPasswordLength;

		return true;
	}

	/**
	 * Returns number of activated accounts for specific email address
	 *
	 * @param mixed $sEmail
	 * @static
	 * @return integer
	 */
	public static function getUsersPerEmailFromDB( $sEmail ) {
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_SLAVE );
		$iCount = $dbw->selectField( 'user',
			'count(*)',
			array(
				'user_email' => $sEmail,
				'user_email_authenticated IS NOT NULL',
		    )
		);
		wfProfileOut( __METHOD__ );
		return $iCount;
	}

	/**
	 * Keeps count of registered accounts with same email
	 *
	 * @param User $user
	 * @static
	 * @return bool
	 */
	public static function onConfirmEmailComplete( User $user ) {
		global $wgAccountsPerEmail, $wgMemc;
		$sEmail = $user->getEmail();
		if ( isset( $wgAccountsPerEmail )
			&& is_numeric( $wgAccountsPerEmail )
			&& !UserLoginHelper::isWikiaEmail( $sEmail )
		) {
			$key = wfSharedMemcKey( "UserLogin", "AccountsPerEmail", $sEmail );
			$iCount = $wgMemc->get( $key );
			if ( $iCount === false ) {
				$iCount = self::getUsersPerEmailFromDB( $sEmail );
				if ( $iCount > 0 ) {
					$wgMemc->set( $key, $iCount );
				}
			} else {
				$wgMemc->incr( $key );
			}
		}
        return true;
	}

	static public function onWikiaMobileAssetsPackages( Array &$jsStaticPackages, Array &$jsExtensionPackages, Array &$scssPackages ) {
		$title = F::app()->wg->Title;

		if ( $title->isSpecial( 'UserSignup' ) ) {
			$scssPackages[] =  'wikiamobile_usersignup_scss';
			$jsExtensionPackages[] =  'wikiamobile_usersignup_js';
		} else if ( $title->isSpecial( 'WikiaConfirmEmail' ) ) {
			$scssPackages[] = 'wikiamobile_usersignup_scss';
		}

		return true;
	}

	/**
	 * Add JS messages to the output
	 * @param \OutputPage $out An output object passed from a hook
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		$out->addModules( 'ext.userLogin' );
		return true;
	}
}

