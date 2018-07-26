<?php

/** Polish (polski)
 *
 * @ingroup Language
 */
class LanguagePl extends Language {

	/**
	 * @param $count string
	 * @param $forms array
	 * @return string
	 */
	function convertPlural( $count, $forms ) {
		if ( !count( $forms ) ) { return ''; }
		$forms = $this->preConvertPlural( $forms, 3 );
		$count = abs( $count );
		if ( $count == 1 )
			return $forms[0];     // singular
		switch ( $count % 10 ) {
			case 2:
			case 3:
			case 4:
				if ( $count / 10 % 10 != 1 )
					return $forms[1]; // plural
			default:
				return $forms[2];   // plural genitive
		}
	}

	/**
	 * @param $_ string
	 * @return string
	 */
	function commafy( $_ ) {
		if ( !preg_match( '/^\-?\d{1,4}(\.\d+)?$/', $_ ) ) {
			return strrev( (string)preg_replace( '/(\d{3})(?=\d)(?!\d*\.)/', '$1,', strrev( $_ ) ) );
		} else {
			return $_;
		}
	}
    
	/**
	 * Grammatical transformations, needed for inflected languages
	 * Invoked by putting {{grammar:case|word}} in a message
	 *
	 * @param $word string
	 * @param $case string
	 * @return string
	 */
    function convertGrammar( $word, $case ) {
		global $wgGrammarForms;
		if ( isset( $wgGrammarForms['pl'][$case][$word] ) ) {
			return $wgGrammarForms['pl'][$case][$word];
		}
		
		# Declension for 'pedia' and 'wikia' in sitenames. It's not perfect but it'll take care of cases that aren't deliberately wonky.
		if ( !preg_match( "/Wiki$/us", $word ) ) {
			$ar = array();
			if ( preg_match_all( '/pedia\b|wikia\b/ius', $word, $ar, PREG_OFFSET_CAPTURE) ) {
				$offset = end($ar[0])[1]+4;
				switch ( $case ) {
					case 'D.lp': # Dopełniacz
					case 'C.lp': # Celownik
					case 'MS.lp': # Miejscownik
						if ( $word[$offset] == 'a' )
							$word[$offset] = 'i';
						elseif ( $word[$offset] == 'A' )
							$word[$offset] = 'I';
						break;
					case 'B.lp': # Biernik
						if ( $word[$offset] == 'a' )
							$word[$offset] = 'ę';
						elseif ( $word[$offset] == 'A' )
							$word[$offset] = 'Ę';
						break;
					case 'N.lp':  # Narzędnik
						if ( $word[$offset] == 'a' )
							$word[$offset] = 'ą';
						elseif ( $word[$offset] == 'A' )
							$word[$offset] = 'Ą';
						break;
					case 'W.lp': # Wołacz
						if ( $word[$offset] == 'a' )
							$word[$offset] = 'o';
						elseif ( $word[$offset] == 'A' )
							$word[$offset] = 'O';
						break;
				}
			}
		}
		return $word;
	}
}
