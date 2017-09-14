<?php

use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\Auth\CookieHelper;

/**
 * User Login Helper
 * @author Hyun
 * @author Saipetch
 */
class UserLoginHelper extends WikiaModel {

	const LIMIT_EMAIL_CHANGES = 5;
	const LIMIT_EMAILS_SENT = 5;

	const WIKIA_EMAIL_DOMAIN = "@fandom.com";

	/**
	 * Redirect the user to the appropriate page after login.
	 *
	 * @param string $extraReturnToQuery Use this to add any additional parameters to the query string
	 * @param int $cbVal Send a specific CB value (mostly for testing)
	 */
	public function doRedirect( $extraReturnToQuery = '', $cbVal = 0 ) {
		$this->wg->out->redirect( $this->getRedirectUrl( $extraReturnToQuery, $cbVal ) );
	}

	/**
	 * Determine the URL that should be redirected to after the current login action.  If
	 * there is a returnto URL and it's valid then send them there.  Otherwise send the
	 * user to the wikia's main page.
	 *
	 * @param string $extraReturnToQuery Use this to add any additional parameters to the query string
	 * @param int $cbVal Send a specific CB value (mostly for testing)
	 *
	 * @return String
	 * @throws MWException
	 */
	public function getRedirectUrl( $extraReturnToQuery = '', $cbVal = 0 ) {
		$returnUrl = $this->wg->Request->getVal( 'returnto', '' );
		$titleObj = Title::newFromText( $returnUrl );

		if ( $this->isInvalidLoginRedirect( $titleObj ) ) {
			$titleObj = Title::newMainPage();
		}

		$cbParam = 'cb=' . ( $cbVal ? $cbVal : rand( 1, 10000 ) );
		$returnParams = $this->wg->Request->getVal( 'returntoquery', '' );

		if ( !empty( $extraReturnToQuery ) ) {
			$returnParams .= ( empty( $returnParams ) ? '' : '&' ) . $extraReturnToQuery;
		}

		$returnParams .= ( empty( $returnParams ) ? '' : '&' ) . $cbParam;

		return $titleObj->getFullURL( $returnParams );
	}

	/**
	 * @param Title|null $title
	 *
	 * @return bool
	 */
	public function isInvalidLoginRedirect( $title ) {
		return (
			!$title instanceof Title ||
			$title->isSpecial( 'Userlogout' ) ||
			$title->isSpecial( 'Signup' ) ||
			$title->isSpecial( 'Connect' ) ||
			$title->isSpecial( 'UserLogin' )
		);
	}

	/**
	 * Send an HTML/text email
	 *
	 * @param User object $user
	 * @param string $category
	 * @param string $msgSubject
	 * @param string $msgBody
	 * @param array $emailParams
	 * @param string $templateType
	 * @param string $template
	 * @param int $priority
	 *
	 * @return Status
	 */
	public function sendEmail( User $user, $category, $msgSubject, $msgBody, $emailParams, $templateType, $template = 'GeneralMail', $priority = 0 ) {
		$subject = strtr( wfMessage( $msgSubject )->escaped(), $emailParams );
		$body = strtr( wfMessage( $msgBody )->escaped(), $emailParams );
		if ( empty( $this->wg->EnableRichEmails ) ) {
			$bodyHTML = null;
		} else {
			$emailTextTemplate = $this->app->renderView( "UserLogin", $template, array( 'language' => $user->getGlobalPreference( 'language' ), 'type' => $templateType ) );
			$bodyHTML = strtr( $emailTextTemplate, $emailParams );
		}

		return $user->sendMail( $subject, $body, null, null, $category, $bodyHTML, $priority );
	}

