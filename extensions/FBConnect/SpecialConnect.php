<?php
/*
 * Copyright © 2008-2010 Garrett Brown <http://www.mediawiki.org/wiki/User:Gbruin>
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
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 */


/*
 * Not a valid entry point, skip unless MEDIAWIKI is defined.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}


/**
 * Class SpecialConnect
 * 
 * This class represents the body class for the page Special:Connect.
 * 
 * Currently, this page has one valid subpage at Special:Connect/ChooseName.
 * Visiting the subpage will generate an error; it is only useful when POSTed to.
 */
class SpecialConnect extends SpecialPage {
	private $userNamePrefix;
	static private $availableUserUpdateOptions = array('fullname', 'nickname', 'email', 'language', 'timecorrection');
	
	/**
	 * Constructor.
	 */
	function __construct() {
		global $wgSpecialPageGroups;
		// Initiate SpecialPage's constructor
		parent::__construct( 'Connect' );
		// Add this special page to the "login" group of special pages
		$wgSpecialPageGroups['Connect'] = 'login';

		wfLoadExtensionMessages( 'FBConnect' );
		$userNamePrefix = wfMsg('fbconnect-usernameprefix');
	}
	
	/**
	 * Allows the prefix to be changed at runtime.  This is useful, for example,
	 * to generate a username based off of a facebook name.
	 */
	public function setUserNamePrefix( $prefix ){
		$this->userNamePrefix = $prefix;
	}
	
	/**
	 * Returns the list of user options that can be updated by facebook on each login.
	 */
	public function getAvailableUserUpdateOptions(){
		return self::$availableUserUpdateOptions;
	}

	/**
	 * Overrides getDescription() in SpecialPage. Looks in a different wiki message
	 * for this extension's description.
	 */
	function getDescription() {
		return wfMsg( 'fbconnect-title' );
	}
	
	/**
	 * Performs any necessary execution and outputs the resulting Special page.
	 */
	function execute( $par ) {
		global $wgUser, $wgRequest;

		// Check to see if the user is already logged in
		if ( $wgUser->getID() ) {
			$this->sendPage('alreadyLoggedIn');
			return;
		}

		// Connect to the Facebook API
		$fb = new FBConnectAPI();
		$fb_user = $fb->user();

		// Look at the subpage name to discover where we are in the login process
		switch ( $par ) {
		case 'ChooseName':
			$choice = $wgRequest->getText('wpNameChoice');
			if ($wgRequest->getCheck('wpCancel')) {
				$this->sendError('fbconnect-cancel', 'fbconnect-canceltext');
			}
			else switch ($choice) {
				// Check to see if the user opted to connect an existing account
				case 'existing':
					$this->attachUser($fb_user, $wgRequest->getText('wpExistingName'),
							$wgRequest->getText('wpExistingPassword'));
					break;
				// Check to see if the user selected another valid option
				case 'nick':
				case 'first':
				case 'full':
					// Get the username from Facebook (Note: not from the form)
					$username = FBConnectUser::getOptionFromInfo($choice . 'name', $fb->getUserInfo());
				case 'manual':
					if (!isset($username) || !$this->userNameOK($username)) {
						// Use manual name if no username is set, even if manual wasn't chosen
						$username = $wgRequest->getText('wpName2');
					}
					// If no valid username was found, something's not right; ask again
					if (!$this->userNameOK($username)) {
						$this->sendPage('chooseNameForm', 'fbconnect-invalidname');
					} else {
						$this->createUser($fb_user, $username);
					}
					break;
				case 'auto':
					// Create a user with a unique generated username
					$this->createUser($fb_user, $this->generateUserName());
					break;
				default:
					$this->sendError('fbconnect-invalid', 'fbconnect-invalidtext');
			}
			break;
		default:
			// Main entry point
			#if ( $wgRequest->getText( 'returnto' ) ) {
			#	$this->setReturnTo( $wgRequest->getText( 'returnto' ),
			#				$wgRequest->getVal( 'returntoquery' ) );
			#}
			if ($fb_user) {
				// If the user is connected, log them in
				$this->login($fb_user);
			} else {
				// If the user isn't Connected, then show a form with the Connect button
				$this->sendPage('connectForm');
			}
		}
	}

