<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, not a valid entry point.' );
}

/**
 * This provides a {{#transliterate:map|word}} parser function that
 *
 * 1. Finds out which transliteration maps exist
 *    Transliteration maps are pages at [[MediaWiki:Transliterator:map]]
 *    This query is cached.
 * 2. Loads the map if it exists, and parses it into an array suitable for use with strtr()
 *    This array is cached.
 * 3. Applies the transliteration map to the word, case-insensitively, but respecting either NFD
 *    or NFC and combining characters, and word start-and-end markers.
 *
 * It also provides syntax checking for the transliteration pages, both on save and preview.
 * Perhaps in the future it will provide an API interface to assist javascript transliteration.
 *
 * More detailed user-documentation is at http://mediawiki.org/wiki/Extension:Transliterator
 *
 * Design decisions:
 * As there are an unlimited number of transliteration schemes, and which to use depends mainly
 * on personal preference, it is too inflexible to provide the schemes along with the extension,
 * though it may be nice to provide some default standardised ones in the future. Perhaps this
 * would also be a way to support some more languages, but most languages that can be transliterated
 * automatically can be done using this scheme.
 *
 * The maps are discovered in one query to deal with the expected use-case on en.wiktionary which
 * is the translation template, i.e. {{#transliterate}} will be called with an invalid map name
 * much more often than not.
 *
 * The need to handle NFD is illustrated best by Korean which has a tractable map in NFD but
 * would require thousands of NFC rules.  Word start and end markers are required by Greek and other
 * languages that treat initial and final letters separately. Code-points are combined because of the
 * mess that letting stray combining characters through on their own can cause, and the confusion
 * that this causes.
 *
 * Most methods are static, with the exception of those methods that must interact (at some level)
 * with the runtime cache of maps, everything else is stateless.
 */
class ExtTransliterator  {
	// These characters have been chosen because they are forbidden by MediaWiki, have no special
	// regex meaning, are not unicode letters, and take up only one byte.
	const WORD_START = "\x1F";  // A character that will be appended when ^ should match at the start
	const WORD_END = "\x1E";    // A character that will be appended when $ should match at the end
	const LETTER_END = "\x1D";  // A chacter added between each character as a separator

	// The prefix to use for cache items (the number should be incremented when the map format changes)
	const CACHE_PREFIX = "extTransliterator.4";

	// flags for preprocessor
	const DECOMPOSE = 1;
	const IGNORE_ENDINGS = 2;

	// attribute flags for postprocessor
	const PREFIXED = 1;
	const UPCASED = 2;

	var $mPages = null;   // An Array of "transliterator:$mapname" => The database row for that template.
	var $mMaps = array(); // An Array of "$mapname" => The map parsed from that page.


	/**
	 * Handle the {{#transliterate: $mapname | $word | $format? | $answer? }} call.
	 *
	 * @param $parser Parser
	 * @param $mapname String is the name of the transliteration map to find.
	 * @param $word String is the string to transliterate (if the map was found)
	 * @param $format String is a string containing $1 to be replaced by the transliteration if the map exists
	 * @param $answer String allows for a user-specified transliteration to override the automatic one
	 */
	function render( $parser, $mapname = '', $word = '', $format = '$1', $answer = '' ) {
		// Handle the case when people use {{#transliterate:<>|<>||<>}}
		if ( trim( $format ) === '' ) {
			$format = '$1';
		}

		// If we have been given the answer, return it straight-away
		if ( trim( $answer ) !== '' ) {
			return str_replace( '$1', $answer, $format );
		}

		// Check that the map is a valid title, if not we're in a template {{#transliterate:{{{1}}}...}}
		$title = Title::newFromText( self::getMapPagePrefix() . $mapname, NS_MEDIAWIKI );
		if ( !$title ) {
			$function = MagicWord::get( 'transliterate' )->getSynonym( 0 );
			return str_replace( '$1', "{{#$function:$mapname|$word}}", $format );
		}

		$mappage = $title->getDBkey();
		$map = $this->getMap( $mappage );

		// False if map was not found
		if ( !$map ) {
			$output = '';

		// An error message (these should have been caught by ::validate, but you can't be too careful)
		} elseif ( is_string( $map ) ) {
			$output = self::wrapError( $map );

		// Success!, now do the transliteration
		} else {
			$output = str_replace( '$1', self::transliterate( $word, $map ), $format );
		}

		// Populate the dependency table so that we get re-rendered if the map changes.
		// TODO: It would be nice if we could make this invisible to the user.
		if ( isset( $this->mPages[$mappage] ) ) {
			$parser->mOutput->addTemplate( $title, $this->mPages[$mappage], null );
		} else {
			$parser->mOutput->addTemplate( $title, $title->getArticleID(), null );
		}

		return $output;
	}

