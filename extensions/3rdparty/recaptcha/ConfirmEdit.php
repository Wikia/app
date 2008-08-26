<?php

/**
 * Experimental captcha plugin framework.
 * Not intended as a real production captcha system; derived classes
 * can extend the base to produce their fancy images in place of the
 * text-based test output here.
 *
 * Copyright (C) 2005, 2006 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @addtogroup Extensions
 */

if ( defined( 'MEDIAWIKI' ) ) {

global $wgExtensionFunctions, $wgGroupPermissions;

$wgExtensionFunctions[] = 'ceSetup';
$wgExtensionCredits['other'][] = array(
	'name' => 'ConfirmEdit',
	'author' => 'Brion Vibber',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ConfirmEdit',
	'description' => 'Simple captcha implementation',
);

# Internationalisation file
require_once( 'ConfirmEdit.i18n.php' );

/**
 * The 'skipcaptcha' permission key can be given out to
 * let known-good users perform triggering actions without
 * having to go through the captcha.
 *
 * By default, sysops and registered bot accounts will be
 * able to skip, while others have to go through it.
 */
$wgGroupPermissions['*'            ]['skipcaptcha'] = false;
$wgGroupPermissions['user'         ]['skipcaptcha'] = false;
$wgGroupPermissions['autoconfirmed']['skipcaptcha'] = false;
$wgGroupPermissions['bot'          ]['skipcaptcha'] = true; // registered bots
$wgGroupPermissions['sysop'        ]['skipcaptcha'] = true;

global $wgCaptcha, $wgCaptchaClass, $wgCaptchaTriggers;
$wgCaptcha = null;
$wgCaptchaClass = 'SimpleCaptcha';

/**
 * Actions which can trigger a captcha
 *
 * If the 'edit' trigger is on, *every* edit will trigger the captcha.
 * This may be useful for protecting against vandalbot attacks.
 *
 * If using the default 'addurl' trigger, the captcha will trigger on
 * edits that include URLs that aren't in the current version of the page.
 * This should catch automated linkspammers without annoying people when
 * they make more typical edits.
 *
 * The captcha code should not use $wgCaptchaTriggers, but CaptchaTriggers()
 * which also takes into account per namespace triggering.
 */
$wgCaptchaTriggers = array();
$wgCaptchaTriggers['edit']          = false; // Would check on every edit
$wgCaptchaTriggers['create']		= false; // Check on page creation.
$wgCaptchaTriggers['addurl']        = true;  // Check on edits that add URLs
$wgCaptchaTriggers['createaccount'] = true;  // Special:Userlogin&type=signup
$wgCaptchaTriggers['badlogin']      = true;  // Special:Userlogin after failure

/**
 * You may wish to apply special rules for captcha triggering on some namespaces.
 * $wgCaptchaTriggersOnNamespace[<namespace id>][<trigger>] forces an always on / 
 * always off configuration with that trigger for the given namespace.
 * Leave unset to use the global options ($wgCaptchaTriggers).
 *
 * Shall not be used with 'createaccount' (it is not checked).
 */
$wgCaptchaTriggersOnNamespace = array();

#Example:
#$wgCaptchaTriggersOnNamespace[NS_TALK]['create'] = false; //Allow creation of talk pages without captchas.
#$wgCaptchaTriggersOnNamespace[NS_PROJECT]['edit'] = true; //Show captcha whenever editing Project pages.

/**
 * Indicate how to store per-session data required to match up the
 * internal captcha data with the editor.
 *
 * 'CaptchaSessionStore' uses PHP's session storage, which is cookie-based
 * and may fail for anons with cookies disabled.
 *
 * 'CaptchaCacheStore' uses $wgMemc, which avoids the cookie dependency
 * but may be fragile depending on cache configuration.
 */
global $wgCaptchaStorageClass;
$wgCaptchaStorageClass = 'CaptchaSessionStore';

/**
 * Number of seconds a captcha session should last in the data cache
 * before expiring when managing through CaptchaCacheStore class.
 *
 * Default is a half hour.
 */
global $wgCaptchaSessionExpiration;
$wgCaptchaSessionExpiration = 30 * 60;

/**
 * Number of seconds after a bad login that a captcha will be shown to
 * that client on the login form to slow down password-guessing bots.
 *
 * Has no effect if 'badlogin' is disabled in $wgCaptchaTriggers or
 * if there is not a caching engine enabled.
 *
 * Default is five minutes.
 */
global $wgCaptchaBadLoginExpiration;
$wgCaptchaBadLoginExpiration = 5 * 60;

/**
 * Allow users who have confirmed their e-mail addresses to post
 * URL links without being harassed by the captcha.
 */
global $ceAllowConfirmedEmail;
$ceAllowConfirmedEmail = false;

/**
 * Regex to whitelist URLs to known-good sites...
 * For instance:
 * $wgCaptchaWhitelist = '#^https?://([a-z0-9-]+\\.)?(wikimedia|wikipedia)\.org/#i';
 * @fixme Use the 'spam-whitelist' thingy instead?
 */
$wgCaptchaWhitelist = false;

/**
 * Additional regexes to check for. Use full regexes; can match things
 * other than URLs such as junk edits.
 *
 * If the new version matches one and the old version doesn't,
 * toss up the captcha screen.
 *
 * @fixme Add a message for local admins to add items as well.
 */
$wgCaptchaRegexes = array();

/** Register special page */
global $wgSpecialPages;
$wgSpecialPages['Captcha'] = array( /*class*/ 'SpecialPage', /*name*/'Captcha', /*restriction*/ '',
	/*listed*/ false, /*function*/ false, /*file*/ false );

/**
 * Set up message strings for captcha utilities.
 */
function ceSetup() {
	# Add messages
	global $wgMessageCache, $wgConfirmEditMessages;
	foreach( $wgConfirmEditMessages as $lang => $messages )
		$wgMessageCache->addMessages( $messages, $lang );

	global $wgHooks, $wgCaptcha, $wgCaptchaClass, $wgSpecialPages;
	$wgCaptcha = new $wgCaptchaClass();
	$wgHooks['EditFilter'][] = array( &$wgCaptcha, 'confirmEdit' );

	$wgHooks['UserCreateForm'][] = array( &$wgCaptcha, 'injectUserCreate' );
	$wgHooks['AbortNewAccount'][] = array( &$wgCaptcha, 'confirmUserCreate' );
	
	$wgHooks['LoginAuthenticateAudit'][] = array( &$wgCaptcha, 'triggerUserLogin' );
	$wgHooks['UserLoginForm'][] = array( &$wgCaptcha, 'injectUserLogin' );
	$wgHooks['AbortLogin'][] = array( &$wgCaptcha, 'confirmUserLogin' );
}

/**
 * Entry point for Special:Captcha
 */
function wfSpecialCaptcha( $par = null ) {
	global $wgCaptcha;
	switch( $par ) {
	case "image":
		return $wgCaptcha->showImage();
	case "help":
	default:
		return $wgCaptcha->showHelp();
	}
}

class SimpleCaptcha {
	function SimpleCaptcha() {
		global $wgCaptchaStorageClass;
		$this->storage = new $wgCaptchaStorageClass;
	}
	
	/**
	 * Insert a captcha prompt into the edit form.
	 * This sample implementation generates a simple arithmetic operation;
	 * it would be easy to defeat by machine.
	 *
	 * Override this!
	 *
	 * @return string HTML
	 */
	function getForm() {
		$a = mt_rand(0, 100);
		$b = mt_rand(0, 10);
		$op = mt_rand(0, 1) ? '+' : '-';

		$test = "$a $op $b";
		$answer = ($op == '+') ? ($a + $b) : ($a - $b);

		$index = $this->storeCaptcha( array( 'answer' => $answer ) );

		return "<p><label for=\"wpCaptchaWord\">$test</label> = " .
			wfElement( 'input', array(
				'name' => 'wpCaptchaWord',
				'id'   => 'wpCaptchaWord',
				'tabindex' => 1 ) ) . // tab in before the edit textarea
			"</p>\n" .
			wfElement( 'input', array(
				'type'  => 'hidden',
				'name'  => 'wpCaptchaId',
				'id'    => 'wpCaptchaId',
				'value' => $index ) );
	}

	/**
	 * Insert the captcha prompt into an edit form.
	 * @param OutputPage $out
	 */
	function editCallback( &$out ) {
		$out->addWikiText( $this->getMessage( $this->action ) );
		$out->addHTML( $this->getForm() );
	}

	/**
	 * Show a message asking the user to enter a captcha on edit
	 * The result will be treated as wiki text
	 *
	 * @param $action Action being performed
	 * @return string
	 */
	function getMessage( $action ) {
		$name = 'captcha-' . $action;
		$text = wfMsg( $name );
		# Obtain a more tailored message, if possible, otherwise, fall back to
		# the default for edits
		return wfEmptyMsg( $name, $text ) ? wfMsg( 'captcha-edit' ) : $text;
	}

	/**
	 * Inject whazawhoo
	 * @fixme if multiple thingies insert a header, could break
	 * @param SimpleTemplate $template
	 * @return bool true to keep running callbacks
	 */
	function injectUserCreate( &$template ) {
		global $wgCaptchaTriggers, $wgOut;
		if( $wgCaptchaTriggers['createaccount'] ) {
			$template->set( 'header',
				"<div class='captcha'>" .
				$wgOut->parse( $this->getMessage( 'createaccount' ) ) .
				$this->getForm() .
				"</div>\n" );
		}
		return true;
	}

	/**
	 * Inject a captcha into the user login form after a failed
	 * password attempt as a speedbump for mass attacks.
	 * @fixme if multiple thingies insert a header, could break
	 * @param SimpleTemplate $template
	 * @return bool true to keep running callbacks
	 */
	function injectUserLogin( &$template ) {
		if( $this->isBadLoginTriggered() ) {
			global $wgOut;
			$template->set( 'header',
				"<div class='captcha'>" .
				$wgOut->parse( $this->getMessage( 'badlogin' ) ) .
				$this->getForm() .
				"</div>\n" );
		}
		return true;
	}
	
	/**
	 * When a bad login attempt is made, increment an expiring counter
	 * in the memcache cloud. Later checks for this may trigger a
	 * captcha display to prevent too many hits from the same place.
	 * @param User $user
	 * @param string $password
	 * @param int $retval authentication return value
	 * @return bool true to keep running callbacks
	 */
	function triggerUserLogin( $user, $password, $retval ) {
		global $wgCaptchaTriggers, $wgCaptchaBadLoginExpiration, $wgMemc;
		if( $retval == LoginForm::WRONG_PASS && $wgCaptchaTriggers['badlogin'] ) {
			$key = $this->badLoginKey();
			$count = $wgMemc->get( $key );
			if( !$count ) {
				$wgMemc->add( $key, 0, $wgCaptchaBadLoginExpiration );
			}
			$count = $wgMemc->incr( $key );
		}
		return true;
	}
	
	/**
	 * Check if a bad login has already been registered for this
	 * IP address. If so, require a captcha.
	 * @return bool
	 * @access private
	 */
	function isBadLoginTriggered() {
		global $wgMemc;
		return intval( $wgMemc->get( $this->badLoginKey() ) ) > 0;
	}
	
	/**
	 * Internal cache key for badlogin checks.
	 * @return string
	 * @access private
	 */
	function badLoginKey() {
		return wfMemcKey( 'captcha', 'badlogin', 'ip', wfGetIP() );
	}
	
	/**
	 * Check if the submitted form matches the captcha session data provided
	 * by the plugin when the form was generated.
	 *
	 * Override this!
	 *
	 * @param WebRequest $request
	 * @param array $info
	 * @return bool
	 */
	function keyMatch( $request, $info ) {
		return $request->getVal( 'wpCaptchaWord' ) == $info['answer'];
	}

	// ----------------------------------

	/**
	 * @param EditPage $editPage
	 * @param string $action (edit/create/addurl...)
	 * @return bool true if action triggers captcha on editPage's namespace
	 */
	function captchaTriggers( &$editPage, $action) {
		global $wgCaptchaTriggers, $wgCaptchaTriggersOnNamespace;	
		//Special config for this NS?
		if (isset( $wgCaptchaTriggersOnNamespace[$editPage->mTitle->getNamespace()][$action] ) )
			return $wgCaptchaTriggersOnNamespace[$editPage->mTitle->getNamespace()][$action];

		return ( !empty( $wgCaptchaTriggers[$action] ) ); //Default
	}


	/**
	 * @param EditPage $editPage
	 * @param string $newtext
	 * @param string $section
	 * @return bool true if the captcha should run
	 */
	function shouldCheck( &$editPage, $newtext, $section ) {
		$this->trigger = '';

		global $wgUser;
		if( $wgUser->isAllowed( 'skipcaptcha' ) ) {
			wfDebug( "ConfirmEdit: user group allows skipping captcha\n" );
			return false;
		}

		global $wgEmailAuthentication, $ceAllowConfirmedEmail;
		if( $wgEmailAuthentication && $ceAllowConfirmedEmail &&
			$wgUser->isEmailConfirmed() ) {
			wfDebug( "ConfirmEdit: user has confirmed mail, skipping captcha\n" );
			return false;
		}

		if( $this->captchaTriggers( $editPage, 'edit' ) ) {
			// Check on all edits
			global $wgUser, $wgTitle;
			$this->trigger = sprintf( "edit trigger by '%s' at [[%s]]",
				$wgUser->getName(),
				$wgTitle->getPrefixedText() );
			$this->action = 'edit';
			wfDebug( "ConfirmEdit: checking all edits...\n" );
			return true;
		}

		if( $this->captchaTriggers( $editPage, 'create' )  && !$editPage->mTitle->exists() ) {
			//Check if creating a page
			global $wgUser, $wgTitle;
			$this->trigger = sprintf( "Create trigger by '%s' at [[%s]]",
				$wgUser->getName(),
				$wgTitle->getPrefixedText() );
			$this->action = 'create';
			wfDebug( "ConfirmEdit: checking on page creation...\n" );
			return true;
		}

		if( $this->captchaTriggers( $editPage, 'addurl' ) ) {
			// Only check edits that add URLs
			$oldtext = $this->loadText( $editPage, $section );

			$oldLinks = $this->findLinks( $oldtext );
			$newLinks = $this->findLinks( $newtext );
			$unknownLinks = array_filter( $newLinks, array( &$this, 'filterLink' ) );

			$addedLinks = array_diff( $unknownLinks, $oldLinks );
			$numLinks = count( $addedLinks );

			if( $numLinks > 0 ) {
				global $wgUser, $wgTitle;
				$this->trigger = sprintf( "%dx url trigger by '%s' at [[%s]]: %s",
					$numLinks,
					$wgUser->getName(),
					$wgTitle->getPrefixedText(),
					implode( ", ", $addedLinks ) );
				$this->action = 'addurl';
				return true;
			}
		}

		global $wgCaptchaRegexes;
		if( !empty( $wgCaptchaRegexes ) ) {
			// Custom regex checks
			$oldtext = $this->loadText( $editPage, $section );

			foreach( $wgCaptchaRegexes as $regex ) {
				$newMatches = array();
				if( preg_match_all( $regex, $newtext, $newMatches ) ) {
					$oldMatches = array();
					preg_match_all( $regex, $oldtext, $oldMatches );

					$addedMatches = array_diff( $newMatches[0], $oldMatches[0] );

					$numHits = count( $addedMatches );
					if( $numHits > 0 ) {
						global $wgUser, $wgTitle;
						$this->trigger = sprintf( "%dx %s at [[%s]]: %s",
							$numHits,
							$regex,
							$wgUser->getName(),
							$wgTitle->getPrefixedText(),
							implode( ", ", $addedMatches ) );
						$this->action = 'edit';
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Filter callback function for URL whitelisting
	 * @return bool true if unknown, false if whitelisted
	 * @access private
	 */
	function filterLink( $url ) {
		global $wgCaptchaWhitelist;
		return !( $wgCaptchaWhitelist && preg_match( $wgCaptchaWhitelist, $url ) );
	}

	/**
	 * The main callback run on edit attempts.
	 * @param EditPage $editPage
	 * @param string $newtext
	 * @param string $section
	 * @param bool true to continue saving, false to abort and show a captcha form
	 */
	function confirmEdit( &$editPage, $newtext, $section ) {
		if( $this->shouldCheck( $editPage, $newtext, $section ) ) {
			if( $this->passCaptcha() ) {
				return true;
			} else {
				$editPage->showEditForm( array( &$this, 'editCallback' ) );
				return false;
			}
		} else {
			wfDebug( "ConfirmEdit: no need to show captcha.\n" );
			return true;
		}
	}

	/**
	 * Hook for user creation form submissions.
	 * @param User $u
	 * @param string $message
	 * @return bool true to continue, false to abort user creation
	 */
	function confirmUserCreate( $u, &$message ) {
		global $wgCaptchaTriggers;
		if( $wgCaptchaTriggers['createaccount'] ) {
			$this->trigger = "new account '" . $u->getName() . "'";
			if( !$this->passCaptcha() ) {
				$message = wfMsg( 'captcha-createaccount-fail' );
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Hook for user login form submissions.
	 * @param User $u
	 * @param string $message
	 * @return bool true to continue, false to abort user creation
	 */
	function confirmUserLogin( $u, $pass, &$retval ) {
		if( $this->isBadLoginTriggered() ) {
			$this->trigger = "post-badlogin login '" . $u->getName() . "'";
			if( !$this->passCaptcha() ) {
				$message = wfMsg( 'captcha-badlogin-fail' );
				// Emulate a bad-password return to confuse the shit out of attackers
				$retval = LoginForm::WRONG_PASS;
				return false;
			}
		}
		return true;
	}

	/**
	 * Given a required captcha run, test form input for correct
	 * input on the open session.
	 * @return bool if passed, false if failed or new session
	 */
	function passCaptcha() {
		$info = $this->retrieveCaptcha();
		if( $info ) {
			global $wgRequest;
			if( $this->keyMatch( $wgRequest, $info ) ) {
				$this->log( "passed" );
				$this->clearCaptcha( $info );
				return true;
			} else {
				$this->clearCaptcha( $info );
				$this->log( "bad form input" );
				return false;
			}
		} else {
			$this->log( "new captcha session" );
			return false;
		}
	}

	/**
	 * Log the status and any triggering info for debugging or statistics
	 * @param string $message
	 */
	function log( $message ) {
		wfDebugLog( 'captcha', 'ConfirmEdit: ' . $message . '; ' .  $this->trigger );
	}

	/**
	 * Generate a captcha session ID and save the info in PHP's session storage.
	 * (Requires the user to have cookies enabled to get through the captcha.)
	 *
	 * A random ID is used so legit users can make edits in multiple tabs or
	 * windows without being unnecessarily hobbled by a serial order requirement.
	 * Pass the returned id value into the edit form as wpCaptchaId.
	 *
	 * @param array $info data to store
	 * @return string captcha ID key
	 */
	function storeCaptcha( $info ) {
		if( !isset( $info['index'] ) ) {
			// Assign random index if we're not udpating
			$info['index'] = strval( mt_rand() );
		}
		$this->storage->store( $info['index'], $info );
		return $info['index'];
	}

	/**
	 * Fetch this session's captcha info.
	 * @return mixed array of info, or false if missing
	 */
	function retrieveCaptcha() {
		global $wgRequest;
		$index = $wgRequest->getVal( 'wpCaptchaId' );
		return $this->storage->retrieve( $index );
	}

	/**
	 * Clear out existing captcha info from the session, to ensure
	 * it can't be reused.
	 */
	function clearCaptcha( $info ) {
		$this->storage->clear( $info['index'] );
	}

	/**
	 * Retrieve the current version of the page or section being edited...
	 * @param EditPage $editPage
	 * @param string $section
	 * @return string
	 * @access private
	 */
	function loadText( $editPage, $section ) {
		$rev = Revision::newFromTitle( $editPage->mTitle );
		if( is_null( $rev ) ) {
			return "";
		} else {
			$text = $rev->getText();
			if( $section != '' ) {
				return Article::getSection( $text, $section );
			} else {
				return $text;
			}
		}
	}

	/**
	 * Extract a list of all recognized HTTP links in the text.
	 * @param string $text
	 * @return array of strings
	 */
	function findLinks( $text ) {
		global $wgParser, $wgTitle, $wgUser;

		$options = new ParserOptions();
		$text = $wgParser->preSaveTransform( $text, $wgTitle, $wgUser, $options );
		$out = $wgParser->parse( $text, $wgTitle, $options );

		return array_keys( $out->getExternalLinks() );
	}

	/**
	 * Show a page explaining what this wacky thing is.
	 */
	function showHelp() {
		global $wgOut, $ceAllowConfirmedEmail;
		$wgOut->setPageTitle( wfMsg( 'captchahelp-title' ) );
		$wgOut->addWikiText( wfMsg( 'captchahelp-text' ) );
		if ( $this->storage->cookiesNeeded() ) {
			$wgOut->addWikiText( wfMsg( 'captchahelp-cookies-needed' ) );
		}
	}

}

class CaptchaSessionStore {
	function store( $index, $info ) {
		$_SESSION['captcha' . $info['index']] = $info;
	}
	
	function retrieve( $index ) {
		if( isset( $_SESSION['captcha' . $index] ) ) {
			return $_SESSION['captcha' . $index];
		} else {
			return false;
		}
	}
	
	function clear( $index ) {
		unset( $_SESSION['captcha' . $index] );
	}

	function cookiesNeeded() {
		return true;
	}
}

class CaptchaCacheStore {
	function store( $index, $info ) {
		global $wgMemc, $wgCaptchaSessionExpiration;
		$wgMemc->set( wfMemcKey( 'captcha', $index ), $info,
			$wgCaptchaSessionExpiration );
	}

	function retrieve( $index ) {
		global $wgMemc;
		$info = $wgMemc->get( wfMemcKey( 'captcha', $index ) );
		if( $info ) {
			return $info;
		} else {
			return false;
		}
	}
	
	function clear( $index ) {
		global $wgMemc;
		$wgMemc->delete( wfMemcKey( 'captcha', $index ) );
	}

	function cookiesNeeded() {
		return false;
	}
}

} # End invocation guard

?>
