<?php

class FCKeditorParser extends FCKeditorParserWrapper {
	public static $fkc_mw_makeImage_options;
	protected $fck_mw_strtr_span;
	protected $fck_mw_strtr_span_counter = 1;
	protected $fck_mw_taghook;
	protected $fck_internal_parse_text;
	protected $fck_matches = array();

	private $FCKeditorMagicWords = array(
	'__NOTOC__',
	'__FORCETOC__',
	'__NOEDITSECTION__',
	'__START__',
	'__NOTITLECONVERT__',
	'__NOCONTENTCONVERT__',
	'__END__',
	'__TOC__',
	'__NOTC__',
	'__NOCC__',
	'__FORCETOC__',
	'__NEWSECTIONLINK__',
	'__NOGALLERY__',
	);

	/**
	 * Add special string (that would be changed by Parser) to array and return simple unique string
	 * that will remain unchanged during whole parsing operation.
	 * At the end we'll replace all this unique strings with original content
	 *
	 * @param string $text
	 * @return string
	 */
	private function fck_addToStrtr( $text, $replaceLineBreaks = true ) {
		$key = 'Fckmw' . $this->fck_mw_strtr_span_counter . 'fckmw';
		$this->fck_mw_strtr_span_counter++;
		if( $replaceLineBreaks ) {
			$this->fck_mw_strtr_span[$key] = str_replace( array( "\r\n", "\n", "\r" ), 'fckLR', $text );
		} else {
			$this->fck_mw_strtr_span[$key] = $text;
		}
		return $key;
	}

	/**
	 * Handle link to subpage if necessary
	 * @param string $target the source of the link
	 * @param string &$text the link text, modified as necessary
	 * @return string the full name of the link
	 * @private
	 */
	function maybeDoSubpageLink( $target, &$text ) {
		return $target;
	}

	/**
	 * DO NOT replace special strings like "ISBN xxx" and "RFC xxx" with
	 * magic external links.
	 *
	 * DML
	 * @private
	 */
	function doMagicLinks( $text ) {
		return $text;
	}

	/**
	 * Callback function for custom tags: feed, ref, references etc.
	 *
	 * @param string $str Input
	 * @param array $argv Arguments
	 * @return string
	 */
	function fck_genericTagHook( $str, $argv, $parser ) {
		if( in_array( $this->fck_mw_taghook, array( 'ref', 'math', 'references', 'source' ) ) ) {
			$class = $this->fck_mw_taghook;
		} else {
			$class = 'special';
		}

		if( empty( $argv ) ) {
			$ret = '<span class="fck_mw_' . $class . '" _fck_mw_customtag="true" _fck_mw_tagname="' . $this->fck_mw_taghook . '">';
		} else {
			$ret = '<span class="fck_mw_' . $class . '" _fck_mw_customtag="true" _fck_mw_tagname="' . $this->fck_mw_taghook . '"';
			foreach( $argv as $key => $value ) {
				$ret .= " " . $key . "=\"" . $value . "\"";
			}
			$ret .= '>';
		}
		if( is_null( $str ) ) {
			$ret = substr( $ret, 0, -1 ) . ' />';
		} else {
			$ret .= htmlspecialchars( $str );
			$ret .= '</span>';
		}

		$replacement = $this->fck_addToStrtr( $ret );
		return $replacement;
	}

	/**
	 * Callback function for wiki tags: nowiki, includeonly, noinclude
	 *
	 * @param string $tagName tag name, eg. nowiki, math
	 * @param string $str Input
	 * @param array $argv Arguments
	 * @return string
	 */
	function fck_wikiTag( $tagName, $str, $argv = array() ) {
		if( empty( $argv ) ) {
			$ret = '<span class="fck_mw_' . $tagName . '" _fck_mw_customtag="true" _fck_mw_tagname="' . $tagName . '">';
		} else {
			$ret = '<span class="fck_mw_' . $tagName . '" _fck_mw_customtag="true" _fck_mw_tagname="' . $tagName . '"';
			foreach( $argv as $key => $value ) {
				$ret .= " " . $key . "=\"" . $value . "\"";
			}
			$ret .= '>';
		}
		if( is_null( $str ) ) {
			$ret = substr( $ret, 0, -1 ) . ' />';
		} else {
			$ret .= htmlspecialchars( $str );
			$ret .= '</span>';
		}

		$replacement = $this->fck_addToStrtr( $ret );

		return $replacement;
	}

