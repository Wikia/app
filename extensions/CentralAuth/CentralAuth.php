<?php

/**
 * Extension credits
 */
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Central Auth',
	'url' => 'http://www.mediawiki.org/wiki/Extension:CentralAuth',
	'svn-date' => '$LastChangedDate: 2009-03-04 06:12:35 +0100 (śro, 04 mar 2009) $',
	'svn-revision' => '$LastChangedRevision: 48012 $',
	'author' => 'Brion Vibber',
	'description'    => 'Merge accounts across a wiki farm',
	'descriptionmsg' => 'centralauth-desc',
);

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'MergeAccount',
	'author'         => 'Brion Vibber',
	'url'            => 'http://meta.wikimedia.org/wiki/Help:Unified_login',
	'svn-date' => '$LastChangedDate: 2009-03-04 06:12:35 +0100 (śro, 04 mar 2009) $',
	'svn-revision' => '$LastChangedRevision: 48012 $',
	'description'    => '[[Special:MergeAccount|Merge multiple accounts]] for Single User Login',
	'descriptionmsg' => 'centralauth-mergeaccount-desc',
);

/**
 * Database name you keep central auth data in.
 *
 * If this is not on the primary database connection, don't forget
 * to also set up $wgDBservers to have an entry with a groupLoads
 * setting for the 'CentralAuth' group. Alternatively you can use 
 * $wgLBFactoryConf to set up an LBFactory_Multi object.
 *
 * To use a database with a table prefix, set this variable to 
 * "{$database}-{$prefix}".
 */
$wgCentralAuthDatabase = 'centralauth';

/**
 * If true, new account registrations will be registered globally if
 * the username hasn't been used elsewhere.
 */
$wgCentralAuthAutoNew = false;

/**
 * If true, existing unattached accounts will be automatically migrated
 * if possible at first login.
 *
 * Any new account creations will be required to attach.
 *
 * If false, unattached accounts will not be harassed unless the individual
 * account has opted in to migration.
 */
$wgCentralAuthAutoMigrate = false;

/**
 * If true, remaining accounts which have not been attached will be forbidden
 * from logging in until they are resolved.
 */
$wgCentralAuthStrict = false;

/**
 * If true, merging won't actually be possible through the Special:MergeAccount
 * interface.
 */
$wgCentralAuthDryRun = false;

/**
 * If true, global session and token cookies will be set alongside the
 * per-wiki session and login tokens when users log in with a global account.
 * This allows other wikis on the same domain to transparently log them in.
 */
$wgCentralAuthCookies = false;

/**
 * Domain to set global cookies for.
 * For instance, '.wikipedia.org' to work on all wikipedia.org subdomains
 * instead of just the current one.
 *
 * Leave blank to set the cookie for the current domain only, such as if
 * all your wikis are hosted on the same subdomain.
 */
$wgCentralAuthCookieDomain = '';

/**
 * Prefix for CentralAuth global authentication cookies.
 */
$wgCentralAuthCookiePrefix = 'centralauth_';

/**
 * List of wiki IDs which should be called on login/logout to set third-party 
 * cookies for the global session state.
 *
 * The wiki ID is typically the database name, except when table prefixes are 
 * used, in which case it is the database name, a hyphen separator, and then 
 * the table prefix.
 *
 * This allows a farm with multiple second-level domains to set up a global 
 * session on all of them by hitting one wiki from each domain 
 * (en.wikipedia.org, en.wikinews.org, etc).
 *
 * Done by $wgCentralAuthLoginIcon from Special:AutoLogin on each wiki.
 *
 * If empty, no other wikis will be hit.
 *
 * The key should be set to the cookie domain name.
 */
$wgCentralAuthAutoLoginWikis = array();

/**
 * Local filesystem path to the icon returned by Special:AutoLogin
 * Should be a 20x20px PNG.
 */
$wgCentralAuthLoginIcon = false;

/**
 * If true, local accounts will be created for active global sessions
 * on any page view. This is kind of creepy, so we're gonna have it off
 * for a little bit.
 *
 * With other default options, the local autocreation will be held off
 * until an active login attempt, while global sessions will still
 * automatically log in those who already have a merged account.
 */
$wgCentralAuthCreateOnView = false;

// UDP logging stuff
$wgCentralAuthUDPAddress = false;
$wgCentralAuthNew2UDPPrefix = '';

/**
 * Initialization of the autoloaders, and special extension pages.
 */
