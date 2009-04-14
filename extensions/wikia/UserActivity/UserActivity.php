<?php
/**
 * @file
 * @ingroup Extensions
 * @author NY
 * @copyright © 2009, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

$dir = dirname(__FILE__);
require_once( "$dir/SpecialUserActivity.php" );
require_once( "$dir/SiteActivityHook.php" );
require_once( "$dir/UserActivityClass.php" );
