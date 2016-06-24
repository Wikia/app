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
	const LIMIT_AVATARS = 4;
	const LIMIT_WIKIS = 3;

	const WIKIA_EMAIL_DOMAIN = "@wikia-inc.com";

	/**
	 * Get random avatars from the current wiki
	 *
	 * @responseParam array avatars
	 */
	public function getRandomAvatars() {
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( 'userlogin', 'random_avatars' );
		$avatars = $this->wg->Memc->get( $memKey );
		if ( !is_array( $avatars ) ) {
			$avatars = $this->getRandomWikiAvatars( self::LIMIT_AVATARS );
			if ( count( $avatars ) < self::LIMIT_AVATARS ) {
				$additions = $this->getRandomWikiAvatars( self::LIMIT_AVATARS, WikiFactory::COMMUNITY_CENTRAL );
				$diff = array_diff_assoc( $additions, $avatars );
				foreach ( $diff as $userId => $avatar ) {
					$avatars[$userId] = $avatar;
					if ( count( $avatars ) >= self::LIMIT_AVATARS )
						break;
				}
			}
			$this->wg->Memc->set( $memKey, $avatars, 60 * 60 * 24 );
		}

		wfProfileOut( __METHOD__ );

		return $avatars;
	}

	/**
	 * Get a list of random avatars from the wiki
	 *
	 * @param integer $require (number of avatars)
	 * @param integer $wikiId
	 * @return array $avatars
	 */
	protected function getRandomWikiAvatars( $require, $wikiId = null ) {
		$avatars = array();
		$users = $this->getWikiUsers( $wikiId );
		if ( count( $users ) < $require ) {
			$randomList = array_keys( $users );
		} else {
			$randomList = array_rand( $users, $require );
		}

		// get avatar url
		foreach ( $randomList as $userId ) {
			$avatars[$userId] = AvatarService::getAvatarUrl( $users[$userId], 30 );
		}

		return $avatars;
	}

	/**
	 * Get users with avatar who sign up on the wiki (include founder)
	 *
	 * @param integer $wikiId
	 * @param integer $limit (number of users)
	 * @return array $wikiUsers
	 */
	protected function getWikiUsers( $wikiId = null, $limit = 30 ) {
		global $wgSpecialsDB;
		wfProfileIn( __METHOD__ );

		$wikiId = ( empty( $wikiId ) ) ? $this->wg->CityId : $wikiId;

		$memKey = wfSharedMemcKey( 'userlogin', 'users_with_avatar', $wikiId );
		$wikiUsers = $this->wg->Memc->get( $memKey );
		if ( !is_array( $wikiUsers ) ) {
			$wikiUsers = array();

			$db = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );
			$result = $db->select(
				array( 'user_login_history' ),
				array( 'distinct user_id' ),
				array( 'city_id' => $wikiId ),
				__METHOD__,
				array( 'LIMIT' => $limit )
			);

			while ( $row = $db->fetchObject( $result ) ) {
				$this->addUserToUserList( $row->user_id, $wikiUsers );
			}
			$db->freeResult( $result );

			// add founder if not exist
			$founder = WikiFactory::getWikiById( $wikiId )->city_founding_user;
			if ( !array_key_exists( $founder, $wikiUsers ) ) {
				$this->addUserToUserList( $founder, $wikiUsers );
			}

			$this->wg->Memc->set( $memKey, $wikiUsers, WikiaResponse::CACHE_STANDARD );
		}

		wfProfileOut( __METHOD__ );
		return $wikiUsers;
	}

	/**
	 * Add user who has avatar to the user list
	 *
	 * @param integer $userId
	 * @param array $userList
	 */
	protected function addUserToUserList( $userId, &$userList ) {
		$user = User::newFromId( $userId );
		$masthead = Masthead::newFromUser( $user );
		if ( $masthead->hasAvatar() ) {
			$userList[$user->getId()] = $user->getName();
		}
	}

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
			$title->isSpecial( 'FacebookConnect' ) ||
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
		wfRunHooks( 'SignupConfirmEmailComplete', array( $user ) );
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

	/**
	 * @desc This function is a workaround for validating user with 'AbortNewAccount' hook without captcha validation.
	 *
	 * Currently this is used for both Facebook registrations and Phalanx validation, where the captcha is not
	 * present. The captcha check is performed in \SimpleCaptcha::confirmUserCreate and is currently bypassed
	 * by setting $wgCaptchaTriggers['createaccount'] to false.
	 * After the custom callable is executed, $wgCaptchaTriggers['createaccount'] is reverted to its previous issue.
	 *
	 * @param callable $function - custom function to execute with disabled captcha chedk
	 * @param array $params - array to be passed to the callable function
	 * @return mixed - result, returned by the callable function
	 */
	public static function callWithCaptchaDisabled( $function, $params = array() ) {
		global $wgCaptchaTriggers;

		// Dissable captcha check
		$oldValue = $wgCaptchaTriggers;
		$wgCaptchaTriggers['createaccount'] = false;

		// Execute custom callable
		if ( is_callable( $function ) ) {
			$result = $function( $params );
		} else {
			$result = null;
		}

		// and bring back the old value
		$wgCaptchaTriggers = $oldValue;

		return $result;
	}

	public function getNewAuthUrl( $page = '/join' ) {
		if ( $this->app->wg->title->isSpecial( 'Userlogout' ) ) {
			$requestUrl = Title::newMainPage()->getLocalURL();
		}
		else {
			$requestUrl = $this->app->wg->request->getRequestURL();
		}

		return $page . '?redirect='
			. urlencode ( wfExpandUrl ( $requestUrl ) )
			. $this->getUselangParam();
	}

	/**
	 * Returns string with uselang param to append to login url if Wikia language is different than default
	 * @return string
	 */
	private function getUselangParam() {
		$lang = $this->wg->ContLang->mCode;
		return $lang == 'en' ? '' : '&uselang=' . $lang;
	}

	/**
	 * Set the cookies for the newly connected user.
	 *
	 * @param User the user that has been authenticated via facebook.
	 */
	public static function setCookiesForFacebookUser( \User $user, \Wikia\HTTP\Response $response ) {
		$user->setCookies();
		self::getCookieHelper()->setAuthenticationCookieWithUserId( $user->getId(), $response );
	}

	/**
	 * @return \Wikia\Service\User\Auth\CookieHelper
	 */
	private static function getCookieHelper() {
		return Injector::getInjector()->get(CookieHelper::class);
	}

}
