<?php
/**
 * CommentCSV
 *
 * This extension enables users with access rights to download article and blog comments
 * as a CSV file.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Grunwell (grunny) <daniel@wikia-inc.com>
 * @date 2012-06-19
 * @copyright Copyright © 2011 Daniel Grunwell, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
 
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'CommentCSV',
	'author' => "[http://www.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]",
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CommentCSV',
	'descriptionmsg' => 'commentcsv-desc'
);

$dir = dirname(__FILE__) . '/';

//i18n
$wgExtensionMessagesFiles['CommentCSV'] = $dir . 'CommentCSV.i18n.php';

$wgAutoloadClasses['CommentCSV'] = $dir . '/CommentCSV.class.php';

$wgHooks['UnknownAction'][] = 'CommentCSV::onCommentCSVDownload';