	/**
	 * Strips and renders nowiki, pre, math, hiero
	 * If $render is set, performs necessary rendering operations on plugins
	 * Returns the text, and fills an array with data needed in unstrip()
	 *
	 * @param StripState $state
	 *
	 * @param bool $stripcomments when set, HTML comments <!-- like this -->
	 *  will be stripped in addition to other tags. This is important
	 *  for section editing, where these comments cause confusion when
	 *  counting the sections in the wikisource
	 *
	 * @param array dontstrip contains tags which should not be stripped;
	 *  used to prevent stipping of <gallery> when saving (fixes bug 2700)
	 *
	 * @private
	 */
	function strip( $text, $state, $stripcomments = false, $dontstrip = array() ) {
		global $wgContLang, $wgUseTeX, $wgScriptPath, $wgVersion, $wgHooks, $wgExtensionFunctions;

		wfProfileIn( __METHOD__ );
		$render = ( $this->mOutputType == OT_HTML );

		$uniq_prefix = $this->mUniqPrefix;
		$commentState = new ReplacementArray;
		$nowikiItems = array();
		$generalItems = array();

		$elements = array_merge( array( 'nowiki', 'gallery', 'math' ), array_keys( $this->mTagHooks ) );
		if ( ( isset( $wgHooks['ParserFirstCallInit']) && in_array( 'efSyntaxHighlight_GeSHiSetup', $wgHooks['ParserFirstCallInit'] ) )
			|| ( isset( $wgExtensionFunctions ) && in_array( 'efSyntaxHighlight_GeSHiSetup', $wgExtensionFunctions ) ) ) {
			$elements = array_merge( $elements, array( 'source' ) );
		}
		if ( ( isset( $wgHooks['ParserFirstCallInit'] ) && in_array( 'wfCite', $wgHooks['ParserFirstCallInit'] ) )
			|| ( isset( $wgExtensionFunctions ) && in_array( 'wfCite', $wgExtensionFunctions ) ) ) {
			$elements = array_merge( $elements, array( 'ref', 'references' ) );
		}
		global $wgRawHtml;
		if( $wgRawHtml ) {
			$elements[] = 'html';
		}

		# Removing $dontstrip tags from $elements list (currently only 'gallery', fixing bug 2700)
		foreach( $elements as $k => $v ) {
			if( !in_array( $v, $dontstrip ) )
				continue;
			unset( $elements[$k] );
		}

		$elements = array_unique( $elements );
		$matches = array();
		if( version_compare( "1.12", $wgVersion, ">" ) ) {
			$text = Parser::extractTagsAndParams( $elements, $text, $matches, $uniq_prefix );
		} else {
			$text = self::extractTagsAndParams( $elements, $text, $matches, $uniq_prefix );
		}

		foreach( $matches as $marker => $data ) {
			list( $element, $content, $params, $tag ) = $data;
			if( $render ) {
				$tagName = strtolower( $element );
				wfProfileIn( __METHOD__ . "-render-$tagName" );
				switch( $tagName ) {
					case '!--':
						// Comment
						if( substr( $tag, -3 ) == '-->' ) {
							$output = $tag;
						} else {
							// Unclosed comment in input.
							// Close it so later stripping can remove it
							$output = "$tag-->";
						}
						break;
					case 'references':
						$output = $this->fck_wikiTag( 'references', $content, $params );
						break;
					case 'ref':
						$output = $this->fck_wikiTag( 'ref', $content, $params );
						break;
					case 'source':
						$output = $this->fck_wikiTag( 'source', $content, $params );
						break;
					case 'html':
						if( $wgRawHtml ) {
							$output = $this->fck_wikiTag( 'html', $content, $params );
						}
						break;
					case 'nowiki':
						$output = $this->fck_wikiTag( 'nowiki', $content, $params ); // required by FCKeditor
						break;
					case 'math':
						if( $wgUseTeX ){ //normal render
							$output = $wgContLang->armourMath( MathRenderer::renderMath( $content ) );
						} else // show fakeimage
							$output = '<img _fckfakelement="true" class="FCK__MWMath" _fck_mw_math="'.$content.'" src="'.$wgScriptPath.'/skins/common/images/button_math.png" />';
						break;
					case 'gallery':
						$output = $this->fck_wikiTag( 'gallery', $content, $params ); // required by FCKeditor
						//$output = $this->renderImageGallery( $content, $params );
						break;
					default:
						if( isset( $this->mTagHooks[$tagName] ) ) {
							$this->fck_mw_taghook = $tagName; // required by FCKeditor
							$output = call_user_func_array( $this->mTagHooks[$tagName],
							array( $content, $params, $this ) );
						} else {
							throw new MWException( "Invalid call hook $element" );
						}
				}
				wfProfileOut( __METHOD__ . "-render-$tagName" );
			} else {
				// Just stripping tags; keep the source
				$output = $tag;
			}

			// Unstrip the output, to support recursive strip() calls
			$output = $state->unstripBoth( $output );

			if( !$stripcomments && $element == '!--' ) {
				$commentState->setPair( $marker, $output );
			} elseif ( $element == 'html' || $element == 'nowiki' ) {
				$nowikiItems[$marker] = $output;
			} else {
				$generalItems[$marker] = $output;
			}
		}
		# Add the new items to the state
		# We do this after the loop instead of during it to avoid slowing
		# down the recursive unstrip
		$state->nowiki->mergeArray( $nowikiItems );
		$state->general->mergeArray( $generalItems );

		# Unstrip comments unless explicitly told otherwise.
		# (The comments are always stripped prior to this point, so as to
		# not invoke any extension tags / parser hooks contained within
		# a comment.)
		if ( !$stripcomments ) {
			// Put them all back and forget them
			$text = $commentState->replace( $text );
		}

		$this->fck_matches = $matches;
		wfProfileOut( __METHOD__ );
		return $text;
	}

