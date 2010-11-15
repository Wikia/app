<?php
/**
 * MobileApp
 *
 *A set of experimental APIs for Wikia mobile app
 *
 * @file
 * @ingroup Extensions
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @date 2010-11-15
 * @version 1.0
 * @copyright Copyright © 2010 Federico "Lox" Lucignano, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named MobileApp.\n";
	exit ( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'MobileApp',
	'version' => '1.0',
	'author' => array(
		'Federico "Lox" Lucignano'
	),
	'descriptionmsg' => 'mobileapp-desc'
);

//constants
define('MOBILEAPP_WF_RECOMMEND_VAR', 'wgMobileAppRecommend');
define('MOBILEAPP_WF_CATEGORY_VAR', 'wgMobileAppCategory');

$dir = dirname( __FILE__ ) . '/';

// classes
$wgAutoloadClasses['MobileAppHelper'] = $dir . 'MobileAppHelper.class.php';

// i18n
$wgExtensionMessagesFiles['MobileApp'] = $dir . '/MobileApp.i18n.php';

//ajax exports
global $wgAjaxExportList;

$wgAjaxExportList[] = 'MobileAppHelper::getRecommendedWikis';