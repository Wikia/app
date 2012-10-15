<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMMagicWordParser extends WOMTemplateParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_MAGICWORD;
	}

	static $underscores = array( '0' => '', '1' => '' );
	static $mwa = null;
	static function getDoubleUnderscoreRegex() {
		if ( WOMMagicWordParser::$mwa === null ) {
			WOMMagicWordParser::$mwa = MagicWord::getDoubleUnderscoreArray();
			foreach ( WOMMagicWordParser::$mwa->names as $name ) {
				$magic = MagicWord::get( $name );
				$case = intval( $magic->isCaseSensitive() );
				foreach ( $magic->getSynonyms() as $i => $syn ) {
					$group = '(' . preg_quote( $syn, '/' ) . ')';
					if ( WOMMagicWordParser::$underscores[$case] === '' ) {
						WOMMagicWordParser::$underscores[$case] = $group;
					} else {
						WOMMagicWordParser::$underscores[$case] .= '|' . $group;
					}
				}
			}
			if ( WOMMagicWordParser::$underscores[0] !== '' ) {
				WOMMagicWordParser::$underscores[0] = "/^(" . WOMMagicWordParser::$underscores[0] . ")/i";
			}
			if ( WOMMagicWordParser::$underscores[1] !== '' ) {
				WOMMagicWordParser::$underscores[1] = "/^(" . WOMMagicWordParser::$underscores[1] . ")/";
			}
		}
		return WOMMagicWordParser::$underscores;
	}
	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$text = substr( $text, $offset );

		$regex = WOMMagicWordParser::getDoubleUnderscoreRegex();
		foreach ( $regex as $reg ) {
			if ( $reg === '' ) continue;
			$r = preg_match( $reg, $text, $m );
			if ( $r ) {
				$len = strlen( $m[0] );
				$magicword = trim( $m[0] );
				return array( 'len' => $len, 'obj' => new WOMMagicWordModel( $magicword, true ) );
			}
		}
		$r = preg_match( '/^\{\{([^{|}]+)\}\}/', $text, $m );

		if ( $r ) {
			$len = strlen( $m[0] );
			$magicword = trim( $m[1] );

			global $wgParser;
			if ( $wgParser->mVariables === null ) $wgParser->initialiseVariables();
			$id = $wgParser->mVariables->matchStartToEnd( $magicword );
			if ( $id !== false ) {
				return array( 'len' => $len, 'obj' => new WOMMagicWordModel( $magicword ) );
			}
		}
		return null;
	}
}
