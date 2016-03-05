<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit(1);
}

//@{
/**
 * @file
 * @ingroup Extensions
 */

$wgExtensionCredits[version_compare($wgVersion, '1.17alpha', '>=') ? 'antispam' : 'other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Title Blacklist',
	'author'         => array( 'Victor Vasiliev', 'Fran Rogers' ),
	'version'        => '1.4.2',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Title_Blacklist',
	'descriptionmsg' => 'titleblacklist-desc',
);

$wgExtensionMessagesFiles['TitleBlacklist'] = dirname( __FILE__ ) . '/TitleBlacklist.i18n.php';
$wgAutoloadClasses['TitleBlacklist']      = dirname( __FILE__ ) . '/TitleBlacklist.list.php';
$wgAutoloadClasses['TitleBlacklistHooks'] = dirname( __FILE__ ) . '/TitleBlacklist.hooks.php';

/** @defgroup Title blacklist source types
 *  @{
 */
define( 'TBLSRC_MSG',       0 );	///< For internal usage
define( 'TBLSRC_LOCALPAGE', 1 );	///< Local wiki page
define( 'TBLSRC_URL',	    2 );	///< Load blacklist from URL
define( 'TBLSRC_FILE',      3 );	///< Load from file
/** @} */

/** Array of title blacklist sources */
$wgTitleBlacklistSources = array();

$wgTitleBlacklistCaching = array(
	'warningchance' => 100,
	'expiry' => 900,
	'warningexpiry' => 600,
);

$dir = dirname( __FILE__ );

// Register the API method
$wgAutoloadClasses['ApiQueryTitleBlacklist'] = "$dir/api/ApiQueryTitleBlacklist.php";
$wgAPIModules['titleblacklist'] = 'ApiQueryTitleBlacklist';

$wgHooks['getUserPermissionsErrorsExpensive'][] = 'TitleBlacklistHooks::userCan';
$wgHooks['AbortMove'][] = 'TitleBlacklistHooks::abortMove';
//$wgHooks['AbortNewAccount'][] = 'TitleBlacklistHooks::abortNewAccount';
//$wgHooks['AbortAutoAccount'][] = 'TitleBlacklistHooks::abortNewAccount';
$wgHooks['CentralAuthAutoCreate'][] = 'TitleBlacklistHooks::centralAuthAutoCreate';
$wgHooks['EditFilter'][] = 'TitleBlacklistHooks::validateBlacklist';
$wgHooks['ArticleSaveComplete'][] = 'TitleBlacklistHooks::clearBlacklist';
//$wgHooks['UserCreateForm'][] = 'TitleBlacklistHooks::addOverrideCheckbox';

//@}
