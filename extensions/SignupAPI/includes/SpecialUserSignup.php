<?php
/**
 * Implements Special:UserSignup
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup SpecialPage
 */

/**
 * Implements Special:UserSignup
 *
 * @ingroup SpecialPage
 */
class SpecialUserSignup extends SpecialPage {

	const SUCCESS = 0;
	const NO_NAME = 1;
	const CREATE_BLOCKED = 2;
	const NEED_TOKEN = 3;
	const WRONG_TOKEN = 4;
	const IP_BLOCKED = 5;
	const USER_EXISTS = 6;
	const WRONG_RETYPE = 7;
	const INVALID_DOMAIN = 8;
	const READ_ONLY_PAGE = 9;
	const NO_COOKIES = 10;
	const INSUFFICIENT_PERMISSION = 11;
	const INVALID_PASS = 12;
	const NO_EMAIL = 13;
	const INVALID_EMAIL = 14;
	const BLOCKED_BY_HOOK = 15;
	const EXTR_DB_ERROR = 16;
	const THROTLLED = 17;
	const INIT_FAILED = 18;

	//Initialise all variables to be used
	var $tempUsername, $mPassword, $mRetype, $mReturnTo, $mCookieCheck, $mPosted;
	var $mAction, $mCreateaccount, $mCreateaccountMail;
	var $mRemember, $mEmail, $mDomain, $mLanguage;
	var $mSkipCookieCheck, $mReturnToQuery, $mToken, $mStickHTTPS;
	var $mType, $mReason, $mRealName, $mUsername;
	var $abortError = '';
	var $tempUser, $mConfirmationMailStatus, $mRunCookieRedirect, $mRunCreationConfirmation;
	var $mSourceAction, $mSourceNS, $msourceArticle;

	/**
	 * @var ExternalUser
	 */
	private $mExtUser = null;

	/**
	 * @param WebRequest $request
	 */
	public function __construct( $request = null ) {
		parent::__construct( 'UserSignup' );

		if ( $request === null ) {
			global $wgRequest;
			$this->load( $wgRequest );
		} else {
			$this->load( $request );
		}
	}

	/**
	 * Loader
	 *
	 * @param $request WebRequest object
	 */
	function load( $request ) {
		global $wgAuth, $wgHiddenPrefs, $wgEnableEmail;

		$this->mType = $request->getText( 'type' );
		$this->mUsername = $request->getText( 'wpName' );
		$this->mPassword = $request->getText( 'wpPassword' );
		$this->mRetype = $request->getText( 'wpRetype' );
		$this->mDomain = $request->getText( 'wpDomain' );
		$this->mReason = $request->getText( 'wpReason' );
		$this->mReturnTo = $request->getVal( 'returnto' );
		$this->mReturnToQuery = $request->getVal( 'returntoquery' );
		$this->mCookieCheck = $request->getVal( 'wpCookieCheck' );
		$this->mPosted = $request->wasPosted();
		$this->mCreateaccount = $request->getCheck( 'wpCreateaccount' );
		$this->mCreateaccountMail = $request->getCheck( 'wpCreateaccountMail' )
									&& $wgEnableEmail;
		$this->mAction = $request->getVal( 'action' );
		$this->mRemember = $request->getCheck( 'wpRemember' );
		$this->mStickHTTPS = $request->getCheck( 'wpStickHTTPS' );
		$this->mLanguage = $request->getText( 'uselang' );
		$this->mSkipCookieCheck = $request->getCheck( 'wpSkipCookieCheck' );
		$this->mToken = $request->getVal( 'wpCreateaccountToken' );

		$this->mSourceAction = $request->getVal( 'wpSourceAction' );
		$this->mSourceNS = $request->getVal( 'wpSourceNS' );
		$this->msourceArticle = $request->getVal( 'wpSourceArticle' );

		if( $wgEnableEmail ) {
			$this->mEmail = $request->getText( 'wpEmail' );
		} else {
			$this->mEmail = '';
		}

		if( !in_array( 'realname', $wgHiddenPrefs ) ) {
			$this->mRealName = $request->getText( 'wpRealName' );
		} else {
			$this->mRealName = '';
		}

		if( !$wgAuth->validDomain( $this->mDomain ) ) {
			$this->mDomain = 'invaliddomain';
		}
		$wgAuth->setDomain( $this->mDomain );
	}

