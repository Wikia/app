<?php

/**
 * WikiaSearch Helper
 * @author Rafal <rafal at wikia-inc.com>
 */

class WikiaSearchHelper extends WikiaModel {

	/**
	 * Convert 1000 to 1k
	 * TODO: should be abstracted and added to $wg->Lang
	 *
	 * @author Rafal
	 * @param int $number
	 * @param string $msgName
	 * @return function
	 */

	public function shortNumForMsg($number, $msgName) {
		if ($number >= 1000000) {
			$shortNum = floor($number / 1000000);
			$msgName = $msgName . '-M';
		} else if ($number >= 1000) {
			$shortNum = floor($number / 1000);
			$msgName = $msgName . '-k';
		} else {
			$shortNum = $number;
		}

		return wfMsg($msgName, $shortNum, $number);

	}
}