	/**
	 * Replace HTML comments with unique text using fck_addToStrtr function
	 *
	 * @private
	 * @param string $text
	 * @return string
	 */
	private function fck_replaceHTMLcomments( $text ) {
		wfProfileIn( __METHOD__ );
		while( ( $start = strpos( $text, '<!--' ) ) !== false ) {
			$end = strpos( $text, '-->', $start + 4 );
			if( $end === false ) {
				# Unterminated comment; bail out
				break;
			}

			$end += 3;

			# Trim space and newline if the comment is both
			# preceded and followed by a newline
			$spaceStart = max( $start - 1, 0 );
			$spaceLen = $end - $spaceStart;
			while( substr( $text, $spaceStart, 1 ) === ' ' && $spaceStart > 0 ) {
				$spaceStart--;
				$spaceLen++;
			}
			while( substr( $text, $spaceStart + $spaceLen, 1 ) === ' ' )
				$spaceLen++;
			if( substr( $text, $spaceStart, 1 ) === "\n" and substr( $text, $spaceStart + $spaceLen, 1 ) === "\n" ) {
				# Remove the comment, leading and trailing
				# spaces, and leave only one newline.
				$replacement = $this->fck_addToStrtr( substr( $text, $spaceStart, $spaceLen + 1 ), false );
				$text = substr_replace( $text, $replacement . "\n", $spaceStart, $spaceLen + 1 );
			} else {
				# Remove just the comment.
				$replacement = $this->fck_addToStrtr( substr( $text, $start, $end - $start ), false );
				$text = substr_replace( $text, $replacement, $start, $end - $start );
			}
		}
		wfProfileOut( __METHOD__ );

		return $text;
	}

