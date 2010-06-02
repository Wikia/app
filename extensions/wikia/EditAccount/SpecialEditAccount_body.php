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

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named EditAccount.\n";
	exit( 1 );
}

class EditAccount extends SpecialPage {
	var $mUser = null;
	var $mStatus = null;
	var $mStatusMsg;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'EditAccount'/*class*/, 'editaccount'/*restriction*/ );
		wfLoadExtensionMessages( 'EditAccount' ); // Load internationalization messages
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest;

		// Set page title and other stuff
		$this->setHeaders();

		# If the user isn't permitted to access this special page, display an error
		if( !$wgUser->isAllowed( 'editaccount' ) ) {
			$wgOut->permissionRequired( 'editaccount' );
			return;
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$action = $wgRequest->getVal( 'wpAction' );
		$userName = $wgRequest->getVal( 'wpUserName' );
		$userName = ucfirst( $userName ); # user names begin with a capital letter

		// check if user name is an existing user
		if( User::isValidUserName( $userName ) ) {
			$this->mUser = User::newFromName( $userName );
			if( $this->mUser->idFromName( $userName ) === 0 ) {
				$this->mStatus = false;
				$this->mStatusMsg = wfMsg( 'editaccount-nouser', $userName );
				$action = '';
			}
		} else {
			$action = '';
		}

		switch( $action ) {
			case 'setemail':
				$newEmail = $wgRequest->getVal( 'wpNewEmail' );
				$this->mStatus = $this->setEmail( $newEmail );
				$template = $this->mStatus ? 'selectuser' : 'displayuser';
				break;
			case 'setpass':
				$newPass = $wgRequest->getVal( 'wpNewPass' );
				$this->mStatus = $this->setPassword( $newPass );
				$template = $this->mStatus ? 'selectuser' : 'displayuser';
				break;
			case 'setrealname':
				$newRealName = $wgRequest->getVal( 'wpNewRealName' );
				$this->mStatus = $this->setRealName( $newRealName );
				$template = $this->mStatus ? 'selectuser' : 'displayuser';				
				break;
			case 'closeaccount':
				$template = 'closeaccount';
				break;
			case 'closeaccountconfirm':
				$this->mStatus = $this->closeAccount();
				$template = $this->mStatus ? 'selectuser' : 'displayuser';
				break;
			case 'displayuser':
				$template = 'displayuser';
				break;
			default:
				$template = 'selectuser';
		}	

		$wgOut->setPageTitle( wfMsg( 'editaccount-title' ) );

		$oTmpl = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
		$oTmpl->set_Vars( array(
				'status'	=> $this->mStatus,
				'statusMsg' => $this->mStatusMsg,
				'user'	  => $userName,
				'userEmail' => is_object($this->mUser) ? $this->mUser->getEmail() : null,
				'userRealName' => is_object($this->mUser) ? $this->mUser->getRealName() : null,
				'userEncoded' => urlencode($userName),
				'userId'  => is_object($this->mUser) ? $this->mUser->getID() : null,
				'userReg' => is_object($this->mUser) ? date('r', strtotime($this->mUser->getRegistration())) : null,
			));
		// HTML output
		$wgOut->addHTML( $oTmpl->execute( $template ) );
	}

	/**
	 * Set a user's email
	 * @param $email Mixed: email address to set to the user
	 * @return Boolean: true on success, false on failure (i.e. if we were given an invalid email address)
	 */
	function setEmail( $email ) {
		$oldEmail = $this->mUser->getEmail();
		if( $this->mUser->isValidEmailAddr( $email ) || $email == '' ) {
			$this->mUser->setEmail( $email );
			if ( $email != '' ) {
				$this->mUser->confirmEmail();
			} else {
				$this->mUser->invalidateEmail();
			}
			$this->mUser->saveSettings();

			// Check if everything went through OK, just in case
			if( $this->mUser->getEmail() == $email ) {
				global $wgUser, $wgTitle;

				$log = new LogPage( 'editaccnt' );
				$log->addEntry( 'mailchange', $wgTitle, '', array( $this->mUser->getUserPage() ) );

				if( $email == '' ) {
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
	 * @return Boolean: true on success, false on failure
	 */
	function setPassword( $pass ) {
		if( $this->mUser->setPassword( $pass ) ) {
			global $wgUser, $wgTitle;

			// Save the new settings
			$this->mUser->saveSettings();

			// Log what was done
			$log = new LogPage( 'editaccnt' );
			$log->addEntry( 'passchange', $wgTitle, '', array( $this->mUser->getUserPage() ) );

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
	 * @return Boolean: true on success, false on failure
	 */
	function setRealName( $realname ) {
		$this->mUser->setRealName( $realname );
		$this->mUser->saveSettings();
		
		if( $this->mUser->getRealName() == $realname ) { // was saved ok? the setRealName function doesn't return bool...
			global $wgUser, $wgTitle;

			// Log what was done
			$log = new LogPage( 'editaccnt' );

			$log->addEntry( 'realnamechange', $wgTitle, '', array( $this->mUser->getUserPage() ) );

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
	 * @return Boolean: true on success, false on failure
	 */
	function closeAccount() {
		# Set flag for Special:Contributions
		# NOTE: requires FlagClosedAccounts.php to be included separately
		if( defined( 'CLOSED_ACCOUNT_FLAG' ) ) {
			$this->mUser->setRealName( CLOSED_ACCOUNT_FLAG );
		}

		// Remove e-mail address
		$this->mUser->setEmail( '' );
		$this->mUser->invalidateEmail();

		if ( $this->mUser->setPassword( wfGenerateToken() ) ) {
			global $wgUser, $wgTitle;

			// Save the new settings
			$this->mUser->saveSettings();

			// Log what was done
			$log = new LogPage( 'editaccnt' );
			$log->addEntry( 'closeaccnt', $wgTitle, '', array( $this->mUser->getUserPage() ) );

			// All clear!
			$this->mStatusMsg = wfMsg( 'editaccount-success-close', $this->mUser->mName );
			return true;	
		} else {
			// There were errors...inform the user about those
			$this->mStatusMsg = wfMsg( 'editaccount-error-close', $this->mUser->mName );
			return false;
		}
	}
}
