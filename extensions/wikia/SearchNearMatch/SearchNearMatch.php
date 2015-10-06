<?php
/**
 * search hook extending near matches to mixture of capital/not letters
 * at the beginning of words
 *
 * @author Przemek Piotrowski <ppiotr@wikia-inc.com>
 * @author Piotr Molski <moli@wikia-inc.com>
 * @see RT#4307 RT#11497
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension.\n";
	exit( 1 ) ;
}

/**
 * order is important, put heavy queries at the end
 */
$wgHooks['SearchGetNearMatch'][] = 'SearchNearMatch::allCapitalOneLower';
$wgHooks['SearchGetNearMatch'][] = 'SearchNearMatch::fullCapitalAndLowerMix';

class SearchNearMatch {
	/**
	 * @see SearchEngine::getNearMatch
	 */
	public static function checkGuesses($guesses, &$title) {
		foreach ($guesses as $guess) {
			$t = Title::newFromText($guess);
			if ($t && $t->exists()) {
				$title = $t;
				return false;
			}
		}

		return true;
	}

	/**
	 * very ascii oriented FIXME
	 *
	 * @input  'ala ma kota'
	 * @output  array('Ala Ma kota', 'Ala ma Kota')
	 *
	 * @see Language::ucwordbreaks etc.
	 */
	public static function allCapitalOneLower($term, &$title) {
		$guesses = array();

		$words = ucwords(strtolower($term));
		$words = preg_split('/\s/', $words, -1, PREG_SPLIT_NO_EMPTY);
		if (7 < sizeof($words)) {
			// PHP Fatal error:  Allowed memory size exhausted...
			return true;
		}

		// first word is always upercase, no need to mutate
		$first_word = array_shift($words);

		$heap = array();
		$heap[] = join(' ', $words);

		for ($i = 0; $i < sizeof($words); $i++) {
			$temp = $words;
			//$temp[$i] = lcfirst($temp[$i]);
			// very funny )-: lcfirst does not exist in php
			$temp[$i] = strtolower($temp[$i]);
			$heap[] = join(' ', $temp);
		}

		foreach ($heap as $mutation) {
			$guesses[] = $first_word . ' ' . $mutation;
		}

		$result = self::checkGuesses($guesses, $title);
		return $result;
	}

	/**
	 * @see self::allCapitalOneLower for FIXME and comments
	 *
	 * @input  'ala ma kota'
	 * @output  array('Ala Ma Kota', 'Ala Ma kota', 'Ala ma Kota', 'Ala ma kota')
	 */
	public static function fullCapitalAndLowerMix($term, &$title) {
		$guesses = array();

		$words = ucwords(strtolower($term));
		$words = preg_split('/\s/', $words, -1, PREG_SPLIT_NO_EMPTY);
		if (7 < sizeof($words)) {
			// PHP Fatal error:  Allowed memory size exhausted...
			return true;
		}

		// first word is always upercase, no need to mutate
		$first_word = array_shift($words);

		$heap = array();
		$heap[] = join(' ', $words);

		self::fullCapitalAndLowerMixMagic($words, $heap);
		$heap = array_unique($heap);

		foreach ($heap as $mutation) {
			$guesses[] = $first_word . ' ' . $mutation;
		}

		$result = self::checkGuesses($guesses, $title);
		return $result;
	}

	private static function fullCapitalAndLowerMixMagic($words, &$heap) {
		for ($i = 0; $i < sizeof($words); $i++) {
			if ($words[$i] != strtolower($words[$i])) {
				$temp = $words;
				$temp[$i] = strtolower($temp[$i]);
				$heap[] = join(' ', $temp);

				self::fullCapitalAndLowerMixMagic($temp, $heap);
			}
		}
	}
}