	/**
	 * Get all the existing maps in one query.
	 *
	 * @return Array( title => id );
	 */
	function getExistingMapNames() {
		global $wgMemc;

		// Has it been used on this page already?
		if ( ! is_null( $this->mPages ) )
			return $this->mPages;

		// Has it been used since it was last updated?
		$cached = $wgMemc->get( wfMemcKey( self::CACHE_PREFIX, "__map_names__" ) );
		if ( $cached )
			return $this->mPages = $cached;

		$dbr = wfGetDB( DB_SLAVE );
		// TODO: This could potentially cause problems if someone creates a few thousand
		// pages with the prefix. The prefix is guaranteed to be a few letters, so this
		// won't get the whole MediaWiki namespace.
		// The result of this query is memcached until someone edits a map.
		$res = $dbr->select( 'page',
			array( 'page_title', 'page_id' ),
			array(
				'page_namespace' => NS_MEDIAWIKI,
				'page_title ' . $dbr->buildLike( self::getMapPagePrefix(), $dbr->anyString() )
			),
			__METHOD__
		);

		$this->mPages = Array();

		while ( $r = $res->fetchObject() ) {
			$this->mPages[$r->page_title] = $r->page_id;
		}

		$wgMemc->set( wfMemcKey( self::CACHE_PREFIX, "__map_names__" ), $this->mPages );
		return $this->mPages;
	}

	/**
	 * Get a parsed map.
	 *
	 * 1. Check caches for quick return.
	 * 2? Load from database
	 * 3? Parse map
	 *
	 * @param $mappage  String including MapPagePrefix
	 * @return false (no map) || String (parse error) || Map (success)
	 */
	function getMap( $mappage ) {
		global $wgMemc;

		if ( isset( $this->mMaps[$mappage] ) ) {
			return $this->mMaps[$mappage];
		}

		$existing = $this->getExistingMapNames();
		if ( isset( $existing[$mappage] ) ) {
			$map = $wgMemc->get( wfMemcKey( self::CACHE_PREFIX, $mappage ) );

			if ( !$map ) {
				$maptext = wfMsg( $mappage );

				if ( !wfEmptyMsg( $mappage, $maptext ) ) {
					$map = self::readMap( $maptext, $mappage );
				}

				if ( $map ) {
					$wgMemc->set( wfMemcKey( self::CACHE_PREFIX, $mappage ), $map );
				}
			}
		} else {
			$map = false;
		}

		return $this->mMaps[$mappage] = $map;
	}

	/**
	 * Normalise the text so it can be used with strtr() safely
	 *
	 * 1. decodeCharReferences
	 * 2. split into NFD codepoints or NFC fully combined
	 * 3. add bookends on word boundaries
	 *
	 * @param $word  String from user input
	 * @param $flags  may include self::DECOMPOSE, self::IGNORE_ENDINGS
	 * @return String
	 */
	static function forTransliteration( $word, $flags ) {
		static $regexes = null;

		// NOTE: this is very slightly inconsistent with MediaWiki if an NFD code-point
		// has been HTML escaped it will be converted to NFC if it passes through
		// transliteration unchanged, I think that's a WONTFIX though.
		$word = Sanitizer::decodeCharReferences( $word );

		if ( $flags & self::DECOMPOSE ) {
			$word = UtfNormal::toNFD( $word );
			$word = preg_replace( '/./u', '$0' . self::LETTER_END, $word );
		} else {
			$word = preg_replace( '/\X/u', '$0' . self::LETTER_END, $word );
		}

		if ( !$regexes ) {
			// A "letter" is a unicode letter followed by some combining characters
			// A "non-letter" is any other character followed by some combining characters
			// "end" is done first so it watches out for word-endings in "start"
			// If it should treat endings then the start and end of the string are non-letters
			// Otherwise it does not touch the start or end of the string, only internal transitions
			$combining = '(?:[\pM]*' . self::LETTER_END . ')';
			$nonletter = '[^\pL' . self::LETTER_END . self::WORD_END . '\pM]';
			$regexes = array (
				'endings' => array (
					'start' => "/(^$combining?|$nonletter$combining)([\pL])/u",
					'end' => "/([\pL]$combining)([^\pL]|$)/u",
				),
				'ignore-endings' => array (
					'start' => "/($nonletter$combining)([\pL])/u",
					'end' => "/([\pL]$combining)([^\pL])/u",
				),
			);
		}

		$regex = $regexes[$flags & self::IGNORE_ENDINGS ? 'ignore-endings' : 'endings'];
		$word = preg_replace( $regex['end'], '$1' . self::WORD_END . '$2', $word );
		$word = preg_replace( $regex['start'], '$1' . self::WORD_START . '$2', $word );

		return $word;
	}

