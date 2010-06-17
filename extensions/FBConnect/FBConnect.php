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

/**
 * FBConnect plugin. Integrates Facebook Connect into MediaWiki.
 * 
 * Facebook Connect single sign on (SSO) experience and XFBML are currently available.
 * Please rename config.sample.php to config.php, follow the instructions inside and
 * customize variables as you like to set up your Facebook Connect extension.
 *
 * Info is available at http://www.mediawiki.org/wiki/Extension:FBConnect
 * and at http://wiki.developers.facebook.com/index.php/MediaWiki
 * 
 * Limited support is available at  http://www.mediawiki.org/wiki/Extension_talk:FBConnect
 * and at http://wiki.developers.facebook.com/index.php/Talk:MediaWiki
 * 
 * @author Garrett Bruin
 * @copyright Copyright © 2008 Garrett Brown
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @addtogroup Extensions
 */


/*
 * Not a valid entry point, skip unless MEDIAWIKI is defined.
 */
if ( !defined( 'MEDIAWIKI' )) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/*
 * FBConnect version. Note: this is not necessarily the most recent SVN revision number.
 */
define( 'MEDIAWIKI_FBCONNECT_VERSION', 'r152, April 14, 2010' );

/*
 * Add information about this extension to Special:Version.
 */
$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Facebook Connect Plugin',
	'author'         => 'Garrett Brown',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:FBConnect',
	'descriptionmsg' => 'fbconnect-desc',
	'version'        => MEDIAWIKI_FBCONNECT_VERSION,
);

/*
 * Initialization of the autoloaders and special extension pages.
 */
$dir = dirname(__FILE__) . '/';
require_once $dir . 'config.php';
require_once $dir . 'facebook-client/facebook.php';

$wgExtensionFunctions[] = 'FBConnect::init';
if(!empty($fbEnablePushToFacebook)){
	// Need to include it explicitly instead of autoload since it has initialization code of its own.
	// This should be done after FBConnect::init is added to wgExtensionFunctions so that FBConnect
	// gets fully initialized first.
	require_once $dir . 'FBConnectPushEvent.php';
}

$wgExtensionMessagesFiles['FBConnect'] =	$dir . 'FBConnect.i18n.php';
$wgExtensionAliasesFiles['FBConnect'] =		$dir . 'FBConnect.alias.php';

$wgAutoloadClasses['FBConnectAPI'] =		$dir . 'FBConnectAPI.php';
$wgAutoloadClasses['FBConnectDB'] =			$dir . 'FBConnectDB.php';
$wgAutoloadClasses['FBConnectHooks'] =		$dir . 'FBConnectHooks.php';
$wgAutoloadClasses['FBConnectProfilePic'] =	$dir . 'FBConnectProfilePic.php';
$wgAutoloadClasses['FBConnectUser'] =		$dir . 'FBConnectUser.php';
$wgAutoloadClasses['FBConnectXFBML'] =		$dir . 'FBConnectXFBML.php';
$wgAutoloadClasses['SpecialConnect'] =		$dir . 'SpecialConnect.php';
$wgAutoloadClasses['ChooseNameTemplate'] =	$dir . 'wikia/template/ChooseNameTemplate.class.php';

$wgSpecialPages['Connect'] = 'SpecialConnect';

// Define new autopromote condition (use quoted text, numbers can cause collisions)
define( 'APCOND_FB_INGROUP',   'fb*g' );
define( 'APCOND_FB_ISOFFICER', 'fb*o' );
define( 'APCOND_FB_ISADMIN',   'fb*a' );

// Create a new group for Facebook users
$wgGroupPermissions['fb-user'] = $wgGroupPermissions['user'];

// If we are configured to pull group info from Facebook, then create the group permissions
if ($fbUserRightsFromGroup) {
	$wgGroupPermissions['fb-groupie'] = $wgGroupPermissions['user'];
	$wgGroupPermissions['fb-officer'] = $wgGroupPermissions['bureaucrat'];
	$wgGroupPermissions['fb-admin'] = $wgGroupPermissions['sysop'];
	#$wgGroupPermissions['fb-officer']['goodlooking'] = true;
	$wgImplictGroups[] = 'fb-groupie';
	$wgImplictGroups[] = 'fb-officer';
	$wgImplictGroups[] = 'fb-admin';
	$wgAutopromote['fb-groupie'] = APCOND_FB_INGROUP;
	$wgAutopromote['fb-officer'] = APCOND_FB_ISOFFICER;
	$wgAutopromote['fb-admin']   = APCOND_FB_ISADMIN;
}

$wgAjaxExportList[] = "FBConnect::disconnectFromFB";
$wgAjaxExportList[] = "SpecialConnect::getLoginButtonModal";
$wgAjaxExportList[] = "SpecialConnect::ajaxModalChooseName";
$wgAjaxExportList[] = "SpecialConnect::checkCreateAccount";


/**
 * Class FBConnect
 * 
 * This class initializes the extension, and contains the core non-hook,
 * non-authentification code.
 */
