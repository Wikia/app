<?php
/**
 * SpecialOpenIDFinish.body.php -- Finish logging into an OpenID site
 * Copyright 2006,2007 Internet Brands (http://www.internetbrands.com/)
 * Copyright 2007,2008 Evan Prodromou <evan@prodromou.name>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@prodromou.name>
 * @addtogroup Extensions
 */

if (!defined('MEDIAWIKI'))
  exit(1);

require_once("Auth/OpenID/Consumer.php");
require_once("Auth/OpenID/SReg.php");
require_once("Auth/Yadis/XRI.php");

class SpecialOpenIDFinish extends SpecialOpenID {

	function SpecialOpenIDFinish() {
		SpecialPage::SpecialPage("OpenIDFinish", '', false);
	}

	function execute($par) {

		global $wgUser, $wgOut, $wgRequest;

		wfLoadExtensionMessages( 'OpenID' );

		$this->setHeaders();

		# Shouldn't work if you're already logged in.

		if ($wgUser->getID() != 0) {
			$this->alreadyLoggedIn();
			return;
		}

		$consumer = $this->getConsumer();

		switch ($par) {
		 case 'ChooseName':
			list($openid, $sreg) = $this->fetchValues();
			if (!isset($openid)) {
				wfDebug("OpenID: aborting in ChooseName because identity_url is missing\n");
				$this->clearValues();
				# No messing around, here
				$wgOut->showErrorPage('openiderror', 'openiderrortext');
				return;
			}

			if ($wgRequest->getCheck('wpCancel')) {
				$this->clearValues();
				$wgOut->showErrorPage('openidcancel', 'openidcanceltext');
				return;
			}

			$choice = $wgRequest->getText('wpNameChoice');
			$nameValue = $wgRequest->getText('wpNameValue');

			if ($choice == 'existing') {
				$user = $this->attachUser($openid, $sreg,
										  $wgRequest->getText('wpExistingName'),
										  $wgRequest->getText('wpExistingPassword'));
				
				if (!$user) {
					$this->chooseNameForm($openid, $sreg, 'wrongpassword');
					return;
				}
			} else {
				$name = $this->getUserName($openid, $sreg, $choice, $nameValue);

				if (!$name || !$this->userNameOK($name)) {
					wfDebug("OpenID: Name not OK: '$name'\n");
					$this->chooseNameForm($openid, $sreg);
					return;
				}
				
				$user = $this->createUser($openid, $sreg, $name);
			}

			if (!isset($user)) {
				wfDebug("OpenID: aborting in ChooseName because we could not create user object\n");
				$this->clearValues();
				$wgOut->showErrorPage('openiderror', 'openiderrortext');
				return;
			}

			$wgUser = $user;

			$this->clearValues();

			$this->finishLogin($response->identity_url);
			break;

		 default: # No parameter, returning from a server

			$response = $consumer->complete($this->scriptUrl('OpenIDFinish'));

			if (!isset($response)) {
				wfDebug("OpenID: aborting in auth because no response was recieved\n");
				$wgOut->showErrorPage('openiderror', 'openiderrortext');
				return;
			}

			switch ($response->status) {
			 case Auth_OpenID_CANCEL:
				// This means the authentication was cancelled.
				$wgOut->showErrorPage('openidcancel', 'openidcanceltext');
				break;
			 case Auth_OpenID_FAILURE:
				wfDebug("OpenID: error message '" . $response->message . "'\n");
				$wgOut->showErrorPage('openidfailure', 'openidfailuretext',
								  array(($response->message) ? $response->message : ''));
				break;
			 case Auth_OpenID_SUCCESS:
				// This means the authentication succeeded.
				$openid = $response->getDisplayIdentifier();
				$sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
				$sreg = $sreg_resp->contents();

				if (!isset($openid)) {
					wfDebug("OpenID: aborting in auth success because display identifier is missing\n");
					$wgOut->showErrorPage('openiderror', 'openiderrortext');
					return;
				}

				$user = $this->getUser($openid);

				if (isset($user)) {
					$this->updateUser($user, $sreg); # update from server
				} else {
					# For easy names
					$name = $this->createName($openid, $sreg);
					if ($name) {
						$user = $this->createUser($openid, $sreg, $name);
					} else {
					# For hard names
						$this->saveValues($openid, $sreg);
						$this->chooseNameForm($openid, $sreg);
						return;
					}
				}

				if (!isset($user)) {
					wfDebug("OpenID: aborting in auth success because we could not create user object\n");
					$wgOut->showErrorPage('openiderror', 'openiderrortext');
				} else {
					$wgUser = $user;
					$this->finishLogin($openid);
				}
			}
		}
	}

