<?php
/**
 * @author Sean Colombo
 * @date 20111001
 *
 * Setup page for Special page to wrap API Gate
 *
 * API Gate (while developed in-house) is an external library in the sense that
 * it is not MediaWiki-dependent.  This extension will be the MediaWiki integration with it.
 *
 * The Special:ApiGate page itself will be the landing page for users to manage keys.  It
 * handles requesting keys,
 *
 * @ingroup SpecialPage
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

$API_GATE_DIR = "$IP/lib/vendor/ApiGate"; // this is used for more than just the initial include, please don't remove it.
include "$API_GATE_DIR/ApiGate.php";

// TODO: Change to class autoloader.
include dirname( __FILE__ ) . '/SpecialApiGate.class.php';

$wgSpecialPages[ "ApiGate" ] = "SpecialApiGate";
$wgExtensionMessagesFiles['ApiGate'] = dirname( __FILE__ ) . '/SpecialApiGate.i18n.php';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ApiGate',
	'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'descriptionmsg' => 'apigate-desc',
	'version' => '1.0',
);

$wgHooks['PersonalUrls'][] = "SpecialApiGate::onPersonalUrls";
$wgHooks['AccountNavigationModuleAfterDropdownItems'][] = "SpecialApiGate::onAccountNavigationModuleAfterDropdownItems";

// Since API Gate is an external system, instead of trying to do granular rights (which are a cool feature) it makes sense
// to just do a single right for superuser power in API Gate since it really doesn't make sense to have any "partial" admins.
$wgAvailableRights[] = 'apigate_admin';
$wgGroupPermissions['*']['apigate_admin'] = false;
$wgGroupPermissions['staff']['apigate_admin'] = true;
