<?php
/*
 * Copyright � 2008-2010 Garrett Brown <http://www.mediawiki.org/wiki/User:Gbruin>
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
	private $isNewUser = false;
	static private $fbOnLoginJs;
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
		
		if ( $wgRequest->getVal("action", "") == "disconnect_reclamation" ) {
			self::disconnectReclamationAction();
			return ;

		}
		 
		$this->mReturnTo = $wgRequest->getVal( 'returnto' );
		$this->mReturnToQuery = $wgRequest->getVal( 'returntoquery' );
			
		if( empty($this->mReturnToQuery) ) {
			$this->mReturnToQuery = parse_str($this->mReturnToQuery);
			if (!empty($this->mReturnToQuery['fbconnected'])) {
				unset($this->mReturnToQuery['fbconnected']);
			}
		}
		$this->mReturnToQuery = urlencode($this->mReturnToQuery); 
		
		$title = Title::newFromText($this->mReturnTo);
		if (!empty($title))
		{
			$this->mResolvedReturnTo = strtolower(SpecialPage::resolveAlias($title->getDBKey()));
			if(in_array($this->mResolvedReturnTo,array('userlogout','signup','connect')))
			{
				$titleObj = Title::newMainPage();
				$this->mReturnTo = $titleObj->getText( );
				$this->mReturnToQuery = '';
			}			
		}

		// Connect to the Facebook API
		$fb = new FBConnectAPI();
		$fb_user = $fb->user(); // fb id or 0 if none is found.
		
		// Setup the session
		global $wgSessionStarted;
		if (!$wgSessionStarted) {
			wfSetupSession();
		}
		
		// Look at the subpage name to discover where we are in the login process
		wfDebug("FBConnect: Executing Special:Connect with the parameter of \"$par\".\n");
		wfDebug("FBConnect: User is".($wgUser->isLoggedIn()?"":" NOT")." logged in.\n");
		
		// If the user is logged in to Wikia on an unconnected account, and trying to connect a
		// facebook id, but the FB-id is already connected to a DIFFERENT Wikia account... display an error message.
		global $wgUser;
		if($wgUser->isLoggedIn() && $fb_user){
			$foundUser = FBConnectDB::getUser( $fb_user );
			if($foundUser && ($foundUser->getId() != $wgUser->getId())){
				$this->sendPage('fbIdAlreadyConnected');
				return;
			}
		}

		switch ( $par ) {
		case 'ChooseName':
			$choice = $wgRequest->getText('wpNameChoice');
			if ($wgRequest->getCheck('wpCancel')) {
				$this->sendError('fbconnect-cancel', 'fbconnect-canceltext');
			}
			else switch ($choice) {
				// Check to see if the user opted to connect an existing account
				case 'existing':
					$this->attachUser($fb_user, $wgRequest->getText('wpExistingName'), $wgRequest->getText('wpExistingPassword'));
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
		case 'ConnectExisting':
			// If not logged in, slide down to the default
			if($wgUser->isLoggedIn()){
				self::connectExisting();
				break;
			}
		default:
			// Main entry point
			#if ( $wgRequest->getText( 'returnto' ) ) {
			#	$this->setReturnTo( $wgRequest->getText( 'returnto' ),
			#				$wgRequest->getVal( 'returntoquery' ) );
			#}
			
			if($wgUser->isLoggedIn()){
				if($fb_user){
					// If the user has previously connected, log them in.  If they have not, then complete the connection process.
					$fb_ids = FBConnectDB::getFacebookIDs($wgUser);
					if(count($fb_ids) == 0){
						self::connectExisting();
					} else {
						// Will display a message that they're already logged in and connected.
						$this->sendPage('alreadyLoggedIn');
					}
				} else {
					// If the user isn't Connected, then show a form with the Connect button (regardless of whether they are logged in or not).
					$this->sendPage('connectForm');
				}
			} else if ($fb_user) {
				// If the user is connected, log them in
				$this->login($fb_user);
			} else {
				// If the user isn't Connected, then show a form with the Connect button
				$this->sendPage('connectForm');
			}
		}
	}
	
	/**
	 * This is called when a user is logged into a Wikia account and has just gone through the Facebook Connect popups,
	 * but has not been connected inside the system.
	 *
	 * This function will connect them in the database, save default preferences and present them with "Congratulations"
	 * message and a link to modify their User Preferences.
	 *
	 * This is different from attachUser because that is made to synchronously test a login at the same time as creating
	 * the account via the ChooseName form.  This function, however, is designed for when the existing user is already logged in
	 * and wants to quickly connect their facebook account.  The main difference, therefore, is that this function usese default
	 * preferences while the other form should have already shown the preferences form to the user.
	 */
	public function connectExisting(){
		global $wgUser, $wgRequest;
		wfProfileIn(__METHOD__);

		$fb_ids = FBConnectDB::getFacebookIDs($wgUser);
		if(count($fb_ids) > 0){
			// Will display a message that they're already logged in and connected.
			$this->sendPage('alreadyLoggedIn');
		} else {
			// Store the facebook-id <=> mediawiki-id mapping.
			// TODO: FIXME: What sould we do if this fb_id is already connected to a DIFFERENT mediawiki account.
			$fb = new FBConnectAPI();
			$fb_id = $fb->user();

			FBConnectDB::addFacebookID($wgUser, $fb_id);

			// Save the default user preferences.
			global $fbEnablePushToFacebook;
			if(!empty($fbEnablePushToFacebook)){
				global $fbPushEventClasses;
				if(!empty($fbPushEventClasses)){
					$DEFAULT_ENABLE_ALL_PUSHES = true;
					foreach($fbPushEventClasses as $pushEventClassName){
						$pushObj = new $pushEventClassName;
						$className = get_class();
						$prefName = $pushObj->getUserPreferenceName();

						$wgUser->setOption($prefName, ($DEFAULT_ENABLE_ALL_PUSHES?"1":"0"));
					}
				}
			}
			$wgUser->setOption("fbFromExist", "1");
			$wgUser->saveSettings();

			wfRunHooks( 'SpecialConnect::userAttached', array( &$this ) );

			$this->sendPage('displaySuccessAttaching');
		}

		wfProfileOut(__METHOD__);
	} // end connectExisting

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
					$wgOut->showErrorPage(wfMsg( 'permissionserrors' ), wfMsgExt( 'acct_creation_throttle_hit', array( 'parseinline' ), $wgAccountCreationThrottle ) );
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

			// Save the prefeference for letting user select to never send anything to their newsfeed.
			$prefName = FBConnectPushEvent::$PREF_TO_DISABLE_ALL;
			$user->setOption($prefName, ($wgRequest->getCheck($prefName)?"1":"0"));

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
			
			$user->addNewUserLogEntryAutoCreate();

			$this->isNewUser = true;
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
	 *
	 * NOTE: This isn't used by Wikia and hasn't been tested with some of the new
	 * code. Does it handle setting push-preferences correctly?
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

		wfRunHooks( 'SpecialConnect::userAttached', array( &$this ) );

		$this->sendPage('displaySuccessAttaching');
		
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
	
	// NOTE: Actually for when you're both already logged in AND connected (consider renaming to alreadyLoggedInAndConnected()).
	private function alreadyLoggedIn() {
		global $wgOut, $wgUser, $wgRequest, $wgSitename;
		$wgOut->setPageTitle(wfMsg('fbconnect-alreadyloggedin-title'));
		$wgOut->addWikiMsg('fbconnect-alreadyloggedin', $wgUser->getName());
		
		// Note: it seems this only gets called when you're already connected, so these buttons aren't needed.
		//$wgOut->addWikiMsg('fbconnect-click-to-connect-existing', $wgSitename);
		//$wgOut->addHTML('<fb:login-button'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'></fb:login-button>');

		// Render the "Return to" text retrieved from the URL
		$wgOut->returnToMain(false, $this->mReturnTo, $this->mReturnToQuery);
	}
	
	/**
	 * This error-page is shown when the user is attempting to connect a Wikia account with a facebook id which is
	 * already connected to a different Wikia account.
	 */
	private function fbIdAlreadyConnected() {
		global $wgOut, $wgUser, $wgRequest, $wgSitename;
		$wgOut->setPageTitle(wfMsg('fbconnect-fbid-is-already-connected-title'));

		$wgOut->addWikiMsg('fbconnect-fbid-is-already-connected');

		// Find out the username that this facebook id is already connected to.
		$fb = new FBConnectAPI();
		$fb_user = $fb->user(); // fb id or 0 if none is found.
		if($fb_user){
			$foundUser = FBConnectDB::getUser( $fb_user );
			if($foundUser){
				$connectedToUser = $foundUser->getName();
				$wgOut->addWikiMsg('fbconnect-fbid-connected-to', $connectedToUser);
			}
		}

		// Render the "Return to" text retrieved from the URL
		$wgOut->returnToMain(false, $this->mReturnTo, $this->mReturnToQuery);
	}

	private function displaySuccessLogin() {
		global $wgOut, $wgUser, $wgRequest;
		$wgOut->setPageTitle(wfMsg('fbconnect-success'));
		$wgOut->addWikiMsg('fbconnect-successtext');
		// Run any hooks for UserLoginComplete
		$injected_html = '';
		wfRunHooks( 'UserLoginComplete', array( &$wgUser, &$injected_html ) );
	
		if( $injected_html !== '' ) {
			$wgOut->addHtml( $injected_html );
			// Render the "return to" text retrieved from the URL
			$wgOut->returnToMain(false, $this->mReturnTo, $this->mReturnToQuery);
		} else {
			$addParam = "";
			if($this->isNewUser) {
				$addParam = "&fbconnected=1";
			} 
			// Since there was no additional message for the user, we can just redirect them back to where they came from.
			$titleObj = Title::newFromText( $this->mReturnTo );
			if (  ( !$titleObj instanceof Title ) || ( $titleObj->isSpecial("Userlogout") ) || ( $titleObj->isSpecial("Signup") ) || ( $titleObj->isSpecial("Connect") )  ) {
				$titleObj = Title::newMainPage();
				$wgOut->redirect( $titleObj->getFullURL( "cb=".rand(1,10000).$addParam ) );
				return true;
			}
			$wgOut->redirect( $titleObj->getFullURL( $this->mReturnToQuery . "&cb=".rand(1,10000).$addParam ) );
		}
	}

	/**
	 * Success page for attaching fb account to a pre-existing MediaWiki account.
	 * Shows a link to preferences and a link back to where the user came from.
	 */
	private function displaySuccessAttaching() {
		global $wgOut, $wgUser, $wgRequest;
		wfProfileIn(__METHOD__);
		
		$wgOut->setPageTitle(wfMsg('fbconnect-success'));

		$prefsLink = SpecialPage::getTitleFor('Preferences')->getLinkUrl();
		$wgOut->addHTML(wfMsg('fbconnect-success-connecting-existing-account', $prefsLink));

		// Run any hooks for UserLoginComplete
		$inject_html = '';
		wfRunHooks( 'UserLoginComplete', array( &$wgUser, &$inject_html ) );
		$wgOut->addHtml( $inject_html );

		$titleObj = Title::newFromText( $this->mReturnTo );
		$wgOut->redirect( $titleObj->getFullURL( $this->mReturnToQuery . "&fbconnected=1&cb=".rand(1,10000) ) );
		
		wfProfileOut(__METHOD__);
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
			return false;
		} elseif ( $wgUser->isBlockedFromCreateAccount() ) {
			$this->userBlockedMessage(); // TODO: FIXME: Is this valid? I think it was in the context of LoginForm before.
			return false;
		} elseif ( count( $permErrors = $titleObj->getUserPermissionsErrors( 'createaccount', $wgUser, true ) )>0 ) {
			$wgOut->showPermissionsErrorPage( $permErrors, 'createaccount' );
			return false;
		}

		// Allow other code to have a custom form here (so that this extension can be integrated with existing custom login screens).
		if( !wfRunHooks( 'SpecialConnect::chooseNameForm', array( &$this, &$messagekey ) ) ){
			return false;
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

		$titleObj = Title::newFromText( $this->mReturnTo );
		if($titleObj){
			$wgOut->redirect( $titleObj->getFullURL( $this->mReturnToQuery . "&fbconnected=2&cb=".rand(1,10000) ) );
		} else {
			// Outputs the canonical name of the special page at the top of the page
			$this->outputHeader();

			// Render a humble Facebook Connect button
			$wgOut->addHTML('<div>'.wfMsgExt( 'fbconnect-intro', array('parse', 'content')) . '<br/>' . wfMsg( 'fbconnect-click-to-login', $wgSitename ) .'
				<fb:login-button size="large" background="black" length="long"'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'></fb:login-button>
				</div>'
			);
		}
	}

	/**
	 * Disconnect from facebook
	 */
	private function disconnectReclamationAction() {
		global $wgRequest, $wgOut, $wgUser;
		
		$wgOut->setArticleRelated( false );
		$wgOut->enableClientCache( false );
		$wgOut->mRedirect = '';
		$wgOut->mBodytext = '';
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		
		$fb = new FBConnectAPI();
		$fb_user_id = $wgRequest->getVal("u",0);
		$hash = $wgRequest->getVal("h","");
		$user_id = $fb->verifyAccountReclamation($fb_user_id, $hash);
		
		if (!($user_id === false)) {
			$result = FBConnect::coreDisconnectFromFB($user_id);
		}
		
		$title = Title::makeTitle( NS_SPECIAL  , "Signup"  );
	
		$html = Xml::openElement("a",array( "href" => $title->getFullUrl() ));
		$html .= $title->getPrefixedText();
		$html .= Xml::closeElement( "a" );
			
		
		if ( (!($user_id === false))  && ($result['status'] == "ok") ) {
			$wgOut->setPageTitle(  wfMsg('fbconnect-reclamation-title') );
			$wgOut->setHTMLTitle( wfMsg('fbconnect-reclamation-title') );
			$wgOut->addHTML( wfMsg('fbconnect-reclamation-body',array("$1" => $html) ));
			
		} else {
			$wgOut->setPageTitle(  wfMsg('fbconnect-reclamation-title-error') );
			$wgOut->setHTMLTitle( wfMsg('fbconnect-reclamation-title-error') );
			$wgOut->addHTML( wfMsg('fbconnect-reclamation-body-error',array("$1" => $html) ));
		}
		
		return true;
	}
	
	function checkCreateAccount() {
		global $wgUser;
		
		$response = new AjaxResponse();
		
		$fb = new FBConnectAPI();
		$fb_user = $fb->user();
		
		$error =  json_encode(array("status" => "error") );
		if (empty($fb_user)) {
			$response->addText($error);
			return $response;	
		}

		if( ((int) $wgUser->getId()) != 0){
			$response->addText($error);
			return $response;			
		} 
		
		if( FBConnectDB::getUser($fb_user) != null) {
			$response->addText($error);
			return $response;			
		}
		
		$titleObj = SpecialPage::getTitleFor( 'Connect' );		
		
		if ( wfReadOnly() ) {
			$response->addText($error);
			return $response;	
		}
		
		if ( $wgUser->isBlockedFromCreateAccount() ) {
			$response->addText($error);
			return $response;	
		}
		
		if ( count( $permErrors = $titleObj->getUserPermissionsErrors( 'createaccount', $wgUser, true ) )>0 ) {
			$response->addText($error);
			return $response;	
		}
		
		$response->addText( json_encode(array("status" => "ok") ));
		return $response;	
	}
	
	function ajaxModalChooseName() {
		global $wgRequest;
		wfLoadExtensionMessages('FBConnect');
		$response = new AjaxResponse();

		$specialConnect = new SpecialConnect();
		$form = new ChooseNameForm($wgRequest,'signup');
		$form->mainLoginForm( $specialConnect, '' );
		$tmpl = $form->getAjaxTemplate();
		$tmpl->set('isajax',true);
		ob_start();
		$tmpl->execute();
		$html = ob_get_clean();
			
		$response->addText( $html );
		return $response;	
	}
}
