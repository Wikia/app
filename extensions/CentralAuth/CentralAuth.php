<?php
/**
 * Extension credits
 */
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Central Auth',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CentralAuth',
	'author' => 'Brion Vibber',
	'descriptionmsg' => 'centralauth-desc',
);

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'MergeAccount',
	'author'         => 'Brion Vibber',
	'url'            => 'http://meta.wikimedia.org/wiki/Help:Unified_login',
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

/**
 * Settings for sending the CentralAuth events to the RC-to-UDP system
 */
$wgCentralAuthUDPAddress = false;
$wgCentralAuthNew2UDPPrefix = '';

/**
 * List of local pages global users may edit while being globally locked.
 */
$wgCentralAuthLockedCanEdit = array();

/**
 * Size of wikis handled in one suppress user job.
 * Keep in mind that one wiki requires ~10 queries.
 */
$wgCentralAuthWikisPerSuppressJob = 10;

/**
 * Like $wgReadOnly, used to set extension to database read only mode
 * @var bool
 */
$wgCentralAuthReadOnly = false;

/**
 * Initialization of the autoloaders, and special extension pages.
 */
$caBase = dirname( __FILE__ );
$wgAutoloadClasses['SpecialCentralAuth'] = "$caBase/specials/SpecialCentralAuth.php";
$wgAutoloadClasses['SpecialMergeAccount'] = "$caBase/specials/SpecialMergeAccount.php";
$wgAutoloadClasses['SpecialGlobalUsers'] = "$caBase/specials/SpecialGlobalUsers.php";
$wgAutoloadClasses['CentralAuthUser'] = "$caBase/CentralAuthUser.php";
$wgAutoloadClasses['CentralAuthPlugin'] = "$caBase/CentralAuthPlugin.php";
$wgAutoloadClasses['CentralAuthHooks'] = "$caBase/CentralAuthHooks.php";
$wgAutoloadClasses['CentralAuthSuppressUserJob'] = "$caBase/SuppressUserJob.php";
$wgAutoloadClasses['WikiSet'] = "$caBase/WikiSet.php";
$wgAutoloadClasses['SpecialAutoLogin'] = "$caBase/specials/SpecialAutoLogin.php";
$wgAutoloadClasses['CentralAuthUserArray'] = "$caBase/CentralAuthUserArray.php";
$wgAutoloadClasses['CentralAuthUserArrayFromResult'] = "$caBase/CentralAuthUserArray.php";
$wgAutoloadClasses['SpecialGlobalGroupMembership'] = "$caBase/specials/SpecialGlobalGroupMembership.php";
$wgAutoloadClasses['CentralAuthGroupMembershipProxy'] = "$caBase/CentralAuthGroupMembershipProxy.php";
$wgAutoloadClasses['SpecialGlobalGroupPermissions'] = "$caBase/specials/SpecialGlobalGroupPermissions.php";
$wgAutoloadClasses['SpecialWikiSets'] = "$caBase/specials/SpecialWikiSets.php";
$wgAutoloadClasses['ApiQueryGlobalUserInfo'] = "$caBase/ApiQueryGlobalUserInfo.php";
$wgAutoloadClasses['CentralAuthReadOnlyError'] = "$caBase/CentralAuthReadOnlyError.php";

$wgExtensionMessagesFiles['SpecialCentralAuth'] = "$caBase/CentralAuth.i18n.php";
$wgExtensionMessagesFiles['SpecialCentralAuthAliases'] = "$caBase/CentralAuth.alias.php";

$wgJobClasses['crosswikiSuppressUser'] = 'CentralAuthSuppressUserJob';

$wgHooks['AuthPluginSetup'][] = 'CentralAuthHooks::onAuthPluginSetup';
$wgHooks['AddNewAccount'][] = 'CentralAuthHooks::onAddNewAccount';
$wgHooks['GetPreferences'][] = 'CentralAuthHooks::onGetPreferences';
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
$wgHooks['SpecialPasswordResetOnSubmit'][] = 'CentralAuthHooks::onSpecialPasswordResetOnSubmit';

// For interaction with the Special:Renameuser extension
$wgHooks['RenameUserWarning'][] = 'CentralAuthHooks::onRenameUserWarning';
$wgHooks['RenameUserPreRename'][] = 'CentralAuthHooks::onRenameUserPreRename';
$wgHooks['RenameUserComplete'][] = 'CentralAuthHooks::onRenameUserComplete';

// For SecurePoll
$wgHooks['SecurePoll_GetUserParams'][] = 'CentralAuthHooks::onSecurePoll_GetUserParams';

$wgAvailableRights[] = 'centralauth-merge';
$wgAvailableRights[] = 'centralauth-unmerge';
$wgAvailableRights[] = 'centralauth-lock';
$wgAvailableRights[] = 'centralauth-oversight';
$wgAvailableRights[] = 'globalgrouppermissions';
$wgAvailableRights[] = 'globalgroupmembership';
$wgAvailableRights[] = 'centralauth-autoaccount';

$wgGroupPermissions['steward']['centralauth-unmerge'] = true;
$wgGroupPermissions['steward']['centralauth-lock'] = true;
$wgGroupPermissions['steward']['centralauth-oversight'] = true;
$wgGroupPermissions['*']['centralauth-merge'] = true;

