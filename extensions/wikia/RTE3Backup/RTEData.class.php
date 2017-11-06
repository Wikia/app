<?php

class RTEData {

	private static $stackData = array();

	public static function put($stack, $data) {
		if(!isset(RTEData::$stackData[$stack])) {
			RTEData::$stackData[$stack] = array();
		}
		RTEData::$stackData[$stack][] = $data;
		return count(RTEData::$stackData[$stack]) - 1;
	}

	public static function get($stack, $index) {
		if(isset(RTEData::$stackData[$stack])) {
			if(isset(RTEData::$stackData[$stack][$index])) {
				return RTEData::$stackData[$stack][$index];
			}
		}
		return null;
	}

	/**
	 * Add data index as value of _rte_dataidx attribute to passed HTML
	 * TODO: Implement better replace logic which will make sure that attribute is really added to tag
	 *
	 * @author: Inez
	 */
	public static function addIdxToTag($dataIdx, $text) {
		$firstSpace = strpos($text, ' ');
		if($dataIdx === null || $firstSpace === false) {
			return $text;
		}
		return substr($text, 0, $firstSpace) . sprintf(' _rte_dataidx="%04d" ', $dataIdx) . substr($text, $firstSpace + 1);
	}

	public static function replaceIdxByData($var) {
		$data = RTEData::get('data', intval($var[1]));

		if (isset($data['type'])) {
			if(isset($data['wikitextIdx'])) {
				$data['wikitext'] = RTEData::get('wikitext', $data['wikitextIdx']);

				// macbre: correctly handle and unmark entities inside links wikitext (RT #38844)
				$data['wikitext'] = htmlspecialchars_decode($data['wikitext']);
				$data['wikitext'] = RTEParser::unmarkEntities($data['wikitext']);

				unset($data['wikitextIdx']);

				if(strpos($data['wikitext'], '_rte_wikitextidx') !== false) {
					RTE::$edgeCases[] = 'COMPLEX.01';
				} else if(strpos($data['wikitext'], '_rte_dataidx') !== false) {
					RTE::$edgeCases[] = 'COMPLEX.02';
				} else if($data['type'] == 'double-brackets') {
					if(strrpos($data['wikitext'], '{{') !== 0 && strpos($data['wikitext'], '{{') !== strlen($data['wikitext']) - 2) {
						RTE::$edgeCases[] = 'COMPLEX.03';
					}
				} else if(strpos($data['wikitext'] , "\x7f") !== false) {
					RTE::$edgeCases[] = 'COMPLEX.07';
				}

			}
		}

		return self::convertDataToAttributes($data);
	}

	public static function convertDataToAttributes($data) {
		// get ID of current CK instance
		$instance =  RTE:: getInstanceId();

		// properly encode JSON
		$encoded = RTEReverseParser::encodeRTEData($data);
		$encoded = Sanitizer::encodeAttribute($encoded);

		return " data-rte-meta=\"{$encoded}\" data-rte-instance=\"{$instance}\" ";
	}

	public static function addDataToTag($data, $text) {
		$firstSpace = strpos($text, ' ');
		if($data === null || $firstSpace === false) {
			return $text;
		}
		return substr($text, 0, $firstSpace) . ' ' . self::convertDataToAttributes($data) . ' ' . substr($text, $firstSpace + 1);
	}

	/**
	 * Checks if given wikitext contains unprocessed RTEData markers
	 *
	 * @author Macbre
	 */
	public static function checkWikitextForMarkers($wikitext) {
		return strpos($wikitext, "\x7f") !== false ||
			strpos($wikitext, '_rte_wikitextidx') !== false ||
			strpos($wikitext, '_rte_dataidx') !== false;
	}

	/**
	 * Replaces \x7f-03-xxxx markers (internal links) with wikitext (RT #90616)
	 *
	 * Returns true if any marker has been replaced.
	 *
	 * @author Macbre
	 */
	 public static function resolveLinksInMediaCaption(&$wikitext) {
		 wfProfileIn(__METHOD__);
		 $resolved = false;

		 // remove \x7f-03-xxxx markers
		 if (strpos($wikitext, "\x7f-" . RTEMarker::INTERNAL_WIKITEXT) !== false) {
			 $wikitext = preg_replace('/\x7f-' . RTEMarker::INTERNAL_WIKITEXT .'-\d{4}/', '', $wikitext);

			 $resolved = true;
		 }

		 wfProfileOut(__METHOD__);
		 return $resolved;
	 }
}