	/**
	 * Send confirmation email
	 *
	 * @param string $username
	 * @return array The format of this array is:
	 * 		[
	 * 			'result' => result status[error/ok/invalidsession/confirmed],
	 * 			'msg' => result message
	 * 		]
	 */
	public function sendConfirmationEmail( $username ) {
		global $wgExternalSharedDB;
		if ( empty( $username ) ) {
			$result['result'] = 'error';
			$result['msg'] = wfMessage( 'userlogin-error-noname' )->escaped();
			return $result;
		}

		// Check whether user already exists or is already confirmed
		wfWaitForSlaves(); // Wait for local DB - Wikis that keep user data in local DB (e.g. Uncyclopedia/Internal)
		wfWaitForSlaves( $wgExternalSharedDB ); // Wait for external shared DB
		$user = User::newFromName( $username );
		if ( !( $user instanceof User ) || $user->getID() == 0 ) {
			// User doesn't exist
			$result['result'] = 'error';
			$result['msg'] = wfMessage( 'userlogin-error-nosuchuser' )->escaped();
			return $result;
		} else {
			if ( !$user->getGlobalFlag( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME ) && $user->isEmailConfirmed() ) {
				// User already confirmed on signup
				$result['result'] = 'confirmed';
				$result['msg'] = wfMessage( 'usersignup-error-confirmed-user', $username, $user->getUserPage()->getFullURL() )->parse();
				return $result;
			}
		}

		// IF session is invalid, set invalidsession result and redirect to login page
		if ( !( isset( $_SESSION['notConfirmedUserId'] ) && $_SESSION['notConfirmedUserId'] == $user->getId() ) ) {
			$result['result'] = 'invalidsession';
			$result['msg'] = wfMessage( 'usersignup-error-invalid-user' )->escaped();
			return $result;
		}

		if ( !$this->wg->EmailAuthentication || !Sanitizer::validateEmail( $user->getEmail() ) ) {// Why throw an invalid email error when wgEmailAuthentication is off?
			$result['result'] = 'error';
			$result['msg'] = wfMessage( 'usersignup-error-invalid-email' )->escaped();
			return $result;
		}

		if ( $user->isEmailConfirmed() ) {
			$result['result'] = 'error';
			$result['msg'] = wfMessage( 'usersignup-error-already-confirmed' )->escaped();
			return $result;
		}

		// Signup throttle check
		$memKey = $this->getMemKeyConfirmationEmailsSent( $user->getId() );
		$emailSent = intval( $this->wg->Memc->get( $memKey ) );
		if ( $user->isEmailConfirmationPending() && ( strtotime( $user->mEmailTokenExpires ) - strtotime( "+6 days" ) > 0 ) && $emailSent >= self::LIMIT_EMAILS_SENT ) {
			$result['result'] = 'error';
			$result['msg'] = wfMessage( 'usersignup-error-throttled-email' )->escaped();
			return $result;
		}

		$response = $user->sendConfirmationMail( false, 'ConfirmationMail' );
		if ( !$response->isGood() ) {
			$result['result'] = 'error';
			$result['msg'] = wfMessage( 'userlogin-error-mail-error' )->escaped();
		} else {
			$result['result'] = 'ok';
			$result['msg'] = wfMessage( 'usersignup-confirmation-email-sent', htmlspecialchars( $user->getEmail() ) )->parse();
			$this->incrMemc( $memKey );
		}

		return $result;
	}

	/**
	 * Send reconfirmation email to the email address without saving that email address
	 *
	 * @param User $user
	 * @param string $email
	 * @param string $type
	 *
	 * @return Status object
	 */
	public function sendReconfirmationEmail( &$user, $email, $type = 'change' ) {
		$userId = $user->getId();
		$userEmail = $user->getEmail();

		$user->mId = 0;
		$user->mEmail = $email;

		$result = $user->sendReConfirmationMail();

		$user->mId = $userId;
		$user->mEmail = $userEmail;
		$user->saveSettings();

		return $result;
	}

	/**
	 * Send a reminder email
	 *
	 * @param User $user
	 * @return Status object
	 */
	public function sendConfirmationReminderEmail( $user ) {
		if ( ( $user->getGlobalFlag( "cr_mailed", 0 ) == 1 ) ) {
			return Status::newFatal( 'userlogin-error-confirmation-reminder-already-sent' );
		}
		$user->setGlobalFlag( "cr_mailed", "1" );
		return $user->sendConfirmationMail( false, 'ConfirmationReminderMail' );
	}

	/**
	 * Check if password throttled
	 *
	 * Meaning whether user exhausted number of attempts
	 * to sign in using wrong password determined
	 * by wgPasswordAttemptThrottle var
	 *
	 * @param string $username
	 * @return boolean passwordThrottled
	 */
	public function isPasswordThrottled( $username ) {
		$passwordThrottled = false;

		if ( is_array( $this->wg->PasswordAttemptThrottle ) ) {
			$throttleKey = $this->getPasswordThrottleCacheKey( $username );
			$count = $this->wg->PasswordAttemptThrottle['count'];
			$period = $this->wg->PasswordAttemptThrottle['seconds'];

			$throttleCount = $this->wg->Memc->get( $throttleKey );
			if ( !$throttleCount ) {
				$this->wg->Memc->add( $throttleKey, 1, $period ); // start counter
			} else if ( $throttleCount < $count ) {
				$this->wg->Memc->incr( $throttleKey );
			} else if ( $throttleCount >= $count ) {
				$passwordThrottled = true;
			}
		}
		return $passwordThrottled;
	}

