<?php

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'UserInterview',
	'author'         => 'Wikia',
	'descriptionmsg' => 'userinterview-desc',
);

$dir = dirname(__FILE__).'/';
// AUTOLOADS

// config
$wgAutoloadClasses['SpecialUserInterview'] = $dir.'specials/SpecialUserInterview.class.php';
$wgSpecialPages['UserInterview'] = 'SpecialUserInterview';

$wgExtensionFunctions[] = 'wfUserInterviewSetup';
$wgHooks['ParserFirstCallInit'][] = 'wfUserInterviewSetup_InstallParser';

function wfUserInterviewSetup() {
	global $wgHooks, $wgParser, $wgAdMarkerList;
	$wgAdMarkerList = array();
	$wgHooks['ParserAfterTidy'][] = 'wfInterviewAfterTidy';
}

function wfUserInterviewSetup_InstallParser( $parser ) {
	$parser->setHook( 'userinterview', 'wfUserInterviewParserHook' );
	return true;
}




function wfUserInterviewParserHook( $contents, $attributes, &$parser ) {
	global $wgAdMarkerList, $wgTitle;
	$marker = "xx-userinterview-xx";
	return $marker;
}

function wfInterviewAfterTidy( &$parser, &$text ) {
	// find markers in $text
	// replace markers with actual output
	global $wgAdMarkerList;
	$replaceUserInterview = strstr($text, 'xx-userinterview-xx');

	if ($replaceUserInterview == true) {
		$html = SpecialUserInterview::getUserAnswersHTML();
		$text = preg_replace( '/xx-userinterview-xx/', $html, $text );
	}
	return true;
}


$wgAjaxExportList[] = 'UserInterviewAjax';
function UserInterviewAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('UserInterviewAjax', $method)) {
		wfProfileIn(__METHOD__);

		// Don't let Varnish cache this.
		header("X-Pass-Cache-Control: max-age=0");

		//$data =array('status' => 'testing');

		$data = UserInterviewAjax::$method();
		// send array as JSON
		$json = Wikia::json_encode($data);
		$response = new AjaxResponse($json);
		$response->setCacheDuration(0); // don't cache any of these requests
		$response->setContentType('application/json; charset=utf-8');


		wfProfileOut(__METHOD__);
		return $response;
	}
}


class UserInterviewAjax{
	public static function submitUserForm() {
		SpecialUserInterview::saveUserAnswersAJAX();
		return array('status' => 'saved');
	}

	public static function submitAdminForm() {
		SpecialUserInterview::saveAdminQuestionsAjax();
		return array('status' => 'saved');
	}

}

