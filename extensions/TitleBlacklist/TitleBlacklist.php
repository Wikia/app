<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit(1);
}

//@{
/**
 * @package MediaWiki
 * @subpackage Extensions
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Title Blacklist',
	'author'         => array( 'VasilievVV', 'Fran Rogers' ),
	'version'        => '1.4.2',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Title_Blacklist',
	'description'    => 'Allows administrators to forbid creation of certain pages and user accounts',
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

$wgAvailableRights[] = 'tboverride';
$wgGroupPermissions['sysop']['tboverride'] = true;

$wgHooks['getUserPermissionsErrorsExpensive'][] = 'TitleBlacklistHooks::userCan';
$wgHooks['AbortMove'][] = 'TitleBlacklistHooks::abortMove';
$wgHooks['AbortNewAccount'][] = 'TitleBlacklistHooks::abortNewAccount';
$wgHooks['EditFilter'][] = 'TitleBlacklistHooks::validateBlacklist';
$wgHooks['ArticleSaveComplete'][] = 'TitleBlacklistHooks::clearBlacklist';

/**
 * Initialize the title blacklist
 */
function efInitTitleBlacklist() {
	global $wgTitleBlacklist;
	if( isset( $wgTitleBlacklist ) && $wgTitleBlacklist ) return;
	$wgTitleBlacklist = new TitleBlacklist();
}

//@}