	function replaceInternalLinks( $text ) {
		$text = preg_replace( "/\[\[([^|\[\]]*?)\]\]/", "[[$1|RTENOTITLE]]", $text ); // #2223: [[()]]	=>	[[%1|RTENOTITLE]]
		$text = preg_replace( "/\[\[:(.*?)\]\]/", "[[RTECOLON$1]]", $text ); // change ':' => 'RTECOLON' in links
		$text = parent::replaceInternalLinks( $text );
		$text = preg_replace( "/\|RTENOTITLE\]\]/", "]]", $text ); // remove unused RTENOTITLE

		return $text;
	}

	function makeImage( $nt, $options, $holders = false ) {
		FCKeditorParser::$fkc_mw_makeImage_options = $options;
		return parent::makeImage( $nt, $options, $holders );
	}

	/**
	 * Replace templates with unique text to preserve them from parsing
	 *
	 * @todo if {{template}} is inside string that also must be returned unparsed,
	 * e.g. <noinclude>{{template}}</noinclude>
	 * {{template}} replaced with Fckmw[n]fckmw which is wrong...
	 *
	 * @param string $text
	 * @return string
	 */
	private function fck_replaceTemplates( $text ) {

		$callback = array(
			'{' => array(
				'end'=>'}',
				'cb' => array(
					2 => array( $this, 'fck_leaveTemplatesAlone' ),
					3 => array( $this, 'fck_leaveTemplatesAlone' ),
				),
				'min' => 2,
				'max' => 3,
			)
		);

		$text = $this->replace_callback( $text, $callback );

		$tags = array();
		$offset = 0;
		$textTmp = $text;
		while( false !== ( $pos = strpos( $textTmp, '<!--FCK_SKIP_START-->' ) ) ){
			$tags[abs($pos + $offset)] = 1;
			$textTmp = substr( $textTmp, $pos + 21 );
			$offset += $pos + 21;
		}

		$offset = 0;
		$textTmp = $text;
		while( false !== ( $pos = strpos( $textTmp, '<!--FCK_SKIP_END-->' ) ) ){
			$tags[abs($pos + $offset)] = -1;
			$textTmp = substr( $textTmp, $pos + 19 );
			$offset += $pos + 19;
		}

		if( !empty( $tags ) ) {
			ksort( $tags );

			$strtr = array( '<!--FCK_SKIP_START-->' => '', '<!--FCK_SKIP_END-->' => '' );

			$sum = 0;
			$lastSum = 0;
			$finalString = '';
			$stringToParse = '';
			$startingPos = 0;
			$inner = '';
			$strtr_span = array();
			foreach( $tags as $pos=>$type) {
				$sum += $type;
				if( !$pos ) {
					$opened = 0;
					$closed = 0;
				} else {
					$opened = substr_count( $text, '[', 0, $pos ); // count [
					$closed = substr_count( $text, ']', 0, $pos ); // count ]
				}
				if( $sum == 1 && $lastSum == 0 ) {
					$stringToParse .= strtr( substr( $text, $startingPos, $pos - $startingPos ), $strtr );
					$startingPos = $pos;
				} else if( $sum == 0 ) {
					$stringToParse .= 'Fckmw' . $this->fck_mw_strtr_span_counter . 'fckmw';
					$inner = htmlspecialchars( strtr( substr( $text, $startingPos, $pos - $startingPos + 19 ), $strtr ) );
					$this->fck_mw_strtr_span['href="Fckmw' . $this->fck_mw_strtr_span_counter . 'fckmw"'] = 'href="' . $inner . '"';
					if( $opened <= $closed ) { // {{template}} is NOT in [] or [[]]
						$this->fck_mw_strtr_span['Fckmw' . $this->fck_mw_strtr_span_counter . 'fckmw'] = '<span class="fck_mw_template">' . str_replace( array( "\r\n", "\n", "\r" ), 'fckLR', $inner ) . '</span>';
					} else {
						$this->fck_mw_strtr_span['Fckmw' . $this->fck_mw_strtr_span_counter . 'fckmw'] = str_replace( array( "\r\n", "\n", "\r" ), 'fckLR', $inner );
					}
					$startingPos = $pos + 19;
					$this->fck_mw_strtr_span_counter++;
				}
				$lastSum = $sum;
			}
			$stringToParse .= substr( $text, $startingPos );
			$text = &$stringToParse;
		}

		return $text;
	}