	/**
	 * Logs in the user by their Facebook ID. If the Facebook user doesn't have
	 * an account on the wiki, then they are presented with a form prompting
	 * them to choose a wiki username.
	 */
	protected function login($fb_id) {
		global $wgUser;

		// Check to see if the Connected user exists in the database
		if ($fb_id) {
			$user = FBConnectDB::getUser($fb_id);
		}

		// If the user doesn't exist yet locally, allow hooks to check to see if this is a clustered set up
		if ( ! (isset($user) && $user instanceof User ) ) {
			if(!wfRunHooks( 'SpecialConnect::login::notFoundLocally', array( &$this, &$user, $fb_id ) )){
				return;
			}
		}

		if ( isset($user) && $user instanceof User ) {
			$fbUser = new FBConnectUser($user);
			// Update user from facebook (see class FBConnectUser)
			$fbUser->updateFromFacebook();
			
			// Setup the session
			global $wgSessionStarted;
			if (!$wgSessionStarted) {
				wfSetupSession();
			}

			$user->setCookies();
			$wgUser = $user;

			// Similar to what's done in LoginForm::authenticateUserData().
			// Load $wgUser now. This is necessary because loading $wgUser (say by calling
			// getName()) calls the UserLoadFromSession hook, which potentially
			// creates the user in the local database.
			$sessionUser = User::newFromSession();
			$sessionUser->load();

			$this->sendPage('displaySuccessLogin');
		} else if ($fb_id) {
			$this->sendPage('chooseNameForm');
		} else {
			// TODO: send an error message saying only Connected users can log in
			// or ask them to Connect.
			$this->sendError('fbconnect-cancel', 'fbconnect-canceltext');
		}
	}

