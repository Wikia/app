<?php
/**
 * SoftwareVersion extension - customizes Special:Version for ShoutWiki
 * by changing MediaWiki's version to $wgVersion and adding ShoutWiki component
 *
 * @file
 * @ingroup Extensions
 * @version 0.4
 * @author Jack Phoenix <jack@shoutwiki.com>
 * @copyright Copyright © 2009-2010 Jack Phoenix
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'SoftwareVersion',
	'author' => 'Jack Phoenix',
	'version' => '0.4',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SoftwareVersion',
	'description' => 'Customizes [[Special:Version]] for ShoutWiki',
);

// Our hooked function
$wgHooks['SoftwareInfo'][] = 'efAddShoutWikiInfo';

/**
 * Adds ShoutWiki component into Special:Version and sets MW's version to $wgVersion
 *
 * @param $software Array: array of software information
 * @return Boolean: true
 */
function efAddShoutWikiInfo( &$software ) {
	global $wgVersion, $IP;

	// Set MW version to $wgVersion
	$software['[http://www.mediawiki.org/ MediaWiki]'] = $wgVersion;

	// Add ShoutWiki component (release branch name) and its revision number
	$software['[http://www.shoutwiki.com/ ShoutWiki]'] = efGetSvnURL( $IP ) . ' (r' . SpecialVersion::getSvnRevision( $IP ) . ')';

	return true;
}

// Gets the name of the release for Special:Version's "ShoutWiki" column
// Copied from Wikia's SpecialVersion.php and modified
function efGetSvnURL( $dir ) {
	// http://svnbook.red-bean.com/nightly/en/svn.developer.insidewc.html
	$entries = $dir . '/.svn/entries';

	if( !file_exists( $entries ) ) {
		return false;
	}

	$content = file( $entries );

	$ret = str_replace( rtrim( $content[5] ), '', rtrim( $content[4] ) );
	// Convert /trunk to trunk
	if ( strpos( $ret, '/trunk' ) !== false ) {
		$ret = str_replace( '/', '', $ret );
	// and /tags/weekly/<release date> to just plain <release date>
	} elseif ( strpos( $ret, '/tags/weekly/' ) !== false ) {
		$ret = str_replace( '/tags/weekly/', '', $ret );
	}

	return $ret;
}