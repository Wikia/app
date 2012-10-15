<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Special page to allow users to configure the wiki via a web based interface
 * Require MediaWiki version 1.17.0 or greater
 *
 * @file
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 */

# Adding credit :)
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Configure',
	'author' => array( 'Alexandre Emsenhuber', 'Andrew Garrett' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Configure',
	'descriptionmsg' => 'configure-desc',
	'version' => '0.17.2',
);

# Configuration part

/**
 * Configuration handler, either "files" or "db"
 */
$wgConfigureHandler = 'files';

/**
 * Default path for the serialized files, if $wgConfigureHandler is 'files'
 * Be sure that this directory is *not* accessible by the web
 */
$wgConfigureFilesPath = "$IP/serialized";

/**
 * Database used to store the configuration, if $wgConfigureHandler is 'db'
 */
$wgConfigureDatabase = 'config';

/**
 * Whether to allow to defer a part of efConfigureSetup() until the cache
 * objects are set by MediaWiki instead of doing it in efConfigureSetup().
 * It is only used if $wgConfigureHandler is 'db'.
 * If you want to use $wgConfigureExtensionsVar (see below), you may need to
 * set it to false, otherwise the variables won't be set in efConfigureSetup()
 * but later.
 */
$wgConfigureAllowDeferSetup = true;

/**
 * Path for file-system cache, only works when $wgConfigureHandler is 'db'.
 */
$wgConfigureFileSystemCache = false;

/**
 * Expiry for the file-system cache, note that it is not purged when saving a
 * new version of the configuration, so let this to a low value.
 */
$wgConfigureFileSystemCacheExpiry = 180;

/**
 * Allow foreign wiki configuration? either:
 * - true: allow any wiki
 * - false: don't allow any wiki
 * - array: array of allowed wikis (e.g. $wgConfigureWikis = $wgLocalDatabases)
 *
 * Users will need *-interwiki right to edit foreign wiki configuration
 */
$wgConfigureWikis = false;

/**
 * Base directory for extensions files, only change it if you need to
 */
$wgConfigureExtDir = "$IP/extensions/";

/**
 * Array of custom extensions (keys have no importance, it has the same format
 * as $extensions in Configure.settings-ext.php)
 * Each value of this array should be an array with the following keys:
 * - name: name of the extension (required)
 * - dir: dir name of the extension, if different than extension's name
 * - file: main file name, if different than name.php
 * - settings-file: file containing settings definitions, if different than
 *   the main file
 * - settings: array of settings mapping setting's name to its type
 * - array: array type for settings
 * - empty: array of overrides for settings values when they match empty()
 * - view-restricted: list of settings that should only seen by users with
 *   extensions-all right
 * - edit-restricted: list of settings that only be modified by users with
 *   extensions-all right
 * - extensions-dependencies: list of extensions that must be enabled so that
 *   this extension can be enabled too
 * - settings-dependencies: array mapping settings to their values that must be
 *   set so that this extension can be enabled
 * - schema: put it to true if the extension requires a database schema change
 * - url: url to the documentation page
 */
$wgConfigureAdditionalExtensions = array();

/**
 * List of disabled extensions
 */
$wgConfigureDisabledExtensions = array();

/**
 * Allows to enable an extension by setting a variable instead of directly
 * include the file.
 * You'll need to handle the variable and include yourself the extension's file.
 * Format is $wgConfigureExtensionsVar['ExtensionName'] = 'VarName';
 *
 * WARNING: If you use database handler, you may need to set
 * $wgConfigureAllowDeferSetup = false;
 * to use it correctly.
 */
$wgConfigureExtensionsVar = array();

/**
 * If this true, extensions will be considered as installed *only* if they are
 * defined in $wgConfigureExtensionsVar, Configure won't check anymore for
 * extensions in the file system.
 */
$wgConfigureOnlyUseVarForExt = false;

/**
 * Array of supplementary view restrictions. Format is
 * $wgConfigureViewRestrictions['wgSetting'] = array( 'right1', 'right2' );
 * if multiple rights are given, the user must have *all* of them to see the
 * setting
 */
$wgConfigureViewRestrictions = array();

