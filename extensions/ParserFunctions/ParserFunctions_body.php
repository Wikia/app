<?php

class ExtParserFunctions {
	static $mExprParser;
	static $mConvertParser;
	static $mTimeCache = array();
	static $mTimeChars = 0;
	static $mMaxTimeChars = 6000; # ~10 seconds

	/**
	 * @param $parser Parser
	 * @return bool
	 */
	public static function clearState( $parser ) {
		self::$mTimeChars = 0;
		$parser->pf_ifexist_breakdown = array();
		$parser->pf_markerRegex = null;
		return true;
	}

	/**
	 * Register ParserClearState hook.
	 * We defer this until needed to avoid the loading of the code of this file
	 * when no parser function is actually called.
	 */
	public static function registerClearHook() {
		static $done = false;
		if( !$done ) {
			global $wgHooks;
			$wgHooks['ParserClearState'][] = __CLASS__ . '::clearState';
			$done = true;
		}
	}

	/**
	 * Get the marker regex. Cached.
	 * @param $parser Parser
	 * @return
	 */
	public static function getMarkerRegex( $parser ) {
		self::registerClearHook();
		if ( isset( $parser->pf_markerRegex ) ) {
			return $parser->pf_markerRegex;
		}

		wfProfileIn( __METHOD__ );

		$prefix = preg_quote( $parser->uniqPrefix(), '/' );

		$suffix = preg_quote( Parser::MARKER_SUFFIX, '/' );

		$parser->pf_markerRegex = '/' . $prefix . '(?:(?!' . $suffix . ').)*' . $suffix . '/us';

		wfProfileOut( __METHOD__ );
		return $parser->pf_markerRegex;
	}

	/**
	 * @param $parser Parser
	 * @param $text string
	 * @return string
	 */
	private static function killMarkers ( $parser, $text ) {
		return preg_replace( self::getMarkerRegex( $parser ), '' , $text );
	}

	/**
	 * @return ExprParser
	 */
	public static function &getExprParser() {
		if ( !isset( self::$mExprParser ) ) {
			self::$mExprParser = new ExprParser;
		}
		return self::$mExprParser;
	}

	/**
	 * @param $parser Parser
	 * @param $expr string
	 * @return string
	 */
	public static function expr( $parser, $expr = '' ) {
		try {
			return self::getExprParser()->doExpression( $expr );
		} catch ( ExprError $e ) {
			// begin wikia change
			// VOLDEV-114
			return '<strong class="error">' . htmlspecialchars( $e->getMessage() ) . '</strong>';
			// end wikia change
		}
	}