	function internalParse( $text, $isMain = true, $frame = false ) {
		$this->fck_internal_parse_text =& $text;

		// these three tags should remain unchanged
		$text = StringUtils::delimiterReplaceCallback( '<includeonly>', '</includeonly>', array( $this, 'fck_includeonly' ), $text );
		$text = StringUtils::delimiterReplaceCallback( '<noinclude>', '</noinclude>', array( $this, 'fck_noinclude' ), $text );
		$text = StringUtils::delimiterReplaceCallback( '<onlyinclude>', '</onlyinclude>', array( $this, 'fck_onlyinclude' ), $text );

		// HTML comments shouldn't be stripped
		$text = $this->fck_replaceHTMLcomments( $text );
		// as well as templates
		$text = $this->fck_replaceTemplates( $text );

		$finalString = parent::internalParse( $text, $isMain );

		return $finalString;
	}

	function fck_includeonly( $matches ) {
		return $this->fck_wikiTag( 'includeonly', $matches[1] );
	}

	function fck_noinclude( $matches ) {
		return $this->fck_wikiTag( 'noinclude', $matches[1] );
	}

	function fck_onlyinclude( $matches ) {
		return $this->fck_wikiTag( 'onlyinclude', $matches[1] );
	}

	function fck_leaveTemplatesAlone( $matches ) {
		return '<!--FCK_SKIP_START-->' . $matches['text'] . '<!--FCK_SKIP_END-->';
	}

	function formatHeadings( $text, $origText, $isMain = true ) {
		return $text;
	}

	function replaceFreeExternalLinks( $text ) { return $text; }

	function stripNoGallery( &$text ) {}

	function stripToc( $text ) {
		//$prefix = '<span class="fck_mw_magic">';
		//$suffix = '</span>';
		$prefix = '';
		$suffix = '';

		$strtr = array();
		foreach( $this->FCKeditorMagicWords as $word ) {
			$strtr[$word] = $prefix . $word . $suffix;
		}

		return strtr( $text, $strtr );
	}

	function doDoubleUnderscore( $text ) {
		return $text;
	}