	public function execute( $par ) {
		global $wgOut;

		if ( session_id() == '' ) {
			wfSetupSession();
		}

		if ( $par == 'signup' ) { # Check for [[Special:Userlogin/signup]]
			$this->mType = 'signup';
		}

		// Ajax-ify ?
		global $wgSignupAPIUseAjax;
		if ( $wgSignupAPIUseAjax ) {
			$wgOut->addModules( 'ext.SignupAPI' );
		}


		if ( !is_null( $this->mCookieCheck ) ) {
			$this->onCookieRedirectCheck( $this->mCookieCheck );
			return;
		} elseif( $this->mPosted ) {
			if( $this->mCreateaccount ) {
				return $this->processSignup();
			} elseif ( $this->mCreateaccountMail ) {
				return $this->addNewAccountMailPassword();
			}
		}

		$this->mainSignupForm( '' );
	}

	/**
	 * @private
	 */
	// Used for mailing password reset request
	function addNewAccountMailPassword() {
		global $wgOut;

		// Check if no email id was provided
		if ( $this->mEmail == '' ) {
			$this->mainSignupForm( wfMsgExt( 'noemail', array( 'parsemag', 'escape' ), $this->mUsername ) );
			return;
		}

		$tempUser = $this->addNewaccountInternal();

		if ( $tempUser == null ) {
			return;
		}

		// Wipe the initial password and mail a temporary one
		$tempUser->setPassword( null );
		$tempUser->saveSettings();
		$result = $this->mailPasswordInternal( $tempUser, false, 'createaccount-title', 'createaccount-text' );

		wfRunHooks( 'AddNewAccount', array( $tempUser, true ) );
		$tempUser->addNewUserLogEntry( true, $this->mReason );

		$wgOut->setPageTitle( wfMsg( 'accmailtitle' ) );

		if( !$result->isGood() ) {
			$this->mainSignupForm( wfMsg( 'mailerror', $result->getWikiText() ) );
		} else {
			$wgOut->addWikiMsg( 'accmailtext', $tempUser->getName(), $tempUser->getEmail() );
			$wgOut->returnToMain( false );
		}
	}

	/**
	 * @private
	 *
	 * @param $tempUser User
	 */
	function addNewAccount( $tempUser ) {
		global $wgUser, $wgEmailAuthentication;

		# If we showed up language selection links, and one was in use, be
		# smart (and sensible) and save that language as the user's preference
		global $wgLoginLanguageSelector;
		if( $wgLoginLanguageSelector && $this->mLanguage ) {
			$tempUser->setOption( 'language', $this->mLanguage );
		}

		# Send out an email authentication message if needed
		if( $wgEmailAuthentication ) {
			$this->mConfirmationMailStatus = $tempUser->sendConfirmationMail();
		}

		# Save settings (including confirmation token)
		$tempUser->saveSettings();

		# If not logged in, assume the new account as the current one and set
		# session cookies then show a "welcome" message or a "need cookies"
		# message as needed
		if( $wgUser->isAnon() ) {
			$wgUser = $tempUser;
			$wgUser->setCookies();
			wfRunHooks( 'AddNewAccount', array( $wgUser, false ) );
			$wgUser->addNewUserLogEntry();
			if( $this->hasSessionCookie() ) {
				return true;
			} else {
				$this->mRunCookieRedirect = true;
				return true;
			}
		} else {
			$this->mRunCreationConfirmation = true;
			wfRunHooks( 'AddNewAccount', array( $tempUser, false ) );
			$tempUser->addNewUserLogEntry( false, $this->mReason );
			return true;
		}
	}