/**
 * Array of supplementary edit restrictions. Format is
 * $wgConfigureViewRestrictions['wgSetting'] = array( 'right1', 'right2' );
 * if multiple rights are given, the user must have *all* of them to edit the
 * setting
 */
$wgConfigureEditRestrictions = array();

/**
 * Array of not editable settings, by anyone.
 * They won't be saved in conf-now.php.
 * Superseded, use the explicit whitelist.
 */
$wgConfigureNotEditableSettings = array();

/**
 * Editable settings. If this is a non-empty array, only the settings in this
 * array will be allowed to be modified.
 */
$wgConfigureEditableSettings = array(
	'wgSitename', 'wgLogo', 'wgContentNamespaces', 'wgMetaNamespace', 'wgMetaNamespaceTalk',
	'wgNamespaceAliases', 'wgNamespaceProtection', 'wgNamespaceRobotPolicies', 'wgNamespacesToBeSearchedDefault',
	'wgNamespacesToBeSearchedProject', 'wgNamespacesWithSubpages', 'wgNoFollowNsExceptions', 'wgNonincludableNamespaces',
	'wgSitemapNamespaces', 'wgAutopromote', 'wgGroupPermissions', 'wgImplicitGroups', 'wgAddGroups', 'wgRemoveGroups',
	'wgGroupsAddToSelf', 'wgGroupsRemoveFromSelf', 'wgArticleRobotPolicies', 'wgCapitalLinks', 'wgDefaultLanguageVariant',
	'wgExtraSubtitle', 'wgImportSources', 'wgRateLimits', 'wgAutoConfirmAge', 'wgAutoConfirmCount', 'wgMaxSigChars',
	'wgExtraNamespaces', 'wgLocaltimezone', 'wgExemptFromUserRobotsControl',
);

/**
 * Whether to use the API module
 */
$wgConfigureAPI = false;

/**
 * Whether to update $wgCacheEpoch when saving changes in Special:Configure
 */
$wgConfigureUpdateCacheEpoch = false;

/**
 * Styles versions, you shouldn't change it
 */
$wgConfigureStyleVersion = '21';

# Adding new rights...
$wgAvailableRights[] = 'configure';
$wgAvailableRights[] = 'configure-all';
$wgAvailableRights[] = 'configure-interwiki';
$wgAvailableRights[] = 'viewconfig';
$wgAvailableRights[] = 'viewconfig-all';
$wgAvailableRights[] = 'viewconfig-interwiki';
$wgAvailableRights[] = 'extensions';
$wgAvailableRights[] = 'extensions-all';
$wgAvailableRights[] = 'extensions-interwiki';

# Rights for Special:Configure
$wgGroupPermissions['bureaucrat']['configure'] = true;
# $wgGroupPermissions['bureaucrat']['configure-interwiki'] = true;
$wgGroupPermissions['bureaucrat']['configure-all'] = true;

# Rights for Special:Extensions
$wgGroupPermissions['bureaucrat']['extensions'] = true;
# $wgGroupPermissions['bureaucrat']['extensions-interwiki'] = true;
# $wgGroupPermissions['developer']['extensions-all'] = true;

# Rights for Special:ViewConfig
$wgGroupPermissions['sysop']['viewconfig'] = true;
# $wgGroupPermissions['sysop']['viewconfig-interwiki'] = true;
# $wgGroupPermissions['developer']['viewconfig-all'] = true;

$dir = dirname( __FILE__ ) . '/';

# Define some functions
require_once( $dir . 'Configure.func.php' );

# Adding internationalisation...
$wgExtensionMessagesFiles['Configure'] = $dir . 'Configure.i18n.php';
$wgExtensionMessagesFiles['ConfigureSettings'] = $dir . 'settings/Settings.i18n.php';

# And special pages aliases...
$wgExtensionMessagesFiles['ConfigureAliases'] = $dir . 'Configure.alias.php';

# Add custom rights defined in $wgRestrictionLevels
$wgHooks['UserGetAllRights'][] = 'efConfigureGetAllRights';

