<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Special page to allow users to configure the wiki via a web based interface
 * Require MediaWiki version 1.14.0 or greater
 *
 * @file
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 */

# Adding credit :)
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Configure',
	'author' => array( 'Alexandre Emsenhuber', 'Andrew Garrett' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:Configure',
	'description' => 'Allow authorised users to configure the wiki via a web-based interface',
	'descriptionmsg' => 'configure-desc',
	'version' => '0.11.5 (1.14 branch-3)',
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
 * - file: main file name, if different that name.php
 * - settings: array of settings mapping setting's name to its type
 * - array: array type for settings
 * - empty: array of overrides for settings values when they match empty()
 * - view-restricted: list of settings that should only seen by users with
 *   extensions-all right
 * - edit-restricted: list of settings that only be modified by users with
 *   extensions-all right
 * - schema: put it to true if the extension requires a database schema change
 * - url: url to the documentation page
 */
$wgConfigureAdditionalExtensions = array();

/**
 * Allows to enable an extension by setting a variable instead of directly
 * include the file.
 * You'll need to handle the variable and include yourself the extension's file.
 * Format is $wgConfigureExtensionsVar['ExtensionName'] = 'VarName';
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
 * They won't be saved in conf-now.ser.
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
$wgConfigureStyleVersion = '19';

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
$wgExtensionMessagesFiles['ConfigureSettings'] = $dir . 'Configure.settings.i18n.php';

# And special pages aliases...
$wgExtensionAliasesFiles['Configure'] = $dir . 'Configure.alias.php';

# Add custom rights defined in $wgRestrictionLevels
$wgHooks['UserGetAllRights'][] = 'efConfigureGetAllRights';

# Handlers
$wgAutoloadClasses['ConfigureHandler'] = $dir . 'Configure.handler.php';
$wgAutoloadClasses['ConfigureHandlerFiles'] = $dir . 'Configure.handler-files.php';
$wgAutoloadClasses['ConfigureHandlerDb'] = $dir . 'Configure.handler-db.php';

# Adding the new special pages...
# Common code
$wgAutoloadClasses['ConfigurationPage'] = $dir . 'Configure.page.php';
# Special:Configure
$wgAutoloadClasses['SpecialConfigure'] = $dir . 'SpecialConfigure.php';
$wgSpecialPages['Configure'] = 'SpecialConfigure';
# Special:ViewConfig
$wgAutoloadClasses['SpecialViewConfig'] = $dir . 'SpecialViewConfig.php';
$wgSpecialPages['ViewConfig'] = 'SpecialViewConfig';
# Special:Extensions
$wgAutoloadClasses['SpecialExtensions'] = $dir . 'SpecialExtensions.php';
$wgSpecialPages['Extensions'] = 'SpecialExtensions';

# Helper for Special:Extension
$wgAutoloadClasses['WebExtension'] = $dir . 'Configure.ext.php';

# Core settings
define( 'CONF_SETTINGS_CORE', 1 );

# Extensions settings
define( 'CONF_SETTINGS_EXT', 2 );

# Both
define( 'CONF_SETTINGS_BOTH', 3 );

# Helper for configuration settings
$wgAutoloadClasses['ConfigurationSettings'] = $dir . 'Configure.settings.php';

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
$wgAutoloadClasses['ConfigurationPager'] = $dir . 'Configure.pager.php';
$wgAutoloadClasses['ConfigurationPagerDb'] = $dir . 'Configure.pager-db.php';
$wgAutoloadClasses['ConfigurationPagerFiles'] = $dir . 'Configure.pager-files.php';

# API module
$wgAutoloadClasses['ApiConfigure'] = $dir . 'Configure.api.php';
$wgExtensionFunctions[] = 'efConfigureSetupAPI';

# Adding the ajax function
$wgAjaxExportList[] = 'efConfigureAjax';