	protected function createUser($fb_id, $name) {
		global $wgAuth, $wgOut, $wgUser, $wgRequest, $wgMemc;
		wfProfileIn(__METHOD__);

		// Handle accidental reposts.
		if($wgUser->isLoggedIn()){
			$this->sendPage('displaySuccessLogin');
		} else {
			// Make sure we're not stealing an existing user account.
			if (!$name || !$this->userNameOK($name)) {
				// TODO: Provide an error message that explains that they need to pick a name or the name is taken.
				wfDebug("FBConnect: Name not OK: '$name'\n");
				$this->sendPage('chooseNameForm');
				return;
			}


			/// START OF TYPICAL VALIDATIONS AND RESTRICITONS ON ACCOUNT-CREATION. ///


			// Check the restrictions again to make sure that the user can create this account.
			$titleObj = SpecialPage::getTitleFor( 'Connect' );
			if ( wfReadOnly() ) {
				$wgOut->readOnlyPage();
				return;
			} elseif ( $wgUser->isBlockedFromCreateAccount() ) {
				wfDebug("FBConnect: Blocked user was attempting to create account via Facebook Connect.\n");
				$wgOut->showErrorPage('fbconnect-error', 'fbconnect-errortext');
				return;
			} elseif ( count( $permErrors = $titleObj->getUserPermissionsErrors( 'createaccount', $wgUser, true ) )>0 ) {
				$wgOut->showPermissionsErrorPage( $permErrors, 'createaccount' );
				return;
			}
			
			// If we are not allowing users to login locally, we should be checking
			// to see if the user is actually able to authenticate to the authenti-
			// cation server before they create an account (otherwise, they can
			// create a local account and login as any domain user). We only need
			// to check this for domains that aren't local.
			$mDomain = $wgRequest->getText( 'wpDomain' );
			if( 'local' != $mDomain && '' != $mDomain ) {
				if( !$wgAuth->canCreateAccounts() && ( !$wgAuth->userExists( $name ) ) ) {
					$wgOut->showErrorPage('fbconnect-error', 'wrongpassword');
					return false;
				}
			}

			// IP-blocking (and open proxy blocking) protection from SpecialUserLogin
			global $wgEnableSorbs, $wgProxyWhitelist;
			$ip = wfGetIP();
			if ( $wgEnableSorbs && !in_array( $ip, $wgProxyWhitelist ) &&
			  $wgUser->inSorbsBlacklist( $ip ) )
			{
				$wgOut->showErrorPage('fbconnect-error', 'sorbs_create_account_reason');
				return;
			}

			/**
			// Test to see if we are denied by $wgAuth or the user can't create an account
			if ( !$wgAuth->autoCreate() || !$wgAuth->userExists( $userName ) ||
										   !$wgAuth->authenticate( $userName )) {
				$result = false;
				return true;
			}
			/**/

			// Run a hook to let custom forms make sure that it is okay to proceed with processing the form.
			// This hook should only check preconditions and should not store values.  Values should be stored using the hook at the bottom of this function.
			// Can use 'this' to call sendPage('chooseNameForm', 'SOME-ERROR-MSG-CODE-HERE') if some of the preconditions are invalid.
			if(! wfRunHooks( 'SpecialConnect::createUser::validateForm', array( &$this ) )){
				return;
			}

			$user = User::newFromName($name);
			if (!$user) {
				wfDebug("FBConnect: Error adding new user.\n");
				$wgOut->showErrorPage('fbconnect-error', 'fbconnect-error-creating-user');
				return;
			}

			// Let extensions abort the account creation.  If you have extensions which are expecting a Real Name or Email, you may need to disable
			// them since these are not requirements of Facebook Connect (so users will not have them).
			// NOTE: Currently this is commented out because it seems that most wikis might have a handful of restrictions that won't be needed on
			// Facebook Connections.  For instance, requiring a CAPTCHA or age-verification, etc.  Having a Facebook account as a pre-requisitie removes the need for that.
			/*
			$abortError = '';
			if( !wfRunHooks( 'AbortNewAccount', array( $user, &$abortError ) ) ) {
				// Hook point to add extra creation throttles and blocks
				wfDebug( "SpecialConnect::createUser: a hook blocked creation\n" );
				$wgOut->showErrorPage('fbconnect-error', 'fbconnect-error-user-creation-hook-aborted', array($abortError));
				return false;
			}
			*/

			// Apply account-creation throttles
			global $wgAccountCreationThrottle;
			if ( $wgAccountCreationThrottle && $wgUser->isPingLimitable() ) {
				$key = wfMemcKey( 'acctcreate', 'ip', $ip );
				$value = $wgMemc->get( $key );
				if ( !$value ) {
					$wgMemc->set( $key, 0, 86400 );
				}
				if ( $value >= $wgAccountCreationThrottle ) {
					$this->throttleHit( $wgAccountCreationThrottle );
					return false;
				}
				$wgMemc->incr( $key );
			}


			/// END OF TYPICAL VALIDATIONS AND RESTRICITONS ON ACCOUNT-CREATION. ///


			// Create the account (locally on main cluster or via wgAuth on other clusters).
			$pass = $email = $realName = ""; // the real values will get filled in outside of the scope of this function.
			$pass = null;
			if( !$wgAuth->addUser( $user, $pass, $email, $realName ) ) {
				wfDebug("FBConnect: Error adding new user to database.\n");
				$wgOut->showErrorPage('fbconnect-error', 'fbconnect-errortext');
				return;
			}
			
			// Adds the user to the local database (regardless of whether wgAuth was used).
			$user = $this->initUser( $user, true );

			// Attach the user to their Facebook account in the database
			// This must be done up here so that the data is in the database before copy-to-local is done for sharded setups.
			FBConnectDB::addFacebookID($user, $fb_id);

			wfRunHooks( 'AddNewAccount', array( $user ) );
			
			// Mark that the user is a Facebook user
			$user->addGroup('fb-user');

			// Store which fields should be auto-updated from Facebook when the user logs in.
			$updateFormPrefix = "wpUpdateUserInfo";
			foreach (self::$availableUserUpdateOptions as $option) {
				if($wgRequest->getVal($updateFormPrefix.$option, '') != ""){
					$user->setOption("fbconnect-update-on-login-$option", 1);
				} else {
					$user->setOption("fbconnect-update-on-login-$option", 0);
				}
			}

			// Process the FBConnectPushEvent preference checkboxes if fbConnectPushEvents are enabled.
			global $fbEnablePushToFacebook;
			if($fbEnablePushToFacebook){
				global $fbPushEventClasses;
				if(!empty($fbPushEventClasses)){
					foreach($fbPushEventClasses as $pushEventClassName){
						$pushObj = new $pushEventClassName;
						$className = get_class();
						$prefName = $pushObj->getUserPreferenceName();

						$user->setOption($prefName, ($wgRequest->getCheck($prefName)?"1":"0"));
					}
				}
			}

			// Unfortunately, performs a second database lookup
			$fbUser = new FBConnectUser($user);
			// Update the user with settings from Facebook
			$fbUser->updateFromFacebook();
			
			// Log the user in.
			$user->setCookies();

			// Store the new user as the global user object
			$wgUser = $user;

			// Allow custom form processing to store values since this form submission was successful.
			// This hook should not fail on invalid input, instead check the input using the SpecialConnect::createUser::validateForm hook above.
			wfRunHooks( 'SpecialConnect::createUser::postProcessForm', array( &$this ) );
			
			// TODO: Which MediaWiki versions can we call this function in?
			$user->addNewUserLogEntryAutoCreate();
			#$user->addNewUserLogEntry();

			$this->sendPage('displaySuccessLogin');
		}

		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Actually add a user to the database.
	 * Give it a User object that has been initialised with a name.
	 *
	 * This is a custom version of similar code in SpecialUserLogin's LoginForm with differences
	 * due to the fact that this code doesn't require a password, etc.
	 *
	 * @param $u User object.
	 * @param $autocreate boolean -- true if this is an autocreation via auth plugin
	 * @return User object.
	 * @private
	 */
	function initUser( $u, $autocreate ) {
		global $wgAuth;

		$u->addToDatabase();

		// No passwords for FBConnect accounts.
		//if ( $wgAuth->allowPasswordChange() ) {
		//	$u->setPassword( $this->mPassword );
		//}

		//$u->setEmail( $this->mEmail ); // emails aren't required by FBConnect extension (some customizations such as Wikia require it on their own).
		//$u->setRealName( $this->mRealName ); // real name isn't required for FBConnect
		$u->setToken();

		$wgAuth->initUser( $u, $autocreate );
		$wgAuth->updateUser($u);

		//$u->setOption( 'rememberpassword', $this->mRemember ? 1 : 0 );
		$u->setOption('skinoverwrite', 1);
		$u->saveSettings();

		# Update user count
		$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssUpdate->doUpdate();

		return $u;
	}

	/**
	 * Attaches the Facebook ID to an existing wiki account. If the user does
	 * not exist, or the supplied password does not match, then an error page
	 * is sent. Otherwise, the accounts are matched in the database and the new
	 * user object is logged in.
	 */
	protected function attachUser($fb_user, $name, $password) {
		global $wgOut, $wgUser;
		wfProfileIn(__METHOD__);

		// The user must be logged into Facebook before choosing a wiki username
		if ( !$fb_user ) {
			wfDebug("FBConnect: aborting in attachUser(): no Facebook ID was reported.\n");
			$wgOut->showErrorPage( 'fbconnect-error', 'fbconnect-errortext' );
			return;
		}
		// Look up the user by their name
		$user = new FBConnectUser(User::newFromName($name));
		if (!$user || !$user->checkPassword($password)) {
			$this->sendPage('chooseNameForm', 'wrongpassword');
			return;
		}
		// Attach the user to their Facebook account in the database
		FBConnectDB::addFacebookID($user, $fb_user);
		// Update the user with settings from Facebook
		$user->updateFromFacebook();
		// Store the user in the global user object
		$wgUser = $user;
		$this->sendPage('displaySuccessLogin');
		
		wfProfileOut(__METHOD__);
	}

	/**
	 * Generates a unique username for a wiki account based on the prefix specified
	 * in the message 'fbconnect-usernameprefix'. The number appended is equal to
	 * the number of Facebook Connect to user ID associations in the user_fbconnect
	 * table, so quite a few numbers will be skipped. However, this approach is
	 * more scalable. For smaller wiki installations, uncomment the line $i = 1 to
	 * have consecutive usernames starting at 1.
	 */
	public function generateUserName() {
		// Because $i is incremented the first time through the while loop
		$i = FBConnectDB::countUsers();
		#$i = 1; // This is the DUMB WAY to do this
		while ($i < PHP_INT_MAX) {
			$name = $this->userNamePrefix.$i;
			if ($this->userNameOK($name)) {
				return $name;
			}
			++$i;
		}
		return $prefix;
	}

	/**
	 * Tests whether the name is OK to use as a user name.
	 */
	public function userNameOK ($name) {
		global $wgReservedUsernames;
		return ($name && (null == User::idFromName($name)) && !in_array($name, $wgReservedUsernames));
	}

	/**
	 * Displays a simple error page.
	 */
	protected function sendError($titleMsg, $textMsg) {
		global $wgOut;
		$wgOut->showErrorPage($titleMsg, $textMsg);
	}
	
	public function sendPage($function, $arg = NULL) {
		global $wgOut;
		// Setup the page for rendering
		wfLoadExtensionMessages( 'FBConnect' );
		$this->setHeaders();
		$wgOut->disallowUserJs();  # just in case...
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		// Call the specified function to continue generating the page
		if (is_null($arg)) {
			$this->$function();
		} else {
			$this->$function($arg);
		}
	}
	
	private function alreadyLoggedIn() {
		global $wgOut, $wgUser, $wgRequest, $wgSitename;
		$wgOut->setPageTitle(wfMsg('fbconnect-error'));
		$wgOut->addWikiMsg('fbconnect-alreadyloggedin', $wgUser->getName());
		$wgOut->addWikiMsg('fbconnect-click-to-connect-existing', $wgSitename);
		$wgOut->addHTML('<fb:login-button'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'></fb:login-button>');
		// Render the "Return to" text retrieved from the URL
		$wgOut->returnToMain(false, $wgRequest->getText('returnto'), $wgRequest->getVal('returntoquery'));
	}

	private function displaySuccessLogin() {
		global $wgOut, $wgRequest;
		$wgOut->setPageTitle(wfMsg('fbconnect-success'));
		$wgOut->addWikiMsg('fbconnect-successtext');
		// Run any hooks for UserLoginComplete
		$inject_html = '';
		wfRunHooks( 'UserLoginComplete', array( &$wgUser, &$inject_html ) );
		$wgOut->addHtml( $inject_html );
		// Render the "return to" text retrieved from the URL
		$wgOut->returnToMain(false, $wgRequest->getText('returnto'), $wgRequest->getVal('returntoquery'));
	}

	/**
	 * TODO: Add an option to disallow this extension to access your Facebook
	 * information. This option could simply point you to your Facebook privacy
	 * settings. This is necessary in case the user wants to perpetually browse
	 * the wiki anonymously, while still being logged in to Facebook.
	 *
	 * NOTE: The above might be done now that we have checkboxes for which options
	 * to update from fb. Haven't tested it though.
	 */
	private function chooseNameForm($messagekey = 'fbconnect-chooseinstructions') {
		// Permissions restrictions.
		global $wgUser, $wgOut;
		$titleObj = SpecialPage::getTitleFor( 'Connect' );
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		} elseif ( $wgUser->isBlockedFromCreateAccount() ) {
			$this->userBlockedMessage(); // TODO: FIXME: Is this valid? I think it was in the context of LoginForm before.
			return;
		} elseif ( count( $permErrors = $titleObj->getUserPermissionsErrors( 'createaccount', $wgUser, true ) )>0 ) {
			$wgOut->showPermissionsErrorPage( $permErrors, 'createaccount' );
			return;
		}

		// Allow other code to have a custom form here (so that this extension can be integrated with existing custom login screens).
		if( !wfRunHooks( 'SpecialConnect::chooseNameForm', array( &$this, &$messagekey ) ) ){
			return;
		}

		global $wgOut, $fbConnectOnly;
		// Connect to the Facebook API
		$fb = new FBConnectAPI();
		$fb_user = $fb->user();
		$userinfo = $fb->getUserInfo($fb_user);

		// Keep track of when the first option visible to the user is checked
		$checked = false;

		// Outputs the canonical name of the special page at the top of the page
		$this->outputHeader();
		// If a different $messagekey was passed (like 'wrongpassword'), use it instead
		$wgOut->addWikiMsg( $messagekey );
		// TODO: Format the html a little nicer
		$wgOut->addHTML('
		<form action="' . $this->getTitle('ChooseName')->getLocalUrl() . '" method="POST">
			<fieldset id="mw-fbconnect-choosename">
				<legend>' . wfMsg('fbconnect-chooselegend') . '</legend>
				<table>');
		// Let them attach to an existing user if $fbConnectOnly allows it
		if (!$fbConnectOnly) {
			// Grab the UserName from the cookie if it exists
			global $wgCookiePrefix;
			$name = isset($_COOKIE[$wgCookiePrefix . 'UserName']) ?
						trim($_COOKIE[$wgCookiePrefix . 'UserName']) : '';
			// Build an array of attributes to update
			$updateOptions = array();
			foreach (self::$availableUserUpdateOptions as $option) {
				// Translate the MW parameter into a FB parameter
				$value = FBConnectUser::getOptionFromInfo($option, $userinfo);
				// If no corresponding value was received from Facebook, then continue
				if (!$value) {
					continue;
				}
				// Build the list item for the update option
				$updateOptions[] = "<li><input name=\"wpUpdateUserInfo$option\" type=\"checkbox\" " .
					"value=\"1\" id=\"wpUpdateUserInfo$option\" /><label for=\"wpUpdateUserInfo$option\">" .
					wfMsgHtml("fbconnect-$option") . wfMsgExt('colon-separator', array('escapenoentities')) .
					" <i>$value</i></label></li>";
			}
			// Implode the update options into an unordered list
			$updateChoices = count($updateOptions) > 0 ? "<br />\n" . wfMsgHtml('fbconnect-updateuserinfo') .
				"\n<ul>\n" . implode("\n", $updateOptions) . "\n</ul>\n" : '';
			// Create the HTML for the "existing account" option
			$html = '<tr><td class="wm-label"><input name="wpNameChoice" type="radio" ' .
				'value="existing" id="wpNameChoiceExisting"/></td><td class="mw-input">' .
				'<label for="wnNameChoiceExisting">' . wfMsg('fbconnect-chooseexisting') . '<br/>' .
				wfMsgHtml('fbconnect-chooseusername') . '<input name="wpExistingName" size="16" value="' .
				$name . '" id="wpExistingName"/>' . wfMsgHtml('fbconnect-choosepassword') .
				'<input name="wpExistingPassword" ' . 'size="" value="" type="password"/>' . $updateChoices .
				'</td></tr>';
			$wgOut->addHTML($html);
		}
		
		// Add the options for nick name, first name and full name if we can get them
		// TODO: Wikify the usernames (i.e. Full name should have an _ )
		foreach (array('nick', 'first', 'full') as $option) {
			$nickname = FBConnectUser::getOptionFromInfo($option . 'name', $userinfo);
			if ($nickname && $this->userNameOK($nickname)) {
				$wgOut->addHTML('<tr><td class="mw-label"><input name="wpNameChoice" type="radio" value="' .
					$option . ($checked ? '' : '" checked="checked') . '" id="wpNameChoice' . $option .
					'"/></td><td class="mw-input"><label for="wpNameChoice' . $option . '">' .
					wfMsg('fbconnect-choose' . $option, $nickname) . '</label></td></tr>');
				// When the first radio is checked, this flag is set and subsequent options aren't checked
				$checked = true;
			}
		}

		// The options for auto and manual usernames are always available
		$wgOut->addHTML('<tr><td class="mw-label"><input name="wpNameChoice" type="radio" value="auto" ' .
			($checked ? '' : 'checked="checked" ') . 'id="wpNameChoiceAuto"/></td><td class="mw-input">' .
			'<label for="wpNameChoiceAuto">' . wfMsg('fbconnect-chooseauto', $this->generateUserName()) .
			'</label></td></tr><tr><td class="mw-label"><input name="wpNameChoice" type="radio" ' .
			'value="manual" id="wpNameChoiceManual"/></td><td class="mw-input"><label ' .
			'for="wpNameChoiceManual">' . wfMsg('fbconnect-choosemanual') . '</label>&nbsp;' .
			'<input name="wpName2" size="16" value="" id="wpName2"/></td></tr>' .
			// Finish with two options, "Log in" or "Cancel"
			'<tr><td></td><td class="mw-submit"><input type="submit" value="Log in" name="wpOK"/>' .
			'<input type="submit" value="Cancel" name="wpCancel"/></td></tr></table></fieldset></form>'
		);
	}

	/**
	 * Displays the main connect form.
	 */
	private function connectForm() {
		global $wgOut, $wgUser, $wgSitename;
		$fb = new FBConnectAPI();
		$fb_user = $fb->user();

		// Outputs the canonical name of the special page at the top of the page
		$this->outputHeader();

		// Render a humble Facebook Connect button
		$wgOut->addHTML('<h2>' . wfMsg( 'fbconnect' ) . '</h2>
			<div>'.wfMsgExt( 'fbconnect-intro', array('parse', 'content')) . '<br/>' . wfMsg( 'fbconnect-click-to-login', $wgSitename ) .'
			<fb:login-button size="large" background="black" length="long"'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'></fb:login-button>
			</div>'
		);
	}
	
	/**
	 * Creates a Login Form template object and propogates it with parameters.
	 *
	private function createLoginForm() {
		global $wgUser, $wgEnableEmail, $wgEmailConfirmToEdit,
		       $wgCookiePrefix, $wgCookieExpiration, $wgAuth;
		
		$template = new UserloginTemplate();
		
		// Pull the name from $wgUser or cookies
		if( $wgUser->isLoggedIn() )
			$name =  $wgUser->getName();
		else if( isset( $_COOKIE[$wgCookiePrefix . 'UserName'] ))
			$name =  $_COOKIE[$wgCookiePrefix . 'UserName'];
		else
			$name = null;
		// Alias some common URLs for $action and $link
		$loginTitle = self::getTitleFor( 'Userlogin' );
		$this_href = wfUrlencode( $this->getTitle() );
		// Action URL that gets posted to
		$action = $loginTitle->getLocalUrl('action=submitlogin&type=login&returnto=' . $this_href);
		// Don't show a "create account" link if the user is not allowed to create an account
		if ($wgUser->isAllowed( 'createaccount' )) {
			$link_href = htmlspecialchars($loginTitle->getLocalUrl('type=signup&returnto=' . $this_href));
			$link_text = wfMsgHtml( 'nologinlink' );
			$link = wfMsgWikiHtml( 'nologin', "<a href=\"$link_href\">$link_text</a>" );
		} else {
			$link = '';
		}
		
		// Set the appropriate options for this template
		$template->set( 'header', '' );
		$template->set( 'name', $name );
		$template->set( 'action', $action );
		$template->set( 'link', $link );
		$template->set( 'message', '' );
		$template->set( 'messagetype', 'none' );
		$template->set( 'useemail', $wgEnableEmail );
		$template->set( 'emailrequired', $wgEmailConfirmToEdit );
		$template->set( 'canreset', $wgAuth->allowPasswordChange() );
		$template->set( 'canremember', ( $wgCookieExpiration > 0 ) );
		$template->set( 'remember', $wgUser->getOption( 'rememberpassword' ) );
		// Look this setting up in SpecialUserLogin.php
		$template->set( 'usedomain', false );
		// Give authentication and captcha plugins a chance to modify the form
		$type = 'login';
		$wgAuth->modifyUITemplate( $template, $type );
		wfRunHooks( 'UserLoginForm', array( &$template ));
		
		
		// Spit out the form we just made
		return $template;
	}
	/**/
}
