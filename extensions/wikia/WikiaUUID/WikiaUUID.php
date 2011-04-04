<?php
/**
 * WikiaUUID
 *
 * A simple extention to create UUIDs based on time and a random number.
 *
 * @file
 * @ingroup Extensions
 * @author Garth Webb <garth@wikia-inc.com>
 * @date 2011-03-28
 * @copyright Copyright © 2011 Garth Webb, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named WikiaUUID.\n";
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'WikiaUUID',
	'author' => "[http://www.wikia.com/wiki/User:Garthwebb]",
	'descriptionmsg' => 'wikia-uuid-desc'
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['WikiaUUID'] = "$dir/WikiaUUID.class.php";

// i18n
$wgExtensionMessagesFiles['WikiaUUID'] = $dir.'/WikiaUUID.i18n.php';

// Ajax exports
$wgAjaxExportList[] = 'WikiaUUID::getUUID';
