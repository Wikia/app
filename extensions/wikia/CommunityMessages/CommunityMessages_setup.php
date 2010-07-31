<?php
/**
 * CommunityMessages
 *
 * A CommunityMessages extension for MediaWiki
 * Helper extension for Community Messages
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-07-30
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/CommunityMessages/CommunityMessages_setup.php");
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named CommunityMessages.\n";
	exit( 1 ) ;
}

$wgExtensionCredits['other'][] = array(
	'name' => 'CommunityMessages',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description' => 'Helper extension for Community Messages.',
	'description-msg' => 'communitymessages-desc',
);

$wgExtensionFunctions[] = 'CommunityMessagesInit';
$wgExtensionMessagesFiles['CommunityMessages'] = dirname( __FILE__ ) . '/CommunityMessages.i18n.php';
$wgAutoloadClasses['CommunityMessages'] = "$IP/extensions/wikia/CommunityMessages/CommunityMessages.class.php";
// FIXME: $dir not defined?
$wgAutoloadClasses['CommunityMessagesAjax'] = "$dir/CommunityMessagesAjax.class.php";

/**
 * Initialize hooks
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function CommunityMessagesInit() {
	global $wgHooks;

	$wgHooks['SkinTemplatePageBeforeUserMsg'][] = 'CommunityMessages::SkinTemplatePageBeforeUserMsg';
}

// Ajax dispatcher
$wgAjaxExportList[] = 'CommunityMessagesAjax';
function CommunityMessagesAjax() {
	global $wgUser, $wgRequest;
	$method = $wgRequest->getVal( 'method', false );

	if ( method_exists( 'CommunityMessagesAjax', $method ) ) {
		wfProfileIn( __METHOD__ );
		wfLoadExtensionMessages( 'CommunityMessages' );

		$data = CommunityMessagesAjax::$method();

		if ( is_array( $data ) ) {
			// send array as JSON
			$json = Wikia::json_encode( $data );
			$response = new AjaxResponse( $json );
			$response->setContentType( 'application/json; charset=utf-8' );
		}
		else {
			// send text as text/html
			$response = new AjaxResponse( $data );
			$response->setContentType( 'text/html; charset=utf-8' );
		}

		wfProfileOut( __METHOD__ );
		return $response;
	}
}
