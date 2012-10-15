<?php

/**
 * Class for the 'THIS' variable/parser function.
 *
 * @since 0.2 (in 'ExtParserFun' class before)
 *
 * @file PFun_This.php
 * @ingroup ParserFun
 *
 * @author Daniel Werner
 */
class ParserFunThis {

	/**
	 * Magic word 'THIS:' to return certain information about the page the word actually is defined on
	 */
	static function pfObj_this( Parser &$parser, PPFrame $frame = null, $args = null ) {
		// if MW version is too old or something is wrong:
		if( $frame === null || $frame->title === null ) {
			return '';
		}

		// get part behind 'THIS:' if only 'THIS', use 'FULLPAGENAME'
		$index = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';

		$newArgs = array();

		if( $index !== '' ) {
			// clean up arguments as if first argument never were set:
			unset( $args[0] );
			foreach( $args as $arg ) {
				$newArgs[] = $arg;
			}

			// get magic word ID of the variable name:
			$mwId = self::getVariablesMagicWordId( $parser, $index );
			if( $mwId === null ) {
				// requested variable doesn't exist, make the thing a template call
				return array( null, 'found' => false );
			}
		}
		else {
			// if only '{{THIS}}', set magic word id to 'FULLPAGENAME'
			$mwId = 'fullpagename';
		}

		// get value:
		$out = self::getThisVariableValue( $mwId, $parser, $frame, $newArgs );
		if( $out === null ) {
			// requested variable doesn't support 'THIS:', make the thing a template call
			return array( null, 'found' => false );
		}

		return $out;
	}

	/**
	 * Returns the magic word ID for a variable like the user would write it. Returns null in case there
	 * is no word for the given variables name.
	 *
	 * @param Parser $parser
	 * @param type $word
	 *
	 * @return string|null
	 */
	static function getVariablesMagicWordId( Parser $parser, $word ) {
		// get all local (including translated) magic words IDs (values) with their actual literals (keys)
		// for case insensitive [0] and sensitive [1]
		$magicWords = $parser->mVariables->getHash();

		if( array_key_exists( strtolower( $word ), $magicWords[0] ) ) {
			// case insensitive word match
			$mwId = $magicWords[0][ strtolower( $word ) ];
		}
		elseif( array_key_exists( $word, $magicWords[1] ) ) {
			// case sensitive word match
			$mwId = $magicWords[1][ $word ];
		}
		else {
			// requested magic word doesn't exist for variables
			return null;
		}
		return $mwId;
	}

	/**
	 * Returns the value of a variable like '{{FULLPAGENAME}}' in the context of the given PPFrame objects
	 * $frame->$title instead of the Parser objects subject. Returns null in case the requested variable
	 * does not support '{{THIS:}}'.
	 *
	 * @param string  $mwId magic word ID of the variable
	 * @param Parser  $parser
	 * @param PPFrame $frame
	 * @param array   $args
	 *
	 * @return string|null
	 */
	static function getThisVariableValue( $mwId, Parser &$parser, $frame, $args = array() ) {
		$ret = null;
		$title = $frame->title;

		if( $title === null ) {
			return null;
		}

		// check whether info is available, e.g. 'THIS:FULLPAGENAME' requires 'FULLPAGENAME'
		switch( $mwId ) {
			case 'namespace':
				// 'namespace' function name was renamed as PHP 5.3 came along
				if( is_callable( 'CoreParserFunctions::mwnamespace' ) ) {
					$ret = CoreParserFunctions::mwnamespace( $parser, $title->getPrefixedText() );
					break;
				}
				// else: no different from the other variables
				// no-break, default function call
			case 'fullpagename':
			case 'fullpagenamee':
			case 'pagename':
			case 'pagenamee':
			case 'basepagename':
			case 'basepagenamee':
			case 'subpagename':
			case 'subpagenamee':
			case 'subjectpagename':
			case 'subjectpagenamee':
			case 'talkpagename':
			case 'talkpagenamee':
			case 'namespacee': // special treat for 'namespace', on top
			case 'subjectspace':
			case 'subjectspacee':
			case 'talkspace':
			case 'talkspacee':
				// core parser function information requested
				$ret = CoreParserFunctions::$mwId( $parser, $title->getPrefixedText() );
				break;

			default:
				// give other extensions a chance to hook up with this and return their own values:
				wfRunHooks( 'GetThisVariableValueSwitch', array( &$parser, $title, &$mwId, &$ret, $frame, $args ) );
		}
		return $ret;
	}
}