	function finishLogin($openid) {

		global $wgUser, $wgOut;

		$wgUser->SetupSession();
		$wgUser->SetCookies();

		# Run any hooks; ignore results

		wfRunHooks('UserLoginComplete', array(&$wgUser));

		# Set a cookie for later check-immediate use

		$this->loginSetCookie($openid);

		$wgOut->setPageTitle( wfMsg( 'openidsuccess' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addWikiText( wfMsg( 'openidsuccess', $wgUser->getName(), $openid ) );
		$wgOut->returnToMain(false, $this->returnTo());
	}

	function loginSetCookie($openid) {
		global $wgCookiePath, $wgCookieDomain, $wgCookieSecure, $wgCookiePrefix;
		global $wgOpenIDCookieExpiration;

		$exp = time() + $wgOpenIDCookieExpiration;

		setcookie($wgCookiePrefix.'OpenID', $openid, $exp, $wgCookiePath, $wgCookieDomain, $wgCookieSecure);
	}

	function chooseNameForm($openid, $sreg, $messagekey = NULL) {

		global $wgOut, $wgUser, $wgOpenIDOnly;
		
		$sk = $wgUser->getSkin();
		if ($messagekey) {
			$message = wfMsg($messagekey);
		} else if (array_key_exists('nickname', $sreg)) {
			$message = wfMsg('openidnotavailable', $sreg['nickname']);
		} else {
			$message = wfMsg('openidnotprovided');
		}
		$instructions = wfMsg('openidchooseinstructions');
		$wgOut->addHTML("<p>{$message}</p>" .
						"<p>{$instructions}</p>" .
						'<form action="' . $sk->makeSpecialUrl('OpenIDFinish/ChooseName') . '" method="POST">');
		$def = false;

		if (!$wgOpenIDOnly) {
			# Let them attach it to an existing user
			
			# Grab the UserName in the cookie if it exists
			
			global $wgCookiePrefix;
			$name = '';
			if ( isset( $_COOKIE["{$wgCookiePrefix}UserName"] ) ) {
				$name = trim( $_COOKIE["{$wgCookiePrefix}UserName"] );
			}
			
			$wgOut->addHTML("<input type='radio' name='wpNameChoice' id='wpNameChoiceExisting' value='existing' /> " .
							"<label for='wpNameChoiceExisting'>" . wfMsg("openidchooseexisting") . "</label> " .
							"<input type='text' name='wpExistingName' id='wpExistingName' size='16' value='{$name}'> " .
							"<label for='wpExistingPassword'>" . wfMsg("openidchoosepassword") . "</label> " .
							"<input type='password' name='wpExistingPassword' size='8' /><br />");
		}
		
		# These options won't exist if we can't get them.

		if (array_key_exists('fullname', $sreg) && $this->userNameOK($sreg['fullname'])) {
			$wgOut->addHTML("<input type='radio' name='wpNameChoice' id='wpNameChoiceFull' value='full' " .
							((!$def) ? "checked = 'checked'" : "") . " />" .
							"<label for='wpNameChoiceFull'>" . wfMsg("openidchoosefull", $sreg['fullname']) . "</label><br />");
			$def = true;
		}

		$idname = $this->toUserName($openid);

		if ($idname && $this->userNameOK($idname)) {
			$wgOut->addHTML("<input type='radio' name='wpNameChoice' id='wpNameChoiceUrl' value='url' " .
							((!$def) ? "checked = 'checked'" : "") . " />" .
							"<label for='wpNameChoiceUrl'>" . wfMsg("openidchooseurl", $idname) . "</label><br />");
			$def = true;
		}

		# These are always available

		$wgOut->addHTML("<input type='radio' name='wpNameChoice' id='wpNameChoiceAuto' value='auto' " .
							((!$def) ? "checked = 'checked'" : "") . " />" .
							"<label for='wpNameChoiceAuto'>" . wfMsg("openidchooseauto", $this->automaticName($sreg)) . "</label><br />");

		$def = true;

		$wgOut->addHTML("<input type='radio' name='wpNameChoice' id='wpNameChoiceManual' value='manual' " .
						" checked='off' />" .
						"<label for='wpNameChoiceManual'>" . wfMsg("openidchoosemanual") . "</label> " .
						"<input type='text' name='wpNameValue' id='wpNameValue' size='16' /><br />");

		$ok = wfMsg('login');
		$cancel = wfMsg('cancel');

		$wgOut->addHTML("<input type='submit' name='wpOK' value='{$ok}' /> <input type='submit' name='wpCancel' value='{$cancel}' />");
		$wgOut->addHTML("</form>");
	}

	function canLogin($openid_url) {

		global $wgOpenIDConsumerDenyByDefault, $wgOpenIDConsumerAllow, $wgOpenIDConsumerDeny;

		if ($this->isLocalUrl($openid_url)) {
			return false;
		}

		if ($wgOpenIDConsumerDenyByDefault) {
			$canLogin = false;
			foreach ($wgOpenIDConsumerAllow as $allow) {
				if (preg_match($allow, $openid_url)) {
					wfDebug("OpenID: $openid_url matched allow pattern $allow.\n");
					$canLogin = true;
					foreach ($wgOpenIDConsumerDeny as $deny) {
						if (preg_match($deny, $openid_url)) {
							wfDebug("OpenID: $openid_url matched deny pattern $deny.\n");
							$canLogin = false;
							break;
						}
					}
					break;
				}
			}
		} else {
			$canLogin = true;
			foreach ($wgOpenIDConsumerDeny as $deny) {
				if (preg_match($deny, $openid_url)) {
					wfDebug("OpenID: $openid_url matched deny pattern $deny.\n");
					$canLogin = false;
					foreach ($wgOpenIDConsumerAllow as $allow) {
						if (preg_match($allow, $openid_url)) {
							wfDebug("OpenID: $openid_url matched allow pattern $allow.\n");
							$canLogin = true;
							break;
						}
					}
					break;
				}
			}
		}
		return $canLogin;
	}

	function isLocalUrl($url) {

		global $wgServer, $wgArticlePath;

		$pattern = $wgServer . $wgArticlePath;
		$pattern = str_replace('$1', '(.*)', $pattern);
		$pattern = str_replace('?', '\?', $pattern);

		return preg_match('|^' . $pattern . '$|', $url);
	}

	# Find the user with the given openid, if any

	function getUser($openid) {
		global $wgSharedDB, $wgDBprefix;

		if (isset($wgSharedDB)) {
			$tableName = "`$wgSharedDB`.${wgDBprefix}user_openid";
		} else {
			$tableName = 'user_openid';
		}

		$dbr =& wfGetDB( DB_SLAVE );
		$id = $dbr->selectField($tableName, 'uoi_user',
								array('uoi_openid' => $openid));
		if ($id) {
			$name = User::whoIs($id);
			return User::newFromName($name);
		} else {
			return NULL;
		}
	}

	function updateUser($user, $sreg) {
		global $wgAllowRealName;

		# FIXME: only update if there's been a change

		if (array_key_exists('nickname', $sreg)) {
			$user->setOption('nickname', $sreg['nickname']);
		} else {
			$user->setOption('nickname', '');
		}

		if (array_key_exists('email', $sreg)) {
			$user->setEmail( $sreg['email'] );
		} else {
			$user->setEmail(NULL);
		}

		if (array_key_exists('fullname', $sreg) && $wgAllowRealName) {
			$user->setRealName($sreg['fullname']);
		} else {
			$user->setRealName(NULL);
		}

		if (array_key_exists('language', $sreg)) {
			# FIXME: check and make sure the language exists
			$user->setOption('language', $sreg['language']);
		} else {
			$user->setOption('language', NULL);
		}

		if (array_key_exists('timezone', $sreg)) {
			# FIXME: do something with it.
			# $offset = OpenIDTimezoneToTzoffset($sreg['timezone']);
			# $user->setOption('timecorrection', $offset);
		} else {
			# $user->setOption('timecorrection', NULL);
		}

		$user->saveSettings();
	}

	function createUser($openid, $sreg, $name) {

		global $wgAuth, $wgAllowRealName;

		$user = User::newFromName($name);

		if (!$user) {
			wfDebug("OpenID: Error adding new user.\n");
			return NULL;
		}
		
		$user->addToDatabase();

		if (!$user->getId()) {
			wfDebug("OpenID: Error adding new user.\n");
		} else {

			$this->insertUserUrl($user, $openid);

			if (array_key_exists('nickname', $sreg)) {
				$user->setOption('nickname', $sreg['nickname']);
			}
			if (array_key_exists('email', $sreg)) {
				$user->setEmail( $sreg['email'] );
			}
			if ($wgAllowRealName && array_key_exists('fullname', $sreg)) {
				$user->setRealName($sreg['fullname']);
			}
			if (array_key_exists('language', $sreg)) {
				# FIXME: check and make sure the language exists
				$user->setOption('language', $sreg['language']);
			}
			if (array_key_exists('timezone', $sreg)) {
				# FIXME: do something with it.
				# $offset = OpenIDTimezoneToTzoffset($sreg['timezone']);
				# $user->setOption('timecorrection', $offset);
			}
			$user->saveSettings();
			return $user;
		}
	}

	function createName($openid, $sreg) {

		if (array_key_exists('nickname', $sreg) && # try nickname
			$this->userNameOK($sreg['nickname']))
		{
			return $sreg['nickname'];
		}
	}

	function toUserName($openid) {
        if (Auth_Yadis_identifierScheme($openid) == 'XRI') {
			return $this->toUserNameXri($openid);
		} else {
			return $this->toUserNameUrl($openid);
		}
	}

	# We try to use an OpenID URL as a legal MediaWiki user name in this order
	# 1. Plain hostname, like http://evanp.myopenid.com/
	# 2. One element in path, like http://profile.typekey.com/EvanProdromou/
	#    or http://getopenid.com/evanprodromou

    function toUserNameUrl($openid) {
		static $bad = array('query', 'user', 'password', 'port', 'fragment');

	    $parts = parse_url($openid);

		# If any of these parts exist, this won't work

		foreach ($bad as $badpart) {
			if (array_key_exists($badpart, $parts)) {
				return NULL;
			}
		}

		# We just have host and/or path

		# If it's just a host...
		if (array_key_exists('host', $parts) &&
			(!array_key_exists('path', $parts) || strcmp($parts['path'], '/') == 0))
		{
			$hostparts = explode('.', $parts['host']);

			# Try to catch common idiom of nickname.service.tld

			if ((count($hostparts) > 2) &&
				(strlen($hostparts[count($hostparts) - 2]) > 3) && # try to skip .co.uk, .com.au
				(strcmp($hostparts[0], 'www') != 0))
			{
				return $hostparts[0];
			} else {
				# Do the whole hostname
				return $parts['host'];
			}
		} else {
			if (array_key_exists('path', $parts)) {
				# Strip starting, ending slashes
				$path = preg_replace('@/$@', '', $parts['path']);
				$path = preg_replace('@^/@', '', $path);
				if (strpos($path, '/') === false) {
					return $path;
				}
			}
		}

		return NULL;
	}

	function toUserNameXri($xri) {
		$base = $this->xriBase($xri);

		if (!$base) {
			return NULL;
		} else {
			# =evan.prodromou
			# or @gratis*evan.prodromou
			$parts = explode('*', substr($base, 1));
			return array_pop($parts);
		}
	}

	# Is this name OK to use as a user name?

	function userNameOK($name) {
		global $wgReservedUsernames;
		return (0 == User::idFromName($name) &&
				!in_array( $name, $wgReservedUsernames ));
	}

	# Get an auto-incremented name

	function firstAvailable($prefix) {
		for ($i = 2; ; $i++) { # FIXME: this is the DUMB WAY to do this
			$name = "$prefix$i";
			if ($this->userNameOK($name)) {
				return $name;
			}
		}
	}

	function alreadyLoggedIn() {

		global $wgUser, $wgOut;

		$wgOut->setPageTitle( wfMsg( 'openiderror' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addWikiText( wfMsg( 'openidalreadyloggedin', $wgUser->getName() ) );
		$wgOut->returnToMain(false, $this->returnTo() );
	}

	function getUserUrl($user) {
		$openid_url = null;

		if (isset($user) && $user->getId() != 0) {
			global $wgSharedDB, $wgDBprefix;
			if (isset($wgSharedDB)) {
				$tableName = "`${wgSharedDB}`.${wgDBprefix}user_openid";
			} else {
				$tableName = 'user_openid';
			}

			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->select(array($tableName),
								array('uoi_openid'),
								array('uoi_user' => $user->getId()),
								'SpecialOpenIDFinish::getUserUrl');

			# This should return 0 or 1 result, since user is unique
			# in the table.

			while ($res && $row = $dbr->fetchObject($res)) {
				$openid_url = $row->uoi_openid;
			}
			$dbr->freeResult($res);
		}
		return $openid_url;
	}

	function saveValues($openid, $sreg) {
		global $wgSessionStarted, $wgUser;

		if (!$wgSessionStarted) {
			$wgUser->SetupSession();
		}

		$_SESSION['openid_consumer_identity'] = $openid;
		$_SESSION['openid_consumer_sreg'] = $sreg;

		return true;
	}

	function clearValues() {
		unset($_SESSION['openid_consumer_identity']);
		unset($_SESSION['openid_consumer_sreg']);
		return true;
	}

	function fetchValues() {
		return array($_SESSION['openid_consumer_identity'], $_SESSION['openid_consumer_sreg']);
	}

	function returnTo() {
		return $_SESSION['openid_consumer_returnto'];
	}

	function setReturnTo($returnto) {
		$_SESSION['openid_consumer_returnto'] = $returnto;
	}

	function getUserName($openid, $sreg, $choice, $nameValue) {
		switch ($choice) {
		 case 'full':
			return ((array_key_exists('fullname', $sreg)) ? $sreg['fullname'] : null);
			break;
		 case 'url':
			return $this->toUserName($openid);
			break;
		 case 'auto':
			return $this->automaticName($sreg);
			break;
		 case 'manual':
			return $nameValue;
		 default:
			return null;
		}
	}

	function automaticName($sreg) {
		if (array_key_exists('nickname', $sreg) && # try auto-generated from nickname
			strlen($sreg['nickname']) > 0) {
			return $this->firstAvailable($sreg['nickname']);
		} else { # try auto-generated
			return $this->firstAvailable(wfMsg('openidusernameprefix'));
		}
	}
	
	function attachUser($openid, $sreg, $name, $password) {

		$user = User::newFromName($name);

		if (!$user) {
			return NULL;
		}
		
		if (!$user->checkPassword($password)) {
			return NULL;
		}
		
		$this->setUserUrl($user, $openid);
		$this->updateUser($user, $sreg);
		
		return $user;
	}
}
