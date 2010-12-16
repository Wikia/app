<?php
/**
 * OpenID.setup.php -- Make MediaWiki an OpenID consumer and server
 * Copyright 2006,2007 Internet Brands (http://www.internetbrands.com/)
 * Copyright 2007,2008 Evan Prodromou <evan@prodromou.name>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@prodromou.name>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

define( 'MEDIAWIKI_OPENID_VERSION', '0.10-dev' );

# CONFIGURATION VARIABLES

/**
 * Whether to hide the "Login with OpenID link" link; set to true if you already
 * have this link in your skin.
 */
$wgHideOpenIDLoginLink = false;

/**
 * Location of the OpenID login logo. You can copy this to your server if you
 * want.
 */
$wgOpenIDLoginLogoUrl = $wgScriptPath . '/extensions/OpenID/skin/icons/openid-inputicon.png';

/**
 * Whether to show the OpenID identity URL on a user's home page. Possible
 * values are 'always', 'never', or 'user'. 'user' lets the user decide.
 */
$wgOpenIDShowUrlOnUserPage = 'user';

/**
 * These are trust roots that we don't bother asking users whether the trust
 * root is allowed to trust; typically for closely-linked partner sites.
 */
$wgOpenIDServerForceAllowTrust = array();

/**
 * Implicitly trust the e-mail address sent from the OpenID server, and don't
 * ask the user to verify it.  This can lead to people with a nasty OpenID 
 * provider setting up accounts and spamming 
 */
$wgOpenIDTrustEmailAddress = false;

/**
 * Where to store transitory data.
 * Supported types are 'file', 'memcached', 'db'.
 */
$wgOpenIDServerStoreType = 'file';

/**
 * If the store type is set to 'file', this is is the name of a directory to
 * store the data in.
 */
$wgOpenIDServerStorePath = "/tmp/$wgDBname/openidserver/";

/**
 * Defines the trust root for this server
 * If null, we make a guess
 */
$wgTrustRoot = null;

/**
 * When using deny and allow arrays, defines how the security works.
 * If true, works like "Order Allow,Deny" in Apache; deny by default,
 * allow items that match allow that don't match deny to pass.
 * If false, works like "Order Deny,Allow" in Apache; allow by default,
 * deny items in deny that aren't in allow.
 */
$wgOpenIDConsumerDenyByDefault = false;

/**
 * Which partners to allow; regexps here. See above.
 */
$wgOpenIDConsumerAllow = array();

/**
 * Which partners to deny; regexps here. See above.
 */
$wgOpenIDConsumerDeny = array();

/**
 * Force this server to only allow authentication against one server; 
 * hides the selection form entirely. 
 */
$wgOpenIDConsumerForce = null;

/**
 * Use the part before the @ in any given e-mail address as the username
 * if a nickname is not given by the OP.
 * This works well with $wgOpenIDConsumerForce where all users have a unique
 * e-mail address at the same domain.
 */
$wgOpenIDUseEmailAsNickname = false;

/**
 * Where to store transitory data.
 * Supported types are 'file', 'memcached', 'db'.
 */
$wgOpenIDConsumerStoreType = 'file';

/**
 * If the store type is set to 'file', this is is the name of a
 * directory to store the data in.
 */
$wgOpenIDConsumerStorePath = "/tmp/$wgDBname/openidconsumer/";

/**
 * Expiration time for the OpenID cookie. Lets the user re-authenticate
 * automatically if their session is expired. Only really useful if
 * it's much greater than $wgCookieExpiration. Default: about one year.
 */
$wgOpenIDCookieExpiration = 365 * 24 * 60 * 60;

/**
 * Only allow login with OpenID. Careful -- this means everybody!
 */
$wgOpenIDOnly = false;

/**
 * If true, user accounts on this wiki *cannot* be used as OpenIDs on other
 * sites.
 */
$wgOpenIDClientOnly = false;

/**
 * If true, will show provider icons instead of the text.
 */
$wgOpenIDShowProviderIcons = false;

