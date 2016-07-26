<?php
/**
 * EditAccount
 *
 * This extension is used by Wikia Staff to manage essential user account information
 * in the case of a lost password and/or invalid e-mail submitted during registration.
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-09-17
 * @copyright Copyright © 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named EditAccount.\n";
	exit( 1 );
}

use Wikia\DependencyInjection\Injector;
use Wikia\Service\Helios\HeliosClient;

class EditAccount extends SpecialPage {
	/** @var User */
	var $mUser = null;
	var $mStatus = null;
	var $mStatusMsg;
	var $mStatusMsg2 = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'EditAccount'/*class*/, 'editaccount'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {

		// Set page title and other stuff
		$this->setHeaders();
		$user = $this->getUser();
		$output = $this->getOutput();

		# If the user isn't permitted to access this special page, display an error
		if ( !$user->isAllowed( 'editaccount' ) ) {
			throw new PermissionsError( 'editaccount' );
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$output->readOnlyPage();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $user->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}

		$output->addModuleStyles( 'ext.editAccount' );

		$request = $this->getRequest();

		$action = $request->getVal( 'wpAction' );
		#get name to work on. subpage is supported, but form submit name trumps
		$userName = $request->getVal( 'wpUserName', $par );

		if( $userName !== null ) {
			#got a name, clean it up
			$userName = str_replace("_", " ", trim($userName));
			$userName = ucfirst( $userName ); # user names begin with a capital letter

			// check if user name is an existing user
			if ( User::isValidUserName( $userName ) ) {

				// BugId:CE-11
				// If the user account has just been enabled with Special:EditAccount
				// and the 'wikicities_c1' database (local for Community Central)
				// has lagged compared to the 'wikicities' database (the shared one)
				// the next action done with Special:EditAccount will fail and the
				// correct user data will be replaced by the temp user cache.
				// In other words: LOST.
				//
				// In order to prevent that we have to do the following two steps:
				//
				// 1) REMOVED: invalidate temp user cache
				//
				// 2) and copy the data from the shared to the local database
				$oUser = User::newFromName( $userName );
				wfRunHooks( 'UserNameLoadFromId', array( $userName, &$oUser, true ) );

				$id = 0;
				$this->mUser = $oUser;
				if ( !empty( $this->mUser ) ) {
					$id = $this->mUser->getId();
				}

				if( empty($action) ) {
					$action = 'displayuser';
				}

				if ( empty( $id ) ) {
					$this->mUser = null;
					$this->mStatus = false;
					$this->mStatusMsg = wfMsg( 'editaccount-nouser', $userName );
				}
			}
		}

		// FB:23860
		if ( !( $this->mUser instanceof User ) ) $action = '';

		// CSRF protection for EditAccount (CE-774)
		if ( ( $action !== '' && $action !== 'displayuser' && $action !== 'closeaccount' )
			&& ( !$request->wasPosted()
				|| !$user->matchEditToken( $request->getVal( 'wpToken' ) ) )
		) {
			$output->addHTML(
				Xml::element( 'p', [ 'class' => 'error' ], $this->msg( 'sessionfailure' )->text() )
			);
			return;
		}

		// Displays a log of email changes for the selected user
		if ($par && $par == "log") {
			$this->displayLogData();
			return;
		}

		$changeReason = $request->getVal( 'wpReason' );

		switch( $action ) {
			case 'setemail':
				$newEmail = $request->getVal( 'wpNewEmail' );
				$this->mStatus = $this->setEmail( $newEmail, $changeReason );
				$template = 'displayuser';
				break;
			case 'setpass':
				$newPass = $request->getVal( 'wpNewPass' );
				$this->mStatus = $this->setPassword( $newPass, $changeReason );
				$template = 'displayuser';
				break;
			case 'setrealname':
				$newRealName = $request->getVal( 'wpNewRealName' );
				$this->mStatus = $this->setRealName( $newRealName, $changeReason );
				$template = 'displayuser';
				break;
			case 'logout':
				$this->mStatus = $this->logOut();
				$template = 'displayuser';
				break;
			case 'closeaccount':
				$template = 'closeaccount';
				$this->mStatus = (bool) $this->mUser->getGlobalPreference( CloseMyAccountHelper::REQUEST_CLOSURE_PREF, 0 );
				$this->mStatusMsg = $this->mStatus ? wfMsg( 'editaccount-requested' ) : wfMsg( 'editaccount-not-requested' );
				break;
			case 'closeaccountconfirm':
				$keepEmail = !$request->getBool( 'clearemail', false );
				$this->mStatus = self::closeAccount( $this->mUser, $changeReason, $this->mStatusMsg, $this->mStatusMsg2, $keepEmail );
				$template = $this->mStatus ? 'selectuser' : 'displayuser';
				break;
			case 'clearunsub':
				$this->mStatus = $this->clearUnsubscribe();
				$template = 'displayuser';
				break;
			case 'cleardisable':
				$this->mStatus = $this->clearDisable();
				$template = 'displayuser';
				break;
			case 'clearclosurerequest':
				$this->mStatus = $this->clearClosureRequest();
				$template = 'displayuser';
				break;
			case 'toggleadopter':
				$this->mStatus = $this->toggleAdopterStatus();
				$template = 'displayuser';
				break;
			case 'displayuser':
				$template = 'displayuser';
				break;
			default:
				$template = 'selectuser';
		}

		$output->setPageTitle( $this->msg( 'editaccount-title' )->plain() );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$oTmpl->set_Vars( array(
				'status'	=> $this->mStatus,
				'statusMsg' => $this->mStatusMsg,
				'statusMsg2' => $this->mStatusMsg2,
				'user'	  => $userName,
				'userEmail' => null,
				'userRealName' => null,
				'userEncoded' => urlencode( $userName ),
				'user_hsc' => htmlspecialchars( $userName ),
				'userId'  => null,
				'userReg' => null,
				'isUnsub' => null,
				'isDisabled' => null,
				'isAdopter' => null,
				'returnURL' => $this->getTitle()->getFullURL(),
				'logLink' => Linker::linkKnown(
					SpecialPage::getTitleFor( 'Log', 'editaccnt' ),
					$this->msg( 'editaccount-log' )->escaped()
				),
				'userStatus' => null,
				'emailStatus' => null,
				'disabled' => null,
				'changeEmailRequested' => null,
				'editToken' => $user->getEditToken(),
			) );

		if( is_object( $this->mUser ) ) {
			$userStatus = wfMsg( 'editaccount-status-realuser' );
			$this->mUser->load();

			// get new email (unconfirmed)
			$optionNewEmail = $this->mUser->getNewEmail();
			$changeEmailRequested = ( empty($optionNewEmail) ) ? '' : wfMsg( 'editaccount-email-change-requested', $optionNewEmail ) ;

			// emailStatus is the status of the email in the "Set new email address" field
			$emailStatus = ( $this->mUser->isEmailConfirmed() ) ? wfMsg('editaccount-status-confirmed') : wfMsg('editaccount-status-unconfirmed') ;
			$oTmpl->set_Vars( array(
					'userEmail' => $this->mUser->getEmail(),
					'userRealName' => $this->mUser->getRealName(),
					'userId'  => $this->mUser->getID(),
					'userReg' => date( 'r', strtotime( $this->mUser->getRegistration() ) ),
					'isUnsub' => $this->mUser->getGlobalPreference('unsubscribed'),
					'isDisabled' => $this->mUser->getGlobalFlag('disabled'),
					'isClosureRequested' => $this->isClosureRequested(),
					'isAdopter' => $this->mUser->getGlobalFlag('AllowAdoption', 1 ),
					'userStatus' => $userStatus,
					'emailStatus' => $emailStatus,
					'changeEmailRequested' => $changeEmailRequested,
					'mailLogLink' => Linker::linkKnown(
						SpecialPage::getTitleFor( 'EditAccount', 'log' ),
						"Mail change log",	// TODO: i18n this
						array(),			// attribs
						array('user_id' => $this->mUser->getID())),
				) );
		}

		// HTML output
		$output->addHTML( $oTmpl->render( $template ) );
	}

	/**
	 * Set a user's email
	 * @param $email Mixed: email address to set to the user
	 * @param $changeReason String: reason for change
	 * @return Boolean: true on success, false on failure (i.e. if we were given an invalid email address)
	 */
	function setEmail( $email, $changeReason = '' ) {
		if ( Sanitizer::validateEmail( $email ) || $email == '' ) {
			$this->mUser->setEmail( $email );
			if ( $email != '' ) {
				UserLoginHelper::removeNotConfirmedFlag( $this->mUser );
				$this->mUser->confirmEmail();
				$this->mUser->clearNewEmail();
			} else {
				if ( $this->mUser->getGlobalFlag( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME ) ) {
					// User not confirmed on signup can't has empty email
					// @TODO introduce new message since usecase here is same as temp user empty email but it's not temp user anymore
					$this->mStatusMsg = wfMsg( 'editaccount-error-tempuser-email' );
					return false;
				}
				$this->mUser->invalidateEmail();
			}
			$this->mUser->saveSettings();

			// Check if everything went through OK, just in case
			if ( $this->mUser->getEmail() == $email ) {
				global $wgUser, $wgTitle;

				$log = new LogPage( 'editaccnt' );
				$log->addEntry( 'mailchange', $wgTitle, $changeReason, array( $this->mUser->getUserPage() ) );

				if ( $email == '' ) {
					$this->mStatusMsg = wfMsg( 'editaccount-success-email-blank', $this->mUser->mName );
				} else {
					$this->mStatusMsg = wfMsg( 'editaccount-success-email', $this->mUser->mName, $email );
				}
				return true;
			} else {
				$this->mStatusMsg = wfMsg( 'editaccount-error-email', $this->mUser->mName );
				return false;
			}
		} else {
			$this->mStatusMsg = wfMsg( 'editaccount-invalid-email', $email );
			return false;
		}
	}

	/**
	 * Set a user's password
	 * @param $pass Mixed: password to set to the user
	 * @param $changeReason String: reason for change
	 * @return Boolean: true on success, false on failure
	 */
	function setPassword( $pass, $changeReason = '' ) {
		try {
			// wrap in try/catch in case of PasswordException

			if ( $this->mUser->setPassword( $pass ) ) {
				global $wgUser, $wgTitle;

				// Save the new settings
				$this->mUser->saveSettings();

				// Log what was done
				$log = new LogPage( 'editaccnt' );
				$log->addEntry( 'passchange', $wgTitle, $changeReason, array( $this->mUser->getUserPage() ) );

				// And finally, inform the user that everything went as planned
				$this->mStatusMsg = wfMsg( 'editaccount-success-pass', $this->mUser->mName );
				return true;
			} else {
				// We have errors, let's inform the user about those
				$this->mStatusMsg = wfMsg( 'editaccount-error-pass', $this->mUser->mName );
				return false;
			}

		} catch ( PasswordError $err ) {

			// recreating logic from User->setPassword here, would rather not but best solution atm
			global $wgMinimalPasswordLength;
			$valid = $this->mUser->getPasswordValidity( $pass );
			if ( is_array( $valid ) ) {
				$message = array_shift( $valid );
				$params = $valid;
			} else {
				$message = $valid;
				$params = array( $wgMinimalPasswordLength );
			}
			$this->mStatusMsg = wfMsgExt( $message, array( 'parsemag' ), $params );
			return false;
		}
	}

	/**
	 * Set a user's real name
	 * @param $pass Mixed: real name to set to the user
	 * @param $changeReason String: reason for change
	 * @return Boolean: true on success, false on failure
	 */
	function setRealName( $realname, $changeReason = '' ) {
		$this->mUser->setRealName( $realname );
		$this->mUser->saveSettings();

		if ( $this->mUser->getRealName() == $realname ) { // was saved ok? the setRealName function doesn't return bool...
			global $wgUser, $wgTitle;

			// Log what was done
			$log = new LogPage( 'editaccnt' );

			$log->addEntry( 'realnamechange', $wgTitle, $changeReason, array( $this->mUser->getUserPage() ) );

			// And finally, inform the user that everything went as planned
			$this->mStatusMsg = wfMsg( 'editaccount-success-realname', $this->mUser->mName );
			return true;
		} else {
			// We have errors, let's inform the user about those
			$this->mStatusMsg = wfMsg( 'editaccount-error-realname', $this->mUser->mName );
			return false;
		}
	}

	/**
	 * Clears the user's password, sets an empty e-mail and marks as disabled
	 *
	 * @param string|User $user User account to close
	 * @param  string $changeReason Reason for change
	 * @param  string $mStatusMsg Main error message
	 * @param  string $mStatusMsg2 Secondary (non-critical) error message
	 * @param  boolean $keepEmail Optionally keep the email address in a user option
	 * @return bool true on success, false on failure
	 * @throws Exception
	 * @throws MWException
	 */
	public static function closeAccount( $user = '', $changeReason = '', &$mStatusMsg = '', &$mStatusMsg2 = '', $keepEmail = true ) {
		if ( empty( $user ) ) {
			throw new Exception( 'User object is invalid.' );
		}

		# Set flag for Special:Contributions
		# NOTE: requires FlagClosedAccounts.php to be included separately
		if ( defined( 'CLOSED_ACCOUNT_FLAG' ) ) {
			$user->setRealName( CLOSED_ACCOUNT_FLAG );
		} else {
			# magic value not found, so lets at least blank it
			$user->setRealName( '' );
		}

		// remove users avatar
		if ( class_exists( 'Masthead' ) ) {
			$avatar = Masthead::newFromUser( $user );
			if ( !$avatar->isDefault() ) {
				if( !$avatar->removeFile( false ) ) {
					# dont quit here, since the avatar is a non-critical part of closing, but flag for later
					$mStatusMsg2 = wfMessage( 'editaccount-remove-avatar-fail' )->plain();
				}
			}
		}

		// close account and invalidate cache + cluster data
		Wikia::invalidateUser( $user, true, $keepEmail, true );

		// if they are connected from facebook, disconnect them
		self::disconnectFromFacebook( $user );

		if ( $user->getEmail() == '' ) {
			$title = Title::newFromText( 'EditAccount', NS_SPECIAL );
			// Log what was done
			$log = new LogPage( 'editaccnt' );
			$log->addEntry( 'closeaccnt', $title, $changeReason, array( $user->getUserPage() ) );

			// All clear!
			$mStatusMsg = wfMessage( 'editaccount-success-close', $user->mName )->plain();

			/** @var HeliosClient $heliosClient */
			$heliosClient = Injector::getInjector()->get(HeliosClient::class);
			$heliosClient->forceLogout($user->getId());

			return true;

		} else {
			// There were errors...inform the user about those
			$mStatusMsg = wfMessage( 'editaccount-error-close', $user->mName )->plain();
			return false;
		}
	}

	/**
	 * Make sure a wikia user account is disconnected from their facebook account.
	 *
	 * @param  User $user The user account to disconnect
	 */
	public static function disconnectFromFacebook( User $user ) {
		if ( !empty( F::app()->wg->EnableFacebookClientExt ) ) {
			FacebookMapModel::deleteFromWikiaID( $user->getId() );
		}
	}

	/**
	 * Clears the magic unsub bit
	 *
	 * @return Boolean: true
	 */
	function clearUnsubscribe() {
		global $wgExternalAuthType;
		$this->mUser->setGlobalPreference( 'unsubscribed', null );
		$this->mUser->saveSettings();

		// delete the record from all the secondary clusters
		if ( $wgExternalAuthType == 'ExternalUser_Wikia' ) {
			$userId = $this->mUser->getId();
			ExternalUser_Wikia::removeFromSecondaryClusters( $userId );
		}

		$this->mStatusMsg = wfMsg( 'editaccount-success-unsub', $this->mUser->mName );

		return true;
	}

	/**
	 * Clears the magic disabled bit
	 *
	 * @return Boolean: true
	 */
	function clearDisable() {
		$this->mUser->setGlobalFlag( 'disabled', null );
		$this->mUser->setGlobalAttribute( 'disabled_date', null );
		$this->mUser->setRealName( '' );
		$this->mUser->saveSettings();

		$this->mStatusMsg = wfMsg( 'editaccount-success-disable', $this->mUser->mName );

		return true;
	}

	function toggleAdopterStatus() {
		$this->mUser->setGlobalFlag( 'AllowAdoption', (int) !$this->mUser->getGlobalFlag( 'AllowAdoption', 1 ) );
		$this->mUser->saveSettings();

		$this->mStatusMsg = wfMsg( 'editaccount-success-toggleadopt', $this->mUser->mName );

		return true;
	}

	private function isClosureRequested() {
		global $wgEnableCloseMyAccountExt;

		if ( !empty( $wgEnableCloseMyAccountExt ) ) {
			$closeAccountHelper = new CloseMyAccountHelper();
			return $closeAccountHelper->isScheduledForClosure( $this->mUser ) &&
				!$closeAccountHelper->isClosed( $this->mUser );
		}

		return false;
	}

	private function clearClosureRequest() {
		global $wgEnableCloseMyAccountExt;

		if ( !empty( $wgEnableCloseMyAccountExt ) ) {
			$closeAccountHelper = new CloseMyAccountHelper();
			$result = $closeAccountHelper->reactivateAccount( $this->mUser );

			if ( !$result ) {
				$this->mStatusMsg = $this->msg( 'editaccount-error-clearclosurerequest' )->text();
			} else {
				$this->mStatusMsg = $this->msg( 'editaccount-success-clearclosurerequest', $this->mUser->getName() )->text();
			}

			return $result;
		}

		return true;
	}

	/**
	 * Returns a random password which conforms to our password requirements and is
	 * not easily guessable.
	 */
	public static function generateRandomScrambledPassword() {
		// Password requirements need a captial letter, a digit, and a lowercase letter.
		// wfGenerateToken() returns a 32 char hex string, which will almost always satisfy the digit/letter but not always.
		// This suffix shouldn't reduce the entropy of the intentionally scrambled password.
		$REQUIRED_CHARS = "A1a";
		return (wfGenerateToken() . $REQUIRED_CHARS);
	}

	public function displayLogData() {
		global $wgExternalSharedDB, $wgOut, $wgRequest;

		$user_id = $wgRequest->getInt('user_id', 0);
		$user_name = "Not found";
		$rows = [];

		if ( $wgExternalSharedDB && $user_id ) {
			$user_name = User::newFromID($user_id);

			$dbr = wfGetDB ( DB_SLAVE, array(), $wgExternalSharedDB );
			$res = $dbr->select (
				'user_email_log',			// from
				["*"],						// cols
				['user_id' => $user_id],	// where
				__METHOD__,
				["ORDER BY" => "changed_at DESC"]	// options
				);
			while ( $row = $dbr->fetchObject( $res ) ) {
				$row->changed_by_name = User::newFromId($row->changed_by_id);
				$rows[] = $row;
			}
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );

		$oTmpl->set_Vars( [
			'userName' => $user_name,
			'returnURL' => $this->getTitle()->getFullURL(),
			'rows' => $rows
			]
		);

		$wgOut->addHTML( $oTmpl->render( "changelog" ) );
	}

	private function logOut() {
		$ok = false;
		try {
			$response = \Wikia\Helios\User::getHeliosClient()->forceLogout( $this->mUser->getId() );
			// successful logout returns 204 No Content and forceLogout() returns null
			$ok = is_null($response);
		} catch (\Wikia\Service\Helios\ClientException $e) {
			\Wikia\Logger\WikiaLogger::instance()->error( "Exception while logging out user", [
				'exception' => $e,
				'user_name' => $this->mUser->getName()
			] );
		}

		if ($ok) {
			$this->mStatusMsg = $this->msg( 'editaccount-success-logout', $this->mUser->getName() );
		} else {
			$this->mStatusMsg = $this->msg( 'editaccount-error-logout', $this->mUser->getName() );
		}

		return $ok;
	}
}
