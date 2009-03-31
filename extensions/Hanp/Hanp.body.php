<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

class Hanp {

	/**
	 * {{#hanp:word|particle|output}}
	 */
	static function hangulParticle( $parser, $word = '', $particle = '', $output = '' ) {

	/**
	 * Initialization of $output parameter
	 * This parameter used if $word contains signs not read
	 * For example: {{#hanp:Wikimedia|particle|[[Wikimedia]]}}
	 */
	if ( $output == '' ) {
		$output = $word;
	}

	switch ( $particle ) {

		case '로':   # ro
		case '으로': # euro
			if ( self::endsInHangulRieul( $word ) ) {
				return $output . '로';
			} elseif ( self::endsInHangulConsonant( $word ) ) {
				return $output . '으로';
			} else {
				return $output . '로'; // Vowel or non-hangul
			}
			break;

		case '을':   # eul
		case '이':   # i
		case '와':   # wa
		case '은':   # eun
		case '를':   # reul
		case '가':   # ga
		case '과':   # gwa
		case '는':   # neun
			if ( self::endsInHangulConsonant( $word ) ) {
				return $output . self::particleMap( $particle, self::SOFT );
			} else {
				return $output . self::particleMap( $particle, self::HARD );
			}
			break;

		default: return $output . $particle;
		}
	}

	// Not real terms, but I do not know how to call these
	const SOFT = 1; // without consonant
	const HARD = 2; // with consonant
	/**
	 * Returns the correct version of the particle.
	 * Use Hanp::SOFT to get version that can be attached to words ending in a
	 * consonant and Hanp::HARD for others.
	 */
	static function particleMap( $particle, $dir ) {
		$map = array(
			'을' => '를', # (r)eul
			'이' => '가', # i, ga
			'과' => '와', # gwa, wa
			'은' => '는', # (n)eun
		);

		if ( $dir === self::SOFT ) $map = array_flip( $map );

		if ( isset( $map[$particle] ) ) {
			return $map[$particle];
		} else {
			return $particle; # We want only valid input, so it is already correct
		}
	}

	static function lastLetterToCodePoint( $string ) {
		require_once ( dirname( __FILE__ ) . '/php-utf8/utf8.inc' );
		$matches = array();
		if ( !preg_match( '/.$/u', $string, $matches ) ) return false;
		// I hate php
		$returnValue = utf8toUnicode( $matches[0] );
		return array_pop( $returnValue );
	}

	static function endsInHangul( $string ) {
		$rangeStart = hexdec( 'AC00' ); # GA
		$rangeEnd   = hexdec( 'D7A3' ); # HIH
		$lastLetter = self::lastLetterToCodePoint( $string );
		return $rangeStart < $lastLetter && $lastLetter < $rangeEnd;
	}

	static function endsInHangulVowel( $string ) {
		$lastLetter = self::lastLetterToCodePoint( $string );
		$candidate = hexdec( 'AC00' ); # GA
		$increment = hexdec( '1C' );
		$lastValue = hexdec( 'D788' );
		do {
			if ( $lastLetter < $candidate ) return false; // Fast out
			if ( $lastLetter === $candidate ) return true;
			$candidate += $increment;
		} while ( $candidate < $lastValue );
		return false;
	}

	static function endsInHangulRieul( $string ) {
		$lastLetter = self::lastLetterToCodePoint( $string );
		$candidate = hexdec( 'AC08' ); # GA
		$increment = hexdec( '1C' );
		$lastValue = hexdec( 'D790' );
		do {
			if ( $lastLetter < $candidate ) return false; // Fast out
			if ( $lastLetter === $candidate ) return true;
			$candidate += $increment;
		} while ( $candidate < $lastValue );
		return false;
	}

	static function endsInHangulConsonant( $string ) {
		return self::endsInHangul( $string ) && !self::endsInHangulVowel( $string );
	}

}
