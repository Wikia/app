<?php

/**
 * Turkish (Türkçe)
 *
 * The Turkish language, like other Turkic languages, distinguishes
 * a dotted letter 'i' from a dotless letter 'ı' (U+0131 LATIN SMALL LETTER DOTLESS I).
 * In these languages, each has an equivalent uppercase mapping:
 * ı (U+0131 LATIN SMALL LETTER DOTLESS I) -> I (U+0049 LATIN CAPITAL LETTER I),
 * i (U+0069 LATIN SMALL LETTER I) -> İ (U+0130 LATIN CAPITAL LETTER I WITH DOT ABOVE).
 *
 * Unicode CaseFolding.txt defines this case as type 'T', a special case for Turkic languages:
 * tr and az. PHP 7.3 parser ignores this special cases. so we have to override the
 * ucfirst and lcfirst methods.
 *
 * See http://en.wikipedia.org/wiki/Dotted_and_dotless_I
 * and @bug 28040
 * @ingroup Language
 */
class LanguageTr extends Language {

	private $uc = [ 'I', 'İ' ];
	private $lc = [ 'ı', 'i' ];

	/**
	 * @param $string string
	 * @return string
	 */
	function ucfirst ( $string ) {
		$first = mb_substr( $string, 0, 1 );
		if ( in_array( $first, $this->lc ) ) {
			$first = str_replace( $this->lc, $this->uc, $first );
			return $first . mb_substr( $string, 1 );
		} else {
			return parent::ucfirst( $string );
		}
	}

	/**
	 * @param $string string
	 * @return mixed|string
	 */
	function lcfirst ( $string ) {
		$first = mb_substr( $string, 0, 1 );
		if ( in_array( $first, $this->uc ) ) {
			$first = str_replace( $this->uc, $this->lc, $first );
			return $first . mb_substr( $string, 1 );
		} else {
			return parent::lcfirst( $string );
		}
	}

}
