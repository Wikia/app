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

/**
 * Set up the new special page
 */
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles[ "AutoCreateWiki" ] = $dir . "AutoCreateWiki.i18n.php";
$wgAutoloadClasses[ "AutoCreateWikiPage" ] = $dir. "AutoCreateWiki_body.php";
$wgAutoloadClasses[ "AutoCreateAnswersPage" ] = $dir. "AutoCreateWiki_body.php";
$wgAutoloadClasses[ "TextRegexCore" ] = "$IP/extensions/wikia/TextRegex/TextRegex.php";
$wgSpecialPages['CreateWiki'] = 'AutoCreateWikiPage';
$wgSpecialPages['CreateAnswers'] = 'AutoCreateAnswersPage';
$wgSpecialPageGroups['CreateWiki'] = 'wikia';
$wgSpecialPageGroups['CreateAnswers'] = 'wikia';

/**
 * user permissions
 */
$wgAvailableRights[] = 'createwikimakefounder'; // user can give another's name as founder
$wgAvailableRights[] = 'createwikilimitsexempt'; // user not bound by creation throttle
$wgGroupPermissions['staff']['createwikilimitsexempt'] = true;

/**
 * register job class
 */
$wgJobClasses[ "ACWLocal" ] = "AutoCreateWikiLocalJob";
$wgAutoloadClasses[ "AutoCreateWikiLocalJob" ] = $dir. "AutoCreateWikiLocalJob.php";

/**
 * generic.starter DB name
 */
define( 'AWC_GENERIC_STARTER', 'aastarter' );

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
