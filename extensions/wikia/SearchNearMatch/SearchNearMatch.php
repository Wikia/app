<?php
/**
 * search hook extending near matches to mixture of capital/not letters
 * at the beginning of words
 * + shared help
 * + link suggest emulation TODO
 * + full capital/not mix
 *
 * @author Przemek Piotrowski <ppiotr@wikia-inc.com>
 * @see RT#4307
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

if ($wgWikiaEnableSharedHelpExt) {
	$wgHooks['SearchGetNearMatch'][] = 'SearchNearMatch::checkHelpWikia';
}

if ($wgEnableLinkSuggestExt) {
	$wgHooks['SearchGetNearMatch'][] = 'SearchNearMatch::emulateLinkSuggest';
}


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
		$words = explode(' ', $words);
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

		return self::checkGuesses($guesses, $title);
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
		$words = explode(' ', $words);
		$first_word = array_shift($words);

		$heap = array();
		$heap[] = join(' ', $words);

		self::fullCapitalAndLowerMixMagic($words, $heap);
		$heap = array_unique($heap);

		foreach ($heap as $mutation) {
			$guesses[] = $first_word . ' ' . $mutation;
		}

		return self::checkGuesses($guesses, $title);
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

	/**
	 * @see getLinkSuggest in LinkSuggest.php 
	 */
	public static function emulateLinkSuggest($term, &$title) {
		$guesses = array();

/*
		TODO
		decouple getLinkSuggest into engine and ajax wrapper
		use engine here
*/
		return self::checkGuesses($guesses, $title);
	}

	/**
	 * page Help:Foo may not/semi/exists via shared help.wikia
	 *
	 * FIXME do it only for help namespace?
	 */
	public static function checkHelpWikia($term, &$title) {
		$guesses = array();

		$data = Http::get('http://help.wikia.com/api.php?action=opensearch&search=' . $term . '&namespace=12');
		if (preg_match('/^\["' . $term . '",\["(.*)"\]\]$/', $data, $matches)) {
			$guesses = split('","', $matches[1]);
		}

		//return self::checkGuesses($guesses, $title);
		// not this time, it does not exist here for sure
		// however, it surely exists via shared help
		if (!empty($guesses[0])) {
			$title = Title::newFromText($guesses[0]);
			return false;
		}

		return true;
	}
}