	/**
	 * @private
	 *
	 * @return User|int If int, it is a returned constant
	 */
	function addNewAccountInternal() {
		global $wgUser;
		global $wgMemc, $wgAccountCreationThrottle;
		global $wgAuth;
		global $wgEmailConfirmToEdit;

		// If the user passes an invalid domain, something is fishy
		if( !$wgAuth->validDomain( $this->mDomain ) ) {
			return self::INVALID_DOMAIN;
		}

		// If we are not allowing users to login locally, we should be checking
		// to see if the user is actually able to authenticate to the authenti-
		// cation server before they create an account (otherwise, they can
		// create a local account and login as any domain user). We only need
		// to check this for domains that aren't local.
		if( 'local' != $this->mDomain && $this->mDomain != '' ) {
			if( !$wgAuth->canCreateAccounts() && ( !$wgAuth->userExists( $this->mUsername )
				|| !$wgAuth->authenticate( $this->mUsername, $this->mPassword ) ) ) {
				return self::INVALID_DOMAIN;
			}
		}

		if ( wfReadOnly() ) {
			return self::READ_ONLY_PAGE;
		}

		# Request forgery checks.
		if ( !self::getCreateaccountToken() ) {
			self::setCreateaccountToken();
			return self::NO_COOKIES;
		}

		# The user didn't pass a createaccount token
		if ( !$this->mToken ) {
			return self::NEED_TOKEN;
		}

		# Validate the createaccount token
		if ( $this->mToken !== self::getCreateaccountToken() ) {
			return self::WRONG_TOKEN;
		}

		# Check permissions
		if ( !$wgUser->isAllowed( 'createaccount' ) ) {
			return self::INSUFFICIENT_PERMISSION;
		} elseif ( $wgUser->isBlockedFromCreateAccount() ) {
			return self::CREATE_BLOCKED;
		}

		$ip = wfGetIP();
		if ( $wgUser->isDnsBlacklisted( $ip, true /* check $wgProxyWhitelist */ ) ) {
			return self::IP_BLOCKED;
		}

		# Now create a dummy user ($tempUser) and check if it is valid
		$name = trim( $this->mUsername );
		$tempUser = User::newFromName( $name, 'creatable' );
		if ( !is_object( $tempUser ) ) {
			return self::NO_NAME;
		}

		if ( 0 != $tempUser->idForName() ) {
			return self::USER_EXISTS;
		}

		if ( 0 != strcmp( $this->mPassword, $this->mRetype ) ) {
			return self::WRONG_RETYPE;
		}

		# check for minimal password length
		$valid = $tempUser->getPasswordValidity( $this->mPassword );
		if ( $valid !== true ) {
			if ( !$this->mCreateaccountMail ) {
				return self::INVALID_PASS;
			} else {
				# do not force a password for account creation by email
				# set invalid password, it will be replaced later by a random generated password
				$this->mPassword = null;
			}
		}

		# if you need a confirmed email address to edit, then obviously you
		# need an email address.
		if ( $wgEmailConfirmToEdit && empty( $this->mEmail ) ) {
			return self::NO_EMAIL;
		}

		# if email is provided then validate it
		if( !empty( $this->mEmail ) && !Sanitizer::validateEmail( $this->mEmail ) ) {
			return self::INVALID_EMAIL;
		}

		# Set some additional data so the AbortNewAccount hook can be used for
		# more than just username validation
		$tempUser->setEmail( $this->mEmail );
		$tempUser->setRealName( $this->mRealName );

		$abortError = '';
		if( !wfRunHooks( 'AbortNewAccount', array( $tempUser, &$abortError ) ) ) {
			// Hook point to add extra creation throttles and blocks
			return self::BLOCKED_BY_HOOK;
		}

		if ( $wgAccountCreationThrottle && $wgUser->isPingLimitable() ) {
			$key = wfMemcKey( 'acctcreate', 'ip', $ip );
			$value = $wgMemc->get( $key );
			if ( !$value ) {
				$wgMemc->set( $key, 0, 86400 );
			}
			if ( $value >= $wgAccountCreationThrottle ) {
				return self::THROTLLED;
			}
			$wgMemc->incr( $key );
		}

		if( !$wgAuth->addUser( $tempUser, $this->mPassword, $this->mEmail, $this->mRealName ) ) {
			return self::EXTR_DB_ERROR;
		}

		self::clearCreateaccountToken();

		$tempUser = $this->initUser( $tempUser, false );
		if( $tempUser == null ) {
			return self::INIT_FAILED;
		}

		$this->addNewAccount( $tempUser );
		return self::SUCCESS;
	}

