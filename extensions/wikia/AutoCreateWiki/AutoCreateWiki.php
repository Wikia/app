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
	'author' => 'Krzysztof Krzyźaniak',
	'description' => 'Create wiki in WikiFactory by user requests'
);

/**
 * Set up the new special page
 */
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles[ "AutoCreateWiki" ] = $dir . "AutoCreateWiki.i18n.php";
$wgAutoloadClasses[ "AutoCreateWikiPage" ] = $dir. "AutoCreateWiki_body.php";
$wgSpecialPages[ "AutoCreateWiki" ] = "AutoCreateWikiPage";

#--- AutoCreateWiki class
require_once( dirname(__FILE__) . "/AutoCreateWiki_helper.php" );
#--- ajax functions
require_once( dirname(__FILE__) . "/AutoCreateWiki_ajax.php" );
global $wgAjaxExportList;
$wgAjaxExportList[] = 'axACWRequestCheckName';
$wgAjaxExportList[] = 'axACWRequestCheckAccount';
$wgAjaxExportList[] = 'axACWRequestCheckBirthday';
