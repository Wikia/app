<?php
/**
 * Javascript unit test runner and integration with wikia's stack Selenium + CruiseControl
 *
 * @ingroup Wikia
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 * @copyright Copyright © 2011, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if(!defined('MEDIAWIKI')) die("This is MediaWiki extension and cannot be used standalone.");

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'JavascriptUnitTest',
	'author'         => array( 'Władysław Bodzek' ),
	'url'            => '',
	'description'    => 'Javascript test runner',
	'descriptionmsg' => 'javascripttestrunner-desc',
);

$dir = dirname(__FILE__) . '/';


//special pages
$wgSpecialPages['JavascriptTestRunner'] = 'SpecialJavascriptTestRunner';
$wgSpecialPageGroups['JavascriptTestRunner'] = 'wikia';

//rights
$wgAvailableRights[] = 'javascripttestrunner';
$wgGroupPermissions['*']['javascripttestrunner'] = false;
$wgGroupPermissions['staff']['javascripttestrunner'] = true;

//internationalization files
$wgExtensionMessagesFiles['JavascriptTestRunner'] = $dir . 'JavascriptTestRunner.i18n.php';

//classes
$wgAutoloadClasses['SpecialJavascriptTestRunner'] = dirname( __FILE__ ) . '/SpecialJavascriptTestRunner.class.php';
$wgAutoloadClasses['JavascriptTestFramework'] = dirname( __FILE__ ) . '/JavascriptTestFramework.class.php';
$wgAutoloadClasses['JavascriptTestFramework_QUnit'] = dirname( __FILE__ ) . '/JavascriptTestFramework_QUnit.class.php';
$wgAutoloadClasses['JavascriptTestFramework_jsUnity'] = dirname( __FILE__ ) . '/JavascriptTestFramework_jsUnity.class.php';