	function parse( $text, Title $title, ParserOptions $options, $linestart = true, $clearState = true, $revid = null ) {
		$text = preg_replace( "/^#REDIRECT/", '<!--FCK_REDIRECT-->', $text );
		$parserOutput = parent::parse( $text, $title, $options, $linestart, $clearState, $revid );

		$categories = $parserOutput->getCategories();
		if( $categories ) {
			$appendString = '';
			foreach( $categories as $cat => $val ) {
				$args = '';
				if( $val == 'RTENOTITLE' ){
					$args .= '_fcknotitle="true" ';
					$val = $cat;
				}
				if( $val != $title->mTextform ) {
					$appendString .= '<a ' . $args . 'href="Category:' . $cat . '">' . $val . '</a> ';
				} else {
					$appendString .= '<a ' . $args . 'href="Category:' . $cat . '">Category:' . $cat . '</a> ';
				}
			}
			$parserOutput->setText( $parserOutput->getText() . $appendString );
		}

		if( !empty( $this->fck_mw_strtr_span ) ) {
			global $leaveRawTemplates;
			if( !empty( $leaveRawTemplates ) ) {
				foreach( $leaveRawTemplates as $l ) {
					$this->fck_mw_strtr_span[$l] = substr( $this->fck_mw_strtr_span[$l], 30, -7 );
				}
			}
			$text = strtr( $parserOutput->getText(), $this->fck_mw_strtr_span );
			$parserOutput->setText( strtr( $text, $this->fck_mw_strtr_span ) );
		}
		if( !empty( $this->fck_matches ) ) {
			$text = $parserOutput->getText();
			foreach( $this->fck_matches as $key => $m ) {
				$text = str_replace( $key, $m[3], $text );
			}
			$parserOutput->setText( $text );
		}

		if( !empty( $parserOutput->mLanguageLinks ) ) {
			foreach( $parserOutput->mLanguageLinks as $l ) {
				$parserOutput->setText( $parserOutput->getText() . "\n" . '<a href="' . $l . '">' . $l . '</a>' );
			}
		}

		$parserOutput->setText( str_replace( '<!--FCK_REDIRECT-->', '#REDIRECT', $parserOutput->getText() ) );

		return $parserOutput;
	}

