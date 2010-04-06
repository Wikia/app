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
	/**
	 * Constructor.
	 */
	function __construct() {
		global $wgSpecialPageGroups;
		// Initiate SpecialPage's constructor
		parent::__construct( 'Connect' );
		// Add this special page to the "login" group of special pages
		$wgSpecialPageGroups['Connect'] = 'login';
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
						$username = $wgRequest->getText('wpNameValue');
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
		global $wgAuth, $wgOut, $wgUser;
		/*
		if (!$name || !$this->userNameOK($name)) {
			wfDebug("FBConnect: Name not OK: '$name'\n");
			$this->sendPage('chooseNameForm');
			break;
		}
		/**
		// Test to see if we are denied by $wgAuth or the user can't create an account
		if ( !$wgAuth->autoCreate() || !$wgAuth->userExists( $userName ) ||
		                               !$wgAuth->authenticate( $userName )) {
			$result = false;
			return true;
		}
		/**/
		
		$user = User::newFromName($name);
		if (!$user) {
			wfDebug("FBConnecr: Error adding new user.\n");
			$wgOut->showErrorPage('fbconnect-error', 'fbconnect-errortext');
			return;
		}
		$user->addToDatabase();
		if (!$user->getId()) {
			wfDebug( "FBConnect: Error adding new user.\n" );
			$wgOut->showErrorPage('fbconnect-error', 'fbconnect-errortext');
			return;
		}
		
		// TODO: Which MediaWiki versions can we call this function in?
		$user->addNewUserLogEntryAutoCreate();
		#$user->addNewUserLogEntry();
		
		// Mark that the user is a Facebook user
		$user->addGroup('fb-user');
		
		// By default, update all info from Facebook on login
		foreach (array('nickname', 'fullname', 'language',
		               'timecorrection', 'email') as $option) {
			$user->setOption("fbconnect-update-on-login-$option", 1);
		}
		
		// Give $wgAuth a chance to deal with the user object
		$wgAuth->initUser($user, true);
		$wgAuth->updateUser($user);
		
		// Update site statistics
		$ssUpdate = new SiteStatsUpdate(0, 0, 0, 0, 1);
		$ssUpdate->doUpdate();
		
		// Attach the user to their Facebook account in the database
		FBConnectDB::addFacebookID($user, $fb_id);
		
		// Unfortunately, performs a second database lookup
		$fbUser = new FBConnectUser($user);
		// Update the user with settings from Facebook
		$fbUser->updateFromFacebook();
		
		// Store the new user as the global user object
		$wgUser = $user;
		$this->sendPage('displaySuccessLogin');
	}
	
	/**
	 * Attaches the Facebook ID to an existing wiki account. If the user does
	 * not exist, or the supplied password does not match, then an error page
	 * is sent. Otherwise, the accounts are matched in the database and the new
	 * user object is logged in.
	 */
	protected function attachUser($fb_user, $name, $password) {
		global $wgOut, $wgUser;
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
	}
	
	/**
	 * Generates a unique username for a wiki account based on the prefix specified
	 * in the message 'fbconnect-usernameprefix'. The number appended is equal to
	 * the number of Facebook Connect to user ID associations in the user_fbconnect
	 * table, so quite a few numbers will be skipped. However, this approach is
	 * more scalable. For smaller wiki installations, uncomment the line $i = 1 to
	 * have consecutive usernames starting at 1.
	 */
	protected function generateUserName() {
		$prefix = wfMsg('fbconnect-usernameprefix');
		// Because $i is incremented the first time through the while loop
		$i = FBConnectDB::countUsers();
		#$i = 1; // This is the DUMB WAY to do this
		while ($i < PHP_INT_MAX) {
			$name = "$prefix$i";
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
	protected function userNameOK ($name) {
		global $wgReservedUsernames;
		return ($name && 0 == User::idFromName($name) && !in_array($name, $wgReservedUsernames));
	}
	
	/**
	 * Displays a simple error page.
	 */
	protected function sendError($titleMsg, $textMsg) {
		global $wgOut;
		$wgOut->showErrorPage($titleMsg, $textMsg);
	}
	
	protected function sendPage($function, $arg = NULL) {
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
		global $wgOut, $wgUser, $wgRequest;
		$wgOut->setPageTitle(wfMsg('fbconnect-error'));
		$wgOut->addWikiMsg('fbconnect-alreadyloggedin', $wgUser->getName());
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
	 */
	private function chooseNameForm($messagekey = 'fbconnect-chooseinstructions') {
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
			$checkUpdateOptions = array('fullname', 'nickname', 'email', 'language', 'timecorrection');
			foreach ($checkUpdateOptions as $option) {
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
				"\n<ul>\n" . implode("\n", $updateOptions) . "\n<ul>\n" : '';
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
			'<input name="wpNameValue" size="16" value="" id="wpNameValue"/></td></tr>' .
			// Finish with two options, "Log in" or "Cancel"
			'<tr><td></td><td class="mw-submit"><input type="submit" value="Log in" name="wpOK"/>' .
			'<input type="submit" value="Cancel" name="wpCancel"/></td></tr></table></fieldset></form>'
		);
	}
	
	/**
	 * Displays the main connect form.
	 */
	private function connectForm() {
		global $wgOut, $wgUser;
		$fb = new FBConnectAPI();
		$fb_user = $fb->user();
		
		// Outputs the canonical name of the special page at the top of the page
		$this->outputHeader();
		
		// Render a humble Facebook Connect button
		$wgOut->addHTML('<h2>' . wfMsg( 'fbconnect' ) . '</h2>
			<div>'.wfMsg( 'fbconnect-intro') . '<br/>' . wfMsg( 'fbconnect-click-to-login') ,
			<fb:login-button size="large" background="black" length="long"></fb:login-button>
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