$wgSpecialPages['CentralAuth'] = 'SpecialCentralAuth';
$wgSpecialPages['AutoLogin'] = 'SpecialAutoLogin';
$wgSpecialPages['MergeAccount'] = 'SpecialMergeAccount';
$wgSpecialPages['GlobalGroupMembership'] = 'SpecialGlobalGroupMembership';
$wgSpecialPages['GlobalGroupPermissions'] = 'SpecialGlobalGroupPermissions';
$wgSpecialPages['WikiSets'] = 'SpecialWikiSets';
$wgSpecialPages['GlobalUsers'] = 'SpecialGlobalUsers';
$wgSpecialPageGroups['CentralAuth'] = 'users';
$wgSpecialPageGroups['MergeAccount'] = 'login';
$wgSpecialPageGroups['GlobalGroupMembership'] = 'users';
$wgSpecialPageGroups['GlobalGroupPermissions'] = 'users';
$wgSpecialPageGroups['WikiSets'] = 'wiki';
$wgSpecialPageGroups['GlobalUsers'] = 'users';

$wgAPIMetaModules['globaluserinfo'] = 'ApiQueryGlobalUserInfo';

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
$wgLogActions['suppress/setstatus'] = 'centralauth-log-entry-chgstatus';

$wgLogTypes[]                          = 'gblrights';
$wgLogNames['gblrights']               = 'centralauth-rightslog-name';
$wgLogHeaders['gblrights']             = 'centralauth-rightslog-header';
$wgLogActions['gblrights/usergroups']  = 'centralauth-rightslog-entry-usergroups';
$wgLogActions['gblrights/groupperms']  = 'centralauth-rightslog-entry-groupperms';
$wgLogActions['gblrights/groupprms2']  = 'centralauth-rightslog-entry-groupperms2';
$wgLogActions['gblrights/groupprms3']  = 'centralauth-rightslog-entry-groupperms3';

foreach ( array( 'newset', 'setrename', 'setnewtype', 'setchange', 'deleteset' ) as $type ) {
	$wgLogActionsHandlers["gblrights/{$type}"] = 'efHandleWikiSetLogEntry';
}

$commonModuleInfo = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'CentralAuth/modules',
);

$wgResourceModules['ext.centralauth'] = array(
	'scripts' => 'ext.centralauth.js',
	'styles' => 'ext.centralauth.css',
	'messages' => array(
		'centralauth-merge-method-primary',
		'centralauth-merge-method-primary-desc',
		'centralauth-merge-method-new',
		'centralauth-merge-method-new-desc',
		'centralauth-merge-method-empty',
		'centralauth-merge-method-empty-desc',
		'centralauth-merge-method-password',
		'centralauth-merge-method-password-desc',
		'centralauth-merge-method-mail',
		'centralauth-merge-method-mail-desc',
		'centralauth-merge-method-admin',
		'centralauth-merge-method-admin-desc',
		'centralauth-merge-method-login',
		'centralauth-merge-method-login-desc',
	),
) + $commonModuleInfo;

$wgResourceModules['ext.centralauth.noflash'] = array(
	'styles' => 'ext.centralauth.noflash.css',
) + $commonModuleInfo;

// If AntiSpoof is installed, we can do some AntiSpoof stuff for CA
// Though, doing it this way, AntiSpoof has to be loaded/included first
// I guess this is bug 30234
if ( MWInit::classExists( 'AntiSpoof' ) ) {
	$wgExtensionCredits['antispam'][] = array(
		'path' => __FILE__,
		'name' => 'AntiSpoof for CentralAuth',
		'url' => 'https://www.mediawiki.org/wiki/Extension:AntiSpoof',
		'author' => 'Sam Reed',
		'descriptionmsg' => 'centralauth-antispoof-desc',
	);
	$wgAutoloadClasses['CentralAuthSpoofUser'] = "$caBase/AntiSpoof/CentralAuthSpoofUser.php";
	$wgAutoloadClasses['CentralAuthAntiSpoofHooks'] = "$caBase/AntiSpoof/CentralAuthAntiSpoofHooks.php";

	$wgHooks['AbortNewAccount'][] = 'CentralAuthAntiSpoofHooks::asAbortNewAccountHook';
	$wgHooks['AddNewAccount'][] = 'CentralAuthAntiSpoofHooks::asAddNewAccountHook';
	$wgHooks['RenameUserComplete'][] = 'CentralAuthAntiSpoofHooks::asAddRenameUserHook';
}

/**
 * @param $type
 * @param $action
 * @param $title
 * @param $skin Skin
 * @param $params
 * @param $filterWikilinks bool
 * @return String
 */
function efHandleWikiSetLogEntry( $type, $action, $title, $skin, $params, $filterWikilinks = false ) {
	$link = Linker::makeLinkObj( $title, htmlspecialchars( $params[0] ) );

	switch( $action ) {
		case 'newset':
			$args = array( WikiSet::formatType( $params[1] ), $params[2] );
			break;
		case 'setrename':
			$args = array( $params[1] );
			break;
		case 'setnewtype':
			$args = array( WikiSet::formatType( $params[1] ), WikiSet::formatType( $params[2] ) );
			break;
		case 'setchange':
			$args = array( $params[1]
				? $params[1] : wfMsg( 'rightsnone' ), $params[2] ? $params[2] : wfMsg( 'rightsnone' ) );
			break;
		default: //'deleteset'
			$args = array();
	}

	return wfMsgReal( "centralauth-rightslog-entry-{$action}", array_merge( array( $link ), $args ), true, !$skin );
}
