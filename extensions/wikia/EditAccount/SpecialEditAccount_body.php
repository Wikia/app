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

class EditAccount extends SpecialPage {
	var $mUser = null;
	var $mStatus = null;
	var $mStatusMsg;
	var $mStatusMsg2 = null;
	var $mTempUser = null;

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
		global $wgOut, $wgUser, $wgRequest, $wgEnableUserLoginExt;

		// Set page title and other stuff
		$this->setHeaders();

		# If the user isn't permitted to access this special page, display an error
		if ( !$wgUser->isAllowed( 'editaccount' ) ) {
			throw new PermissionsError( 'editaccount' );
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}

		$action = $wgRequest->getVal( 'wpAction' );
		#get name to work on. subpage is supported, but form submit name trumps
		$userName = $wgRequest->getVal( 'wpUserName', $par );

		if( $userName !== null ) {
			#got a name, clean it up
			$userName = str_replace("_", " ", trim($userName));
			$userName = ucfirst( $userName ); # user names begin with a capital letter

			// check if user name is an existing user
			if ( User::isValidUserName( $userName ) ) {
				$this->mUser = User::newFromName( $userName );
				$id = $this->mUser->idFromName( $userName );

				if( empty($action) ) {
					$action = 'displayuser';
				}

				if ( empty( $id ) ) {
					if ( !empty($wgEnableUserLoginExt) ) {
						$this->mTempUser = TempUser::getTempUserFromName( $userName );
					}

					if ( $this->mTempUser ) {
						$id = $this->mTempUser->getId();
						$this->mUser = User::newFromId( $id );
					} else {
						$this->mStatus = false;
						$this->mStatusMsg = wfMsg( 'editaccount-nouser', $userName );
						$action = '';
					}
				}
			}
		}

		// FB:23860
		if ( !( $this->mUser instanceof User ) ) $action = '';

		$changeReason = $wgRequest->getVal( 'wpReason' );