# New options
$wgDefaultUserOptions['openid-hide'] = 0;
$wgDefaultUserOptions['openid-update-on-login-nickname'] = false;
$wgDefaultUserOptions['openid-update-on-login-email'] = false;
$wgDefaultUserOptions['openid-update-on-login-fullname'] = false;
$wgDefaultUserOptions['openid-update-on-login-language'] = false;
$wgDefaultUserOptions['openid-update-on-login-timezone'] = false;

# END CONFIGURATION VARIABLES

$wgExtensionCredits['other'][] = array(
	'name' => 'OpenID',
	'version' => MEDIAWIKI_OPENID_VERSION,
	'path' => __FILE__,
	'author' => array( 'Evan Prodromou', 'Sergey Chernyshev', 'Alexandre Emsenhuber' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:OpenID',
	'description' => 'Lets users login to the wiki with an [http://openid.net/ OpenID] and login to other OpenID-aware Web sites with their wiki user account',
	'descriptiomsg' => 'openid-desc',
);

function OpenIDGetServerPath() {
	$rel = 'Auth/OpenID/Server.php';

	foreach ( explode( PATH_SEPARATOR, get_include_path() ) as $pe ) {
		$full = $pe . DIRECTORY_SEPARATOR . $rel;
		if ( file_exists( $full ) ) {
			return $full;
		}
	}
	return $rel;
}

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['OpenID'] = $dir . 'OpenID.i18n.php';
$wgExtensionAliasesFiles['OpenID'] = $dir . 'OpenID.alias.php';

$wgAutoloadClasses['OpenIDHooks'] = $dir . 'OpenID.hooks.php';

# Autoload common parent with utility methods
$wgAutoloadClasses['SpecialOpenID'] = $dir . 'SpecialOpenID.body.php';

$wgAutoloadClasses['SpecialOpenIDLogin'] = $dir . 'SpecialOpenIDLogin.body.php';
$wgAutoloadClasses['SpecialOpenIDConvert'] = $dir . 'SpecialOpenIDConvert.body.php';
$wgAutoloadClasses['SpecialOpenIDServer'] = $dir . 'SpecialOpenIDServer.body.php';
$wgAutoloadClasses['SpecialOpenIDXRDS'] = $dir . 'SpecialOpenIDXRDS.body.php';

# UI class
$wgAutoloadClasses['OpenIDProvider'] = $dir . 'OpenIDProvider.body.php';

# Gets stored in the session, needs to be reified before our setup
$wgAutoloadClasses['Auth_OpenID_CheckIDRequest'] = OpenIDGetServerPath();

$wgAutoloadClasses['MediaWikiOpenIDDatabaseConnection'] = $dir . 'DatabaseConnection.php';
$wgAutoloadClasses['MediaWikiOpenIDMemcachedStore'] = $dir . 'MemcachedStore.php';

$wgHooks['PersonalUrls'][] = 'OpenIDHooks::onPersonalUrls';
$wgHooks['BeforePageDisplay'][] = 'OpenIDHooks::onBeforePageDisplay';
$wgHooks['ArticleViewHeader'][] = 'OpenIDHooks::onArticleViewHeader';
$wgHooks['SpecialPage_initList'][] = 'OpenIDHooks::onSpecialPage_initList';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'OpenIDHooks::onLoadExtensionSchemaUpdates';

# 1.16+
$wgHooks['GetPreferences'][] = 'OpenIDHooks::onGetPreferences';

# < 1.16
$wgHooks['RenderPreferencesForm'][] = 'OpenIDHooks::onRenderPreferencesForm';
$wgHooks['InitPreferencesForm'][] = 'OpenIDHooks::onInitPreferencesForm';
$wgHooks['ResetPreferences'][] = 'OpenIDHooks::onResetPreferences';
$wgHooks['SavePreferences'][] = 'OpenIDHooks::onSavePreferences';

# FIXME, function does not exist
# $wgHooks['UserLoginForm'][] = 'OpenIDHooks::onUserLoginForm';
