<?php

class I18nTags {

	public static function formatNumber( $data, $params, $parser ) {
		$lang = self::languageObject( $params );
		return $lang->formatNum($data);
	}

	public static function grammar( $data, $params, $parser ) {
		$case = isset($params['case']) ? $params['case'] : '';
		$lang = self::languageObject($params);
		return $lang->convertGrammar($data, $case);
	}

	public static function plural( $data, $params, $parser ) {
		list( $from, $to ) = self::getRange( @$params['n'] );
		$args = explode('|', $data);
		$lang = self::languageObject( $params );

		$format = isset($params['format']) ? $params['format'] : '%s';
		$format = str_replace( '\n', "\n", $format );

		$s = '';
		for( $i = $from; $i <= $to; $i++ ) {
			$t = $lang->convertPlural( $i, $args );
			$fmtn = $lang->formatNum($i);
			$s .= str_replace(
				array( '%d', '%s'), 
				array( $i, wfMsgReplaceArgs( $t, array($fmtn) ) ),
				$format
			);
		}
		return $s;
	}

	public static function linktrail( $data, $params, $parser ) {
		$lang = self::languageObject( $params );
		$regex = $lang->linkTrail();

		$inside = '';
		if ( '' != $data ) {
			$predata = array();
			preg_match( '/^\[\[([^\]|]+)(\|[^\]]+)?\]\](.*)$/sDu', $data, $predata );
			$m = array();
			if ( preg_match( $regex, $predata[3], $m ) ) {
				$inside = $m[1];
				$data = $m[2];
			}
		}
		$predata = isset( $predata[2] ) ? $predata[2] : isset( $predata[1] ) ? $predata[1] : $predata[0];
		return "<b>$predata$inside</b>$data";
	}

	public static function languageName( &$parser, $code = '', $native = '' ) {
		global $wgLang;
		if ( !$code ) return '';
		$native = $native === 'native';
		$cldr   = is_callable(array( 'LanguageNames', 'getNames' ));
		if ( !$native && $cldr ) {
			$languages = LanguageNames::getNames( $wgLang->getCode(),
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW_AND_CLDR
			);
		} else {
			$languages = Language::getLanguageNames( false );
		}

		return isset($languages[$code]) ? $languages[$code] : $code;
	}


	/**
	 * Static helper that returns either content or user interface language object.
	 * @param $params Parameters passed to to the parser tag
	 * @return Instance of class Language
	 * Globals: $wgContLang.
	 */
	public static function languageObject( $params ) {
		global $wgContLang;
		return isset( $params['lang'] ) ? Language::factory( $params['lang'] ) : $wgContLang;
	}

	public static function getRange( $s, $min = false, $max = false) {
		$matches = array();
		if ( preg_match( '/(\d+)-(\d+)/', $s, $matches ) ) {
			$from = $matches[1];
			$to = $matches[2];
		} else {
			$from = $to = (int) $s;
		}


		if ( $from > $to ) {$UNDEFINED = $to; $to = $from; $from = $UNDEFINED;}
		if ( $min !== false ) $from = max( $min, $from );
		if ( $max !== false ) $to = min( $max, $to );

		return array( $from, $to );
	}
}