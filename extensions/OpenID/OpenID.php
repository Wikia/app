<?php
/**
 * OpenID.php -- Make MediaWiki an OpenID consumer and server
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
 * @file
 * @author Evan Prodromou <evan@prodromou.name>
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

define( 'MEDIAWIKI_OPENID_VERSION', '0.947-beta 20120205' );

$path = dirname( __FILE__ );
set_include_path( implode( PATH_SEPARATOR, array( $path ) ) . PATH_SEPARATOR . get_include_path() );

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
 * values are 'always', 'never' (default), or 'user'.
 * 'user' lets the user decide in their preferences.
 */
$wgOpenIDShowUrlOnUserPage = 'never';

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
 * when creating a new account or associating an existing account with OpenID:
 *
 * the following settings allow the Wiki sysop a fine-grained tuning of
 * how new wiki user account names are derived from data associated with or
 * otherwise available from the validated OpenID identity, and/or whether or not
 * the free choice of the corresponding wiki user account name is allowed.
 */

/**
 * whether associating an existing account with OpenID is allowed:
 * show a wiki account username text input and password field
 */
$wgOpenIDAllowExistingAccountSelection = true;

/**
 * when creating a new account with OpenID:
 * show users a text input field to enter an arbitrary username
 */
$wgOpenIDAllowNewAccountname = true;

/**
 * when creating a new account or associating an existing account with OpenID:
 * Use the username part left of "@" in an OpenID e-mail address as username
 * for account creation, or log in - if no nickname is supplied in the OpenID
 * SREG data set. In other words: if available, nickname takes precedence
 * over username from e-mail.
 *
 * Example:
 *
 * When your OpenID is http://me.yahoo.com/my.name and your e-mail address is
 * my.name@yahoo.com, then "my.name" will be used for account creation.
 *
 * This works well with $wgOpenIDConsumerForce where all users have a unique
 * e-mail address at the same domain.
 *
 * The e-mail address associated with the OpenID identity becomes
 * the (unconfirmed) users' wiki account e-mail address.
 */
$wgOpenIDUseEmailAsNickname = false;

/**
 * when creating a new account or associating an existing account with OpenID:
 * propose and allow new account names from OpenID SREG data such as
 * fullname or nickname (if such data is available)
 */
$wgOpenIDProposeUsernameFromSREG = true;

/**
 * when creating a new account or associating an existing account with OpenID:
 * propose an auto-generated fixed unique username "OpenIDUser#" (#=1, 2, ..)
 */
$wgOpenIDAllowAutomaticUsername = true;

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
 * Allow to use User pages as OpenIDs even if user is using OpenID already
 *
 * If true, users can use their user page URLs of this site A as OpenID
 * on another site B even if user is using OpenID on A already.
 *
 * Some users might want to do that for vanity purposes or whatever.
 *
 * https://bugzilla.wikimedia.org/show_bug.cgi?id=18635
 * If false, prevent serving OpenID accounts (TODO list item; done)
 *
 */
$wgOpenIDAllowServingOpenIDUserAccounts = true;

/**
 * When merging accounts with the UserMerge and Delete extension,
 * should OpenIDs associated to the "from" account automatically be associated
 * to the "to" account ?
 */
$wgOpenIDMergeOnAccountMerge = false;

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
	'author' => array( 'Evan Prodromou', 'Sergey Chernyshev', 'Alexandre Emsenhuber', 'Thomas Gries' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:OpenID',
	'descriptionmsg' => 'openid-desc',
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

$dir = $path . '/';

$wgExtensionMessagesFiles['OpenID'] = $dir . 'OpenID.i18n.php';
$wgExtensionMessagesFiles['OpenIDAlias'] = $dir . 'OpenID.alias.php';

$wgAutoloadClasses['OpenIDHooks'] = $dir . 'OpenID.hooks.php';

# Autoload common parent with utility methods
$wgAutoloadClasses['SpecialOpenID'] = $dir . 'SpecialOpenID.body.php';

$wgAutoloadClasses['SpecialOpenIDLogin'] = $dir . 'SpecialOpenIDLogin.body.php';
$wgAutoloadClasses['SpecialOpenIDConvert'] = $dir . 'SpecialOpenIDConvert.body.php';
$wgAutoloadClasses['SpecialOpenIDServer'] = $dir . 'SpecialOpenIDServer.body.php';
$wgAutoloadClasses['SpecialOpenIDXRDS'] = $dir . 'SpecialOpenIDXRDS.body.php';
$wgAutoloadClasses['SpecialOpenIDDashboard'] = $dir . 'SpecialOpenIDDashboard.body.php';

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

$wgHooks['DeleteAccount'][] = 'OpenIDHooks::onDeleteAccount';
$wgHooks['MergeAccountFromTo'][] = 'OpenIDHooks::onMergeAccountFromTo';

# 1.16+
$wgHooks['GetPreferences'][] = 'OpenIDHooks::onGetPreferences';

# FIXME, function does not exist
# $wgHooks['UserLoginForm'][] = 'OpenIDHooks::onUserLoginForm';

# new user rights
$wgAvailableRights[] = 'openid-dashboard-access';
$wgAvailableRights[] = 'openid-dashboard-admin';

# uncomment to allow users to read access the dashboard
# $wgGroupPermissions['user']['openid-dashboard-access'] = true;

# allow users to add or convert OpenIDs to their accounts
$wgGroupPermissions['user']['openid-converter-access'] = true;

# allow sysops to read access the dashboard and
# allow sysops to adminstrate the OpenID settings (feature under construction)
$wgGroupPermissions['sysop']['openid-dashboard-access'] = true;
$wgGroupPermissions['sysop']['openid-dashboard-admin'] = true;

$myResourceTemplate = array(
	'localBasePath' => $path . '/skin',
	'remoteExtPath' => 'OpenID/skin',
	'group' => 'ext.openid',
);

$wgResourceModules['ext.openid'] = $myResourceTemplate + array(
	'scripts' => 'openid.js',
	'dependencies' => array(
		'jquery.cookie'
	)
);
$wgResourceModules['ext.openid.plain'] = $myResourceTemplate + array(
	'styles' => 'openid-plain.css',
	'dependencies' => array(
		'ext.openid'
	)
);
$wgResourceModules['ext.openid.icons'] = $myResourceTemplate + array(
	'styles' => 'openid.css',
	'dependencies' => array(
		'ext.openid'
	)
);