	/**
	 * Actually add a user to the database.
	 * Give it a User object that has been initialised with a name.
	 *
	 * @param $tempUser User object.
	 * @param $autocreate boolean -- true if this is an autocreation via auth plugin
	 * @return User object.
	 * @private
	 */
	function initUser( $tempUser, $autocreate = false ) {
		global $wgAuth;

		$tempUser->addToDatabase();

		if ( $wgAuth->allowPasswordChange() ) {
			$tempUser->setPassword( $this->mPassword );
		}

		$tempUser->setEmail( $this->mEmail );
		$tempUser->setRealName( $this->mRealName );
		$tempUser->setToken();

		$wgAuth->initUser( $tempUser, $autocreate );

		if ( $this->mExtUser ) {
			$this->mExtUser->linkToLocal( $tempUser->getId() );
			$email = $this->mExtUser->getPref( 'emailaddress' );
			if ( $email && !$this->mEmail ) {
				$tempUser->setEmail( $email );
			}
		}

		$tempUser->setOption( 'rememberpassword', $this->mRemember ? 1 : 0 );
		$tempUser->saveSettings();

		# Update user count
		$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssUpdate->doUpdate();

		$this->addToSourceTracking( $tempUser );

		return $tempUser;
	}

	function processSignup() {
		global $wgUser, $wgOut, $wgEmailAuthentication;

		switch ( $this->addNewAccountInternal() ) {
			case self::SUCCESS:
				if( $wgEmailAuthentication ) {
					if( $this->mConfirmationMailStatus->isGood() ) {
						$wgOut->addWikiMsg( 'confirmemail_oncreate' );
					} else {
						$wgOut->addWikiText( $this->mConfirmationMailStatus->getWikiText( 'confirmemail_sendfailed' ) );
					}
				}

 				if( $this->mRunCookieRedirect ) {
	 				$this->cookieRedirectCheck( 'new' );
 				}

 				# Confirm that the account was created
 				if( $this->mRunCreationConfirmation ) {
	 				$self = SpecialPage::getTitleFor( 'Userlogin' );
	 				$wgOut->setPageTitle( wfMsgHtml( 'accountcreated' ) );
				 	$wgOut->addWikiMsg( 'accountcreatedtext', $tempUser->getName() );
				 	$wgOut->returnToMain( false, $self );
 				}

				$this->successfulCreation();
				break;

			case self::INVALID_DOMAIN:
				$this->mainSignupForm( wfMsg( 'wrongpassword' ) );
				break;

			case self::READ_ONLY_PAGE:
				$wgOut->readOnlyPage();
				break;

			case self::NO_COOKIES:
				$this->mainSignupForm( wfMsgExt( 'nocookiesfornew', array( 'parseinline' ) ) );
				break;

			case self::NEED_TOKEN:
				$this->mainSignupForm( wfMsg( 'sessionfailure' ) );
				break;

			case self::WRONG_TOKEN:
				$this->mainSignupForm( wfMsg( 'sessionfailure' ) );
				break;

			case self::INSUFFICIENT_PERMISSION:
				$wgOut->permissionRequired( 'createaccount' );
				break;

			case self::CREATE_BLOCKED:
				$this->userBlockedMessage( $wgUser->isBlockedFromCreateAccount() );
				break;

			case self::IP_BLOCKED:
				$this->mainSignupForm( wfMsg( 'sorbs_create_account_reason' ) . ' (' . htmlspecialchars( $ip ) . ')' );
				break;

			case self::NO_NAME:
				$this->mainSignupForm( wfMsg( 'noname' ) );
				break;

			case self::USER_EXISTS:
				$this->mainSignupForm( wfMsg( 'userexists' ) );
				break;

			case self::WRONG_RETYPE:
				$this->mainSignupForm( wfMsg( 'badretype' ) );
				break;

			case self::INVALID_PASS:
				if ( is_array( $valid ) ) {
					$message = array_shift( $valid );
					$params = $valid;
				} else {
					global $wgMinimalPasswordLength;
					$message = $valid;
					$params = array( $wgMinimalPasswordLength );
				}
				$this->mainSignupForm( wfMsgExt( $message, array( 'parsemag' ), $params ) );
				break;

			case self::NO_EMAIL:
				$this->mainSignupForm( wfMsg( 'noemailtitle' ) );
				break;

			case self::INVALID_EMAIL:
				$this->mainSignupForm( wfMsg( 'invalidemailaddress' ) );
				break;

			case self::BLOCKED_BY_HOOK:
				wfDebug( "LoginForm::addNewAccountInternal: a hook blocked creation\n" );
				$this->mainSignupForm( $abortError );
				break;

			case self::EXTR_DB_ERROR:
				$this->mainSignupForm( wfMsg( 'externaldberror' ) );
				break;

			case self::THROTLLED:
				global $wgAccountCreationThrottle;
				$this->mainSignupForm( wfMsgExt( 'acct_creation_throttle_hit', array( 'parseinline' ), $wgAccountCreationThrottle ) );
				break;

			case self::INIT_FAILED:
				$this->mainSignupForm( wfMsg( 'init_failed' ) );
				break;

			default:
				throw new MWException( 'Unhandled case value' );
		}
	}