$caBase = dirname( __FILE__ );
$wgAutoloadClasses['SpecialCentralAuth'] = "$caBase/SpecialCentralAuth.php";
$wgAutoloadClasses['SpecialMergeAccount'] = "$caBase/SpecialMergeAccount.php";
$wgAutoloadClasses['SpecialGlobalUsers'] = "$caBase/SpecialGlobalUsers.php";
$wgAutoloadClasses['CentralAuthUser'] = "$caBase/CentralAuthUser.php";
$wgAutoloadClasses['CentralAuthPlugin'] = "$caBase/CentralAuthPlugin.php";
$wgAutoloadClasses['CentralAuthHooks'] = "$caBase/CentralAuthHooks.php";
$wgAutoloadClasses['WikiMap'] = "$caBase/WikiMap.php";
$wgAutoloadClasses['WikiReference'] = "$caBase/WikiMap.php";
$wgAutoloadClasses['WikiSet'] = "$caBase/WikiSet.php";
$wgAutoloadClasses['SpecialAutoLogin'] = "$caBase/SpecialAutoLogin.php";
$wgAutoloadClasses['CentralAuthUserArray'] = "$caBase/CentralAuthUserArray.php";
$wgAutoloadClasses['CentralAuthUserArrayFromResult'] = "$caBase/CentralAuthUserArray.php";
$wgAutoloadClasses['SpecialGlobalGroupMembership'] = "$caBase/SpecialGlobalGroupMembership.php";
$wgAutoloadClasses['CentralAuthGroupMembershipProxy'] = "$caBase/CentralAuthGroupMembershipProxy.php";
$wgAutoloadClasses['SpecialGlobalGroupPermissions'] = "$caBase/SpecialGlobalGroupPermissions.php";
$wgAutoloadClasses['SpecialEditWikiSets'] = "$caBase/SpecialEditWikiSets.php";

$wgExtensionMessagesFiles['SpecialCentralAuth'] = "$caBase/CentralAuth.i18n.php";
$wgExtensionAliasesFiles['SpecialCentralAuth'] = "$caBase/CentralAuth.alias.php";

$wgHooks['AuthPluginSetup'][] = 'CentralAuthHooks::onAuthPluginSetup';
$wgHooks['AddNewAccount'][] = 'CentralAuthHooks::onAddNewAccount';
$wgHooks['PreferencesUserInformationPanel'][] = 'CentralAuthHooks::onPreferencesUserInformationPanel';
$wgHooks['AbortNewAccount'][] = 'CentralAuthHooks::onAbortNewAccount';
$wgHooks['UserLoginComplete'][] = 'CentralAuthHooks::onUserLoginComplete';
$wgHooks['UserLoadFromSession'][] = 'CentralAuthHooks::onUserLoadFromSession';
$wgHooks['UserLogout'][] = 'CentralAuthHooks::onUserLogout';
$wgHooks['UserLogoutComplete'][] = 'CentralAuthHooks::onUserLogoutComplete';
$wgHooks['GetCacheVaryCookies'][] = 'CentralAuthHooks::onGetCacheVaryCookies';
$wgHooks['UserArrayFromResult'][] = 'CentralAuthHooks::onUserArrayFromResult';
$wgHooks['UserGetEmail'][] = 'CentralAuthHooks::onUserGetEmail';
$wgHooks['UserGetEmailAuthenticationTimestamp'][] = 'CentralAuthHooks::onUserGetEmailAuthenticationTimestamp';
$wgHooks['UserSetEmail'][] = 'CentralAuthHooks::onUserSetEmail';
$wgHooks['UserSaveSettings'][] = 'CentralAuthHooks::onUserSaveSettings';
$wgHooks['UserSetEmailAuthenticationTimestamp'][] = 'CentralAuthHooks::onUserSetEmailAuthenticationTimestamp';
$wgHooks['UserGetRights'][] = 'CentralAuthHooks::onUserGetRights';
$wgHooks['UserSetCookies'][] = 'CentralAuthHooks::onUserSetCookies';
$wgHooks['UserLoadDefaults'][] = 'CentralAuthHooks::onUserLoadDefaults';
$wgHooks['getUserPermissionsErrorsExpensive'][] = 'CentralAuthHooks::onGetUserPermissionsErrorsExpensive';
$wgHooks['MakeGlobalVariablesScript'][] = 'CentralAuthHooks::onMakeGlobalVariablesScript';

