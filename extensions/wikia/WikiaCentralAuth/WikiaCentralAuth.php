<?php

/** 	 	 
 * Database name you keep central auth data in. 	 	 
 * 	 	 
 * If this is not on the primary database connection, don't forget 	 	 
 * to also set up $wgDBservers to have an entry with a groupLoads 	 	 
 * setting for the 'WikiaCentralAuth' group. Alternatively you can use  	 	 
 * $wgLBFactoryConf to set up an LBFactory_Multi object. 	 	 
 * 	 	 
 * To use a database with a table prefix, set this variable to  	 	 
 * "{$database}-{$prefix}". 	 	 
 */ 	 	 
$wgWikiaCentralAuthDatabase = 'wikicities'; 

/**
 * If true, new account registrations will be registered globally if
 * the username hasn't been used elsewhere.
 */
$wgWikiaCentralAuthAutoNew = true;

/**
 * If true, existing unattached accounts will be automatically migrated
 * if possible at first login.
 *
 * Any new account creations will be required to attach.
 *
 * If false, unattached accounts will not be harassed unless the individual
 * account has opted in to migration.
 */
$wgWikiaCentralAuthAutoMigrate = true;

/**
 * If true, global session and token cookies will be set alongside the
 * per-wiki session and login tokens when users log in with a global account.
 * This allows other wikis on the same domain to transparently log them in.
 */
$wgWikiaCentralAuthCookies = false;

/**
 * Domain to set global cookies for.
 * For instance, '.wikipedia.org' to work on all wikipedia.org subdomains
 * instead of just the current one.
 *
 * Leave blank to set the cookie for the current domain only, such as if
 * all your wikis are hosted on the same subdomain.
 */
$wgWikiaCentralAuthCookieDomain = '.wikia.com';

/**
 * Prefix for WikiaCentralAuth global authentication cookies.
 */
$wgWikiaCentralAuthCookiePrefix = 'wikiacentralauth_';

/**
 * Prefix for WikiaCentralAuth memcache key.
 */
$wgWikiaCentralAuthMemcPrefix = 'wikiacentralauth_';

/**
 * If true, local accounts will be created for active global sessions
 * on any page view. This is kind of creepy, so we're gonna have it off
 * for a little bit.
 *
 * With other default options, the local autocreation will be held off
 * until an active login attempt, while global sessions will still
 * automatically log in those who already have a merged account.
 */
$wgWikiaCentralAuthCreateOnView = true;

/**
 * If true, use new crypt function to generate password
 */
$wgWikiaCentralNewCryptPassword = false;

/**
 * Central groups 
 */
$wgWikiaCentralUseGlobalGroups = false;
$wgWikiaCentralGroups = array('staff', 'wikiabot');

/**
 * Initialization of the autoloaders, and special extension pages.
 */
$caBase = dirname( __FILE__ );
$wgAutoloadClasses['WikiaCentralAuthUser'] = "$caBase/WikiaCentralAuthUser.php";
$wgAutoloadClasses['WikiaCentralAuthPlugin'] = "$caBase/WikiaCentralAuthPlugin.php";
$wgAutoloadClasses['WikiaCentralAuthHooks'] = "$caBase/WikiaCentralAuthHooks.php";
$wgAutoloadClasses['WikiaCentralAuthUserArray'] = "$caBase/WikiaCentralAuthUserArray.php";
$wgAutoloadClasses['WikiaCentralAuthUserArrayFromResult'] = "$caBase/WikiaCentralAuthUserArray.php";

$wgHooks['AuthPluginSetup'][] = 'WikiaCentralAuthHooks::onAuthPluginSetup';
$wgHooks['AddNewAccount'][] = 'WikiaCentralAuthHooks::onAddNewAccount';
$wgHooks['AbortNewAccount'][] = 'WikiaCentralAuthHooks::onAbortNewAccount';
$wgHooks['UserLogout'][] = 'WikiaCentralAuthHooks::onUserLogout';
$wgHooks['UserArrayFromResult'][] = 'WikiaCentralAuthHooks::onUserArrayFromResult';
$wgHooks['UserLoadDefaults'][] = 'WikiaCentralAuthHooks::onUserLoadDefaults';

#- settings hooks
$wgHooks['UserGetEmail'][] = 'WikiaCentralAuthHooks::onUserGetEmail';
$wgHooks['UserGetEmailAuthenticationTimestamp'][] = 'WikiaCentralAuthHooks::onUserGetEmailAuthenticationTimestamp';
$wgHooks['UserSetEmail'][] = 'WikiaCentralAuthHooks::onUserSetEmail';
$wgHooks['UserSaveSettings'][] = 'WikiaCentralAuthHooks::onUserSaveSettings';
$wgHooks['UserSetEmailAuthenticationTimestamp'][] = 'WikiaCentralAuthHooks::onUserSetEmailAuthenticationTimestamp';
$wgHooks['getUserPermissionsErrorsExpensive'][] = 'WikiaCentralAuthHooks::onGetUserPermissionsErrorsExpensive';

$wgHooks['UserLoadFromSessionInfo'][] = 'WikiaCentralAuthHooks::onUserLoadFromSessionInfo';
$wgHooks['GetCacheVaryCookies'][] = 'WikiaCentralAuthHooks::onGetCacheVaryCookies';
$wgHooks['UserSetCookies'][] = 'WikiaCentralAuthHooks::onUserSetCookies';
$wgHooks['UserLoadFromSession'][] = 'WikiaCentralAuthHooks::onUserLoadFromSession'; 
#- turn on if central database with users will be ready
#$wgHooks['UserLoadGroups'][] = 'WikiaCentralAuthHooks::onUserLoadGroups';

$wgHooks['UserLoadFromDatabase'][] = 'WikiaCentralAuthHooks::onUserLoadFromDatabase';
$wgHooks['UserNameLoadFromId'][] = 'WikiaCentralAuthHooks::onUserNameLoadFromId';