	/**
	 * Update the current rule-set from a rule
	 *
	 * @param $from String, the left-hand-side of a rule
	 * @param $to String, the right-hand-side of a rule
	 * @param $flags Flags, flags from the top of the map
	 * @param $rules Array, ^from$ -> to (for strtr())
	 * @param $attrs Array, from$ -> Flags (for post processing)
	 * @return Bool true on success, false if an ambiguous rule
	 */
	static function addToRules( $from, $to, $flags, &$rules, &$attrs ) {
		global $wgLang;

		$prefix = $suffix = '';

		// forTransliteration() may decode a deliberately escaped ^ or $.
		// in order to find accurate word boundaries. So we check here if
		// this occurs, and work around it.
		$noprefix = $nosuffix = false;
		if ( $from[0] === '&' || $from[strlen( $from ) - 1] === ';' ) {
		       	$decoded = Sanitizer::decodeCharReferences( $from );
			$noprefix = $decoded[0] === '^';
			$nosuffix = $decoded[strlen( $decoded ) - 1] === '$';
		}

		$from = self::forTransliteration( $from, $flags | self::IGNORE_ENDINGS );

		if ( !$noprefix ) {
			$from = preg_replace( '/^[\^][' . self::LETTER_END . '][' . self::WORD_START . ']/u', '', $from, 1, $count );
			if ( $count ) {
				$prefix = self::WORD_START;
			}
		}
		if ( !$nosuffix ) {
			$from = preg_replace( '/[' . self::WORD_END . '][$][' . self::LETTER_END . ']$/u', '', $from, 1, $count );
			if ( $count ) {
				$suffix = self::WORD_END;
			}
		}

		// Check that this rule isn't ambiguous
		if ( isset( $rules[$prefix . $from . $suffix] ) && !( $attrs[$from] & self::UPCASED ) ) {
			return false;
		}

		$rules[$prefix . $from . $suffix] = $to;
		$attrs[$from . $suffix] = $prefix ? self::PREFIXED : 0;

		// Now case-insensitivity
		$casefrom = $wgLang->ucfirst( $from ) ;
		if ( $from !== $casefrom && !isset( $rules[$prefix . $casefrom . $suffix] ) ) {
			$rules[$prefix . $casefrom . $suffix] = $wgLang->ucfirst( $to );
			$attrs[$casefrom . $suffix] = ( $prefix ? self::PREFIXED : 0 ) | self::UPCASED;
		}

		return true;
	}

	/**
	 * Decide if a line in a map page may contain useful information.
	 *
	 * @param $line
	 * @return Boolean
	 */
	static function isUsefulLine( $line ) {
		return $line != '' && $line[0] != '#';
	}

