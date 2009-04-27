<?php
/**
 * Lazy loader for Special:AutoCreateWiki
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia.com
 * @copyright © 2009, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

/**
 * Extension credits that will show up on Special:Version
 */
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'AutoCreateWiki',
	'version' => '1.0',
	'author' => 'Krzysztof Krzyżaniak, Piotr Molski',
	'description' => 'Create wiki in WikiFactory by user requests'
);

/**
 * Set up the new special page
 */
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles[ "AutoCreateWiki" ] = $dir . "AutoCreateWiki.i18n.php";
$wgAutoloadClasses[ "AutoCreateWikiPage" ] = $dir. "AutoCreateWiki_body.php";
$wgAutoloadClasses[ "TextRegexCore" ] = "$IP/extensions/wikia/TextRegex/TextRegex.php";
$wgSpecialPages['CreateWiki'] = 'AutoCreateWikiPage';
$wgSpecialPageGroups['CreateWiki'] = 'wikia';

/**
 * register job class
 */
$wgJobClasses[ "ACWLocal" ] = "AutoCreateWikiLocalJob";
$wgAutoloadClasses[ "AutoCreateWikiLocalJob" ] = $dir. "AutoCreateWikiLocalJob.php";

/**
 * AutoCreateWiki class
 */
require_once( $dir . "AutoCreateWiki_helper.php" );

/**
 * ajax functions
 */
require_once( $dir . "AutoCreateWiki_ajax.php" );

global $wgAjaxExportList;
$wgAjaxExportList[] = 'axACWRequestCheckName';
$wgAjaxExportList[] = 'axACWRequestCheckAccount';
$wgAjaxExportList[] = 'axACWRequestCheckBirthday';
$wgAjaxExportList[] = 'axACWRequestCheckLog';
$wgAjaxExportList[] = 'axACWRequestCheckWikiName';