# For interaction with Extension:Farmer
$wgHooks['FarmerAdminPermissions'][] = 'efConfigureFarmerAdminPermissions';
$wgHooks['FarmerAdminSkin'][] = 'efConfigureFarmerAdminSkin';
$wgHooks['FarmerAdminExtensions'][] = 'efConfigureFarmerAdminExtensions';
$wgHooks['FarmerManageExtensions'][] = 'efConfigureFarmerManageExtensions';

# For interaction with Admin Links extension
$wgHooks['AdminLinks'][] = 'efConfigureAddToAdminLinks';

# Handlers
$wgAutoloadClasses['ConfigureHandler'] = $dir . 'handler/Handler.php';
$wgAutoloadClasses['ConfigureHandlerFiles'] = $dir . 'handler/HandlerFiles.php';
$wgAutoloadClasses['ConfigureHandlerDb'] = $dir . 'handler/HandlerDb.php';

# Adding the new special pages...
# Common code
$wgAutoloadClasses['ConfigurationPage'] = $dir . 'specials/ConfigurationPage.php';
# Special:Configure
$wgAutoloadClasses['SpecialConfigure'] = $dir . 'specials/SpecialConfigure.php';
$wgSpecialPages['Configure'] = 'SpecialConfigure';
# Special:ViewConfig
$wgAutoloadClasses['SpecialViewConfig'] = $dir . 'specials/SpecialViewConfig.php';
$wgSpecialPages['ViewConfig'] = 'SpecialViewConfig';
# Special:Extensions
$wgAutoloadClasses['SpecialExtensions'] = $dir . 'specials/SpecialExtensions.php';
$wgSpecialPages['Extensions'] = 'SpecialExtensions';

# Helper for Special:Extension
$wgAutoloadClasses['WebExtension'] = $dir . 'settings/WebExtension.php';

# Core settings
define( 'CONF_SETTINGS_CORE', 1 );

# Extensions settings
define( 'CONF_SETTINGS_EXT', 2 );

# Both
define( 'CONF_SETTINGS_BOTH', 3 );

# Helper for configuration settings
$wgAutoloadClasses['ConfigurationSettings'] = $dir . 'settings/ConfigurationSettings.php';
$wgAutoloadClasses['TxtDef'] = $dir . 'load_txt_def/TxtDef.php';

# Groups
$wgSpecialPageGroups['Configure'] = 'wiki';
$wgSpecialPageGroups['Extensions'] = 'wiki';
$wgSpecialPageGroups['ViewConfig'] = 'wiki';

# Diff stuff
$wgAutoloadClasses['ConfigurationDiff'] = $dir . 'Configure.diff.php';
$wgAutoloadClasses['CorePreviewConfigurationDiff'] = $dir . 'Configure.diff.php';
$wgAutoloadClasses['ExtPreviewConfigurationDiff'] = $dir . 'Configure.diff.php';
$wgAutoloadClasses['HistoryConfigurationDiff'] = $dir . 'Configure.diff.php';

# Pager stuff
$wgAutoloadClasses['ConfigurationPager'] = $dir . 'pager/Pager.php';
$wgAutoloadClasses['ConfigurationPagerDb'] = $dir . 'pager/PagerDb.php';
$wgAutoloadClasses['ConfigurationPagerFiles'] = $dir . 'pager/PagerFiles.php';

# API module
$wgAutoloadClasses['ApiConfigure'] = $dir . 'Configure.api.php';
$wgAPIModules['configure'] = 'ApiConfigure';

# Ressource loader
$wgResourceModules['ext.configure'] = array(
	'scripts' => 'Configure.js',
	'styles'  => 'Configure.css',
 
	'messages' => array(
		'configure-js-add',
		'configure-js-remove',
		'configure-js-remove-row',
		'configure-js-prompt-group',
		'configure-js-group-exists',
		'configure-js-get-image-url',
		'configure-js-image-error',
		'configure-js-biglist-shown',
		'configure-js-biglist-hidden',
		'configure-js-biglist-show',
		'configure-js-biglist-hide',
		'configure-js-summary-none',
		'configure-throttle-summary',
	),

	'dependencies' => 'mediawiki.legacy.wikibits',

	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'Configure'
);
