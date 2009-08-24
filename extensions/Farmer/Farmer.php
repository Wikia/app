<?php
/**
 * This file contains classes and functions for MediaWiki farmer, a tool to help
 * manage a MediaWiki farm
 *
 * @author Gregory Szorc <gregory.szorc@gmail.com>
 * @licence GNU General Public Licence 2.0 or later
 *
 * @todo Extension management on per-wiki basis
 * @todo Upload prefix
 * @todo Use MediaWiki messages
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Farmer',
	'author' => 'Gregory Szorc <gregory.szorc@case.edu>',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Farmer',
	'description' => 'Manage a MediaWiki farm',
	'descriptionmsg' => 'farmer-desc',
	'version' => '0.0.4'
);

/**
 * Extension's configuration
 */
$wgFarmerSettings = array(
	//Path to the directory that holds settings for wikis
	'configDirectory'           =>  realpath( dirname( __FILE__ ) ) . '/configs/',

	// Default wiki
	'defaultWiki'               =>  '',

	// Function used to identify the wiki to use
	'wikiIdentifierFunction'    =>  array( 'MediaWikiFarmer', '_matchByURLHostname' ),
	'matchRegExp'               =>  '',
	'matchOffset'               =>  null,
	'matchServerNameSuffix'     =>   '',

	// Function to call for unknown wiki
	'onUnknownWiki'             =>  array( 'MediaWikiFarmer', '_redirectTo' ),
	// If onUnknownWiki calls MediaWikiFarmer::_redirectTo (default), url to redirect to
	'redirectToURL'             =>  '',

	// Wheter to use $wgConf to get some settings
	'useWgConf'                 => false,

	// File used to create tables for new wikis
	'newDbSourceFile'           =>  "$IP/maintenance/tables.sql",

	// Get DB name and table prefix for a wiki
	'dbFromWikiFunction'        => array( 'MediaWikiFarmer', '_prefixTable' ),
    'dbTablePrefixSeparator'    =>  '',
    'dbTablePrefix'             =>  '',

	// user name and password for MySQL admin user
	'dbAdminUser'               =>  'root',
	'dbAdminPassword'           =>  '',

	// Per-wiki image storage, filesystem path
	'perWikiStorageRoot'        => '',
	// Url
	'perWikiStorageUrl'         => '',

	// default skin
	'defaultSkin'               => 'monobook',
);

$root = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['MediaWikiFarmer'] = $root . 'Farmer.i18n.php';

$wgExtensionAliasesFiles['MediaWikiFarmer'] = $root . 'Farmer.alias.php';

$wgAutoloadClasses['MediaWikiFarmer'] = $root . 'MediaWikiFarmer.php';
$wgAutoloadClasses['MediaWikiFarmer_Extension'] = $root . 'MediaWikiFarmer_Extension.php';
$wgAutoloadClasses['MediaWikiFarmer_Wiki'] = $root . 'MediaWikiFarmer_Wiki.php';
$wgAutoloadClasses['SpecialFarmer'] = $root . 'SpecialFarmer.php';

$wgSpecialPages['Farmer'] = 'SpecialFarmer';
$wgSpecialPageGroups['Farmer'] = 'wiki';

# New permissions
$wgAvailableRights[] = 'farmeradmin';
$wgAvailableRights[] = 'createwiki';

$wgGroupPermissions['*']['farmeradmin'] = false;
$wgGroupPermissions['sysop']['farmeradmin'] = true;
$wgGroupPermissions['*']['createwiki'] = false;
$wgGroupPermissions['sysop']['createwiki'] = true;
