<?php

if (!defined('MEDIAWIKI')) die();

/**
 * Class that holds static functions for handling compound queries.
 * This class is heavily based on Semantic MediaWiki's SMWQueryProcessor,
 * and calls that class's functions when possible.
 *
 * @ingroup SemanticCompoundQueries
 * @author Yaron Koren
 */
class SCQQueryProcessor {

	public static function registerParserFunctions(&$parser) {
		$parser->setFunctionHook( 'compound_query', array('SCQQueryProcessor','doCompoundQuery') );
		return true; // always return true, in order not to stop MW's hook processing!
	}

	/**
	 * An alternative to explode() - that function won't work here,
	 * because we don't want to split the string on all semicolons, just
	 * the ones that aren't contained within square brackets
	 */
	public static function getSubParams($param) {
		$sub_params = array();
		$sub_param = "";
		$uncompleted_square_brackets = 0;
		for ($i = 0; $i < strlen($param); $i++) {
			$c = $param[$i];
			if (($c == ';') && ($uncompleted_square_brackets <= 0)) {
				$sub_params[] = $sub_param;
				$sub_param = "";
			} else {
				$sub_param .= $c;
				if ($c == '[')
					$uncompleted_square_brackets++;
				elseif ($c == ']')
					$uncompleted_square_brackets--;
			}
		}
		$sub_params[] = $sub_param;
		return $sub_params;
	}

	/**
	 */
	public static function doCompoundQuery(&$parser) {
		global $smwgQEnabled, $smwgIQRunningNumber;
		if ($smwgQEnabled) {
			$smwgIQRunningNumber++;
			$params = func_get_args();
			array_shift( $params ); // we already know the $parser ...
			$other_params = array();
			$query_result = null;
			foreach ($params as $param) {
				// very primitive heuristic - if the parameter
				// includes a square bracket, then it's a
				// sub-query; otherwise it's a regular parameter
				if (strpos($param, '[') !== false) {
					$sub_params = SCQQueryProcessor::getSubParams($param);
					$next_result = SCQQueryProcessor::getQueryResultFromFunctionParams($sub_params, SMW_OUTPUT_WIKI);
					if ($query_result == null)
						$query_result = new SCQQueryResult($next_result->getPrintRequests(), new SMWQuery());
					$query_result->addResult($next_result);
				} else {
					$parts = explode('=', $param, 2);
					if (count($parts) >= 2) {
						$other_params[strtolower(trim($parts[0]))] = $parts[1]; // don't trim here, some params care for " "
					}
				}
			}
			$result = SCQQueryProcessor::getResultFromQueryResult($query_result, $other_params, null, SMW_OUTPUT_WIKI);
		} else {
			wfLoadExtensionMessages('SemanticMediaWiki');
			$result = smwfEncodeMessages(array(wfMsgForContent('smw_iq_disabled')));
		}
		return $result;
	}

	static function getQueryResultFromFunctionParams($rawparams, $outputmode, $context = SMWQueryProcessor::INLINE_QUERY, $showmode = false) {
		SMWQueryProcessor::processFunctionParams($rawparams,$querystring,$params,$printouts,$showmode);
		return SCQQueryProcessor::getQueryResultFromQueryString($querystring,$params,$printouts, SMW_OUTPUT_WIKI, $context);
	}

	/**
	 * Combine the values from two SMWQueryResult objects into one
	 */
	static function mergeSMWQueryResults($result1, $result2) {
		if ($result1 == null) {
			$result1 = new SMWQueryResult($result2->getPrintRequests(), new SMWQuery());
		}
		$existing_page_names = array();
		while ($row = $result1->getNext()) {
			if ($row[0] instanceof SMWResultArray) {
				$content = $row[0]->getContent();
				$existing_page_names[] = $content[0]->getLongText(SMW_OUTPUT_WIKI);
			}
		}
		while (($row = $result2->getNext()) !== false) {
			$row[0]->display_options = $result2->display_options;
			$content = $row[0]->getContent();
			$page_name = $content[0]->getLongText(SMW_OUTPUT_WIKI);
			if (! in_array($page_name, $existing_page_names))
				$result1->addRow($row);
		}
		return $result1;
	}

	// this method is an exact copy of SMWQueryProcessor's function,
	// but it needs to be duplicated because there it's protected
	static function getResultFormat($params) {
		$format = 'auto';
		if (array_key_exists('format', $params)) {
			$format = strtolower(trim($params['format']));
			global $smwgResultFormats;
			if ( !array_key_exists($format, $smwgResultFormats) ) {
				$format = 'auto'; // If it is an unknown format, defaults to list/table again
			}
		}
		return $format;
	}

	static function getQueryResultFromQueryString($querystring, $params, $extraprintouts, $outputmode, $context = SMWQueryProcessor::INLINE_QUERY) {
		wfProfileIn('SCQQueryProcessor::getQueryResultFromQueryString');
		$query  = SMWQueryProcessor::createQuery($querystring, $params, $context, null, $extraprintouts);
		$query_result = smwfGetStore()->getQueryResult($query);
		$query_result->display_options = array();
		foreach ($params as $key => $value) {
			// special handling for 'icon' field, since it requires
			// conversion of a name to a URL
			if ($key == 'icon') {
				$icon_title = Title::newFromText($value);
				$icon_image_page = new ImagePage($icon_title);
				// method was only added in MW 1.13
				if (method_exists('ImagePage', 'getDisplayedFile')) {
					$icon_url = $icon_image_page->getDisplayedFile()->getURL();
					$query_result->display_options['icon'] = $icon_url;
				}
			} else {
				$query_result->display_options[$key] = $value;
			}
		}

		wfProfileOut('SCQQueryProcessor::getQueryResultFromQueryString');
		return $query_result;
	}

	/*
	 * Matches getResultFromQueryResult() from SMWQueryProcessor,
	 * except that formats of type 'debug' and 'count' aren't handled
	 */
	static function getResultFromQueryResult($res, $params, $extraprintouts, $outputmode, $context = SMWQueryProcessor::INLINE_QUERY, $format = '') {
		wfProfileIn('SCQQueryProcessor::getResultFromQueryResult');
		$format = SCQQueryProcessor::getResultFormat($params);
		$printer = SMWQueryProcessor::getResultPrinter($format, $context, $res);
		$result = $printer->getResult($res, $params, $outputmode);
		wfProfileOut('SCQQueryProcessor::getResultFromQueryResult');
		return $result;
	}
}