	/**
	 * Make lists from lines starting with ':', '*', '#', etc.
	 *
	 * @private
	 * @return string the lists rendered as HTML
	 */
	function doBlockLevels( $text, $linestart ) {
		wfProfileIn( __METHOD__ );

		# Parsing through the text line by line.  The main thing
		# happening here is handling of block-level elements p, pre,
		# and making lists from lines starting with * # : etc.
		$textLines = explode( "\n", $text );

		$lastPrefix = $output = '';
		$this->mDTopen = $inBlockElem = false;
		$prefixLength = 0;
		$paragraphStack = false;

		if ( !$linestart ) {
			$output .= array_shift( $textLines );
		}
		foreach ( $textLines as $oLine ) {
			$lastPrefixLength = strlen( $lastPrefix );
			$preCloseMatch = preg_match('/<\\/pre/i', $oLine );
			$preOpenMatch = preg_match('/<pre/i', $oLine );
			if ( !$this->mInPre ) {
				# Multiple prefixes may abut each other for nested lists.
				$prefixLength = strspn( $oLine, '*#:;' );
				$pref = substr( $oLine, 0, $prefixLength );

				# eh?
				$pref2 = str_replace( ';', ':', $pref );
				$t = substr( $oLine, $prefixLength );
				$this->mInPre = !empty( $preOpenMatch );
			} else {
				# Don't interpret any other prefixes in preformatted text
				$prefixLength = 0;
				$pref = $pref2 = '';
				$t = $oLine;
			}

			# List generation
			if( $prefixLength && 0 == strcmp( $lastPrefix, $pref2 ) ) {
				# Same as the last item, so no need to deal with nesting or opening stuff
				$output .= $this->nextItem( substr( $pref, -1 ) );
				$paragraphStack = false;

				if ( substr( $pref, -1 ) == ';') {
					# The one nasty exception: definition lists work like this:
					# ; title : definition text
					# So we check for : in the remainder text to split up the
					# title and definition, without b0rking links.
					$term = $t2 = '';
					if( $this->findColonNoLinks( $t, $term, $t2 ) !== false ) {
						$t = $t2;
						$output .= $term . $this->nextItem( ':' );
					}
				}
			} elseif( $prefixLength || $lastPrefixLength ) {
				# Either open or close a level...
				$commonPrefixLength = $this->getCommon( $pref, $lastPrefix );
				$paragraphStack = false;

				while( $commonPrefixLength < $lastPrefixLength ) {
					$output .= $this->closeList( $lastPrefix{$lastPrefixLength-1} );
					--$lastPrefixLength;
				}
				if ( $prefixLength <= $commonPrefixLength && $commonPrefixLength > 0 ) {
					$output .= $this->nextItem( $pref{$commonPrefixLength-1} );
				}
				while ( $prefixLength > $commonPrefixLength ) {
					$char = substr( $pref, $commonPrefixLength, 1 );
					$output .= $this->openList( $char );

					if ( ';' == $char ) {
						# FIXME: This is dupe of code above
						if( $this->findColonNoLinks( $t, $term, $t2 ) !== false ) {
							$t = $t2;
							$output .= $term . $this->nextItem( ':' );
						}
					}
					++$commonPrefixLength;
				}
				$lastPrefix = $pref2;
			}
			if( 0 == $prefixLength ) {
				wfProfileIn( __METHOD__ .  '-paragraph' );
				# No prefix (not in list)--go to paragraph mode
				// XXX: use a stack for nestable elements like span, table and div
				$openmatch = preg_match( '/(?:<table|<blockquote|<h1|<h2|<h3|<h4|<h5|<h6|<pre|<tr|<p|<ul|<ol|<li|<\\/tr|<\\/td|<\\/th)/iS', $t );
				$closematch = preg_match(
				'/(?:<\\/table|<\\/blockquote|<\\/h1|<\\/h2|<\\/h3|<\\/h4|<\\/h5|<\\/h6|'.
				'<td|<th|<\\/?div|<hr|<\\/pre|<\\/p|' . $this->mUniqPrefix . '-pre|<\\/li|<\\/ul|<\\/ol|<\\/?center)/iS', $t );
				if ( $openmatch or $closematch ) {
					$paragraphStack = false;
					# TODO bug 5718: paragraph closed
					$output .= $this->closeParagraph();
					if ( $preOpenMatch and !$preCloseMatch ) {
						$this->mInPre = true;
					}
					if ( $closematch ) {
						$inBlockElem = false;
					} else {
						$inBlockElem = true;
					}
				} else if ( !$inBlockElem && !$this->mInPre ) {
					if ( ' ' == $t{0} and ( $this->mLastSection == 'pre' or trim( $t ) != '' ) ) {
						// pre
						if( $this->mLastSection != 'pre' ) {
							$paragraphStack = false;
							$output .= $this->closeParagraph() . '<pre class="_fck_mw_lspace">';
							$this->mLastSection = 'pre';
						}
						$t = substr( $t, 1 );
					} else {
						// paragraph
						if ( '' == trim( $t ) ) {
							if ( $paragraphStack ) {
								$output .= $paragraphStack . '<br />';
								$paragraphStack = false;
								$this->mLastSection = 'p';
							} else {
								if ($this->mLastSection != 'p' ) {
									$output .= $this->closeParagraph();
									$this->mLastSection = '';
									$paragraphStack = '<p>';
								} else {
									$paragraphStack = '</p><p>';
								}
							}
						} else {
							if ( $paragraphStack ) {
								$output .= $paragraphStack;
								$paragraphStack = false;
								$this->mLastSection = 'p';
							} else if ($this->mLastSection != 'p') {
								$output .= $this->closeParagraph().'<p>';
								$this->mLastSection = 'p';
							}
						}
					}
				}
				wfProfileOut( __METHOD__ . '-paragraph' );
			}
			// somewhere above we forget to get out of pre block (bug 785)
			if( $preCloseMatch && $this->mInPre ) {
				$this->mInPre = false;
			}
			if( $paragraphStack === false ) {
				$output .= $t . "\n";
			}
		}
		while ( $prefixLength ) {
			$output .= $this->closeList( $pref2{$prefixLength-1} );
			--$prefixLength;
		}
		if ( '' != $this->mLastSection ) {
			$output .= '</' . $this->mLastSection . '>';
			$this->mLastSection = '';
		}

		wfProfileOut( __METHOD__ );
		return $output;
	}
}