		switch( $action ) {
			case 'setemail':
				$newEmail = $wgRequest->getVal( 'wpNewEmail' );
				$this->mStatus = $this->setEmail( $newEmail, $changeReason );
				$template = 'displayuser';
				break;
			case 'setpass':
				$newPass = $wgRequest->getVal( 'wpNewPass' );
				$this->mStatus = $this->setPassword( $newPass, $changeReason );
				$template = 'displayuser';
				break;
			case 'setrealname':
				$newRealName = $wgRequest->getVal( 'wpNewRealName' );
				$this->mStatus = $this->setRealName( $newRealName, $changeReason );
				$template = 'displayuser';
				break;
			case 'closeaccount':
				$template = 'closeaccount';
				$this->mStatus = (bool) $this->mUser->getOption( 'requested-closure', 0 );
				$this->mStatusMsg = $this->mStatus ? wfMsg( 'editaccount-requested' ) : wfMsg( 'editaccount-not-requested' );
				break;
			case 'closeaccountconfirm':
				$this->mStatus = $this->closeAccount( $changeReason );
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

		$wgOut->setPageTitle( wfMsg( 'editaccount-title' ) );

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
				'userStatus' => null,
				'emailStatus' => null,
				'disabled' => null,
				'changeEmailRequested' => null,
			) );

		if( is_object( $this->mUser ) ) {
			if ( $this->mTempUser ) {
				$this->mUser = $this->mTempUser->mapTempUserToUser( false );
				$userStatus = wfMsg('editaccount-status-tempuser');
				$oTmpl->set_Vars( array('disabled' => 'disabled="disabled"') );
			} else {
				$userStatus = wfMsg('editaccount-status-realuser');
			}
			$this->mUser->load();

			// get new email (unconfirmed)
			$optionNewEmail = $this->mUser->getOption( 'new_email' );
			$changeEmailRequested = ( empty($optionNewEmail) ) ? '' : wfMsg( 'editaccount-email-change-requested', $optionNewEmail ) ;

			// emailStatus is the status of the email in the "Set new email address" field
			$emailStatus = ( $this->mUser->isEmailConfirmed() ) ? wfMsg('editaccount-status-confirmed') : wfMsg('editaccount-status-unconfirmed') ;
			$oTmpl->set_Vars( array(
					'userEmail' => $this->mUser->getEmail(),
					'userRealName' => $this->mUser->getRealName(),
					'userId'  => $this->mUser->getID(),
					'userReg' => date( 'r', strtotime( $this->mUser->getRegistration() ) ),
					'isUnsub' => $this->mUser->getOption('unsubscribed'),
					'isDisabled' => $this->mUser->getOption('disabled'),
					'isAdopter' => $this->mUser->getOption('AllowAdoption', 1 ),
					'userStatus' => $userStatus,
					'emailStatus' => $emailStatus,
					'changeEmailRequested' => $changeEmailRequested,
				) );
		}

		// HTML output
		$wgOut->addHTML( $oTmpl->render( $template ) );
	}

	/**
	 * Set a user's email
	 * @param $email Mixed: email address to set to the user
	 * @param $changeReason String: reason for change
	 * @return Boolean: true on success, false on failure (i.e. if we were given an invalid email address)
	 */
	function setEmail( $email, $changeReason = '' ) {
		$oldEmail = $this->mUser->getEmail();
		if ( Sanitizer::validateEmail( $email ) || $email == '' ) {
			if ( $this->mTempUser ) {
				if ( $email == '' ) {
					$this->mStatusMsg = wfMsg( 'editaccount-error-tempuser-email' );
					return false;
				} else {
					$this->mTempUser->setEmail( $email );
					$this->mUser = $this->mTempUser->activateUser( $this->mUser );

					// reset temp user after activating the user
					$this->mTempUser = null;
				}
			} else {
				$this->mUser->setEmail( $email );
				if ( $email != '' ) {
					$this->mUser->confirmEmail();
					$this->mUser->setOption( 'new_email', null );
				} else {
					$this->mUser->invalidateEmail();
				}
				$this->mUser->saveSettings();
			}

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
		if ( $this->mUser->setPassword( $pass ) ) {
			global $wgUser, $wgTitle;

			// Save the new settings
			if ( $this->mTempUser ) {
				$this->mTempUser->setPassword( $this->mUser->mPassword );
				$this->mTempUser->updateData();
				$this->mTempUser->saveSettingsTempUserToUser( $this->mUser );
				$this->mUser->mName = $this->mTempUser->getName();
			} else {
				$this->mUser->saveSettings();
			}

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
	 * Scrambles the user's password, sets an empty e-mail and marks as disabled
	 *
	 * @param $changeReason String: reason for change
	 * @return Boolean: true on success, false on failure
	 */
	function closeAccount( $changeReason = '' ) {
		# Set flag for Special:Contributions
		# NOTE: requires FlagClosedAccounts.php to be included separately
		if ( defined( 'CLOSED_ACCOUNT_FLAG' ) ) {
			$this->mUser->setRealName( CLOSED_ACCOUNT_FLAG );
		} else {
			# magic value not found, so lets at least blank it
			$this->mUser->setRealName( '' );
		}

		// remove users avatar
		if ( class_exists( 'Masthead' ) ) {
			$avatar = Masthead::newFromUser( $this->mUser );
			if ( !$avatar->isDefault() ) {
				if( !$avatar->removeFile( false ) ) {
					# dont quit here, since the avatar is a non-critical part of closing, but flag for later
					$this->mStatusMsg2 = wfMsgExt( 'editaccount-remove-avatar-fail' );
				}
			}
		}

		// Remove e-mail address and passwor
		$this->mUser->setEmail( '' );
		$this->mUser->setPassword( $newpass = $this->generateRandomScrambledPassword() );
		// Save the new settings
		$this->mUser->saveSettings();

		$id = $this->mUser->getId();

		// Reload user
		$this->mUser = User::newFromId( $id );

		if ( $this->mUser->getEmail() == ''  ) {
			global $wgUser, $wgTitle;
			// Mark as disabled in a more real way, that doesnt depend on the real_name text
			$this->mUser->setOption( 'disabled', 1 );
			// BugId:18085 - setting a new token causes the user to be logged out.
			$this->mUser->setToken( md5( microtime() . mt_rand( 0, 0x7fffffff ) ) );
			// Need to save these additional changes
			$this->mUser->saveSettings();


			// Log what was done
			$log = new LogPage( 'editaccnt' );
			$log->addEntry( 'closeaccnt', $wgTitle, $changeReason, array( $this->mUser->getUserPage() ) );

			// All clear!
			$this->mStatusMsg = wfMsg( 'editaccount-success-close', $this->mUser->mName );
			return true;
		} else {
			// There were errors...inform the user about those
			$this->mStatusMsg = wfMsg( 'editaccount-error-close', $this->mUser->mName );
			return false;
		}
	}

	/**
	 * Clears the magic unsub bit
	 *
	 * @return Boolean: true
	 */
	function clearUnsubscribe() {
		$this->mUser->setOption( 'unsubscribed', null );
		$this->mUser->saveSettings();

		$this->mStatusMsg = wfMsg( 'editaccount-success-unsub', $this->mUser->mName );

		return true;
	}

	/**
	 * Clears the magic disabled bit
	 *
	 * @return Boolean: true
	 */
	function clearDisable() {
		$this->mUser->setOption( 'disabled', null );
		$this->mUser->saveSettings();

		$this->mStatusMsg = wfMsg( 'editaccount-success-disable', $this->mUser->mName );

		return true;
	}

	function toggleAdopterStatus() {
		$this->mUser->setOption( 'AllowAdoption', (int) !$this->mUser->getOption( 'AllowAdoption', 1 ) );
		$this->mUser->saveSettings();

		$this->mStatusMsg = wfMsg( 'editaccount-success-toggleadopt', $this->mUser->mName );

		return true;
	}

	/**
	 * Returns a random password which conforms to our password requirements and is
	 * not easily guessable.
	 */
	function generateRandomScrambledPassword() {
		// Password requirements need a captial letter, a digit, and a lowercase letter.
		// wfGenerateToken() returns a 32 char hex string, which will almost always satisfy the digit/letter but not always.
		// This suffix shouldn't reduce the entropy of the intentionally scrambled password.
		$REQUIRED_CHARS = "A1a";
		return (wfGenerateToken() . $REQUIRED_CHARS);
	}
}