	/**
	 * Parse a map input syntax into a map.
	 *
	 * Input syntax is a set of lines.
	 *  All " " are ignored.
	 *  Lines starting with # are ignored, remaining lines are split by =>
	 *  HTML entities are decoded (essential for sanity when trying to add rules for combining codepoints)
	 *
	 * @param $input String - the contents of the map page
	 * @param $mappage String - the title of the map page (without MediaWiki:)
	 * @return false (empty, or no useful content, treat as no map) ||
	 *         String (error message, syntax error while parsing) ||
	 *         Array( 'rules' => Array ( from => to ), 'flags' => Flags )
	 */
	static function readMap( $input, $mappage ) {
		global $wgTransliteratorRuleCount, $wgTransliteratorRuleSize;

		$rules = array(); // The actual rules to go into strtr()
		$attrs = array(); // A map of those rules that were automatically added
		$flags = 0;       // Flags associated with those rules

		// Split lines, remove blank lines and comments.
		$input = trim( $input );
		$lines = preg_split( "/\s*\n\s*/u", $input );
		$lines = array_filter( $lines, array( 'ExtTransliterator', 'isUsefulLine' ) );
		$lines = array_values( $lines );

		// Nothing left?
		if ( count( $lines ) == 0 )
			return false;

		// Check for __DECOMPOSE__
		$decompose = MagicWord::get( 'tr_decompose' );
		if ( $decompose->matchVariableStartToEnd( $lines[0] ) ) {
			$flags = $flags | self::DECOMPOSE;
			array_shift( $lines );
		}

		// Check for DoS
		if ( count( $lines ) > $wgTransliteratorRuleCount ) {
			return wfMsgExt( 'transliterator-error-rulecount', array( 'parsemag' ), $wgTransliteratorRuleCount, $mappage );
		}

		foreach ( $lines as $line ) {

			$pair = preg_split( '/\s*=>\s*/u', $line );

			if ( count( $pair ) != 2 || $pair[0] === '' ) {
				return wfMsg( 'transliterator-error-syntax', $line, $mappage );
			}

			if ( strlen( $pair[0] ) > $wgTransliteratorRuleSize ) {
				return wfMsg( 'transliterator-error-rulesize', $line, $mappage,  $wgTransliteratorRuleSize );

			}

			if ( !self::addToRules( $pair[0], $pair[1], $flags, $rules, $attrs ) ) {
				return wfMsg( 'transliterator-error-ambiguous', $line, $mappage );
			}
		}

		return self::postProcessMap( $rules, $attrs, $flags );
	}

	/**
	 * Fix problems created by readMap.
	 *
	 * 1. Long auto-generated case rules override case-specific rules.
	 *   Delete the auto-generated rules.
	 *
	 * 2. The ^ operator overrides length ($ is ok though).
	 *   Insert extra ^ rules with each needed length.
	 *
	 * 3. All the bookends we have inserted are still there
	 *   Add rules to remove them.
	 *
	 * @param $rules  Array( from => to )
	 * @param $attrs  Array( from => self::PREFIXED | self::UPCASED )
	 * @param $flags  May contain self::DECOMPOSE
	 * @return Array( "rules" => $rules, "flags" => $flags )
	 */
	static function postProcessMap( $rules, $attrs, $flags ) {
		// $attrs is sorted into binary order, so start-based substrings of longer rules
		// immediately precede them. Don't need to know anything else about the order.
		ksort( $attrs );
		$wasPrefixed = false;
		$naturalCased = false;
		$naturalCasedFrom = '';
		$prefixedFrom = '';
		foreach ( $attrs as $from => $attr ) {

			// If the current rule has been auto-upcased, but a prefix of this rule wasn't,
			// remove the auto-upcased rule as the specified upper-case takes priority.
			if ( $attr & self::UPCASED ) {

				if ( $naturalCased ) {
					if ( strpos( $from, $naturalCasedFrom ) === 0 ) {

						unset( $rules[$from] );
						unset( $rules[self::WORD_START . $from] );
						continue;

					} else {
						$naturalCased = false;
					}
				}

			} elseif ( !$naturalCased ) {

				$naturalCased = true;
				$naturalCasedFrom = $from;

			}

			// When it finds a ^ed rule, it duplicates all rules that start with that rule
			// which has the effect of promoting length to override ^.
                        // If the length is actually the same, ^x needs to maintain priority over x$
			if ( $attr & self::PREFIXED ) {

				if ( !$wasPrefixed || strpos( $from, $prefixedFrom ) !== 0 ) {
					$wasPrefixed = true;
					$prefixedFrom = $from;
				}

			} elseif ( $wasPrefixed ) {

				if ( strpos( $from, $prefixedFrom ) === 0 ) {
					if ( $from !== $prefixedFrom . self::WORD_END ) {
						$rules[self::WORD_START . $from] = $rules[$from];
					}
				} else {
					$wasPrefixed = false;
				}

			}
		}

		$rules[self::LETTER_END] = '';
		$rules[self::WORD_END] = '';
		$rules[self::WORD_START] = '';

		$rules = new ReplacementArray( $rules );

		return array( 'rules' => $rules, 'flags' => $flags );
	}