	/**
	 * @param $tempUser User object
	 * @param $throttle Boolean
	 * @param $emailTitle String: message name of email title
	 * @param $emailText String: message name of email text
	 * @return Status object
	 * @private
	 */
	function mailPasswordInternal( $tempUser, $throttle = true, $emailTitle = 'passwordremindertitle', $emailText = 'passwordremindertext' ) {
		global $wgServer, $wgScript, $wgUser, $wgNewPasswordExpiry;

		if ( $tempUser->getEmail() == '' ) {
			return Status::newFatal( 'noemail', $tempUser->getName() );
		}
		$ip = wfGetIP();
		if( !$ip ) {
			return Status::newFatal( 'badipaddress' );
		}

		wfRunHooks( 'User::mailPasswordInternal', array( &$wgUser, &$ip, &$tempUser ) );

		$np = $tempUser->randomPassword();
		$tempUser->setNewpassword( $np, $throttle );
		$tempUser->saveSettings();
		$tempUserserLanguage = $tempUser->getOption( 'language' );
		$m = wfMsgExt( $emailText, array( 'parsemag', 'language' => $tempUserserLanguage ), $ip, $tempUser->getName(), $np,
				$wgServer . $wgScript, round( $wgNewPasswordExpiry / 86400 ) );
		$result = $tempUser->sendMail( wfMsgExt( $emailTitle, array( 'parsemag', 'language' => $tempUserserLanguage ) ), $m );

		return $result;
	}

	/**
	 * Run any hooks registered for logins, then display a message welcoming
	 * the user.
	 *
	 * @private
	 */
	function successfulCreation() {
		global $wgUser;
		# Run any hooks; display injected HTML
		$injected_html = '';
		$welcome_creation_msg = 'welcomecreation';

		wfRunHooks( 'UserLoginComplete', array( &$wgUser, &$injected_html ) );

		//let any extensions change what message is shown
		wfRunHooks( 'BeforeWelcomeCreation', array( &$welcome_creation_msg, &$injected_html ) );

		$this->displaySuccessfulCreation( $welcome_creation_msg, $injected_html );
	}

