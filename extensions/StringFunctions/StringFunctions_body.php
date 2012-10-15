<?php

class ExtStringFunctions {

	/**
	 * Returns part of the perl regexp pattern that matches a marker.
	 * Unfortunatelly, we are still backward-supporting old versions.
	 */
	static protected function mwMarkerRE( &$parser ) {
		if ( defined( 'Parser::MARKER_SUFFIX' ) ) {
			$suffix = preg_quote( Parser::MARKER_SUFFIX, '/' );
		} elseif ( isset( $parser->mMarkerSuffix ) ) {
			$suffix = preg_quote( $parser->mMarkerSuffix, '/' );
		} elseif ( defined( 'MW_PARSER_VERSION' ) && strcmp( MW_PARSER_VERSION, '1.6.1' ) > 0 ) {
			$suffix = "QINU\x07";
		} else {
			$suffix = 'QINU';
		}

		return preg_quote( $parser->mUniqPrefix, '/' ) . '.*?' . $suffix;
	}

	/**
	 * {{#len:value}}
	 *
	 * Main idea: Count multibytes. Find markers. Substract.
	 */
	static function runLen( &$parser, $inStr = '' ) {
		$len = mb_strlen( (string)$inStr );

		$count = preg_match_all (
			'/' . self::mwMarkerRE( $parser ) . '/',
			(string) $inStr, $matches
		);

		foreach ( $matches[0] as $match ) {
			$len -= strlen( $match ) - 1;
		}

		return $len;
	}

	/**
	 * Splits the string into its component parts using preg_match_all().
	 * $chars is set to the resulting array of multibyte characters.
	 * Returns count($chars).
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
	 * {{#pos:value|key|offset}}
	 * Note: If the needle is an empty string, single space is used instead.
	 * Note: If the needle is not found, empty string is returned.
	 * Note: The needle is limited to specific length.
	 */
	static function runPos( &$parser, $inStr = '', $inNeedle = '', $inOffset = 0 ) {
		global $wgStringFunctionsLimitSearch;

		if ( $inNeedle === '' ) {
			# empty needle
			$needle = array( ' ' );
			$nSize = 1;
		} else {
			# convert needle
			$nSize = self::mwSplit( $parser, $inNeedle, $needle );

			if ( $nSize > $wgStringFunctionsLimitSearch ) {
				$nSize = $wgStringFunctionsLimitSearch;
				$needle = array_slice( $needle, 0, $nSize );
			}
		}

		# convert string
		$size = self::mwSplit( $parser, $inStr, $chars ) - $nSize;
		$inOffset = max( intval( $inOffset ), 0 );

		# find needle
		for ( $i = $inOffset; $i <= $size; $i++ ) {
			if ( $chars[$i] !== $needle[0] ) {
				continue;
			}
			for ( $j = 1; ; $j++ ) {
				if ( $j >= $nSize ) {
					return $i;
				}
				if ( $chars[$i + $j] !== $needle[$j] ) {
					break;
				}
			}
		}

		# return empty string upon not found
		return '';
	}

	/**
	 * {{#rpos:value|key}}
	 * Note: If the needle is an empty string, single space is used instead.
	 * Note: If the needle is not found, -1 is returned.
	 * Note: The needle is limited to specific length.
	 */
	static function runRPos( &$parser, $inStr = '', $inNeedle = '' ) {
		global $wgStringFunctionsLimitSearch;

		if ( $inNeedle === '' ) {
			# empty needle
			$needle = array( ' ' );
			$nSize = 1;
		} else {
			# convert needle
			$nSize = self::mwSplit( $parser, $inNeedle, $needle );

			if ( $nSize > $wgStringFunctionsLimitSearch ) {
				$nSize = $wgStringFunctionsLimitSearch;
				$needle = array_slice ( $needle, 0, $nSize );
			}
		}

		# convert string
		$size = self::mwSplit( $parser, $inStr, $chars ) - $nSize;

		# find needle
		for ( $i = $size; $i >= 0; $i-- ) {
			if ( $chars[$i] !== $needle[0] ) {
				continue;
			}
			for ( $j = 1; ; $j++ ) {
				if ( $j >= $nSize ) {
					return $i;
				}
				if ( $chars[$i + $j] !== $needle[$j] ) {
					break;
				}
			}
		}

		# return -1 upon not found
		return '-1';
	}

	/**
	 * {{#sub:value|start|length}}
	 * Note: If length is zero, the rest of the input is returned.
	 */
	static function runSub( &$parser, $inStr = '', $inStart = 0, $inLength = 0 ) {
		# convert string
		self::mwSplit( $parser, $inStr, $chars );

		# zero length
		if ( intval( $inLength ) == 0 ) {
			return join( '', array_slice( $chars, intval( $inStart ) ) );
		}

		# non-zero length
		return join( '', array_slice( $chars, intval( $inStart ), intval( $inLength ) ) );
	}

