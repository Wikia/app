<?php
/**
 * Used by MW 1.12+
 */
class FCKeditorParserWrapper extends Parser {
	function __construct() {
		global $wgParser;

		parent::__construct();

		$wgParser->firstCallInit();
		foreach( $wgParser->getTags() as $h ) {
			if( !in_array( $h, array( 'pre' ) ) ) {
				$this->setHook( $h, array( $this, 'fck_genericTagHook' ) );
			}
		}
	}

	/**
	 * parse any parentheses in format ((title|part|part))
	 * and call callbacks to get a replacement text for any found piece
	 *
	 * @param string $text The text to parse
	 * @param array $callbacks rules in form:
	 *	 '{' => array(				# opening parentheses
	 *		'end' => '}',   # closing parentheses
	 *		'cb' => array(
	 *			2 => callback,	# replacement callback to call if {{..}} is found
	 *			3 => callback	 # replacement callback to call if {{{..}}} is found
	 *		)
	 *	)
	 *	'min' => 2,	 # Minimum parenthesis count in cb
	 *	'max' => 3,	 # Maximum parenthesis count in cb
	 */
	/*private*/ function replace_callback( $text, $callbacks ) {
		wfProfileIn( __METHOD__ );
		$openingBraceStack = array();	# this array will hold a stack of parentheses which are not closed yet
		$lastOpeningBrace = -1;			# last not closed parentheses

		$validOpeningBraces = implode( '', array_keys( $callbacks ) );

		$i = 0;
		while ( $i < strlen( $text ) ) {
			# Find next opening brace, closing brace or pipe
			if ( $lastOpeningBrace == -1 ) {
				$currentClosing = '';
				$search = $validOpeningBraces;
			} else {
				$currentClosing = $openingBraceStack[$lastOpeningBrace]['braceEnd'];
				$search = $validOpeningBraces . '|' . $currentClosing;
			}
			$rule = null;
			$i += strcspn( $text, $search, $i );
			if ( $i < strlen( $text ) ) {
				if ( $text[$i] == '|' ) {
					$found = 'pipe';
				} elseif ( $text[$i] == $currentClosing ) {
					$found = 'close';
				} elseif ( isset( $callbacks[$text[$i]] ) ) {
					$found = 'open';
					$rule = $callbacks[$text[$i]];
				} else {
					# Some versions of PHP have a strcspn which stops on null characters
					# Ignore and continue
					++$i;
					continue;
				}
			} else {
				# All done
				break;
			}

			if ( $found == 'open' ) {
				# found opening brace, let's add it to parentheses stack
				$piece = array(
					'brace' => $text[$i],
					'braceEnd' => $rule['end'],
					'title' => '',
					'parts' => null
				);

				# count opening brace characters
				$piece['count'] = strspn( $text, $piece['brace'], $i );
				$piece['startAt'] = $piece['partStart'] = $i + $piece['count'];
				$i += $piece['count'];

				# we need to add to stack only if opening brace count is enough for one of the rules
				if ( $piece['count'] >= $rule['min'] ) {
					$lastOpeningBrace ++;
					$openingBraceStack[$lastOpeningBrace] = $piece;
				}
			} elseif ( $found == 'close' ) {
				# lets check if it is enough characters for closing brace
				$maxCount = $openingBraceStack[$lastOpeningBrace]['count'];
				$count = strspn( $text, $text[$i], $i, $maxCount );

				# check for maximum matching characters (if there are 5 closing
				# characters, we will probably need only 3 - depending on the rules)
				$matchingCount = 0;
				$matchingCallback = null;
				$cbType = $callbacks[$openingBraceStack[$lastOpeningBrace]['brace']];
				if ( $count > $cbType['max'] ) {
					# The specified maximum exists in the callback array, unless the caller
					# has made an error
					$matchingCount = $cbType['max'];
				} else {
					# Count is less than the maximum
					# Skip any gaps in the callback array to find the true largest match
					# Need to use array_key_exists not isset because the callback can be null
					$matchingCount = $count;
					while ( $matchingCount > 0 && !array_key_exists( $matchingCount, $cbType['cb'] ) ) {
						--$matchingCount;
					}
				}

				if( $matchingCount <= 0 ) {
					$i += $count;
					continue;
				}
				$matchingCallback = $cbType['cb'][$matchingCount];

				# let's set a title or last part (if '|' was found)
				if( null === $openingBraceStack[$lastOpeningBrace]['parts'] ) {
					$openingBraceStack[$lastOpeningBrace]['title'] =
						substr($text, $openingBraceStack[$lastOpeningBrace]['partStart'],
						$i - $openingBraceStack[$lastOpeningBrace]['partStart']);
				} else {
					$openingBraceStack[$lastOpeningBrace]['parts'][] =
						substr($text, $openingBraceStack[$lastOpeningBrace]['partStart'],
						$i - $openingBraceStack[$lastOpeningBrace]['partStart']);
				}

				$pieceStart = $openingBraceStack[$lastOpeningBrace]['startAt'] - $matchingCount;
				$pieceEnd = $i + $matchingCount;

				if( is_callable( $matchingCallback ) ) {
					$cbArgs = array(
						'text' => substr( $text, $pieceStart, $pieceEnd - $pieceStart ),
						'title' => trim( $openingBraceStack[$lastOpeningBrace]['title'] ),
						'parts' => $openingBraceStack[$lastOpeningBrace]['parts'],
						'lineStart' => ( ( $pieceStart > 0 ) && ( $text[$pieceStart-1] == "\n" ) ),
					);
					# finally we can call a user callback and replace piece of text
					$replaceWith = call_user_func( $matchingCallback, $cbArgs );
					$text = substr( $text, 0, $pieceStart ) . $replaceWith . substr( $text, $pieceEnd );
					$i = $pieceStart + strlen( $replaceWith );
				} else {
					# null value for callback means that parentheses should be parsed, but not replaced
					$i += $matchingCount;
				}

				# reset last opening parentheses, but keep it in case there are unused characters
				$piece = array(
					'brace' => $openingBraceStack[$lastOpeningBrace]['brace'],
					'braceEnd' => $openingBraceStack[$lastOpeningBrace]['braceEnd'],
					'count' => $openingBraceStack[$lastOpeningBrace]['count'],
					'title' => '',
					'parts' => null,
					'startAt' => $openingBraceStack[$lastOpeningBrace]['startAt']
				);
				$openingBraceStack[$lastOpeningBrace--] = null;

				if( $matchingCount < $piece['count'] ) {
					$piece['count'] -= $matchingCount;
					$piece['startAt'] -= $matchingCount;
					$piece['partStart'] = $piece['startAt'];
					# do we still qualify for any callback with remaining count?
					$currentCbList = $callbacks[$piece['brace']]['cb'];
					while ( $piece['count'] ) {
						if ( array_key_exists( $piece['count'], $currentCbList ) ) {
							$lastOpeningBrace++;
							$openingBraceStack[$lastOpeningBrace] = $piece;
							break;
						}
						--$piece['count'];
					}
				}
			} elseif ( $found == 'pipe' ) {
				# let's set a title if it is a first separator, or next part otherwise
				if( null === $openingBraceStack[$lastOpeningBrace]['parts'] ) {
					$openingBraceStack[$lastOpeningBrace]['title'] =
						substr($text, $openingBraceStack[$lastOpeningBrace]['partStart'],
						$i - $openingBraceStack[$lastOpeningBrace]['partStart']);
					$openingBraceStack[$lastOpeningBrace]['parts'] = array();
				} else {
					$openingBraceStack[$lastOpeningBrace]['parts'][] =
						substr($text, $openingBraceStack[$lastOpeningBrace]['partStart'],
						$i - $openingBraceStack[$lastOpeningBrace]['partStart']);
				}
				$openingBraceStack[$lastOpeningBrace]['partStart'] = ++$i;
			}
		}

		wfProfileOut( __METHOD__ );
		return $text;
	}
}
