<?php
/**
 *
 * @package MediaWiki
 * @subpackage SponsorshipDashboard
 * @author Jakub Kurcek
 *
 * To use this extension $wgEnableSponsorshipDashboardExt = true
 */

if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SponsorshipDashboard',
	'descriptionmsg' => 'sponsorshipdashboard-desc',
	'author' => 'Jakub Kurcek',
);

$dir = dirname(__FILE__) . '/';

require_once( $dir . '/SponsorshipDashboard_autoload.php' );

$wgExtensionMessagesFiles['SponsorshipDashboard'] = $dir . 'SponsorshipDashboard.i18n.php';

$wgAjaxExportList[] = 'SponsorshipDashboardAjax';

function SponsorshipDashboardAjax() {
	global $wgRequest;
	wfProfileIn(__METHOD__);
	$method = $wgRequest->getVal('method', false);
	if ( method_exists('SponsorshipDashboardAjax', $method) ) {
		$data = SponsorshipDashboardAjax::$method();
		if (is_array($data)) {
			// send array as JSON
			$json = json_encode($data);
			$response = new AjaxResponse($json);
			$response->setContentType('application/json; charset=utf-8');
		}
		else {
			// send text as text/html
			$response = new AjaxResponse($data);
			$response->setContentType('text/html; charset=utf-8');
		}
	}
	wfProfileOut(__METHOD__);
	return $response;
}

