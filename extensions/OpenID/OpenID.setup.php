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

if (!defined('MEDIAWIKI')) {
	exit( 1 );
}

define('MEDIAWIKI_OPENID_VERSION', '0.8.4dev');

# CONFIGURATION VARIABLES

# Whether to hide the "Login with OpenID link" link; set to true if you already have this link in your skin.

$wgHideOpenIDLoginLink = false;

# Location of the OpenID login logo. You can copy this to your server if you want.

$wgOpenIDLoginLogoUrl = 'http://www.openid.net/login-bg.gif';

# Whether to show the OpenID identity URL on a user's home page. Possible values are 'always', 'never', or 'user'
# 'user' lets the user decide.

$wgOpenIDShowUrlOnUserPage = 'user';

# These are trust roots that we don't bother asking users
# whether the trust root is allowed to trust; typically
# for closely-linked partner sites.

$wgOpenIDServerForceAllowTrust = array();

# Where to store transitory data. Only supported type is 'file'.

$wgOpenIDServerStoreType = 'file';

# If the store type is set to 'file', this is is the name of a
# directory to store the data in.

$wgOpenIDServerStorePath = "/tmp/$wgDBname/openidserver/";

# Defines the trust root for this server
# If null, we make a guess

$wgTrustRoot = null;

# When using deny and allow arrays, defines how the security works.
# If true, works like "Order Allow,Deny" in Apache; deny by default,
# allow items that match allow that don't match deny to pass.
# If false, works like "Order Deny,Allow" in Apache; allow by default,
# deny items in deny that aren't in allow.

$wgOpenIDConsumerDenyByDefault = false;

# Which partners to allow; regexps here. See above.

$wgOpenIDConsumerAllow = array();

# Which partners to deny; regexps here. See above.

$wgOpenIDConsumerDeny = array();

# Where to store transitory data. Only supported type is 'file'.

$wgOpenIDConsumerStoreType = 'file';

# If the store type is set to 'file', this is is the name of a
# directory to store the data in.

$wgOpenIDConsumerStorePath = "/tmp/$wgDBname/openidconsumer/";

# Expiration time for the OpenID cookie. Lets the user re-authenticate
# automatically if their session is expired. Only really useful if
# it's much greater than $wgCookieExpiration. Default: about one year.

$wgOpenIDCookieExpiration = 365 * 24 * 60 * 60;

# Only allow login with OpenID. Careful -- this means everybody!

$wgOpenIDOnly = false;

# If true, user accounts on this wiki *cannot* be used as
# OpenIDs on other sites.

$wgOpenIDClientOnly = false;

# END CONFIGURATION VARIABLES

$wgExtensionCredits['other'][] = array(
	'name' => 'OpenID',
	'version' => MEDIAWIKI_OPENID_VERSION,
	'author' => 'Evan Prodromou',
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
$wgAutoloadClasses['SpecialOpenIDFinish'] = $dir . 'SpecialOpenIDFinish.body.php';
$wgAutoloadClasses['SpecialOpenIDConvert'] = $dir . 'SpecialOpenIDConvert.body.php';
$wgAutoloadClasses['SpecialOpenIDServer'] = $dir . 'SpecialOpenIDServer.body.php';
$wgAutoloadClasses['SpecialOpenIDXRDS'] = $dir . 'SpecialOpenIDXRDS.body.php';

# Gets stored in the session, needs to be reified before our setup
$wgAutoloadClasses['Auth_OpenID_CheckIDRequest'] = OpenIDGetServerPath();

$wgHooks['PersonalUrls'][] = 'OpenIDHooks::onPersonalUrls';
$wgHooks['ArticleViewHeader'][] = 'OpenIDHooks::onArticleViewHeader';
$wgHooks['SpecialPage_initList'][] = 'OpenIDHooks::onSpecialPage_initList';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'OpenIDHooks::onLoadExtensionSchemaUpdates';
$wgHooks['RenderPreferencesForm'][] = 'OpenIDHooks::onRenderPreferencesForm';
$wgHooks['InitPreferencesForm'][] = 'OpenIDHooks::onInitPreferencesForm';
$wgHooks['ResetPreferences'][] = 'OpenIDHooks::onResetPreferences';
$wgHooks['SavePreferences'][] = 'OpenIDHooks::onSavePreferences';
