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
$wgAutoloadClasses['SponsorshipDashboard']	= $dir . 'SponsorshipDashboard.body.php';
$wgAutoloadClasses['SponsorshipDashboardService'] = $dir . 'SponsorshipDashboardService.class.php';

// report class
$wgAutoloadClasses['SponsorshipDashboardReports'] = $dir . 'SDReports.class.php';
$wgAutoloadClasses['SponsorshipDashboardReport'] = $dir . 'SDReport.class.php';
$wgAutoloadClasses['SponsorshipDashboardGroups'] = $dir . 'SDGroups.class.php';
$wgAutoloadClasses['SponsorshipDashboardGroup'] = $dir . 'SDGroup.class.php';
$wgAutoloadClasses['SponsorshipDashboardUsers'] = $dir . 'SDUsers.class.php';
$wgAutoloadClasses['SponsorshipDashboardUser'] = $dir . 'SDUser.class.php';

// report sources
$wgAutoloadClasses['SponsorshipDashboardSourceGapi'] = $dir . 'sources/SDSourceGapi.class.php';
$wgAutoloadClasses['SponsorshipDashboardSourceGapiCu'] = $dir . 'sources/SDSourceGapiCu.class.php';
$wgAutoloadClasses['SponsorshipDashboardSourceStats'] = $dir . 'sources/SDSourceStats.class.php';
$wgAutoloadClasses['SponsorshipDashboardSourceOneDot'] = $dir . 'sources/SDSourceOneDot.class.php';
$wgAutoloadClasses['SponsorshipDashboardSourceMobile'] = $dir . 'sources/SDSourceMobile.class.php';
$wgAutoloadClasses['SponsorshipDashboardSource'] = $dir . 'sources/SDSource.class.php';

// date provider classes
$wgAutoloadClasses['SponsorshipDashboardDateProvider'] = $dir . 'SDDateProvider.class.php';
$wgAutoloadClasses['SponsorshipDashboardDateProviderDay'] = $dir . 'SDDateProvider.class.php';
$wgAutoloadClasses['SponsorshipDashboardDateProviderMonth'] = $dir . 'SDDateProvider.class.php';
$wgAutoloadClasses['SponsorshipDashboardDateProviderYear'] = $dir . 'SDDateProvider.class.php';

// output formater classes
$wgAutoloadClasses['SponsorshipDashboardOutputFormatter'] = $dir . 'output/SDOutputFormatter.class.php';
$wgAutoloadClasses['SponsorshipDashboardOutputChart'] = $dir . 'output/SDOutputChart.class.php';
$wgAutoloadClasses['SponsorshipDashboardOutputTable'] = $dir . 'output/SDOutputTable.class.php';
$wgAutoloadClasses['SponsorshipDashboardOutputCSV'] = $dir . 'output/SDOutputCSV.class.php';

// Ajax
$wgAutoloadClasses[ 'SponsorshipDashboardAjax' ]		= $dir . 'SponsorshipDashboardAjax.class.php';

$wgAutoloadClasses['gapi'] = $dir . '../../../lib/gapi/gapi.class.php';

$wgExtensionMessagesFiles['SponsorshipDashboard'] = $dir . 'SponsorshipDashboard.i18n.php';

$wgSpecialPages['SponsorshipDashboard']		= 'SponsorshipDashboard';
$wgSpecialPageGroups['SponsorshipDashboard']	= 'wikia';

$wgAjaxExportList[] = 'SponsorshipDashboardAjax';

// permissions
$wgAvailableRights[] = 'wikimetrics';
$wgGroupPermissions['*']['wikimetrics'] = false;
$wgGroupPermissions['staff']['wikimetrics'] = true;

function SponsorshipDashboardAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);
	if ( method_exists('SponsorshipDashboardAjax', $method) ) {
		$data = SponsorshipDashboardAjax::$method();
		wfProfileIn(__METHOD__);
		if (is_array($data)) {
			// send array as JSON
			$json = Wikia::json_encode($data);
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

