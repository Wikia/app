<?php

class RTEMarker {

	const PLACEHOLDER = '01';
	const EXTERNAL_WIKITEXT = '02';
	const INTERNAL_WIKITEXT = '03';
	const IMAGE_DATA = '04';
	const INTERNAL_DATA = '05';
	const EXTERNAL_DATA = '06';
	const EXT_WIKITEXT = '07';

	/**
	 * Generate marker for passed marker type and data index
	 * Example: \x7f-01-0001
	 *
	 * @author: Inez Korczyński
	 */
	public static function generate($type, $dataIdx) {
		return sprintf("\x7f-%s-%04d", $type, $dataIdx);
	}

	/**
	 * Return data index stored at the beginning of the passed text, from which marker is deleted by default.
	 *
	 * @author: Inez Korczyński
	 */
	public static function getDataIdx($type, &$text, $cut = true) {
		$dataIdx = null;
		if(strpos($text, "\x7f-" . $type . '-') === 0) {
			$dataIdx = intval(substr($text, 5, 4));
			if($cut) {
				$text = substr($text, 9);
			}
		}
		return $dataIdx;
	}

}