	/**
	 * Get memcache key for confirmation emails sent
	 */
	public function getMemKeyConfirmationEmailsSent( $userId ) {
		return wfSharedMemcKey( 'wikialogin', 'confirmation_emails_sent', $userId );
	}

	/**
	 * Set or increase counter in memcache
	 *
	 * @param string $memKey
	 * @param integer $period (time to expire data at)
	 */
	public function incrMemc( $memKey, $period = 86400 ) {
		$value = $this->wg->Memc->get( $memKey );
		if ( !$value ) {
			$this->wg->Memc->add( $memKey, 1, $period );
		} else {
			$this->wg->Memc->incr( $memKey );
		}
	}

	/**
	 * clear password-throttle cache
	 *
	 * @param string $username
	 */
	public function clearPasswordThrottle( $username ) {
		$key = $this->getPasswordThrottleCacheKey( $username );
		$this->wg->Memc->delete( $key );
	}

	/**
	 * @param $username
	 *
	 * @return String
	 * @throws MWException
	 */
	public function getPasswordThrottleCacheKey( $username ) {
		return wfSharedMemcKey( 'password-throttle', $this->wg->Request->getIP(), md5( $username ) );
	}

	/**
	 * Add a newuser log entry for the user
	 *
	 * @param User $user
	 * @param bool $byEmail account made by email?
	 *
	 * @return bool
	 */
	public function addNewUserLogEntry( $user, $byEmail = false ) {
		if ( empty( $this->wg->NewUserLog ) ) {
			return true; // disabled
		}

		if ( !$byEmail ) {
			$action = 'create';
			$doer = $user;
		} else {
			$action = 'create2';
			$doer = null;
		}

		$log = new LogPage( 'newusers' );
		$log->addEntry(
			$action,
			$user->getUserPage(),
			'',
			array( $user->getId() ),
			$doer
		);
		return true;
	}

	/**
	 * Read a login token, DO NOT init if it doesn't exist
	 *
	 * @return string loginToken|null
	 */
	public static function readLoginToken() {
		$loginToken = LoginForm::getLoginToken();
		return !empty( $loginToken ) ? $loginToken : null;
	}

	/**
	 * Get a login token
	 *
	 * @return string loginToken
	 */
	public static function getLoginToken() {
		if ( !LoginForm::getLoginToken() ) {
			// Init session if necessary
			if ( session_id() == '' ) {
				wfSetupSession();
			}
			LoginForm::setLoginToken();
		}
		return LoginForm::getLoginToken();
	}

	/**
	 * Get a signup token
	 * @return string signupToken
	 */
	public static function getSignupToken() {
		if ( !LoginForm::getCreateaccountToken() ) {
			// Init session if necessary
			if ( session_id() == '' ) {
				wfSetupSession();
			}
			LoginForm::setCreateaccountToken();
		}
		return LoginForm::getCreateaccountToken();
	}