	/**
	 * @param $parser Parser
	 * @param $expr string
	 * @param $then string
	 * @param $else string
	 * @return string
	 */
	public static function ifexpr( $parser, $expr = '', $then = '', $else = '' ) {
		try {
			$ret = self::getExprParser()->doExpression( $expr );
			if ( is_numeric( $ret ) ) {
				$ret = floatval( $ret );
			}
			if ( $ret ) {
				return $then;
			} else {
				return $else;
			}
		} catch ( ExprError $e ) {
			// begin wikia change
			// VOLDEV-114
			return '<strong class="error">' . htmlspecialchars( $e->getMessage() ) . '</strong>';
			// end wikia change
		}
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	public static function ifexprObj( $parser, $frame, $args ) {
		$expr = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		$then = isset( $args[1] ) ? $args[1] : '';
		$else = isset( $args[2] ) ? $args[2] : '';
		$result = self::ifexpr( $parser, $expr, $then, $else );
		if ( is_object( $result ) ) {
			$result = trim( $frame->expand( $result ) );
		}
		return $result;
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	public static function ifObj( $parser, $frame, $args ) {
		$test = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		if ( $test !== '' ) {
			return isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		} else {
			return isset( $args[2] ) ? trim( $frame->expand( $args[2] ) ) : '';
		}
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	public static function ifeqObj( $parser, $frame, $args ) {
		$left = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		$right = isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		if ( $left == $right ) {
			return isset( $args[2] ) ? trim( $frame->expand( $args[2] ) ) : '';
		} else {
			return isset( $args[3] ) ? trim( $frame->expand( $args[3] ) ) : '';
		}
	}

	/**
	 * @param $parser Parser
	 * @param $test string
	 * @param $then string
	 * @param $else bool
	 * @return bool|string
	 */
	public static function iferror( $parser, $test = '', $then = '', $else = false ) {
		if ( preg_match( '/<(?:strong|span|p|div)\s(?:[^\s>]*\s+)*?class="(?:[^"\s>]*\s+)*?error(?:\s[^">]*)?"/', $test ) ) {
			return $then;
		} elseif ( $else === false ) {
			return $test;
		} else {
			return $else;
		}
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	public static function iferrorObj( $parser, $frame, $args ) {
		$test = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		$then = isset( $args[1] ) ? $args[1] : false;
		$else = isset( $args[2] ) ? $args[2] : false;
		$result = self::iferror( $parser, $test, $then, $else );
		if ( $result === false ) {
			return '';
		} else {
			return trim( $frame->expand( $result ) );
		}
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args
	 * @return string
	 */
	public static function switchObj( $parser, $frame, $args ) {
		if ( count( $args ) == 0 ) {
			return '';
		}
		$primary = trim( $frame->expand( array_shift( $args ) ) );
		$found = $defaultFound = false;
		$default = null;
		$lastItemHadNoEquals = false;
		$mwDefault =& MagicWord::get( 'default' );
		foreach ( $args as $arg ) {
			$bits = $arg->splitArg();
			$nameNode = $bits['name'];
			$index = $bits['index'];
			$valueNode = $bits['value'];

			if ( $index === '' ) {
				# Found "="
				$lastItemHadNoEquals = false;
				if ( $found ) {
					# Multiple input match
					return trim( $frame->expand( $valueNode ) );
				} else {
					$test = trim( $frame->expand( $nameNode ) );
					if ( $test == $primary ) {
						# Found a match, return now
						return trim( $frame->expand( $valueNode ) );
					} elseif ( $defaultFound || $mwDefault->matchStartAndRemove( $test ) ) {
						$default = $valueNode;
					} # else wrong case, continue
				}
			} else {
				# Multiple input, single output
				# If the value matches, set a flag and continue
				$lastItemHadNoEquals = true;
				$test = trim( $frame->expand( $valueNode ) );
				if ( $test == $primary ) {
					$found = true;
				} elseif ( $mwDefault->matchStartAndRemove( $test ) ) {
					$defaultFound = true;
				}
			}
		}
		# Default case
		# Check if the last item had no = sign, thus specifying the default case
		if ( $lastItemHadNoEquals ) {
			return $test;
		} elseif ( !is_null( $default ) ) {
			return trim( $frame->expand( $default ) );
		} else {
			return '';
		}
	}

	/**
	 * Returns the absolute path to a subpage, relative to the current article
	 * title. Treats titles as slash-separated paths.
	 *
	 * Following subpage link syntax instead of standard path syntax, an
	 * initial slash is treated as a relative path, and vice versa.
	 *
	 * @param $parser Parser
	 * @param $to string
	 * @param $from string
	 *
	 * @return string
	 */
	public static function rel2abs( $parser , $to = '' , $from = '' ) {

		$from = trim( $from );
		if ( $from == '' ) {
			$from = $parser->getTitle()->getPrefixedText();
		}

		$to = rtrim( $to , ' /' );

		// if we have an empty path, or just one containing a dot
		if ( $to == '' || $to == '.' ) {
			return $from;
		}

		// if the path isn't relative
		if ( substr( $to , 0 , 1 ) != '/' &&
		 substr( $to , 0 , 2 ) != './' &&
		 substr( $to , 0 , 3 ) != '../' &&
		 $to != '..' )
		{
			$from = '';
		}
		// Make a long path, containing both, enclose it in /.../
		$fullPath = '/' . $from . '/' .  $to . '/';

		// remove redundant current path dots
		$fullPath = preg_replace( '!/(\./)+!', '/', $fullPath );

		// remove double slashes
		$fullPath = preg_replace( '!/{2,}!', '/', $fullPath );

		// remove the enclosing slashes now
		$fullPath = trim( $fullPath , '/' );
		$exploded = explode ( '/' , $fullPath );
		$newExploded = array();

		foreach ( $exploded as $current ) {
			if ( $current == '..' ) { // removing one level
				if ( !count( $newExploded ) ) {
					// attempted to access a node above root node
					return '<strong class="error">' . wfMsgForContent( 'pfunc_rel2abs_invalid_depth', $fullPath ) . '</strong>';
				}
				// remove last level from the stack
				array_pop( $newExploded );
			} else {
				// add the current level to the stack
				$newExploded[] = $current;
			}
		}

		// we can now join it again
		return implode( '/' , $newExploded );
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @return bool
	 */
	public static function incrementIfexistCount( $parser, $frame ) {
		// Don't let this be called more than a certain number of times. It tends to make the database explode.
		global $wgExpensiveParserFunctionLimit;
		self::registerClearHook();
		$parser->mExpensiveFunctionCount++;
		if ( $frame ) {
			$pdbk = $frame->getPDBK( 1 );
			if ( !isset( $parser->pf_ifexist_breakdown[$pdbk] ) ) {
				$parser->pf_ifexist_breakdown[$pdbk] = 0;
			}
			$parser->pf_ifexist_breakdown[$pdbk] ++;
		}
		return $parser->mExpensiveFunctionCount <= $wgExpensiveParserFunctionLimit;
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $titletext string
	 * @param $then string
	 * @param $else string
	 *
	 * @return string
	 */
	public static function ifexistCommon( $parser, $frame, $titletext = '', $then = '', $else = '' ) {
		global $wgContLang;
		$title = Title::newFromText( $titletext );
		$wgContLang->findVariantLink( $titletext, $title, true );
		if ( $title ) {
			if ( $title->getNamespace() == NS_MEDIA ) {
				/* If namespace is specified as NS_MEDIA, then we want to
				 * check the physical file, not the "description" page.
				 */
				if ( !self::incrementIfexistCount( $parser, $frame ) ) {
					return $else;
				}
				$file = wfFindFile( $title );
				if ( !$file ) {
					return $else;
				}
				$parser->mOutput->addImage(
					$file->getName(), $file->getTimestamp(), $file->getSha1() );
				return $file->exists() ? $then : $else;
			} elseif ( $title->getNamespace() == NS_SPECIAL ) {
				/* Don't bother with the count for special pages,
				 * since their existence can be checked without
				 * accessing the database.
				 */
				return SpecialPageFactory::exists( $title->getDBkey() ) ? $then : $else;
			} elseif ( $title->isExternal() ) {
				/* Can't check the existence of pages on other sites,
				 * so just return $else.  Makes a sort of sense, since
				 * they don't exist _locally_.
				 */
				return $else;
			} else {
				$pdbk = $title->getPrefixedDBkey();
				if ( !self::incrementIfexistCount( $parser, $frame ) ) {
					return $else;
				}
				$lc = LinkCache::singleton();
				$id = $lc->getGoodLinkID( $pdbk );
				if ( $id != 0 ) {
					$parser->mOutput->addLink( $title, $id );
					return $then;
				} elseif ( $lc->isBadLink( $pdbk ) ) {
					$parser->mOutput->addLink( $title, 0 );
					return $else;
				}
				$id = $title->getArticleID();
				$parser->mOutput->addLink( $title, $id );
				if ( $id ) {
					return $then;
				}
			}
		}
		return $else;
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	public static function ifexistObj( $parser, $frame, $args ) {
		$title = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		$then = isset( $args[1] ) ? $args[1] : null;
		$else = isset( $args[2] ) ? $args[2] : null;

		$result = self::ifexistCommon( $parser, $frame, $title, $then, $else );
		if ( $result === null ) {
			return '';
		} else {
			return trim( $frame->expand( $result ) );
		}
	}

	/**
	 * @param $parser Parser
	 * @param $format string
	 * @param $date string
	 * @param $language string
	 * @param $local string|bool
	 * @return string
	 */
	public static function time( $parser, $format = '', $date = '', $language = '', $local = false ) {
		global $wgLocaltimezone;
		self::registerClearHook();
		if ( $date === '' ) {
			$cacheKey = $parser->getOptions()->getTimestamp();
			$date = wfTimestamp( TS_ISO_8601, $cacheKey );
		} else {
			$cacheKey = $date;
		}
		if ( isset( self::$mTimeCache[$format][$cacheKey][$language][$local] ) ) {
			return self::$mTimeCache[$format][$cacheKey][$language][$local];
		}

		# compute the timestamp string $ts
		# PHP >= 5.2 can handle dates before 1970 or after 2038 using the DateTime object

		$invalidTime = false;

		# the DateTime constructor must be used because it throws exceptions
		# when errors occur, whereas date_create appears to just output a warning
		# that can't really be detected from within the code
		try {

			# Default input timezone is UTC.
			$utc = new DateTimeZone( 'UTC' );

			# Correct for DateTime interpreting 'XXXX' as XX:XX o'clock
			if ( preg_match( '/^[0-9]{4}$/', $date ) ) {
				$date = '00:00 '.$date;
			}

			# Parse date
			# UTC is a default input timezone.
			$dateObject = new DateTime( $date, $utc );

			# Set output timezone.
			if ( $local ) {
				if ( isset( $wgLocaltimezone ) ) {
					$tz = new DateTimeZone( $wgLocaltimezone );
				} else {
					$tz = new DateTimeZone( date_default_timezone_get() );
				}
				$dateObject->setTimezone( $tz );
			} else {
				$dateObject->setTimezone( $utc );
			}
			# Generate timestamp
			$ts = $dateObject->format( 'YmdHis' );

		} catch ( Exception $ex ) {
			$invalidTime = true;
		}

		# format the timestamp and return the result
		if ( $invalidTime ) {
			$result = '<strong class="error">' . wfMsgForContent( 'pfunc_time_error' ) . '</strong>';
		} else {
			self::$mTimeChars += strlen( $format );
			if ( self::$mTimeChars > self::$mMaxTimeChars ) {
				return '<strong class="error">' . wfMsgForContent( 'pfunc_time_too_long' ) . '</strong>';
			} else {
				if ( $ts < 100000000000000 ) { // Language can't deal with years after 9999
					if ( $language !== '' && Language::isValidBuiltInCode( $language ) ) {
						// use whatever language is passed as a parameter
						$langObject = Language::factory( $language );
						$result = $langObject->sprintfDate( $format, $ts );
					} else {
						// use wiki's content language
						$result = $parser->getFunctionLang()->sprintfDate( $format, $ts );
					}
				} else {
					return '<strong class="error">' . wfMsgForContent( 'pfunc_time_too_big' ) . '</strong>';
				}
			}
		}
		self::$mTimeCache[$format][$cacheKey][$language][$local] = $result;
		return $result;
	}

	/**
	 * @param $parser Parser
	 * @param $format string
	 * @param $date string
	 * @param $language string
	 * @return string
	 */
	public static function localTime( $parser, $format = '', $date = '', $language = '' ) {
		return self::time( $parser, $format, $date, $language, true );
	}

	/**
	 * Obtain a specified number of slash-separated parts of a title,
	 * e.g. {{#titleparts:Hello/World|1}} => "Hello"
	 *
	 * @param $parser Parent parser
	 * @param $title string Title to split
	 * @param $parts int Number of parts to keep
	 * @param $offset int Offset starting at 1
	 * @return string
	 */
	public static function titleparts( $parser, $title = '', $parts = 0, $offset = 0 ) {
		$parts = intval( $parts );
		$offset = intval( $offset );
		$ntitle = Title::newFromText( $title );
		if ( $ntitle instanceof Title ) {
			$bits = explode( '/', $ntitle->getPrefixedText(), 25 );
			if ( count( $bits ) <= 0 ) {
				 return $ntitle->getPrefixedText();
			} else {
				if ( $offset > 0 ) {
					--$offset;
				}
				if ( $parts == 0 ) {
					return implode( '/', array_slice( $bits, $offset ) );
				} else {
					return implode( '/', array_slice( $bits, $offset, $parts ) );
				}
			}
		} else {
			return $title;
		}
	}

	/**
	 * Get a ConvertParser object
	 * @return ConvertParser
	 */
	protected static function &getConvertParser() {
		if ( !isset( self::$mConvertParser ) ) {
			self::$mConvertParser = new ConvertParser;
		}
		return self::$mConvertParser;
	}

	/**
	 * @return string
	 */
	public static function convert( /*...*/ ) {
		try {
			$args = func_get_args();
			return self::getConvertParser()->execute( $args );
		} catch ( ConvertError $e ) {
			return $e->getMessage();
		}
	}

	/**
	 *  Verifies parameter is less than max string length.
	 * @param $text
	 * @return bool
	 */
	private static function checkLength( $text ) {
		global $wgPFStringLengthLimit;
		return ( mb_strlen( $text ) < $wgPFStringLengthLimit );
	}

	/**
	 * Generates error message.  Called when string is too long.
	 * @return string
	 */
	private static function tooLongError() {
		global $wgPFStringLengthLimit, $wgContLang;
		return '<strong class="error">' .
			wfMsgExt( 'pfunc_string_too_long',
				array( 'escape', 'parsemag', 'content' ),
				$wgContLang->formatNum( $wgPFStringLengthLimit ) ) .
			'</strong>';
	}

	/**
	 * {{#len:string}}
	 *
	 * Reports number of characters in string.
	 * @param $parser Parser
	 * @param $inStr string
	 * @return int
	 */
	public static function runLen ( $parser, $inStr = '' ) {
		wfProfileIn( __METHOD__ );

		$inStr = self::killMarkers( $parser, (string)$inStr );
		$len = mb_strlen( $inStr );

		wfProfileOut( __METHOD__ );
		return $len;
	}

	/**
	 * {{#pos: string | needle | offset}}
	 *
	 * Finds first occurrence of "needle" in "string" starting at "offset".
	 *
	 * Note: If the needle is an empty string, single space is used instead.
	 * Note: If the needle is not found, empty string is returned.
	 * @param $parser Parser
	 * @param $inStr string
	 * @param $inNeedle int
	 * @param $inOffset int
	 * @return int|string
	 */
	public static function runPos ( $parser, $inStr = '', $inNeedle = '', $inOffset = 0 ) {
		wfProfileIn( __METHOD__ );

		$inStr = self::killMarkers( $parser, (string)$inStr );
		$inNeedle = self::killMarkers( $parser, (string)$inNeedle );

		if ( !self::checkLength( $inStr ) ||
			!self::checkLength( $inNeedle ) ) {
			wfProfileOut( __METHOD__ );
			return self::tooLongError();
		}

		if ( $inNeedle == '' ) { $inNeedle = ' '; }

		$pos = mb_strpos( $inStr, $inNeedle, $inOffset );
		if ( $pos === false ) { $pos = ""; }

		wfProfileOut( __METHOD__ );
		return $pos;
	}

	/**
	 * {{#rpos: string | needle}}
	 *
	 * Finds last occurrence of "needle" in "string".
	 *
	 * Note: If the needle is an empty string, single space is used instead.
	 * Note: If the needle is not found, -1 is returned.
	 * @param $parser Parser
	 * @param $inStr string
	 * @param $inNeedle int
	 * @return int|string
	 */
	public static function runRPos ( $parser, $inStr = '', $inNeedle = '' ) {
		wfProfileIn( __METHOD__ );

		$inStr = self::killMarkers( $parser, (string)$inStr );
		$inNeedle = self::killMarkers( $parser, (string)$inNeedle );

		if ( !self::checkLength( $inStr ) ||
			!self::checkLength( $inNeedle ) ) {
			wfProfileOut( __METHOD__ );
			return self::tooLongError();
		}

		if ( $inNeedle == '' ) { $inNeedle = ' '; }

		$pos = mb_strrpos( $inStr, $inNeedle );
		if ( $pos === false ) { $pos = -1; }

		wfProfileOut( __METHOD__ );
		return $pos;
	}

	/**
	 * {{#sub: string | start | length }}
	 *
	 * Returns substring of "string" starting at "start" and having
	 * "length" characters.
	 *
	 * Note: If length is zero, the rest of the input is returned.
	 * Note: A negative value for "start" operates from the end of the
	 *   "string".
	 * Note: A negative value for "length" returns a string reduced in
	 *   length by that amount.
	 *
	 * @param $parser Parser
	 * @param $inStr string
	 * @param $inStart int
	 * @param $inLength int
	 * @return string
	 */
	public static function runSub ( $parser, $inStr = '', $inStart = 0, $inLength = 0 ) {
		wfProfileIn( __METHOD__ );

		$inStr = self::killMarkers( $parser, (string)$inStr );

		if ( !self::checkLength( $inStr ) ) {
			wfProfileOut( __METHOD__ );
			return self::tooLongError();
		}

		if ( intval( $inLength ) == 0 ) {
			$result = mb_substr( $inStr, $inStart );
		} else {
			$result = mb_substr( $inStr, intval( $inStart ), intval( $inLength ) );
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * {{#count: string | substr }}
	 *
	 * Returns number of occurrences of "substr" in "string".
	 *
	 * Note: If "substr" is empty, a single space is used.
	 * @param $parser
	 * @param $inStr string
	 * @param $inSubStr string
	 * @return int|string
	 */
	public static function runCount ( $parser, $inStr = '', $inSubStr = '' ) {
		wfProfileIn( __METHOD__ );

		$inStr = self::killMarkers( $parser, (string)$inStr );
		$inSubStr = self::killMarkers( $parser, (string)$inSubStr );

		if ( !self::checkLength( $inStr ) ||
			!self::checkLength( $inSubStr ) ) {
			wfProfileOut( __METHOD__ );
			return self::tooLongError();
		}

		if ( $inSubStr == '' ) {
			$inSubStr = ' ';
		}

		$result = mb_substr_count( $inStr, $inSubStr );

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * {{#replace:string | from | to | limit }}
	 *
	 * Replaces each occurrence of "from" in "string" with "to".
	 * At most "limit" replacements are performed.
	 *
	 * Note: Armored against replacements that would generate huge strings.
	 * Note: If "from" is an empty string, single space is used instead.
	 * @param $parser Parser
	 * @param $inStr string
	 * @param $inReplaceFrom string
	 * @param $inReplaceTo string
	 * @param $inLimit int
	 * @return mixed|string
	 */
	public static function runReplace( $parser, $inStr = '',
			$inReplaceFrom = '', $inReplaceTo = '', $inLimit = -1 ) {
		global $wgPFStringLengthLimit;
		wfProfileIn( __METHOD__ );

		$inStr = self::killMarkers( $parser, (string)$inStr );
		$inReplaceFrom = self::killMarkers( $parser, (string)$inReplaceFrom );
		$inReplaceTo = self::killMarkers( $parser, (string)$inReplaceTo );

		if ( !self::checkLength( $inStr ) ||
			!self::checkLength( $inReplaceFrom ) ||
			!self::checkLength( $inReplaceTo ) ) {
			wfProfileOut( __METHOD__ );
			return self::tooLongError();
		}

		if ( $inReplaceFrom == '' ) { $inReplaceFrom = ' '; }

		// Precompute limit to avoid generating enormous string:
		$diff = mb_strlen( $inReplaceTo ) - mb_strlen( $inReplaceFrom );
		if ( $diff > 0 ) {
			$limit = ( ( $wgPFStringLengthLimit - mb_strlen( $inStr ) ) / $diff ) + 1;
		} else {
			$limit = -1;
		}

		$inLimit = intval( $inLimit );
		if ( $inLimit >= 0 ) {
			if ( $limit > $inLimit || $limit == -1 ) { $limit = $inLimit; }
		}

		// Use regex to allow limit and handle UTF-8 correctly.
		$inReplaceFrom = preg_quote( $inReplaceFrom, '/' );
		$inReplaceTo = StringUtils::escapeRegexReplacement( $inReplaceTo );

		$result = preg_replace( '/' . $inReplaceFrom . '/u',
						$inReplaceTo, $inStr, $limit );

		if ( !self::checkLength( $result ) ) {
			wfProfileOut( __METHOD__ );
			return self::tooLongError();
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}


	/**
	 * {{#explode:string | delimiter | position | limit}}
	 *
	 * Breaks "string" into chunks separated by "delimiter" and returns the
	 * chunk identified by "position".
	 *
	 * Note: Negative position can be used to specify tokens from the end.
	 * Note: If the divider is an empty string, single space is used instead.
	 * Note: Empty string is returned if there are not enough exploded chunks.
	 * @param $parser Parser
	 * @param $inStr string
	 * @param $inDiv string
	 * @param $inPos int
	 * @param $inLim int|null
	 * @return string
	 */
	public static function runExplode ( $parser, $inStr = '', $inDiv = '', $inPos = 0, $inLim = null ) {
		wfProfileIn( __METHOD__ );

		$inStr = self::killMarkers( $parser, (string)$inStr );
		$inDiv = self::killMarkers( $parser, (string)$inDiv );

		if ( $inDiv == '' ) {
			$inDiv = ' ';
		}

		if ( !self::checkLength( $inStr ) ||
			!self::checkLength( $inDiv ) ) {
			wfProfileOut( __METHOD__ );
			return self::tooLongError();
		}

		$inDiv = preg_quote( $inDiv, '/' );

		$matches = preg_split( '/' . $inDiv . '/u', $inStr, $inLim );

		if ( $inPos >= 0 && isset( $matches[$inPos] ) ) {
			$result = $matches[$inPos];
		} elseif ( $inPos < 0 && isset( $matches[count( $matches ) + $inPos] ) ) {
			$result = $matches[count( $matches ) + $inPos];
		} else {
			$result = '';
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * {{#urldecode:string}}
	 *
	 * Decodes URL-encoded (like%20that) strings.
	 * @param $parser Parser
	 * @param $inStr string
	 * @return string
	 */
	public static function runUrlDecode( $parser, $inStr = '' ) {
		wfProfileIn( __METHOD__ );

		$inStr = self::killMarkers( $parser, (string)$inStr );
		if ( !self::checkLength( $inStr ) ) {
			wfProfileOut( __METHOD__ );
			return self::tooLongError();
		}

		$result = urldecode( $inStr );

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Splits the string into its component parts using preg_match_all().
	 * $chars is set to the resulting array of multibyte characters.
	 * Returns count($chars).
	 * copied from StringFunctions by eloy
	 */
	static protected function mwSplit( &$parser, $str, &$chars ) {
		# Get marker prefix & suffix
		$prefix = preg_quote( $parser->mUniqPrefix, '/' );
		if ( defined( 'Parser::MARKER_SUFFIX' ) ) {
			$suffix = preg_quote( Parser::MARKER_SUFFIX, '/' );
		} elseif ( isset( $parser->mMarkerSuffix ) ) {
			$suffix = preg_quote( $parser->mMarkerSuffix, '/' );
		} elseif ( defined( 'MW_PARSER_VERSION' ) && strcmp( MW_PARSER_VERSION, '1.6.1' ) > 0 ) {
			$suffix = "QINU\x07";
		} else {
			$suffix = 'QINU';
		}

		# Treat strip markers as single multibyte characters
		$count = preg_match_all( '/' . $prefix . '.*?' . $suffix . '|./su', $str, $arr );
		$chars = $arr[0];
		return $count;
	}

	/**
	 * {{#pad:value|length|with|direction}}
	 * Note: Length of the resulting string is limited.
	 *
	 * copied from StringFunctions by eloy
	 */
	static function runPad( &$parser, $inStr = '', $inLen = 0, $inWith = '', $inDirection = '' ) {
		global $wgPFStringLengthLimit;

		# direction
		switch ( strtolower( $inDirection ) ) {
			case 'center':
				$direction = STR_PAD_BOTH;
				break;
			case 'right':
				$direction = STR_PAD_RIGHT;
				break;
			case 'left':
			default:
				$direction = STR_PAD_LEFT;
				break;
		}

		# prevent markers in padding
		$a = explode( $parser->mUniqPrefix, $inWith, 2 );
		if ( $a[0] === '' ) {
			$inWith = ' ';
		} else {
			$inWith = $a[0];
		}

		# limit pad length
		$inLen = intval( $inLen );
		if ( $wgPFStringLengthLimit > 0 ) {
			$inLen = min( $inLen, $wgPFStringLengthLimit );
		}

		# adjust for multibyte strings
		$inLen += mb_strlen( $inStr ) - self::mwSplit( $parser, $inStr, $a );

		# pad
		return str_pad( $inStr, $inLen, $inWith, $direction );
	}

}
