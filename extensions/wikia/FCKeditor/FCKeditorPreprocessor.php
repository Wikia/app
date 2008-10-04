<?php

class FCKPreprocessor_DOM extends Preprocessor_DOM {
	public $mTemplateRun ;

	function __construct($parser) {
                parent::__construct($parser);
        	$this->mTemplateRun = false ;
        }

        function newFrame() {
                return new FCK_PPFrame_DOM( $this );
        }

	function preprocessToObj( $text, $flags = 0 ) {
		wfProfileIn( __METHOD__ );
		wfProfileIn( __METHOD__.'-makexml' );

		$rules = array(
			'{' =>  array(
					'end'=>'}',
					'names' => array(
						2=> 'template' ,
						3=> 'tplarg' ,
						),
					'min' =>2,
					'max' =>3,
				     ),

			'[' => array(
					'end' => ']',
					'names' => array( 2 => null ),
					'min' => 2,
					'max' => 2,
			)
		);

		$forInclusion = $flags & Parser::PTD_FOR_INCLUSION;

		$xmlishElements = $this->parser->getStripList();
		$enableOnlyinclude = false;
		if ( $forInclusion ) {
			$ignoredTags = array( 'includeonly', '/includeonly' );
			$ignoredElements = array( 'noinclude' );
			$xmlishElements[] = 'noinclude';
			if ( strpos( $text, '<onlyinclude>' ) !== false && strpos( $text, '</onlyinclude>' ) !== false ) {
				$enableOnlyinclude = true;
			}
		} else {
			$ignoredTags = array( 'noinclude', '/noinclude', 'onlyinclude', '/onlyinclude' );
			$ignoredElements = array( 'includeonly' );
			$xmlishElements[] = 'includeonly';
		}
		$xmlishRegex = implode( '|', array_merge( $xmlishElements, $ignoredTags ) );

		// Use "A" modifier (anchored) instead of "^", because ^ doesn't work with an offset
		$elementsRegex = "~($xmlishRegex)(?:\s|\/>|>)|(!--)~iA";
	
		$stack = new PPDStack;

		$searchBase = "[{<\n"; #}
		$revText = strrev( $text ); // For fast reverse searches

		$i = 0;                     # Input pointer, starts out pointing to a pseudo-newline before the start
		$accum =& $stack->getAccum();   # Current accumulator
		$accum = '<root>';
		$findEquals = false;            # True to find equals signs in arguments
		$findPipe = false;              # True to take notice of pipe characters
		$headingIndex = 1;
		$inHeading = false;        # True if $i is inside a possible heading
		$noMoreGT = false;         # True if there are no more greater-than (>) signs right of $i
		$findOnlyinclude = $enableOnlyinclude; # True to ignore all input up to the next <onlyinclude>
		$fakeLineStart = true;     # Do a line-start run without outputting an LF character

		while ( true ) {
			//$this->memCheck();

			if ( $findOnlyinclude ) {
				// Ignore all input up to the next <onlyinclude>
				$startPos = strpos( $text, '<onlyinclude>', $i );
				if ( $startPos === false ) {
					// Ignored section runs to the end
					$accum .= '<ignore>' . htmlspecialchars( substr( $text, $i ) ) . '</ignore>';
					break;
				}
				$tagEndPos = $startPos + strlen( '<onlyinclude>' ); // past-the-end
				$accum .= '<ignore>' . htmlspecialchars( substr( $text, $i, $tagEndPos - $i ) ) . '</ignore>';
				$i = $tagEndPos;
				$findOnlyinclude = false;
			}

			if ( $fakeLineStart ) {
				$found = 'line-start';
				$curChar = '';
			} else {
				# Find next opening brace, closing brace or pipe
				$search = $searchBase;
				if ( $stack->top === false ) {
					$currentClosing = '';
				} else {
					$currentClosing = $stack->top->close;
					$search .= $currentClosing;
				}
				if ( $findPipe ) {
					$search .= '|';
				}
				if ( $findEquals ) {
					// First equals will be for the template
					$search .= '=';
				}
				$rule = null;
				# Output literal section, advance input counter
				$literalLength = strcspn( $text, $search, $i );
				if ( $literalLength > 0 ) {
					$accum .= htmlspecialchars( substr( $text, $i, $literalLength ) );
					$i += $literalLength;
				}
				if ( $i >= strlen( $text ) ) {
					if ( $currentClosing == "\n" ) {
						// Do a past-the-end run to finish off the heading
						$curChar = '';
						$found = 'line-end';
					} else {
						# All done
						break;
					}
				} else {
					$curChar = $text[$i];
					if ( $curChar == '|' ) {
						$found = 'pipe';
					} elseif ( $curChar == '=' ) {
						$found = 'equals';
					} elseif ( $curChar == '<' ) {
						$found = 'angle';
					} elseif ( $curChar == "\n" ) {
						if ( $inHeading ) {
							$found = 'line-end';
						} else {
							$found = 'line-start';
						}
					} elseif ( $curChar == $currentClosing ) {
						$found = 'close';
					} elseif ( isset( $rules[$curChar] ) ) {
						$found = 'open';
						$rule = $rules[$curChar];
					} else {
						# Some versions of PHP have a strcspn which stops on null characters
						# Ignore and continue
						++$i;
						continue;
					}
				}
			}

			if ( $found == 'angle' ) {
				$matches = false;
				// Handle </onlyinclude>
				if ( $enableOnlyinclude && substr( $text, $i, strlen( '</onlyinclude>' ) ) == '</onlyinclude>' ) {
					$findOnlyinclude = true;
					continue;
				}

				// Determine element name
				if ( !preg_match( $elementsRegex, $text, $matches, 0, $i + 1 ) ) {
					// Element name missing or not listed
					$accum .= '&lt;';
					++$i;
					continue;
				}
				// Handle comments
				if ( isset( $matches[2] ) && $matches[2] == '!--' ) {
					// To avoid leaving blank lines, when a comment is both preceded
					// and followed by a newline (ignoring spaces), trim leading and
					// trailing spaces and one of the newlines.
					
					// Find the end
					$endPos = strpos( $text, '-->', $i + 4 );
					if ( $endPos === false ) {
						// Unclosed comment in input, runs to end
						$inner = substr( $text, $i );
						$accum .= '<comment>' . htmlspecialchars( $inner ) . '</comment>';
						$i = strlen( $text );
					} else {
						// Search backwards for leading whitespace
						$wsStart = $i ? ( $i - strspn( $revText, ' ', strlen( $text ) - $i ) ) : 0;
						// Search forwards for trailing whitespace
						// $wsEnd will be the position of the last space
						$wsEnd = $endPos + 2 + strspn( $text, ' ', $endPos + 3 );
						// Eat the line if possible
						// TODO: This could theoretically be done if $wsStart == 0, i.e. for comments at 
						// the overall start. That's not how Sanitizer::removeHTMLcomments() did it, but 
						// it's a possible beneficial b/c break.
						if ( $wsStart > 0 && substr( $text, $wsStart - 1, 1 ) == "\n" 
							&& substr( $text, $wsEnd + 1, 1 ) == "\n" )
						{
							$startPos = $wsStart;
							$endPos = $wsEnd + 1;
							// Remove leading whitespace from the end of the accumulator
							// Sanity check first though
							$wsLength = $i - $wsStart;
							if ( $wsLength > 0 && substr( $accum, -$wsLength ) === str_repeat( ' ', $wsLength ) ) {
								$accum = substr( $accum, 0, -$wsLength );
							}
							// Do a line-start run next time to look for headings after the comment
							$fakeLineStart = true;
						} else {
							// No line to eat, just take the comment itself
							$startPos = $i;
							$endPos += 2;
						}

						if ( $stack->top ) {
							$part = $stack->top->getCurrentPart();
							if ( isset( $part->commentEnd ) && $part->commentEnd == $wsStart - 1 ) {
								// Comments abutting, no change in visual end
								$part->commentEnd = $wsEnd;
							} else {
								$part->visualEnd = $wsStart;
								$part->commentEnd = $endPos;
							}
						}
						$i = $endPos + 1;
						$inner = substr( $text, $startPos, $endPos - $startPos + 1 );
						$accum .= '<comment>' . htmlspecialchars( $inner ) . '</comment>';
					}
					continue;
				}
				$name = $matches[1];
				$attrStart = $i + strlen( $name ) + 1;

				// Find end of tag
				$tagEndPos = $noMoreGT ? false : strpos( $text, '>', $attrStart );
				if ( $tagEndPos === false ) {
					// Infinite backtrack
					// Disable tag search to prevent worst-case O(N^2) performance
					$noMoreGT = true;
					$accum .= '&lt;';
					++$i;
					continue;
				}

				// Handle ignored tags
				if ( in_array( $name, $ignoredTags ) ) {
					$accum .= '<ignore>' . htmlspecialchars( substr( $text, $i, $tagEndPos - $i + 1 ) ) . '</ignore>';
					$i = $tagEndPos + 1;
					continue;
				}

				$tagStartPos = $i;
				if ( $text[$tagEndPos-1] == '/' ) {
					$attrEnd = $tagEndPos - 1;
					$inner = null;
					$i = $tagEndPos + 1;
					$close = '';
				} else {
					$attrEnd = $tagEndPos;
					// Find closing tag
					if ( preg_match( "/<\/$name\s*>/i", $text, $matches, PREG_OFFSET_CAPTURE, $tagEndPos + 1 ) ) {
						$inner = substr( $text, $tagEndPos + 1, $matches[0][1] - $tagEndPos - 1 );
						$i = $matches[0][1] + strlen( $matches[0][0] );
						$close = '<close>' . htmlspecialchars( $matches[0][0] ) . '</close>';
					} else {
						// No end tag -- let it run out to the end of the text.
						$inner = substr( $text, $tagEndPos + 1 );
						$i = strlen( $text );
						$close = '';
					}
				}
				// <includeonly> and <noinclude> just become <ignore> tags
				if ( in_array( $name, $ignoredElements ) ) {
					$accum .= '<ignore>' . htmlspecialchars( substr( $text, $tagStartPos, $i - $tagStartPos ) ) 
						. '</ignore>';
					continue;
				}

				$accum .= '<ext>';
				if ( $attrEnd <= $attrStart ) {
					$attr = '';
				} else {
					$attr = substr( $text, $attrStart, $attrEnd - $attrStart );
				}
				$accum .= '<name>' . htmlspecialchars( $name ) . '</name>' .
					// Note that the attr element contains the whitespace between name and attribute, 
					// this is necessary for precise reconstruction during pre-save transform.
					'<attr>' . htmlspecialchars( $attr ) . '</attr>';
				if ( $inner !== null ) {
					$accum .= '<inner>' . htmlspecialchars( $inner ) . '</inner>';
				}
				$accum .= $close . '</ext>';
			}

			elseif ( $found == 'line-start' ) {
				// Is this the start of a heading? 
				// Line break belongs before the heading element in any case
				if ( $fakeLineStart ) {
					$fakeLineStart = false;
				} else {
					$accum .= $curChar;
					$i++;
				}
				
				$count = strspn( $text, '=', $i, 6 );
				if ( $count == 1 && $findEquals ) {
					// DWIM: This looks kind of like a name/value separator
					// Let's let the equals handler have it and break the potential heading
					// This is heuristic, but AFAICT the methods for completely correct disambiguation are very complex.
				} elseif ( $count > 0 ) {
					$piece = array(
						'open' => "\n",
						'close' => "\n",
						'parts' => array( new PPDPart( str_repeat( '=', $count ) ) ),
						'startPos' => $i,
						'count' => $count );
					$stack->push( $piece );
					$accum =& $stack->getAccum();
					extract( $stack->getFlags() );
					$i += $count;
				}
			}

			elseif ( $found == 'line-end' ) {
				$piece = $stack->top;
				// A heading must be open, otherwise \n wouldn't have been in the search list
				assert( $piece->open == "\n" );
				$part = $piece->getCurrentPart();
				// Search back through the input to see if it has a proper close
				// Do this using the reversed string since the other solutions (end anchor, etc.) are inefficient
				$wsLength = strspn( $revText, " \t", strlen( $text ) - $i );
				$searchStart = $i - $wsLength;
				if ( isset( $part->commentEnd ) && $searchStart - 1 == $part->commentEnd ) {
					// Comment found at line end
					// Search for equals signs before the comment
					$searchStart = $part->visualEnd;
					$searchStart -= strspn( $revText, " \t", strlen( $text ) - $searchStart );
				}
				$count = $piece->count;
				$equalsLength = strspn( $revText, '=', strlen( $text ) - $searchStart );
				if ( $equalsLength > 0 ) {
					if ( $i - $equalsLength == $piece->startPos ) {
						// This is just a single string of equals signs on its own line
						// Replicate the doHeadings behaviour /={count}(.+)={count}/
						// First find out how many equals signs there really are (don't stop at 6)
						$count = $equalsLength;
						if ( $count < 3 ) {
							$count = 0;
						} else {
							$count = min( 6, intval( ( $count - 1 ) / 2 ) );
						}
					} else {
						$count = min( $equalsLength, $count );
					}
					if ( $count > 0 ) {
						// Normal match, output <h>
						$element = "<h level=\"$count\" i=\"$headingIndex\">$accum</h>";
						$headingIndex++;
					} else {
						// Single equals sign on its own line, count=0
						$element = $accum;
					}
				} else {
					// No match, no <h>, just pass down the inner text
					$element = $accum;
				}
				// Unwind the stack
				$stack->pop();
				$accum =& $stack->getAccum();
				extract( $stack->getFlags() );

				// Append the result to the enclosing accumulator
				$accum .= $element;
				// Note that we do NOT increment the input pointer.
				// This is because the closing linebreak could be the opening linebreak of 
				// another heading. Infinite loops are avoided because the next iteration MUST
				// hit the heading open case above, which unconditionally increments the 
				// input pointer.
			}
			
			elseif ( $found == 'open' ) {
				# count opening brace characters
				$count = strspn( $text, $curChar, $i );

				# we need to add to stack only if opening brace count is enough for one of the rules
				if ( $count >= $rule['min'] ) {
				# Add it to the stack
					$piece = array(
							'open' => $curChar,
							'close' => $rule['end'],
							'count' => $count,
							'lineStart' => ($i > 0 && $text[$i-1] == "\n"),
						      );

					$stack->push( $piece );
					$accum =& $stack->getAccum();
					extract( $stack->getFlags() );
				} else {
					# Add literal brace(s)
					$accum .= htmlspecialchars( str_repeat( $curChar, $count ) );
				}
				$i += $count;
			}

			elseif ( $found == 'close' ) {
				$piece = $stack->top;
				# lets check if there are enough characters for closing brace
				$maxCount = $piece->count;
				$count = strspn( $text, $curChar, $i, $maxCount );

				# check for maximum matching characters (if there are 5 closing
				# characters, we will probably need only 3 - depending on the rules)
				$matchingCount = 0;
				$rule = $rules[$piece->open];
				if ( $count > $rule['max'] ) {
					# The specified maximum exists in the callback array, unless the caller
					# has made an error
					$matchingCount = $rule['max'];
				} else {
					# Count is less than the maximum
					# Skip any gaps in the callback array to find the true largest match
					# Need to use array_key_exists not isset because the callback can be null
					$matchingCount = $count;
					while ( $matchingCount > 0 && !array_key_exists( $matchingCount, $rule['names'] ) ) {
						--$matchingCount;
					}
				}

				if ($matchingCount <= 0) {
					# No matching element found in callback array
					# Output a literal closing brace and continue
					$accum .= htmlspecialchars( str_repeat( $curChar, $count ) );
					$i += $count;
					continue;
				}
				$name = $rule['names'][$matchingCount];
				if ( $name === null ) {
					// No element, just literal text
					$element = $piece->breakSyntax( $matchingCount ) . str_repeat( $rule['end'], $matchingCount );
				} else {
					# Create XML element
					# Note: $parts is already XML, does not need to be encoded further
					$parts = $piece->parts;
					$title = $parts[0]->out;
					unset( $parts[0] );

					# The invocation is at the start of the line if lineStart is set in 
					# the stack, and all opening brackets are used up.
					if ( $maxCount == $matchingCount && !empty( $piece->lineStart ) ) {
						$attr = ' lineStart="1"';
					} else {
						$attr = '';
					}

					$element = "<$name$attr>";
					$element .= "<title>$title</title>";
					$argIndex = 1;
					foreach ( $parts as $partIndex => $part ) {
						if ( isset( $part->eqpos ) ) {
							$argName = substr( $part->out, 0, $part->eqpos );
							$argValue = substr( $part->out, $part->eqpos + 1 );
							$element .= "<part><name>$argName</name>=<value>$argValue</value></part>";
						} else {
							$element .= "<part><name index=\"$argIndex\" /><value>{$part->out}</value></part>";
							$argIndex++;
						}
					}
					$element .= "</$name>";
				}

				# Advance input pointer
				$i += $matchingCount;

				# Unwind the stack
				$stack->pop();
				$accum =& $stack->getAccum();

				# Re-add the old stack element if it still has unmatched opening characters remaining
				if ($matchingCount < $piece->count) {
					$piece->parts = array( new PPDPart );
					$piece->count -= $matchingCount;
					# do we still qualify for any callback with remaining count?
					$names = $rules[$piece->open]['names'];
					$skippedBraces = 0;
					$enclosingAccum =& $accum;
					while ( $piece->count ) {
						if ( array_key_exists( $piece->count, $names ) ) {
							$stack->push( $piece );
							$accum =& $stack->getAccum();
							break;
						}
						--$piece->count;
						$skippedBraces ++;
					}
					$enclosingAccum .= str_repeat( $piece->open, $skippedBraces );
				}

				extract( $stack->getFlags() );

				# Add XML element to the enclosing accumulator
				$accum .= $element;
			}
			
			elseif ( $found == 'pipe' ) {
				$findEquals = true; // shortcut for getFlags()
				$stack->addPart();
				$accum =& $stack->getAccum();
				++$i;
			}
			
			elseif ( $found == 'equals' ) {
				$findEquals = false; // shortcut for getFlags()
				$stack->getCurrentPart()->eqpos = strlen( $accum );
				$accum .= '=';
				++$i;
			}
		}

		# Output any remaining unclosed brackets
		foreach ( $stack->stack as $piece ) {
			$stack->rootAccum .= $piece->breakSyntax();
		}
		$stack->rootAccum .= '</root>';
		$xml = $stack->rootAccum;

		wfProfileOut( __METHOD__.'-makexml' );
		wfProfileIn( __METHOD__.'-loadXML' );
		$dom = new DOMDocument;
		wfSuppressWarnings();
		$result = $dom->loadXML( $xml );
		wfRestoreWarnings();
		if ( !$result ) {
			// Try running the XML through UtfNormal to get rid of invalid characters
			$xml = UtfNormal::cleanUp( $xml );
			$result = $dom->loadXML( $xml );
			if ( !$result ) {
				throw new MWException( __METHOD__.' generated invalid XML' );
			}
		}
		$obj = new PPNode_DOM( $dom->documentElement );
		wfProfileOut( __METHOD__.'-loadXML' );
		wfProfileOut( __METHOD__ );
		return $obj;
	}
}