	/**
	 * Output a message that informs the user that they cannot create an account because
	 * there is a block on them or their IP which prevents account creation. Note that
	 * User::isBlockedFromCreateAccount(), which gets this block, ignores the 'hardblock'
	 * setting on blocks (bug 13611).
	 * @param $block Block the block causing this error
	 */
	function userBlockedMessage( Block $block ) {
		global $wgOut;

		# Let's be nice about this, it's likely that this feature will be used
		# for blocking large numbers of innocent people, e.g. range blocks on
		# schools. Don't blame it on the user. There's a small chance that it
		# really is the user's fault, i.e. the username is blocked and they
		# haven't bothered to log out before trying to create an account to
		# evade it, but we'll leave that to their guilty conscience to figure
		# out.

		$wgOut->setPageTitle( wfMsg( 'cantcreateaccounttitle' ) );

		$block_reason = $block->mReason;
		if ( strval( $block_reason ) === '' ) {
			$block_reason = wfMsg( 'blockednoreason' );
		}

		$wgOut->addWikiMsg(
			'cantcreateaccount-text',
			$block->getTarget(),
			$block_reason,
			$block->getByName()
		);

		$wgOut->returnToMain( false );
	}

	/**
	 * @private
	 */
	function mainSignupForm( $msg, $msgtype = 'error' ) {
		global $wgUser, $wgOut, $wgHiddenPrefs, $wgRequest;
		global $wgEnableEmail, $wgEnableUserEmail;
		global $wgLoginLanguageSelector;
		global $wgAuth, $wgEmailConfirmToEdit, $wgCookieExpiration;
		global $wgSecureLogin, $wgPasswordResetRoutes;

		$titleObj = SpecialPage::getTitleFor( 'Usersignup' );

		// Block signup here if in readonly. Keeps user from
		// going through the process (filling out data, etc)
		// and being informed later.
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		} elseif ( $wgUser->isBlockedFromCreateAccount() ) {
			$this->userBlockedMessage( $wgUser->isBlockedFromCreateAccount() );
			return;
		} elseif ( count( $permErrors = $titleObj->getUserPermissionsErrors( 'createaccount', $wgUser, true ) )>0 ) {
			$wgOut->showPermissionsErrorPage( $permErrors, 'createaccount' );
			return;
		}

		if ( $this->mUsername == '' ) {
			if ( $wgUser->isLoggedIn() ) {
				$this->mUsername = $wgUser->getName();
			} else {
				$this->mUsername = $wgRequest->getCookie( 'UserName' );
			}
		}

		$template = new UsercreateTemplate();
		$q = "action=submitlogin&type=signup&wpSourceAction=$this->mSourceAction&wpSourceNS=$this->mSourceNS&wpSourceArticle=$this->msourceArticle";
		$linkq = 'type=login';
		$linkmsg = 'gotaccount';

		if ( !empty( $this->mReturnTo ) ) {
			$returnto = '&returnto=' . wfUrlencode( $this->mReturnTo );
			if ( !empty( $this->mReturnToQuery ) ) {
				$returnto .= '&returntoquery=' .
					wfUrlencode( $this->mReturnToQuery );
			}
			$q .= $returnto;
			$linkq .= $returnto;
		}

		# Pass any language selection on to the mode switch link
		if( $wgLoginLanguageSelector && $this->mLanguage ) {
			$linkq .= '&uselang=' . $this->mLanguage;
		}

		$link = '<a href="' . htmlspecialchars ( $titleObj->getLocalURL( $linkq ) ) . '">';
		$link .= wfMsgHtml( $linkmsg . 'link' ); # Calling either 'gotaccountlink' or 'nologinlink'
		$link .= '</a>';

		# Don't show a "create account" link if the user can't
		if( $this->showCreateOrLoginLink( $wgUser ) ) {
			$template->set( 'link', wfMsgExt( $linkmsg, array( 'parseinline', 'replaceafter' ), $link ) );
		} else {
			$template->set( 'link', '' );
		}

