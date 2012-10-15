<?php

/*
 * @author: Piotr Pawlowski
 *
 * This class uses some functionality of FogbugzService class and provides usage
 * of special tags: <fogbugz_tck id="ticket_id"></fogbugz_tck>
 * Putting these tags in article will result in loading info about particular fogbugz case
 * and all it's subcases.
 * TO DO: add possibility of showing comments for each of displayed cases and hide them.
 */

class FogbugzTag {
	public function __construct() {
	}

	private static $mWikitextIdx;

	//private static $frame;

	public function onFogbugzTagInit(Parser $parser) {
		$parser->setHook('fogbugz_tck', 'FogbugzTag::renderTag');
		return true;
	}

	public function renderTag($input, $params, Parser $parser, PPFrame $frame) {
		//$this->frame = $frame;
		global $wgRTEParserEnabled, $wgHTTPProxy, $wgFogbugzAPIConfig,
			   $wgCaptchaDirectory, $wgCaptchaDirectoryLevels, $wgStylePath;

		if (!isset($params['id'])) {
			return '';
		}

		$output = Xml::openElement('span', array('class' => 'fogbugz_tck', 'data-id' => $parser->recursiveTagParse($params['id'], $frame)));
		//$output .= $input;
		$output .= Xml::openElement('img', array('src' => $wgStylePath . '/common/images/ajax.gif'));
		$output .= Xml::closeElement('span');

		$data = array(
			'wikitext' => RTEData::get('wikitext', self::$mWikitextIdx),
			'placeholder' => 1
		);
		//$dataIdx = RTEData::put('data', $data);
		//$output = RTEData::addIdxToTag($dataIdx, $output);
		$output .= F::build('JSSnippets')->addToStack(array('/extensions/wikia/FogbugzTag/js/FogbugzTag.js'));
		return $output;
	}

	/**
	 *
	 * cmd posible values:
	 * 'getCasesInfo' - in response there will be returned set of cases and subcases info formated in WikiText
	 * 'getComment' - in response there will be returned comments for particular case
	 */
	public static function getFogbugzServiceResponse() {
		global $wgRequest, $wgHTTPProxy, $wgFogbugzAPIConfig;

		$command = $wgRequest->getText('cmd');
		$myFBService = new FogbugzService($wgFogbugzAPIConfig['apiUrl'], $wgFogbugzAPIConfig['username'],
			$wgFogbugzAPIConfig['password'], $wgHTTPProxy
		);

		// there should be made some kind of protection from setting different value as cmd
		if ($command == 'getCasesInfo') {
			$outerIDs = $wgRequest->getArray('IDs');
			$results = array();

			try {
				$results = $myFBService->logon()->getCasesBasicInfo($outerIDs);
			} catch (Exception $e) {
				$results = array();
			}

			$preparedResults = FogbugzTag::sortAndMakeTickets($results);
			$response = new AjaxResponse();
			$response->addText(json_encode($preparedResults));
		}
		else { // this part is not in use now; it will be after adding displaying comments
			$outerIDs = $wgRequest->getText('ID');

			/* ... */
		}

		if (!$response) {
			$response = new AjaxResponse();
			$response->addText(json_encode(array('status' => wfMsg('fbtag-unknown-error'))));
		}

		return $response;
	}

	/**
	 *
	 * Sort tickets in order that should be displayed on target page and prepare html
	 * @param array $ticketsArray - array with
	 */

	private function sortAndMakeTickets(Array $ticketsArray) { //$addCommentClass = false ) {
		global $wgTitle;
		$fogbugzTicketsHtmlReady = array();
		$splitedResults = array();

		$res = array();

		$mainList = array();
		$index = -1;

		$isDone = false;

		while ($isDone == false && $index < count($ticketsArray)) {
			++$index;
			for ($i = 0; $i < $index; $i++) {
				if (!empty($ticketsArray[$index]) &&
					!($ticketsArray[$i]['ixBug'] != $ticketsArray[$index]['ixBugParent'])
				) {
					$isDone = true;
				}
			}
		} // we have prepared list of cases from page (main cases that has been written as tags)

		for ($i = 0; $i < $index; $i++) {
			$mainList[] = new FogbugzContainer($ticketsArray[$i]);
			$mainList[$i]->addChildren($ticketsArray);
			$mainList[$i]->prioritySort();
			$mainList[$i]->prepareHtml($res, $i);
		}

		$tmpParser = new Parser();
		$tmpParser->setOutputType(OT_HTML);
		$tmpParserOptions = new ParserOptions();
		$parsedResults = array();

		//return $res;

		//TODO: create templating system

		for ($i = 0; $i < count($res); $i++) {
			$fullInfo = implode("", $res[$i]);
			$parsedResults[$i] = $tmpParser->parse($fullInfo, $wgTitle, $tmpParserOptions)->getText();
		}
		return $parsedResults;
	}

	private function makeComments(Array $commentsArray) { // function not in use
		$fogbugzCommentsHtmlReady = array();
	}
}
