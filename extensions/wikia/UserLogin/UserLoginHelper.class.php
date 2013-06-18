<?php

/**
 * User Login Helper
 * @author Hyun
 * @author Saipetch
 *
 */
class UserLoginHelper extends WikiaModel {

	protected static $instance = NULL;

	const LIMIT_EMAIL_CHANGES = 5;
	const LIMIT_EMAILS_SENT = 5;
	const LIMIT_AVATARS = 4;
	const LIMIT_WIKIS = 3;

	const WIKIA_CITYID_COMMUNITY = 177;

	/**
	 * get random avatars from the current wiki
	 * @responseParam array avatars
	 */
	public function getRandomAvatars() {
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( 'userlogin', 'random_avatars' );
		$avatars = $this->wg->Memc->get( $memKey );
		if ( !is_array($avatars) ) {
			$avatars = $this->getRandomWikiAvatars( self::LIMIT_AVATARS );
			if ( count($avatars) < self::LIMIT_AVATARS ) {
				$additions = $this->getRandomWikiAvatars( self::LIMIT_AVATARS, self::WIKIA_CITYID_COMMUNITY );
				$diff = array_diff_assoc( $additions, $avatars );
				foreach( $diff as $userId => $avatar ) {
					$avatars[$userId] = $avatar;
					if ( count($avatars) >= self::LIMIT_AVATARS )
						break;
				}
			}
			$this->wg->Memc->set( $memKey, $avatars, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $avatars;
	}

	/**
	 * get a list of random avatars from the wiki
	 * @param integer $require (number of avatars)
	 * @param integer $wikiId
	 * @return array $avatars
	 */
	protected function getRandomWikiAvatars( $require, $wikiId=null ) {
		$avatars = array();
		$users = $this->getWikiUsers( $wikiId );
		if ( count($users) < $require ) {
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
	 * get users with avatar who sign up on the wiki (include founder)
	 * @param integer $wikiId
	 * @param integer $limit (number of users)
	 * @return array $wikiUsers
	 */
	protected function getWikiUsers( $wikiId=null, $limit=30 ) {
		wfProfileIn( __METHOD__ );

		$wikiId = (empty($wikiId)) ? $this->wg->CityId : $wikiId;

		$memKey = wfSharedMemcKey( 'userlogin', 'users_with_avatar', $wikiId );
		$wikiUsers = $this->wg->Memc->get( $memKey );
		if ( !is_array($wikiUsers) ) {
			$wikiUsers = array();

			$db = wfGetDB( DB_SLAVE, array(), $this->wg->StatsDB );
			$result = $db->select(
				array( 'user_login_history' ),
				array( 'distinct user_id' ),
				array( 'city_id' => $wikiId ),
				__METHOD__,
				array( 'LIMIT' => $limit )
			);

			while( $row = $db->fetchObject($result) ) {
				$this->addUserToUserList( $row->user_id, $wikiUsers );
			}
			$db->freeResult( $result );

			// add founder if not exist
			$founder = WikiFactory::getWikiById( $wikiId )->city_founding_user;
			if ( !array_key_exists($founder, $wikiUsers) ) {
				$this->addUserToUserList( $founder, $wikiUsers );
			}

			$this->wg->Memc->set( $memKey, $wikiUsers, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $wikiUsers;
	}

	/**
	 * add user who has avatar to the user list
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
	 * get a list of random popular wikis
	 * @param integer $require (number of wikis)
	 * @return array $wikis
	 */
	public function getRandomWikis( $require=self::LIMIT_WIKIS ) {
		return array();
/**
		$memKey = wfSharedMemcKey( 'userlogin', 'random_wikis' );
		$wikis = $this->wg->Memc->get( $memKey );
		if ( !is_array($wikis) ) {
			$popularWikis = $this->getPopularWikis();
			shuffle( $popularWikis );
			$wikis = array();

			foreach( $popularWikis as $wikiId ) {
				$themeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);
				if( !empty($themeSettings['wordmark-image-url']) ) {
					$wikis[] = $themeSettings['wordmark-image-url'];
				}

				if ( count($wikis) >= $require )
					break;
			}

			$this->wg->Memc->set( $memKey, $wikis, 60*60*24 );
		}

		return $wikis;
 **/
	}

	/**
	 * get popular wikis
	 * @param integer $wikiId
	 * @param integer $limit (number of users)
	 * @return array $popularWikis
	 */
	protected function getPopularWikis( $limit=50 ) {
		wfProfileIn( __METHOD__ );

		$memKey = wfSharedMemcKey( 'userlogin', 'popular_wikis' );
		$popularWikis = $this->wg->Memc->get( $memKey );
		if ( empty($popularWikis) ) {
			$popularWikis = array_keys( DataMartService::getTopWikisByPageviews( DataMartService::PERIOD_ID_MONTHLY, $limit ) );

			if ( empty($popularWikis) ) {
				$popularWikis[] = self::WIKIA_CITYID_COMMUNITY;
			}

			$this->wg->Memc->set( $memKey, $popularWikis, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $popularWikis;
	}

	/**
	 * redirect page
	 * @requestParam string returnUrl
	 */
	public function doRedirect(){
		$returnUrl = $this->wg->Request->getVal( 'returnto', '' );
		$returnToQuery = $this->wg->Request->getVal('returntoquery', '');
		$titleObj = Title::newFromText( $returnUrl );
		if ( (!$titleObj instanceof Title) ||
				$titleObj->isSpecial("Userlogout") ||
				$titleObj->isSpecial("Signup") ||
				$titleObj->isSpecial("Userlogin") ) {
			$titleObj = Title::newMainPage();
		}
		$this->wg->out->redirect( $titleObj->getFullURL($returnToQuery."&cb=".rand(1,10000)) );
	}

	/**
	 * send email
	 * @param User object $user
	 * @param string $category
	 * @param string $msgSubject
	 * @param string $msgBody
	 * @param array $emailParams
	 * @param string $templateType
	 * @return Status object
	 */
	public function sendEmail( User $user, $category, $msgSubject, $msgBody, $emailParams, $templateType, $template='GeneralMail', $priority=0 ) {
		$subject = strtr( wfMsg($msgSubject), $emailParams );
		$body = strtr( wfMsg($msgBody), $emailParams );
		if ( empty($this->wg->EnableRichEmails) ) {
			$bodyHTML = null;
		} else {
			$emailTextTemplate = $this->app->renderView( "UserLogin", $template, array('language' => $user->getOption('language'), 'type' => $templateType) );
			$bodyHTML = strtr( $emailTextTemplate, $emailParams );
		}

		return $user->sendMail( $subject, $body, null, null, $category, $bodyHTML, $priority );
	}

	/**
	 * send confirmation email
	 * @param string $username
	 * @return array result { array( 'result' => result status[error/ok/invalidsession/confirmed], 'msg' => result message ) }
	 */
	public function sendConfirmationEmail( $username, $user=null ) {
		if ( empty($username) ) {
			$result['result'] = 'error';
			$result['msg'] = wfMsg( 'userlogin-error-noname' );
			return $result;
		}

		/* @var $tempUser TempUser */
		$tempUser = TempUser::getTempUserFromName( $username );
		if ( $tempUser == false ) {
			$user = User::newFromName( $username );
			if ( $user instanceof User && $user->getID() != 0 ) {
				$result['result'] = 'confirmed';
				$result['msg'] = wfMsgExt( 'usersignup-error-confirmed-user', array('parseinline'), $username, $user->getUserPage()->getFullURL() );
			} else {
				$result['result'] = 'error';
				$result['msg'] = wfMsg( 'userlogin-error-nosuchuser' );
			}
			return $result;
		}

		if ( !(isset($_SESSION['tempUserId']) && $_SESSION['tempUserId'] == $tempUser->getId()) ) {
			$result['result'] = 'invalidsession';
			$result['msg'] = wfMsg( 'usersignup-error-invalid-user' );
			return $result;
		}

		if ( !$this->wg->EmailAuthentication || !Sanitizer::validateEmail($tempUser->getEmail()) ) {
			$result['result'] = 'error';
			$result['msg'] = wfMsg( 'usersignup-error-invalid-email' );
			return $result;
		}

		$user = $tempUser->mapTempUserToUser( true, $user );
		if ( $user->isEmailConfirmed() ) {
			$result['result'] = 'error';
			$result['msg'] = wfMsg( 'usersignup-error-already-confirmed' );
			return $result;
		}

		$memKey = $this->getMemKeyConfirmationEmailsSent( $tempUser->getId() );
		$emailSent = intval( $this->wg->Memc->get($memKey) );
		if( $user->isEmailConfirmationPending() && (strtotime($user->mEmailTokenExpires) - strtotime("+6 days") > 0) && $emailSent >= self::LIMIT_EMAILS_SENT ) {
			$result['result'] = 'error';
			$result['msg'] = wfMsg( 'usersignup-error-throttled-email' );
			return $result;
		}

		$emailTextTemplate = $this->app->renderView( "UserLogin", "GeneralMail", array('language' => $user->getOption('language'), 'type' => 'confirmation-email') );
		$response = $user->sendConfirmationMail( false, 'ConfirmationMail', 'usersignup-confirmation-email', true, $emailTextTemplate );
		$tempUser->saveSettingsTempUserToUser( $user );
		if( !$response->isGood() ) {
			$result['result'] = 'error';
			$result['msg'] = wfMsg( 'userlogin-error-mail-error' );
		} else {
			$result['result'] = 'ok';
			$result['msg'] = wfMsgExt( 'usersignup-confirmation-email-sent', array('parseinline'), htmlspecialchars($tempUser->getEmail()) );
			$this->incrMemc( $memKey );
		}

		return $result;
	}

	/**
	 * @param User $user
	 * @return string
	 */
	public function getReconfirmationEmailTempalte( $user ) {
		$emailTextTemplate = $this->app->renderView( "UserLogin", "GeneralMail", array('language' => $user->getOption('language'), 'type' => 'reconfirmation-email') );
		return $emailTextTemplate;
	}

	/**
	 * send reconfirmation email to the email address without saving that email address
	 * @param User $user
	 * @param string $email
	 * @return Status object
	 */
	public function sendReconfirmationEmail( &$user, $email, $type = 'change' ) {
		$userId = $user->getId();
		$userEmail = $user->getEmail();

		$user->mId = 0;
		$user->mEmail = $email;

		$result = $user->sendReConfirmationMail( $type );

		$user->mId = $userId;
		$user->mEmail = $userEmail;
		$user->saveSettings();

		return $result;
	}

	/**
	 * send reminder email
	 * @param User $user
	 * @return Status object
	 */
	public function sendConfirmationReminderEmail( &$user ) {
		if( ($user->getOption("cr_mailed", 0) == 1) ) {
			return false;
		}
		$emailTextTemplate = $this->app->renderView( "UserLogin", "GeneralMail", array('language' => $user->getOption('language'), 'type' => 'confirmation-reminder-email') );
		$user->setOption( "cr_mailed","1" );
		return $user->sendConfirmationMail( false, 'ConfirmationReminderMail', 'usersignup-confirmation-reminder-email', true, $emailTextTemplate );
	}

	/**
	 * check if password throttled
	 * @param string $username
	 * @return boolean passwordThrottled
	 */
	public function isPasswordThrottled( $username ) {
		$passwordThrottled = false;
		$throttleCount = 0;
		if ( is_array( $this->wg->PasswordAttemptThrottle ) ) {
			$throttleKey = wfMemcKey( 'password-throttle', wfGetIP(), md5( $username ) );
			$count = $this->wg->PasswordAttemptThrottle['count'];
			$period = $this->wg->PasswordAttemptThrottle['seconds'];

			$throttleCount = $this->wg->Memc->get( $throttleKey );
			if ( !$throttleCount ) {
				$this->wg->Memc->add( $throttleKey, 1, $period ); // start counter
			} else if ( $throttleCount < $count ) {
				$this->wg->Memc->incr($throttleKey);
			} else if ( $throttleCount >= $count ) {
				$passwordThrottled = true;
			}
		}
		return $passwordThrottled;
	}

	/*
	 * get memcache key for confirmation emails sent
	 */
	public function getMemKeyConfirmationEmailsSent( $userId ) {
		return wfSharedMemcKey( 'wikialogin', 'confirmation_emails_sent', $userId );
	}

	/*
	 * set or increase counter in memcache
	 * @param string memKey
	 * @param integer period (time to expire data at)
	 */
	public function incrMemc( $memKey, $period=86400 ) {
		$value = $this->wg->Memc->get( $memKey );
		if ( !$value ) {
			$this->wg->Memc->add( $memKey, 1, $period );
		} else {
			$this->wg->Memc->incr( $memKey );
		}
	}

	/**
	 * clear password-throttle cache
	 * @param string $username
	 */
	public function clearPasswordThrottle( $username ) {
		$key = wfMemcKey( 'password-throttle', wfGetIP(), md5($username) );
		$this->wg->Memc->delete( $key );
	}

	/**
	 * Add a newuser log entry for the user
	 *
	 * @param User $user
	 * @param $byEmail Boolean: account made by email?
	 */
	public function addNewUserLogEntry( $user, $byEmail = false ) {
		if( empty( $this->wg->NewUserLog ) ) {
			return true; // disabled
		}

		if( !$byEmail ) {
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
	 * get login token
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
	 * get signup token
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

	/*
	 * Show a nice form for the user to request a confirmation mail
	 * original function: showRequestForm() in EmailConfirmation class (Special:Confirmemail page)
	 */
	public function showRequestFormConfirmEmail( $pageObj ) {
		$user = $pageObj->getUser(); /* @var $user User */
		$out = $pageObj->getOutput(); /* @var $out OutputPage */
		$optionNewEmail = $user->getOption( 'new_email' );
		if( $pageObj->getRequest()->wasPosted() && $user->matchEditToken( $pageObj->getRequest()->getText( 'token' ) ) ) {
			// Wikia change -- only allow one email confirmation attempt per hour
			if (strtotime($user->mEmailTokenExpires) - strtotime("+6 days 23 hours") > 0) {
				$out->addWikiMsg( 'usersignup-error-throttled-email' );
				return;
			}

			$email = ( $user->isEmailConfirmed() && !empty($optionNewEmail) ) ? $optionNewEmail : $user->getEmail() ;
			$status = $this->sendReconfirmationEmail( $user, $email );
			if ( $status->isGood() ) {
				$out->addWikiMsg( 'usersignup-user-pref-reconfirmation-email-sent', $email );
			} else {
				$out->addWikiText( $status->getWikiText( 'userlogin-error-mail-error' ) );
			}
		} else {
			if ( $user->isEmailConfirmed() && empty($optionNewEmail) ) {
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

			if ( $user->isEmailConfirmationPending() || !empty($optionNewEmail) ) {
				$out->addWikiMsg( 'usersignup-confirm-email-unconfirmed-emailnotauthenticated' );
				if (strtotime($user->mEmailTokenExpires) - strtotime("+6 days 23 hours") > 0)
					return;
			}

			$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $pageObj->getTitle()->getLocalUrl() ) );
			$form .= Html::hidden( 'token', $user->getEditToken() );
			$form .= Xml::submitButton( $pageObj->msg( 'usersignup-user-pref-confirmemail_send' )->text() );
			$form .= Xml::closeElement( 'form' );
			$out->addHTML( $form );
		}
	}


}