		$resetLink = $this->mType == 'signup'
			? null
			: is_array( $wgPasswordResetRoutes ) && in_array( true, array_values( $wgPasswordResetRoutes ) );

		$template->set( 'header', '' );
		$template->set( 'name', $this->mUsername );
		$template->set( 'password', $this->mPassword );
		$template->set( 'retype', $this->mRetype );
		$template->set( 'email', $this->mEmail );
		$template->set( 'realname', $this->mRealName );
		$template->set( 'domain', $this->mDomain );
		$template->set( 'reason', $this->mReason );

		$template->set( 'action', $titleObj->getLocalURL( $q ) );
		$template->set( 'message', $msg );
		$template->set( 'messagetype', $msgtype );
		$template->set( 'createemail', $wgEnableEmail && $wgUser->isLoggedIn() );
		$template->set( 'userealname', !in_array( 'realname', $wgHiddenPrefs ) );
		$template->set( 'useemail', $wgEnableEmail );
		$template->set( 'emailrequired', $wgEmailConfirmToEdit );
		$template->set( 'emailothers', $wgEnableUserEmail );
		$template->set( 'canreset', $wgAuth->allowPasswordChange() );
		$template->set( 'resetlink', $resetLink );
		$template->set( 'canremember', ( $wgCookieExpiration > 0 ) );
		$template->set( 'usereason', $wgUser->isLoggedIn() );
		$template->set( 'remember', $wgUser->getOption( 'rememberpassword' ) || $this->mRemember );
		$template->set( 'cansecurelogin', ( $wgSecureLogin === true ) );
		$template->set( 'stickHTTPS', $this->mStickHTTPS );

		$template->set( 'wpSourceAction', $this->mSourceAction );
		$template->set( 'wpSourceNS', $this->mSourceNS );
		$template->set( 'wpSourceArticle', $this->msourceArticle );

		if ( !self::getCreateaccountToken() ) {
			self::setCreateaccountToken();
		}
		$template->set( 'token', self::getCreateaccountToken() );

		# Prepare language selection links as needed
		if( $wgLoginLanguageSelector ) {
			$template->set( 'languages', $this->makeLanguageSelector() );
			if( $this->mLanguage )
				$template->set( 'uselang', $this->mLanguage );
		}

		// Give authentication and captcha plugins a chance to modify the form
		$wgAuth->modifyUITemplate( $template, $this->mType );

		wfRunHooks( 'UserCreateForm', array( &$template ) );
		wfRunHooks( 'SignupForm' );

		// Changes the title depending on permissions for creating account
		if ( $wgUser->isAllowed( 'createaccount' ) ) {
			$wgOut->setPageTitle( wfMsg( 'userlogin' ) );
		} else {
			$wgOut->setPageTitle( wfMsg( 'userloginnocreate' ) );
		}