	/**
	 * {{#pad:value|length|with|direction}}
	 * Note: Length of the resulting string is limited.
	 */
	static function runPad( &$parser, $inStr = '', $inLen = 0, $inWith = '', $inDirection = '' ) {
		global $wgStringFunctionsLimitPad;

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
		if ( $wgStringFunctionsLimitPad > 0 ) {
			$inLen = min( $inLen, $wgStringFunctionsLimitPad );
		}

		# adjust for multibyte strings
		$inLen += strlen( $inStr ) - self::mwSplit( $parser, $inStr, $a );

		# pad
		return str_pad( $inStr, $inLen, $inWith, $direction );
	}

	/**
	 * {{#replace:value|from|to}}
	 * Note: If the needle is an empty string, single space is used instead.
	 * Note: The needle is limited to specific length.
	 * Note: The product is limited to specific length.
	 */
	static function runReplace( &$parser, $inStr = '', $inReplaceFrom = '', $inReplaceTo = '' ) {
		global $wgStringFunctionsLimitSearch, $wgStringFunctionsLimitReplace;

		if ( $inReplaceFrom === '' ) {
			# empty needle
			$needle = array( ' ' );
			$nSize = 1;
		} else {
			# convert needle
			$nSize = self::mwSplit( $parser, $inReplaceFrom, $needle );
			if ( $nSize > $wgStringFunctionsLimitSearch ) {
				$nSize = $wgStringFunctionsLimitSearch;
				$needle = array_slice( $needle, 0, $nSize );
			}
		}

		# convert product
		$pSize = self::mwSplit( $parser, $inReplaceTo, $product );
		if ( $pSize > $wgStringFunctionsLimitReplace ) {
			$pSize = $wgStringFunctionsLimitReplace;
			$product = array_slice( $product, 0, $pSize );
		}

		# remove markers in product
		for( $i = 0; $i < $pSize; $i++ ) {
			if( strlen( $product[$i] ) > 6 ) {
				$product[$i] = ' ';
			}
		}

		# convert string
		$size = self::mwSplit( $parser, $inStr, $chars ) - $nSize;

		# replace
		for ( $i = 0; $i <= $size; $i++ ) {
			if ( $chars[$i] !== $needle[0] ) {
				continue;
			}
			for ( $j = 1; ; $j++ ) {
				if ( $j >= $nSize ) {
					array_splice( $chars, $i, $j, $product );
					$size += ( $pSize - $nSize );
					$i += ( $pSize - 1 );
					break;
				}
				if ( $chars[$i + $j] !== $needle[$j] ) {
					break;
				}
			}
		}
		return join( '', $chars );
	}

	/**
	 * {{#explode:value|delimiter|position}}
	 * Note: Negative position can be used to specify tokens from the end.
	 * Note: If the divider is an empty string, single space is used instead.
	 * Note: The divider is limited to specific length.
	 * Note: Empty string is returned, if there is not enough exploded chunks.
	 */
	static function runExplode( &$parser, $inStr = '', $inDiv = '', $inPos = 0 ) {
		global $wgStringFunctionsLimitSearch;

		if ( $inDiv === '' ) {
			# empty divider
			$div = array( ' ' );
			$dSize = 1;
		} else {
			# convert divider
			$dSize = self::mwSplit( $parser, $inDiv, $div );
			if ( $dSize > $wgStringFunctionsLimitSearch ) {
				$dSize = $wgStringFunctionsLimitSearch;
				$div = array_slice ( $div, 0, $dSize );
			}
		}

		# convert string
		$size = self::mwSplit( $parser, $inStr, $chars ) - $dSize;

		# explode
		$inPos = intval( $inPos );
		$tokens = array();
		$start = 0;
		for ( $i = 0; $i <= $size; $i++ ) {
			if ( $chars[$i] !== $div[0] ) {
				continue;
			}
			for ( $j = 1; ; $j++ ) {
				if ( $j >= $dSize ) {
					if ( $inPos > 0 ) {
						$inPos--;
					} else {
						$tokens[] = join( '', array_slice( $chars, $start, ( $i - $start ) ) );
						if ( $inPos == 0 ) {
							return $tokens[0];
						}
					}
					$start = $i + $j;
					$i = $start - 1;
					break;
				}
				if ( $chars[$i + $j] !== $div[$j] ) {
					break;
				}
			}
		}
		$tokens[] = join( '', array_slice( $chars, $start ) );

		# negative $inPos
		if ( $inPos < 0 ) {
			$inPos += count( $tokens );
		}

		# out of range
		if ( !isset( $tokens[$inPos] ) ) {
			return '';
		}

		# in range
		return $tokens[$inPos];
	}

	/**
	 * {{#urldecode:value}}
	 */
	static function runUrlDecode( &$parser, $inStr = '' ) {
		# decode
		return urldecode( $inStr );
	}
}