	/**
	 * Transliterate a word using the given map's rules and flags.
	 *
	 * @param $word  raw user input
	 * @param $map  as returned by getMap()
	 * @return String ready to output
	 */
	static function transliterate( $word, $map )
	{
		// Add bookends and combining character markers
		$word = self::forTransliteration( $word, $map['flags'] );

		// Perform transliteration
		$output = $map['rules']->replace( $word );

		// Maintain MediaWiki invariant of NFC
		return UtfNormal::toNFC( $output );
	}

	/**
	 * Put a message inside an error span.
	 *
	 * @param $msg String (HTML)
	 * @return String (HTML)
	 */
	static function wrapError( $msg ) {
		return "<span class=\"transliterator error\">$msg</span>";
	}

	/**
	 * Get the prefix to use for map pages in the MediaWiki namespace.
	 *
	 * @return String
	 */
	static function getMapPagePrefix () {
		static $prefix = null;
		if ( !$prefix ) {
			$prefix = MagicWord::get( 'tr_prefix' )->getSynonym( 0 );
			// If the prefix is too short then parts of the MediaWiki namespace are
			// rendered un-editable. If it is not a valid title, then it is very broken.
			if ( strlen( $prefix ) < 3 || !Title::newFromText( $prefix, NS_MEDIAWIKI ) ) {
				wfDebug( "Invalid Transliterator prefix, must be a valid title longer than three characters, falling back to Transliterator:" );
				$prefix = "Transliterator:";
			}
		}
		return $prefix;
	}

	/**
	 * Decide whether the title represents a Transliterator map.
	 *
	 * @param $title Title
	 * @return Boolean
	 */
	static function isMapPage( &$title ) {
		if ( $title->getNamespace() == NS_MEDIAWIKI ) {
			if ( strpos( $title->getText(), self::getMapPagePrefix() ) === 0 ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Remove the article from the Transliterator caches.
	 * (ArticlePurge, ArticleDeleteComplete)
	 *
	 * @param $article Article
	 */
	static function purgeArticle( &$article ) {
		$title = $article->getTitle();
		return self::purgeTitle( $title );
	}

	/**
	 * Remove the article from the Transliterator caches.
	 * (NewRevisionFromEditComplete)
	 *
	 * @param $article Article
	 */
	static function purgeArticleNewRevision( $article ) {
		$title = $article->getTitle();
		return self::purgeTitle( $title );
	}

	/**
	 * Remove the title from the Transliterator caches.
	 * (TitleMoveComplete hook)
	 */
	static function purgeNewTitle( &$title, &$newtitle ) {
		return self::purgeTitle( $newtitle );
	}

	/**
	 * Remove the title from the Transliterator caches.
	 * (ArticleUndelete hook)
	 *
	 * @param $title Title
	 */
	static function purgeTitle( &$title ) {
		global $wgMemc;
		if ( self::isMapPage( $title ) ) {
			$wgMemc->delete( wfMemcKey( self::CACHE_PREFIX, $title->getDBkey() ) );
			$wgMemc->delete( wfMemcKey( self::CACHE_PREFIX, '__map_names__' ) );
		}
		return true;
	}

	/**
	 * Show any errors that would be caused by trying to use this map.
         *
         * Does not follow redirects.
         *
	 * (EditFilter hook)
	 *
	 * @param $editPage EditPage
	 * @param $text String
	 * @param $section
	 * @param $hookError
	 */
	static function validate( $editPage, $text, $section, &$hookError ) {
		// FIXME: Should not access private variables
		$title = $editPage->mTitle;
		if ( self::isMapPage( $title ) ) {
			$map = self::readMap( $text, $title->getDBkey() );
			if ( is_string( $map ) ) {
				$hookError = self::wrapError( $map );
			}
		}
		return true;
	}

	/**
	 * Prepend any error message caused by parsing the text for preview.
	 * (EditPageGetPreviewText hook)
	 */
	static function preview( $editPage, &$text ) {
		self::validate( $editPage, $text, null, $hookError );
		if ( $hookError ) {
			$text = $hookError . "\n----\n" . $text;
		}
		return true;
	}

	/**
	 * Called on first use to create singleton
	 * (ParserFirstCallInit hook)
	 *
	 * @param $parser Parser
	 */
	static function setup( &$parser ) {
		$trans = new ExtTransliterator;
		$parser->setFunctionHook( 'transliterate', array( $trans, 'render' ) );
		return true;
	}
}
