<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, not a valid entry point.' );
}

class ExtTransliterator  {

	const FIRST = "\x1F"; // A character that will be appended when ^ should match at the start
	const LAST = "\x1E";  // A character that will be appended when $ should match at the end
	const CACHE_PREFIX = "extTransliterator.2"; // The prefix to use for cache items (the number should be incremented when the map format changes)
	var $mPages = null;   // An Array of "transliterator:$mapname" => The database row for that template.
	var $mMaps = array(); // An Array of "$mapname" => The map parsed from that page.

	/**
	 * Split a word into letters (not bytes or codepoints) implicitly in NFC due to MediaWiki.
	 */
	static function letters( $word ) {
		global $utfCombiningClass;
		UtfNormal::loadData();

		$split = preg_split( '/(.)/u', $word, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );

		$i = 1;
		while ( $i < count( $split ) ) {
			if ( isset( $utfCombiningClass[$split[$i]] ) ) {
				array_splice( $split, $i - 1, 2, array( $split[$i - 1] . $split[$i] ) ); //decrement count($split)

			} else {
				++$i;

			}
		}

		return $split;
	}

	/**
	 * Split a word into the NFD codepoints that make it up.
	 */
	static function codepoints( $word ) {
		$word = UtfNormal::toNFD( $word );
		return preg_split( '/(.)/u', $word, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
	}

	/**
	 * Decides whether, for the purpose of edge-of-word detection, this letter should be
	 * included or excluded.
	 */
	static function is_a_letter( $letter ) {
		return preg_match( '/\pL/u', $letter ) || isset( $utfCombiningClass[$letter] );
	}

	/**
	 * Given a codepoints or letters array returns a list that contains 1 for every
	 * alphabetic character and accent, and 0 otherwise. This allows for edge-of-word
	 * detection.
	 */
	static function alphamap( $letters ) {
		return array_map( array( 'ExtTransliterator', 'is_a_letter' ), $letters );
	}

	/**
	 * Get all the existing maps in one query, useful given that the default
	 * behaviour of failing silently is designed to allow it to be used by
	 * templates that don't know if a map exists, so may try far too often.
	 */
	function getExistingMapNames( $prefix ) {
		global $wgMemc;

		// Have we used it on this page already?
		if ( ! is_null($this->mPages) )
			return $this->mPages;

		// Have we used it recently?
		$cached = $wgMemc->get( wfMemcKey( self::CACHE_PREFIX, "__map_names__" ) );
		if ( $cached )
			return $this->mPages = $cached;

		$dbr = wfGetDB( DB_SLAVE );
		// TODO: This could potentially cause problems if someone creates a few thousand
		// pages with the prefix. The prefix is guaranteed to be a few letters, so this 
		// won't get the whole namespace.
		// The result of this query is memcached until someone edits a map.
		$res = $dbr->select( 'page',
			array( 'page_title', 'page_id' ),
			array(
				'page_namespace' => NS_MEDIAWIKI,
				'page_title LIKE \'' . $dbr->escapeLike( $prefix ) .'%\''
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
	 * Get a parsed map, either from the local cache or from the page,
	 */
	function getMap( $prefix, $mappage ) {
		global $wgMemc;

		// Have we used it on this page already?
		if ( isset( $this->mMaps[$mappage] ) ) {
			return $this->mMaps[$mappage];
		}

		// Does it exist at all?
		$existing = $this->getExistingMapNames( $prefix );
		if ( isset( $existing[$mappage] ) ) {

			// Have we used it recently?
			$map = $wgMemc->get( wfMemcKey( self::CACHE_PREFIX, $mappage ) );
			if (! $map ) {

				$map = self::readMap( wfMsg( $mappage ), $mappage );

				if ( $map )
					$wgMemc->set( wfMemcKey( self::CACHE_PREFIX, $mappage ), $map);
			}

		} else {
			$map = false;
		}

		return $this->mMaps[$mappage] = $map;
	}

	/**
	 * Returns true if the line might contain something useful, false otherwise.
	 */
	static function is_useful_line( $line ) {
		return $line != "" && substr( $line, 0, 1 ) != '#';
	}

	/**
	 * Parse a map input syntax into a map.
	 *
	 * Input syntax is a set of lines.
	 *  All " " are ignored.
	 *  Lines starting with # are ignored, remaining lines are split by =>
	 *  HTML entities are decoded (essential for sanity when trying to add rules for combining codepoints)
	 *
	 * The map created is a set of "from" strings to "to" strings
	 *  With extra "from" => true for all substrings of "from" strings
	 *   So that the transliteration algorithm knows when it has found the longest match
	 *
	 * $map[''] is used as the default fall through for any characters not in the map
	 * $map['__decompose__'] indicates that NFD should be used instead of characters
	 * $map['__sensitive__'] indicates that the automatic first-letter upper-case fall-through should not be tried
	 */
	static function readMap( $input, $mappage ) {
		global $wgTransliteratorRuleCount, $wgTransliteratorRuleSize;

		$map = array();
		$decompose = false;

		// Split lines and remove whitespace at beginning and end
		$input = trim( $input );
		$lines = preg_split( "/\s*\n\s*/", $input );
		$lines = array_filter( $lines, array( 'ExtTransliterator', 'is_useful_line' ) );
		$lines = array_values( $lines );

		$count = count( $lines );

		// The only content was comments
		if ( $count == 0 )
			return false;

		// The first line can contain flags
		$firstLine = $lines[0];
		if ( strpos( $firstLine, "=>") === false ) {
			// Or, could just signify that the message was blank
			if ( $firstLine == "<$mappage>")
				return false;
			else if ( preg_replace( '/<(decompose|sensitive)>/', '', $firstLine ) != '')
				return wfMsg( 'transliterator-error-syntax', $firstLine, $mappage );

			if ( strpos( $firstLine, "<decompose>" ) !== false ) {
				$map['__decompose__'] = true;
				$decompose = true;
			}
			if ( strpos( $firstLine, "<sensitive>" ) !== false ) {
				$map['__sensitive__'] = true;
			}
			array_shift( $lines );
			$count--;
		}

		if ( $count > $wgTransliteratorRuleCount )
			return wfMsgExt( 'transliterator-error-rulecount', array('parsemag'), $wgTransliteratorRuleCount, $mappage );

		foreach ( $lines as $line ) {

			$pair = preg_split( '/\s*=>\s*/', $line );

			if ( count( $pair ) != 2 )
				return wfMsg( "transliterator-error-syntax", $line, $mappage );

			$from = $pair[0];
			$to = Sanitizer::decodeCharReferences( $pair[1], ENT_QUOTES, 'UTF-8' );

			// Convert the ^ and $ selectors into special characters for matching
			// Leave single ^ and $'s alone incase someone wants to use them
			// Still permits the creation of the rule "^$=>" that will never match, but hey
			$fromlast = strlen( $from ) - 1;
			if ( $fromlast > 0 ) {
				if ( $from[0] == "^" ) {
					$from = substr( $from, 1 ) . self::FIRST;
					$fromlast--;
				}

				if ( $from[$fromlast] == "$")
					$from[$fromlast] = self::LAST;
			}

			// Now we've looked at our syntax we can remove html escaping to reveal the true form
			$from = Sanitizer::decodeCharReferences( $from, ENT_QUOTES, 'UTF-8' );
			if ( $decompose ) { // Undo the NFCing of MediaWiki
				$from = UtfNormal::toNFD( $from );
			}

			// If $map[$from] is set we can skip the filling in of sub-strings as there is a longer rule
			if ( isset( $map[$from] ) ) {

				// Or a rule of the same length, i.e. the same rule.
				if ( is_string( $map[$from] ) && $to != $map[$from] )
					return wfMsg("transliterator-error-ambiguous", $line, $mappage);

			} else if ( strlen( $from ) > 1 ){

				// Bail if the left hand side is too long (has performance implications otherwise)
				$fromlen = strlen( $from );
				if ( $fromlen > $wgTransliteratorRuleSize )
					return wfMsgExt('transliterator-error-rulesize', array('parsemag'), $line, $mappage, $wgTransliteratorRuleSize );

				// Fill in the blanks, so that we know when to stop looking while transliterating
				for ( $i = 1; $i < $fromlen; $i++ ) {
					$substr = substr( $from, 0, $i );

					if (! isset( $map[$substr] ) )
						$map[$substr] = true;
				}
			} // else we have the default rule

			$map[$from] = $to;
		}

		return $map;
	}

	/**
	 * Transliterate a word by iteratively finding the longest substring from
	 * the start of the untransliterated string that we have a rule for, and
	 * transliterating it.
	 */
	static function transliterate( $word, $map )
	{
		if ( isset( $map["__decompose__"] ) ) {
			$letters = self::codepoints( $word );
		} else {
			$letters =  self::letters( $word );
		}

		$alphamap = false;                           // Lazily loaded if it looks like it might be needed.

		$sensitive = isset( $map["__sensitive__"] ); // Are we in case-sensitive mode, or not
		$ucfirst = false;                            // We are in case-sensitive mode and the first character of the current match was upper-case originally
		$lastUpper = null;                           // We have lower-cased the current letter, but we need to keep track of the original (dotted I for example)

		$output = "";               // The output
		$lastMatch = 0;             // The position of the last character matched, or the first character of the current run
		$lastTrans = null;          // The transliteration of the last character matched, or null if the first character of the current run
		$i = 0;                     // The current position in the string
		$count = count( $letters );   // The total number of characters in the string
		$current = "";              // The substring that we are currently trying to find the longest match for.
		$currentStart = 0;          // The position that $current starts at

		while ( $lastMatch < $count ) {

			if ( $i < $count ) {

				$next = $current.$letters[$i];

				// There may be a match longer than $current
				if ( isset( $map[$next] ) ) {

					// In fact, $next is a match
					if ( is_string( $map[$next] ) ) {
						$lastMatch = $i;
						$lastTrans = $map[$next];
					}

					$i++;
					$current = $next;
					continue;
				}
			}

			// If this match is at the end of a word, see whether we have a more specific rule
			if ( $i > 0 ) {
				$try = $current . self::LAST;
				if ( isset( $map[$try] ) ) {
					if ( $alphamap === false )
						$alphamap = self::alphamap( $letters );

					if ( $alphamap[$i-1] && ( $i == $count || !$alphamap[$i] ) ) {
						if ( is_string( $map[$try] ) ) {
							$lastTrans = $map[$try];
						}
						if ( isset( $map[$try . self::FIRST] ) ) {
							$current = $try;
						}
					}
				}
			}

			// If this match is at the start of a word, see whether we have a more specific rule
			$try = $current . self::FIRST;
			if ( isset( $map[$try] ) && is_string( $map[$try] ) ) {

				if ( $alphamap === false )
					$alphamap = self::alphamap( $letters );

				if ( ( $currentStart == 0 || !$alphamap[$currentStart - 1]) && $alphamap[$currentStart] ) {
					$lastTrans = $map[$try];
				}
			}

			// We had no match at all, pass through one character
			if ( is_null( $lastTrans ) ) {

				$lastLetter = $letters[$lastMatch];
				$lastLower = $sensitive ? $lastLetter : mb_strtolower( $lastLetter );

				// If we are not being sensitive, we can try down-casing the previous letter
				if ( $lastLetter != $lastLower ) {
					$ucfirst = true;
					$letters[$lastMatch] = $lastLower;
					$lastUpper = $lastLetter;

				// Might be nice to output a ? if we don't understand
				} else if ( isset( $map[''] ) ) {

					if ( $ucfirst ) {
						$output .= str_replace( '$1', $lastUpper , $map[''] );
						$ucfirst = false;
					} else {
						$output .= str_replace( '$1', $lastLetter, $map[''] );
					}
					$i = $currentStart = ++$lastMatch;
					$current = "";

				// Or the input if it's likely to be correct enough
				} else {

					if ( $ucfirst ) {
						$output .= $lastUpper;
						$ucfirst = false;
					} else {
						$output .= $lastLetter;
					}
					$i = $currentStart = ++$lastMatch;
					$current = "";
				}

			// Output the previous match
			} else {

				if ( $ucfirst ) {
					$output .= mb_strtoupper( mb_substr( $lastTrans, 0, 1 ) ).mb_substr( $lastTrans, 1 );
					$ucfirst = false;
				} else {
					$output .= $lastTrans;
				}
				$i = $currentStart = ++$lastMatch;
				$lastTrans = null;
				$current = "";

			}
		}
		return $output;
	}

	/**
	 * {{#transliterate:<mapname>|<word>[|<format>[|<answer>[|<onerror>]]]}}
	 *
	 * Direct usage will generally be of the form {{#transilterate:<mapname>|<word>}} while
	 * generic templates may find the latter three parameters invaluable for easy use.
	 *
	 * $mapname is the name of the transliteration map to find.
	 * $word    is the string to transliterate (if the map was found)
	 * $format  is a string containing $1 to be replaced by the transliteration if the map exists
	 * $answer  allows for a user-specified transliteration to override the automatic one
	 * $other   is an error messsage to display if $answer is blank and an invalid map is specified
	 */
	function render( &$parser, $mapname = '', $word = '', $format = '$1', $answer = '', $other = '' ) {
		if ( trim( $format ) == '' ) { // Handle the case when people use {{#transliterate:<>|<>||<>}}
			$format = '$1';
		}

		if ( trim( $answer ) != '' ) {
			return str_replace( '$1', $answer, $format );
		}

		$prefix = wfMsg( 'transliterator-prefix' );
		$title = Title::newFromText( $prefix . $mapname, NS_MEDIAWIKI );

		if (! $title ) {
			return $other == '' ? str_replace( "$1", "{{#transliterate:$mapname|$word}}", $format ) : $other;

		} else if ( strlen( $prefix ) < 3 ) {
			return '<span class="transliterator error">' .
				wfMsgExt( 'transliterator-error-prefix', 'parsemag', 3, 'transliterator-prefix' ) .
				'</span>';

		}

		$mappage = $title->getDBkey();

		$map = $this->getMap( $prefix, $mappage );

		if ( !$map ) { // False if map was not found
			$output = $other;

		} else if ( is_string( $map ) ) { // An error message
			$output = '<span class="transliterator error"> '.$map.' </span>';

		} else { // A Map
			$trans = UtfNormal::toNFC( self::transliterate( Sanitizer::decodeCharReferences( $word ), $map ) );
			$output = str_replace( '$1', $trans, $format );
		}

		// Populate the dependency table so that we get re-rendered if the map changes.
		if ( isset( $this->mPages[$mappage] ) )
			$parser->mOutput->addTemplate( $title, $this->mPages[$mappage], null );

		else
			$parser->mOutput->addTemplate( $title, $title->getArticleID(), null );

		return $output;
	}

	/**
	 * Called on ArticlePurge, ArticleDeleteComplete and NewRevisionFromEditComplete in order to purge cache
	 */
	static function purgeArticle( &$article ) {
		$title = $article->getTitle();
		return self::purgeTitle( $title );
	}

	/**
	 * Called on TitleMoveComplete
	 */
	static function purgeNewTitle ( &$title, &$newtitle ) {
		return self::purgeTitle( $newtitle );
	}

	/**
	 * Called on ArticleUndelete (and by other purge hook handlers)
	 */
	static function purgeTitle( &$title ) {
		global $wgMemc;
		if ( $title->getNamespace() == NS_MEDIAWIKI ) {
			$text = $title->getText();
			$prefix = wfMsg( 'transliterator-prefix' );
			if ( strpos( $text, $prefix ) === 0 ) {
				$wgMemc->delete( wfMemcKey( self::CACHE_PREFIX, $title->getDBkey() ) );
				$wgMemc->delete( wfMemcKey( self::CACHE_PREFIX, "__map_names__" ) );
			}
		}
		return true;

	}

	/**
	 * Called on first use to create singleton
	 */
	static function setup( &$parser ) {
		$trans = new ExtTransliterator;
		$parser->setFunctionHook( 'transliterate', array( $trans, 'render' ) );
		return true;
	}
}