	/**
	 * Show a nice form for the user to request a confirmation mail
	 * original function: showRequestForm() in EmailConfirmation class (Special:Confirmemail page)
	 *
	 * @param EmailConfirmation $pageObj
	 */
	public function showRequestFormConfirmEmail( EmailConfirmation $pageObj ) {
		$user = $pageObj->getUser(); /* @var $user User */
		$out = $pageObj->getOutput(); /* @var $out OutputPage */
		$optionNewEmail = $user->getNewEmail();
		if ( $pageObj->getRequest()->wasPosted() && $user->matchEditToken( $pageObj->getRequest()->getText( 'token' ) ) ) {
			// Wikia change -- only allow one email confirmation attempt per hour
			if ( strtotime( $user->mEmailTokenExpires ) - strtotime( "+6 days 23 hours" ) > 0 ) {
				$out->addWikiMsg( 'usersignup-error-throttled-email' );
				return;
			}

			$email = ( $user->isEmailConfirmed() && !empty( $optionNewEmail ) ) ? $optionNewEmail : $user->getEmail() ;
			$status = $this->sendReconfirmationEmail( $user, $email );
			if ( $status->isGood() ) {
				$out->addWikiMsg( 'usersignup-user-pref-reconfirmation-email-sent', $email );
			} else {
				$out->addWikiText( $status->getWikiText( 'userlogin-error-mail-error' ) );
			}
		} else {
			if ( $user->isEmailConfirmed() && empty( $optionNewEmail ) ) {
				// date and time are separate parameters to facilitate localisation.
				// $time is kept for backward compat reasons.
				// 'emailauthenticated' is also used in SpecialPreferences.php
				$lang = $pageObj->getLanguage();
				$emailAuthenticated = $user->getEmailAuthenticationTimestamp();
				$time = $lang->timeAndDate( $emailAuthenticated, $user );
				$d = $lang->date( $emailAuthenticated, $user );
				$t = $lang->time( $emailAuthenticated, $user );
				$out->addWikiMsg( 'usersignup-user-pref-emailauthenticated', $time, $d, $t );
				return;
			}

			if ( $user->isEmailConfirmationPending() || !empty( $optionNewEmail ) ) {
				$out->addWikiMsg( 'usersignup-confirm-email-unconfirmed-emailnotauthenticated' );
				if ( strtotime( $user->mEmailTokenExpires ) - strtotime( "+6 days 23 hours" ) > 0 )
					return;
			}

			$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $pageObj->getTitle()->getLocalUrl() ) );
			$form .= Html::hidden( 'token', $user->getEditToken() );
			$form .= Xml::submitButton( $pageObj->msg( 'usersignup-user-pref-confirmemail_send' )->text() );
			$form .= Xml::closeElement( 'form' );
			$out->addHTML( $form );
		}
	}

	public static function clearNotConfirmedUserSession() {
		unset( $_SESSION['notConfirmedUserId'] );
	}

	public static function setNotConfirmedUserSession( $userId ) {
		$_SESSION['notConfirmedUserId'] = $userId;
	}

	/**
	 * Removes not confirmed option from user's properties
	 *
	 * @param User $user
	 * @return bool
	 */
	public static function removeNotConfirmedFlag( User &$user ) {
		$user->setGlobalFlag( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, null );
		$user->setGlobalFlag( UserLoginSpecialController::SIGNED_UP_ON_WIKI_OPTION_NAME, null );
		$user->saveSettings();
		$user->saveToCache();
		Hooks::run( 'SignupConfirmEmailComplete', array( $user ) );
		return true;
	}

	/**
	 * Checks if Email belongs to the wikia domain;
	 *
	 * @param string $sEmail Email to check
	 * @static
	 * @return bool
	 */
	public static function isWikiaEmail( $sEmail ) {
		return substr( $sEmail, strpos( $sEmail, '@' ) ) == self::WIKIA_EMAIL_DOMAIN;
	}

	/**
	 * @desc Checks if the email provided is wikia mail and within the limit specified by $wgAccountsPerEmail
	 *
	 * @param $sEmail - email address to check
	 * @return bool - TRUE if the email can be registered, otherwise FALSE
	 */
	public static function withinEmailRegLimit( $sEmail ) {
		global $wgAccountsPerEmail, $wgMemc;

		if ( isset( $wgAccountsPerEmail )
			&& is_numeric( $wgAccountsPerEmail )
			&& !self::isWikiaEmail( $sEmail )
		) {
			$key = wfSharedMemcKey( "UserLogin", "AccountsPerEmail", $sEmail );
			$count = $wgMemc->get( $key );
			if ( $count !== false
				&& (int)$count >= (int)$wgAccountsPerEmail
			) {
				return false;
			}
		}
		return true;
	}

	public function getNewAuthUrl( $page = '/join' ) {
		$requestUrl = $this->getCurrentUrlOrMainPageIfOnUserLogout();
		parse_str( parse_url( $page, PHP_URL_QUERY ), $queryParams );

		return wfAppendQuery( $page, 'redirect='
			. urlencode ( $requestUrl )
			. ( !isset( $queryParams['uselang'] ) ? $this->getUselangParam() : '' )
		);
	}

	public function getCurrentUrlOrMainPageIfOnUserLogout() {
		if ( $this->app->wg->title->isSpecial( 'Userlogout' ) ) {
			return wfExpandUrl( Title::newMainPage()->getLocalURL() );
		} else {
			return wfExpandUrl( $this->app->wg->request->getRequestURL() );
		}
	}

	/**
	 * Returns string with uselang param to append to login url if Wikia language is different than default
	 * @return string
	 */
	private function getUselangParam() {
		$lang = $this->wg->ContLang->mCode;
		return $lang == 'en' ? '' : '&uselang=' . $lang;
	}

}