		$wgOut->disallowUserJs(); // just in case...
		$wgOut->addTemplate( $template );

	}

	/**
	 * @private
	 *
	 * @param $tempUser User
	 *
	 * @return Boolean
	 */
	function showCreateOrLoginLink( $tempUser ) {
		return $this->mType == 'signup' || $tempUser->isAllowed( 'createaccount' );
	}

	/**
	 * Check if a session cookie is present.
	 *
	 * This will not pick up a cookie set during _this_ request, but is meant
	 * to ensure that the client is returning the cookie which was set on a
	 * previous pass through the system.
	 *
	 * @private
	 */
	function hasSessionCookie() {
		global $wgDisableCookieCheck, $wgRequest;
		return $wgDisableCookieCheck ? true : $wgRequest->checkSessionCookie();
	}

	/**
	 * Get the createaccount token from the current session
	 */
	public static function getCreateaccountToken() {
		global $wgRequest;
		return $wgRequest->getSessionData( 'wsCreateaccountToken' );
	}

	/**
	 * Randomly generate a new createaccount token and attach it to the current session
	 */
	public static function setCreateaccountToken() {
		global $wgRequest;
		$wgRequest->setSessionData( 'wsCreateaccountToken', User::generateToken() );
	}

	/**
	 * Remove any createaccount token attached to the current session
	 */
	public static function clearCreateaccountToken() {
		global $wgRequest;
		$wgRequest->setSessionData( 'wsCreateaccountToken', null );
	}

	/**
	 * @private
	 */
	function cookieRedirectCheck( $type ) {
		global $wgOut;

		$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
		$query = array( 'wpCookieCheck' => $type );
		if ( $this->mReturnTo ) {
			$query['returnto'] = $this->mReturnTo;
		}
		$check = $titleObj->getFullURL( $query );

		return $wgOut->redirect( $check );
	}

	/**
	 * @private
	 */
	function onCookieRedirectCheck( $type ) {
		if ( !$this->hasSessionCookie() ) {
			if ( $type == 'new' ) {
				return $this->mainSignupForm( wfMsgExt( 'nocookiesnew', array( 'parseinline' ) ) );
			} elseif ( $type == 'login' ) {
				return $this->mainSignupForm( wfMsgExt( 'nocookieslogin', array( 'parseinline' ) ) );
			} else {
				# shouldn't happen
				return $this->mainSignupForm( wfMsg( 'error' ) );
			}
		} else {
			return $this->successfulLogin();
		}
	}

	/**
	 * Produce a bar of links which allow the user to select another language
	 * during login/registration but retain "returnto"
	 *
	 * @return string
	 */
	function makeLanguageSelector() {
		global $wgLang;

		$msg = wfMessage( 'loginlanguagelinks' )->inContentLanguage();
		if( !$msg->isBlank() ) {

			$langs = explode( "\n", $msg->text() );
			$links = array();
			foreach( $langs as $lang ) {
				$lang = trim( $lang, '* ' );
				$parts = explode( '|', $lang );
				if ( count( $parts ) >= 2 ) {
					$links[] = $this->makeLanguageSelectorLink( $parts[0], $parts[1] );
				}
			}
			return count( $links ) > 0 ? wfMsgHtml( 'loginlanguagelabel', $wgLang->pipeList( $links ) ) : '';
		} else {
			return '';
		}
	}

	/**
	 * Create a language selector link for a particular language
	 * Links back to this page preserving type and returnto
	 *
	 * @param $text Link text
	 * @param $lang Language code
	 */
	function makeLanguageSelectorLink( $text, $lang ) {
		global $wgUser;
		$self = SpecialPage::getTitleFor( 'Userlogin' );
		$attr = array( 'uselang' => $lang );
		if( $this->mType == 'signup' ) {
			$attr['type'] = 'signup';
		}
		if( $this->mReturnTo ) {
			$attr['returnto'] = $this->mReturnTo;
		}
		$skin = $wgUser->getSkin();
		return $skin->linkKnown(
			$self,
			htmlspecialchars( $text ),
			array(),
			$attr
		);
	}

	/**
	 * Display a "login successful" page.
	 */
	private function displaySuccessfulCreation( $msgname, $injected_html ) {
		global $wgOut, $wgUser;

		$wgOut->setPageTitle( wfMsg( 'loginsuccesstitle' ) );
		if( $msgname ){
			$wgOut->addWikiMsg( $msgname, $wgUser->getName() );
		}

		$wgOut->addHTML( $injected_html );

		if ( !empty( $this->mReturnTo ) ) {
			$wgOut->returnToMain( null, $this->mReturnTo, $this->mReturnToQuery );
		} else {
			$wgOut->returnToMain( null );
		}
	}

	/**
	 * @param $tempUser User
	 * @return bool
	 */
	private function addToSourceTracking( $tempUser ) {
		$sourcetracking_data = array(
			'userid' => $tempUser->getId(),
			'source_action' => $this->mSourceAction,
			'source_ns' => $this->mSourceNS,
			'source_article' => $this->msourceArticle
		);

		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert( 'sourcetracking', $sourcetracking_data );

		return true;
	}
}