// For interaction with the Special:Renameuser extension
$wgHooks['RenameUserWarning'][] = 'CentralAuthHooks::onRenameUserWarning';
$wgHooks['RenameUserPreRename'][] = 'CentralAuthHooks::onRenameUserPreRename';
$wgHooks['RenameUserComplete'][] = 'CentralAuthHooks::onRenameUserComplete';

$wgAvailableRights[] = 'centralauth-admin';
$wgAvailableRights[] = 'centralauth-merge';
$wgAvailableRights[] = 'globalgrouppermissions';
$wgAvailableRights[] = 'globalgroupmembership';
$wgGroupPermissions['steward']['centralauth-admin'] = true;
$wgGroupPermissions['*']['centralauth-merge'] = true;

$wgSpecialPages['CentralAuth'] = 'SpecialCentralAuth';
$wgSpecialPages['AutoLogin'] = 'SpecialAutoLogin';
$wgSpecialPages['MergeAccount'] = 'SpecialMergeAccount';
$wgSpecialPages['GlobalGroupMembership'] = 'SpecialGlobalGroupMembership';
$wgSpecialPages['GlobalGroupPermissions'] = 'SpecialGlobalGroupPermissions';
$wgSpecialPages['EditWikiSets'] = 'SpecialEditWikiSets';
$wgSpecialPages['GlobalUsers'] = 'SpecialGlobalUsers';
$wgSpecialPageGroups['CentralAuth'] = 'users';
$wgSpecialPageGroups['MergeAccount'] = 'login';
$wgSpecialPageGroups['GlobalGroupMembership'] = 'users';
$wgSpecialPageGroups['GlobalGroupPermissions'] = 'users';
$wgSpecialPageGroups['EditWikiSets'] = 'wiki';
$wgSpecialPageGroups['GlobalUsers'] = 'users';

$wgLogTypes[]                      = 'globalauth';
$wgLogNames['globalauth']          = 'centralauth-log-name';
$wgLogHeaders['globalauth']        = 'centralauth-log-header';
$wgLogActions['globalauth/delete'] = 'centralauth-log-entry-delete';
$wgLogActions['globalauth/lock']   = 'centralauth-log-entry-lock';
$wgLogActions['globalauth/unlock'] = 'centralauth-log-entry-unlock';
$wgLogActions['globalauth/hide']   = 'centralauth-log-entry-hide';
$wgLogActions['globalauth/unhide'] = 'centralauth-log-entry-unhide';
$wgLogActions['globalauth/lockandhid'] = 'centralauth-log-entry-lockandhide';
$wgLogActions['globalauth/setstatus'] = 'centralauth-log-entry-chgstatus';

$wgLogTypes[]                          = 'gblrights';
$wgLogNames['gblrights']               = 'centralauth-rightslog-name';
$wgLogHeaders['gblrights']	           = 'centralauth-rightslog-header';
$wgLogActions['gblrights/usergroups']  = 'centralauth-rightslog-entry-usergroups';
$wgLogActions['gblrights/groupperms']  = 'centralauth-rightslog-entry-groupperms';
$wgLogActions['gblrights/groupprms2']  = 'centralauth-rightslog-entry-groupperms2';
$wgLogActions['gblrights/groupprms3']  = 'centralauth-rightslog-entry-groupperms3';
foreach( array( 'newset', 'setrename', 'setnewtype', 'setchange' ) as $type )
	$wgLogActionsHandlers["gblrights/{$type}"] = 'efHandleWikiSetLogEntry';

function efHandleWikiSetLogEntry( $type, $action, $title, $skin, $params, $filterWikilinks = false ) {
	wfLoadExtensionMessages('SpecialCentralAuth');
	$link = $skin ? $skin->makeLinkObj( $title, $params[0] ) : $params[0];
	if( $action == 'newset' )
		$args = array( WikiSet::formatType( $params[1] ), $params[2] );
	if( $action == 'setrename' )
		$args = array( $params[1] );
	if( $action == 'setnewtype' )
		$args = array( WikiSet::formatType( $params[1] ), WikiSet::formatType( $params[2] ) );
	if( $action == 'setchange' )
		$args = array( $params[1] ? $params[1] : wfMsg( 'rightsnone' ), $params[2] ? $params[2] : wfMsg( 'rightsnone' ) );
	return wfMsgReal( "centralauth-rightslog-entry-{$action}", array_merge( array( $link ), $args ), true, !$skin );
}