class FCK_PPFrame_DOM extends PPFrame_DOM {
		function expand( $root, $flags = 0 ) {
		if ( is_string( $root ) ) {
			return $root;
		}

		if ( ++$this->parser->mPPNodeCount > $this->parser->mOptions->mMaxPPNodeCount ) 
		{
			return '<span class="error">Node-count limit exceeded</span>';
		}

		if ( $root instanceof PPNode_DOM ) {
			$root = $root->node;
		}
		if ( $root instanceof DOMDocument ) {
			$root = $root->documentElement;
		}

		$outStack = array( '', '' );
		$iteratorStack = array( false, $root );
		$indexStack = array( 0, 0 );

		while ( count( $iteratorStack ) > 1 ) {
			$level = count( $outStack ) - 1;
			$iteratorNode =& $iteratorStack[ $level ];
			$out =& $outStack[$level];
			$index =& $indexStack[$level];

			if ( $iteratorNode instanceof PPNode_DOM ) $iteratorNode = $iteratorNode->node;

			if ( is_array( $iteratorNode ) ) {
				if ( $index >= count( $iteratorNode ) ) {
					// All done with this iterator
					$iteratorStack[$level] = false;
					$contextNode = false;
				} else {
					$contextNode = $iteratorNode[$index];
					$index++;
				}
			} elseif ( $iteratorNode instanceof DOMNodeList ) {
				if ( $index >= $iteratorNode->length ) {
					// All done with this iterator
					$iteratorStack[$level] = false;
					$contextNode = false;
				} else {
					$contextNode = $iteratorNode->item( $index );
					$index++;
				}
			} else {
				// Copy to $contextNode and then delete from iterator stack, 
				// because this is not an iterator but we do have to execute it once
				$contextNode = $iteratorStack[$level];
				$iteratorStack[$level] = false;
			}

			if ( $contextNode instanceof PPNode_DOM ) $contextNode = $contextNode->node;

			$newIterator = false;

			if ( $contextNode === false ) {
				// nothing to do
			} elseif ( is_string( $contextNode ) ) {
				$out .= $contextNode;
			} elseif ( is_array( $contextNode ) || $contextNode instanceof DOMNodeList ) {
				$newIterator = $contextNode;
			} elseif ( $contextNode instanceof DOMNode ) {
				if ( $contextNode->nodeType == XML_TEXT_NODE ) {
					$out .= $contextNode->nodeValue;
				} elseif ( $contextNode->nodeName == 'template' ) {
					# Double-brace expansion
					$xpath = new DOMXPath( $contextNode->ownerDocument );
					$titles = $xpath->query( 'title', $contextNode );
					$title = $titles->item( 0 );
					$parts = $xpath->query( 'part', $contextNode );
					if ( $flags & self::NO_TEMPLATES ) {
						$newIterator = $this->virtualBracketedImplode( '{{', '|', '}}', $title, $parts );
					} else {						
						$newIterator = $this->virtualBracketedImplode( '<!--FCK_SKIP_START-->{{', '|', '}}<!--FCK_SKIP_END-->', $title, $parts ) ;
					}
				} elseif ( $contextNode->nodeName == 'tplarg' ) {
					# Triple-brace expansion
					$xpath = new DOMXPath( $contextNode->ownerDocument );
					$titles = $xpath->query( 'title', $contextNode );
					$title = $titles->item( 0 );
					$parts = $xpath->query( 'part', $contextNode );
					if ( $flags & self::NO_ARGS ) {
						$newIterator = $this->virtualBracketedImplode( '{{{', '|', '}}}', $title, $parts );
					} else {
						$params = array( 
							'title' => new PPNode_DOM( $title ), 
							'parts' => new PPNode_DOM( $parts ) );
						$ret = $this->parser->argSubstitution( $params, $this );
						if ( isset( $ret['object'] ) ) {
							$newIterator = $ret['object'];
						} else {
							$out .= $ret['text'];
						}
					}
				} elseif ( $contextNode->nodeName == 'comment' ) {
					# HTML-style comment
					# Remove it in HTML, pre+remove and STRIP_COMMENTS modes
					if ( $this->parser->ot['html'] 
						|| ( $this->parser->ot['pre'] && $this->parser->mOptions->getRemoveComments() ) 
						|| ( $flags & self::STRIP_COMMENTS ) ) 
					{
						$out .= '';
					}
					# Add a strip marker in PST mode so that pstPass2() can run some old-fashioned regexes on the result
					# Not in RECOVER_COMMENTS mode (extractSections) though
					elseif ( $this->parser->ot['wiki'] && ! ( $flags & self::RECOVER_COMMENTS ) ) {
						$out .= $this->parser->insertStripItem( $contextNode->textContent );
					}
					# Recover the literal comment in RECOVER_COMMENTS and pre+no-remove
					else {
						$out .= $contextNode->textContent;
					}
				} elseif ( $contextNode->nodeName == 'ignore' ) {
					# Output suppression used by <includeonly> etc.
					# OT_WIKI will only respect <ignore> in substed templates.
					# The other output types respect it unless NO_IGNORE is set. 
					# extractSections() sets NO_IGNORE and so never respects it.
					if ( ( !isset( $this->parent ) && $this->parser->ot['wiki'] ) || ( $flags & self::NO_IGNORE ) ) {
						$out .= $contextNode->textContent;
					} else {
						$out .= '';
					}
				} elseif ( $contextNode->nodeName == 'ext' ) {
					# Extension tag
					$xpath = new DOMXPath( $contextNode->ownerDocument );
					$names = $xpath->query( 'name', $contextNode );
					$attrs = $xpath->query( 'attr', $contextNode );
					$inners = $xpath->query( 'inner', $contextNode );
					$closes = $xpath->query( 'close', $contextNode );
					$params = array(
						'name' => new PPNode_DOM( $names->item( 0 ) ),
						'attr' => $attrs->length > 0 ? new PPNode_DOM( $attrs->item( 0 ) ) : null,
						'inner' => $inners->length > 0 ? new PPNode_DOM( $inners->item( 0 ) ) : null,
						'close' => $closes->length > 0 ? new PPNode_DOM( $closes->item( 0 ) ) : null,
					);
					$out .= $this->parser->extensionSubstitution( $params, $this );
				} elseif ( $contextNode->nodeName == 'h' ) {
					# Heading
					$s = $this->expand( $contextNode->childNodes, $flags );

                    # Insert a heading marker only for <h> children of <root>
                    # This is to stop extractSections from going over multiple tree levels
                    if ( $contextNode->parentNode->nodeName == 'root' 
                      && $this->parser->ot['html'] ) 
                    {
						# Insert heading index marker
						$headingIndex = $contextNode->getAttribute( 'i' );
						$titleText = $this->title->getPrefixedDBkey();
						$this->parser->mHeadings[] = array( $titleText, $headingIndex );
						$serial = count( $this->parser->mHeadings ) - 1;
						$marker = "{$this->parser->mUniqPrefix}-h-$serial-{$this->parser->mMarkerSuffix}";
						$count = $contextNode->getAttribute( 'level' );
						$s = substr( $s, 0, $count ) . $marker . substr( $s, $count );
						$this->parser->mStripState->general->setPair( $marker, '' );
					}
					$out .= $s;
				} else {
					# Generic recursive expansion
					$newIterator = $contextNode->childNodes;
				}
			} else {
				throw new MWException( __METHOD__.': Invalid parameter type' );
			}

			if ( $newIterator !== false ) {
				if ( $newIterator instanceof PPNode_DOM ) {
					$newIterator = $newIterator->node;
				}
				$outStack[] = '';
				$iteratorStack[] = $newIterator;
				$indexStack[] = 0;
			} elseif ( $iteratorStack[$level] === false ) {
				// Return accumulated value to parent
				// With tail recursion
				while ( $iteratorStack[$level] === false && $level > 0 ) {
					$outStack[$level - 1] .= $out;
					array_pop( $outStack );
					array_pop( $iteratorStack );
					array_pop( $indexStack );
					$level--;
				}
			}
		}
		return $outStack[0];
	}
}

