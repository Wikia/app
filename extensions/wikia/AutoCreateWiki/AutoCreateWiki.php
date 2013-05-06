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
	'author' => array( 'Krzysztof Krzyżaniak', 'Piotr Molski' ),
	'description' => 'Create wiki in WikiFactory by user requests',
	'description-msg' => 'autocreatewiki-desc',
);

$dir = __DIR__ . '/';

/**
 * i18n - used in various places :(
 */
$wgExtensionMessagesFiles[ "AutoCreateWiki" ] = $dir . "AutoCreateWiki.i18n.php";

/**
 * user permissions
 */
$wgAvailableRights[] = 'createwikimakefounder'; // user can give another's name as founder
$wgAvailableRights[] = 'createwikilimitsexempt'; // user not bound by creation throttle
$wgGroupPermissions['staff']['createwikilimitsexempt'] = true;

/**
 * AutoCreateWiki class
 *
 * Used in CreateWiki.php and CreateNewWikiController
 */
require_once( $dir . "AutoCreateWiki_helper.php" );