class FBConnect {
	static private $fbOnLoginJs;

	/**
	 * Initializes and configures the extension.
	 */
	public static function init() {
		global $wgXhtmlNamespaces, $wgAuth, $wgHooks, $wgSharedTables;
		
		// The xmlns:fb attribute is required for proper rendering on IE
		$wgXhtmlNamespaces['fb'] = 'http://www.facebook.com/2008/fbml';
		
		// Install all public static functions in class FBConnectHooks as MediaWiki hooks
		$hooks = self::enumMethods('FBConnectHooks');
		
		foreach( $hooks as $hookName ) {
			$wgHooks[$hookName][] = "FBConnectHooks::$hookName";
		}
		
		// Allow configurable over-riding of the onLogin handler.
		global $fbOnLoginJsOverride;
		if(!empty($fbOnLoginJsOverride)){
			self::$fbOnLoginJs = $fbOnLoginJsOverride;
		} else {
			self::$fbOnLoginJs = "window.location.reload(true);";
		}

		// ParserFirstCallInit was introduced in modern (1.12+) MW versions so as to
		// avoid unstubbing $wgParser on setHook() too early, as per r35980
		if (!defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' )) {
			global $wgParser;
			wfRunHooks( 'ParserFirstCallInit', $wgParser );
		}
	}

	/**
	 * Returns an array with the names of all public static functions
	 * in the specified class.
	 */
	public static function enumMethods( $className ) {
		$hooks = array();
		try {
			$class = new ReflectionClass( $className );
			foreach( $class->getMethods( ReflectionMethod::IS_PUBLIC ) as $method ) {
				if ( $method->isStatic() ) {
					$hooks[] = $method->getName();
				}
			}
		} catch( Exception $e ) {
			// If PHP's version doesn't support the Reflection API, then exit
			die( 'PHP version (' . phpversion() . ') must be great enough to support the Reflection API' );
			// Or list the extensions here manually...
			$hooks = array('AuthPluginSetup', 'UserLoadFromSession',
			               'RenderPreferencesForm', 'PersonalUrls',
			               'ParserAfterTidy', 'BeforePageDisplay', /*...*/ );
		}
		return $hooks;
	}
	
	/**
	 * Return the code for the permissions attribute (with leading space) to use on all fb:login-buttons.
	 */
	public static function getPermissionsAttribute(){
		global $fbExtendedPermissions;
		$attr = "";
		if(!empty($fbExtendedPermissions)){
			$attr = " perms=\"".implode(",", $fbExtendedPermissions)."\"";
		}
		return $attr;
	} // end getPermissionsAttribute()
	
	/**
	 * Return the code for the onlogin attribute which should be appended to all fb:login-button's in this
	 * extension.
	 *
	 * TODO: Generate the entire fb:login-button in a function in this class.  We have numerous buttons now.
	 */
	public static function getOnLoginAttribute(){
		$attr = "";
		if(!empty(self::$fbOnLoginJs)){
			$attr = " onlogin=\"".self::$fbOnLoginJs."\"";
		}
		return $attr;
	} // end getOnLoginAttribute()
	
	
	public static function getFBButton($onload = "", $id = "") {
		global $fbExtendedPermissions;
		return Xml::openElement("fb:login-button",
			array("onlogin" => $onload,
				  "id" => $id,
				  "perms" => implode(",", $fbExtendedPermissions)), true);
	}  
	
	/*
	 * Ajax function to disconect from facebook   
	 */
	public static function disconnectFromFB($user = null){
		$response = new AjaxResponse();
		$response->addText(json_encode(self::coreDisconnectFromFB($user)));
		return $response;
	}
	
	/*
	 * Fb disconect function and send mail with temp password 
	 */
	public static function coreDisconnectFromFB($user = null){
		global $wgRequest, $wgUser, $wgAuth;
		
		wfLoadExtensionMessages('FBConnect');
		
		if($user == null) {
			$user = $wgUser;	
		}
		
		
		$statusError = array('status' => "error", "msg" => wfMsg('fbconnect-unknown-error') );
		if($user->getId() == 0) {
			return $statusError;
		}
		
		$dbw = wfGetDB( DB_MASTER, array(), FBConnectDB::sharedDB() );
		$dbw->begin();
		$rows = FBConnectDB::removeFacebookID($user);
		// Remind password attemp
		$params = new FauxRequest(array (
			'wpName' => $user->getName()
		));
		
		if( !$wgAuth->allowPasswordChange() ) {
			return $statusError;
		}
		
		$result = array ();
		$loginForm = new LoginForm($params);
		
		$res = $loginForm->mailPasswordInternal( $wgUser, true, 'fbconnect-passwordremindertitle', 'fbconnect-passwordremindertext' );
		if( WikiError::isError( $res ) ) {
			return $statusError;
		}
				
		return array('status' => "ok" );
		$dbw->commit();
		return $response;	
	}
}
