<?php

class FCKeditorParser extends Parser
{
	public static $fkc_mw_makeImage_options;
	protected $fck_mw_strtr_span;
	protected $fck_mw_strtr_span_counter=1;
	protected $fck_mw_taghook;
	protected $fck_internal_parse_text;
	protected $fck_matches = array();
	public $fck_parsed_templates ;

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
	"__FORCETOC__",
	"__NEWSECTIONLINK__",
	"__NOGALLERY__",
	);

	function __construct() {
		global $wgParser;
		parent::__construct();

		foreach ($wgParser->getTags() as $h) {
			if (!in_array($h, array("pre"))) {
				$this->setHook($h, array($this, "fck_genericTagHook"));
			}
		}
	}

	/**
	 * Add special string (that would be changed by Parser) to array and return simple unique string 
	 * that will remain unchanged during whole parsing operation.
	 * At the end we'll replace all this unique strings with original content
	 *
	 * @param string $text
	 * @return string
	 */
	private function fck_addToStrtr($text, $replaceLineBreaks = true) {
		$key = 'Fckmw'.$this->fck_mw_strtr_span_counter.'fckmw';
		$this->fck_mw_strtr_span_counter++;
		if ($replaceLineBreaks) {
			$this->fck_mw_strtr_span[$key] = str_replace(array("\r\n", "\n", "\r"),"fckLR",$text);
		}
		else {
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
	function maybeDoSubpageLink($target, &$text) {
		return $target;
	}
	
	/**
	* Callback function for custom tags: feed, ref, references etc.
	*
	* @param string $str Input
	* @param array $argv Arguments
	* @return string
	*/
	function fck_genericTagHook( $str, $argv, $parser ) {
		if (in_array($this->fck_mw_taghook, array("ref", "math", "references"))) {
			$class = $this->fck_mw_taghook;
		}
		else {
			$class = "special";
		}
		
		if (empty($argv)) {
			$ret = "<span class=\"fck_mw_".$class."\" _fck_mw_customtag=\"true\" _fck_mw_tagname=\"".$this->fck_mw_taghook."\">";
		}
		else {
			$ret = "<span class=\"fck_mw_".$class."\" _fck_mw_customtag=\"true\" _fck_mw_tagname=\"".$this->fck_mw_taghook."\"";
			foreach ($argv as $key=>$value) {
				$ret .= " ".$key."=\"".$value."\"";
			}
			$ret .=">";
		}
		if (is_null($str)) {
			$ret = substr($ret, 0, -1) . " />";
		}
		else {
			$ret .= htmlspecialchars($str);
			$ret .= "</span>";
		}

		$replacement = $this->fck_addToStrtr($ret);
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
	function fck_wikiTag( $tagName, $str, $argv = array()) {
		$ret = "<span class=\"fck_mw_".$tagName."\" _fck_mw_customtag=\"true\" _fck_mw_tagname=\"".$tagName."\">";
		if (is_null($str)) {
			$ret = substr($ret, 0, -1) . " />";
		}
		else {
			$ret .= htmlspecialchars($str);
			$ret .= "</span>";
		}

		$replacement = $this->fck_addToStrtr($ret);

		return $replacement;
	}

       /**
         * Return the text to be used for a given extension tag.
         * This is the ghost of strip().
         *
         * @param array $params Associative array of parameters:
         *     name       PPNode for the tag name
         *     attr       PPNode for unparsed text where tag attributes are thought to be
         *     attributes Optional associative array of parsed attributes
         *     inner      Contents of extension element
         *     noClose    Original text did not have a close tag
         * @param PPFrame $frame
         */
        function extensionSubstitution( $params, $frame ) {
                global $wgRawHtml, $wgContLang;

                $name = $frame->expand( $params['name'] );
                $attrText = !isset( $params['attr'] ) ? null : $frame->expand( $params['attr'] );
                $content = !isset( $params['inner'] ) ? null : $frame->expand( $params['inner'] );

                $marker = "{$this->mUniqPrefix}-$name-" . sprintf('%08X', $this->mMarkerIndex++) . $this->mMarkerSuffix;

                if ( $this->ot['html'] ) {
                        $name = strtolower( $name );

                        $attributes = Sanitizer::decodeTagAttributes( $attrText );
                        if ( isset( $params['attributes'] ) ) {
                                $attributes = $attributes + $params['attributes'];
                        }
                        switch ( $name ) {
                                case 'html':
                                        if( $wgRawHtml ) {
                                                $output = $content;
                                                break;
                                        } else {
                                                throw new MWException( '<html> extension tag encountered unexpectedly' );
                                        }
                                case 'nowiki':
					$output = $this->fck_wikiTag('nowiki', $content, $params); //required by FCKeditor
                                        break;
                                case 'gallery':
					$output = $this->fck_wikiTag('gallery', $content, $params); //required by FCKeditor
                                        break;
                                default:
                                        if( isset( $this->mTagHooks[$name] ) ) {
                                                # Workaround for PHP bug 35229 and similar
                                                if ( !is_callable( $this->mTagHooks[$name] ) ) {
                                                        throw new MWException( "Tag hook for $name is not callable\n" );
                                                }
					        $this->fck_mw_taghook = $name; //required by FCKeditor 
                                                $output = call_user_func_array( $this->mTagHooks[$name],
                                                        array( $content, $attributes, $this ) );
                                        } else {
                                                throw new MWException( "Invalid call hook $name" );
                                        }
                        }
                } else {
                        if ( is_null( $attrText ) ) {
                                $attrText = '';
                        }
                        if ( isset( $params['attributes'] ) ) {
                                foreach ( $params['attributes'] as $attrName => $attrValue ) {
                                        $attrText .= ' ' . htmlspecialchars( $attrName ) . '="' .
                                                htmlspecialchars( $attrValue ) . '"';
                                }
                        }
                        if ( $content === null ) {
                                $output = "<$name$attrText/>";
                        } else {
                                $close = is_null( $params['close'] ) ? '' : $frame->expand( $params['close'] );
                                $output = "<$name$attrText>$content$close";
                        }
                }

                if ( $name == 'html' || $name == 'nowiki' ) {
                        $this->mStripState->nowiki->setPair( $marker, $output );
                } else {
                        $this->mStripState->general->setPair( $marker, $output );
                }
		$this->fck_matches = $matches;
                return $marker;
        }

	/** Replace HTML comments with unique text using fck_addToStrtr function
	 *
	 * @private
	 * @param string $text
	 * @return string
	 */
	private function fck_replaceHTMLcomments( $text ) {
		wfProfileIn( __METHOD__ );
		while (($start = strpos($text, '<!--')) !== false) {
			$end = strpos($text, '-->', $start + 4);
			if ($end === false) {
				# Unterminated comment; bail out
				break;
			}

			$end += 3;

			# Trim space and newline if the comment is both
			# preceded and followed by a newline
			$spaceStart = max($start - 1, 0);
			$spaceLen = $end - $spaceStart;
			while (substr($text, $spaceStart, 1) === ' ' && $spaceStart > 0) {
				$spaceStart--;
				$spaceLen++;
			}
			while (substr($text, $spaceStart + $spaceLen, 1) === ' ')
			$spaceLen++;
			if (substr($text, $spaceStart, 1) === "\n" and substr($text, $spaceStart + $spaceLen, 1) === "\n") {
				# Remove the comment, leading and trailing
				# spaces, and leave only one newline.
				$replacement = $this->fck_addToStrtr(substr($text, $spaceStart, $spaceLen+1), false);
				$text = substr_replace($text, $replacement."\n", $spaceStart, $spaceLen + 1);
			}
			else {
				# Remove just the comment.
				$replacement = $this->fck_addToStrtr(substr($text, $start, $end - $start), false);
				$text = substr_replace($text, $replacement, $start, $end - $start);
			}
		}
		wfProfileOut( __METHOD__ );

		return $text;
	}

	function replaceInternalLinks( $text ) {
		return parent::replaceInternalLinks($text);
	}

	function makeImage( $nt, $options ) {
		FCKeditorParser::$fkc_mw_makeImage_options = $options;
		return parent::makeImage( $nt, $options );
	}

       /* 
       	* getPreprocessor override (to use an extended class)
        *
	*/

        function getPreprocessor() {
                if ( !isset( $this->mPreprocessor ) ) {
                        $class = 'FCKPreprocessor_DOM' ;
                        $this->mPreprocessor = new $class( $this );
                }
                return $this->mPreprocessor;
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
		
		$frame = $this->getPreprocessor()->newFrame();

		$dom = $this->preprocessToDom( $text );
                $flags = 0 ;
                $text = $frame->expand( $dom, $flags );
		$templates = "" ;
		
		$tags = array();
		$result = array () ;
		$offset=0;
		$textTmp = $text;
		while (false !== ($pos = strpos($textTmp, "<!--FCK_SKIP_START-->")))
		{
			$tags[abs($pos + $offset)] = 1;
			$textTmp = substr($textTmp, $pos+21);
			$offset += $pos + 21;
		}

		$offset=0;
		$textTmp = $text;
		while (false !== ($pos = strpos($textTmp, "<!--FCK_SKIP_END-->")))
		{
			$tags[abs($pos + $offset)] = -1;
			$textTmp = substr($textTmp, $pos+19);
			$offset += $pos + 19;
		}

		if (!empty($tags)) {
			ksort($tags);

			$strtr = array("<!--FCK_SKIP_START-->" => "", "<!--FCK_SKIP_END-->" => "");

			$sum=0;
			$lastSum=0;
			$finalString = "";
			$stringToParse = "";
			$templates = "";
			$startingPos = 0;
			$inner = "";
			$strtr_span = array();
			foreach ($tags as $pos=>$type) {
				$sum += $type;
				if ($sum == 1 && $lastSum == 0) {
					$stringToParse .= strtr(substr($text, $startingPos, $pos - $startingPos), $strtr);
					$startingPos = $pos;
				}
				else if ($sum == 0) {
					$stringToParse .= 'Fckmw'.$this->fck_mw_strtr_span_counter.'fckmw';
					$inner = htmlspecialchars(strtr(substr($text, $startingPos, $pos - $startingPos + 19), $strtr));
					$templates .= "<span class=\"fck_mw_template\">" . $inner . "</span>" ;
					$this->fck_mw_strtr_span['href="Fckmw'.$this->fck_mw_strtr_span_counter.'fckmw"'] = 'href="'.$inner.'"';
					$this->fck_mw_strtr_span['Fckmw'.$this->fck_mw_strtr_span_counter.'fckmw'] = '<span class="fck_mw_template">'.str_replace(array("\r\n", "\n", "\r"),"fckLR",$inner).'</span>';
					$startingPos = $pos + 19;
					$this->fck_mw_strtr_span_counter++;
				}
				$lastSum = $sum;
			}
			$stringToParse .= substr($text, $startingPos);
			$text = &$stringToParse;
		}
	
       	 	return array (
				"text" => $text ,
				"templates" => $templates . "__NOTOC__"
		       ) ;
	}

	function internalParse ( $text ) {

		$this->fck_internal_parse_text =& $text;

		//these three tags should remain unchanged
		$text = StringUtils::delimiterReplaceCallback( '<includeonly>', '</includeonly>', array($this, 'fck_includeonly'), $text );
		$text = StringUtils::delimiterReplaceCallback( '<noinclude>', '</noinclude>', array($this, 'fck_noinclude'), $text );
		$text = StringUtils::delimiterReplaceCallback( '<onlyinclude>', '</onlyinclude>', array($this, 'fck_onlyinclude'), $text );

		//html comments shouldn't be stripped
		$text = $this->fck_replaceHTMLcomments( $text );

		//as well as templates
		$replacedTemplates = $this->fck_replaceTemplates( $text );
		$text = $replacedTemplates ["text"] ;
		$templates = $replacedTemplates ["templates"] ;

		$finalString = parent::internalParse($text);
		$this->fck_parsed_templates = $templates ;
		
		return $finalString;
	}
	function fck_includeonly( $matches ) {
		return $this->fck_wikiTag('includeonly', $matches[1]);
	}
	function fck_noinclude( $matches ) {
		return $this->fck_wikiTag('noinclude', $matches[1]);
	}
	function fck_onlyinclude( $matches ) {
		return $this->fck_wikiTag('onlyinclude', $matches[1]);
	}
	function formatHeadings( $text, $isMain=true ) {
		return $text;
	}
	function replaceFreeExternalLinks( $text ) { return $text; }
	function stripNoGallery(&$text) {}
	function stripToc( $text ) {
		//$prefix = '<span class="fck_mw_magic">';
		//$suffix = '</span>';
		$prefix = '';
		$suffix = '';

		$strtr = array();
		foreach ($this->FCKeditorMagicWords as $word) {
			$strtr[$word] = $prefix . $word . $suffix;
		}

		return strtr( $text, $strtr );
	}

	function parse( $text, &$title, $options, $linestart = true, $clearState = true, $revid = null ) {
		$text = preg_replace("/^#REDIRECT/", "<!--FCK_REDIRECT-->", $text);
		$parserOutput = parent::parse($text, $title, $options, $linestart , $clearState , $revid );

		$categories = $parserOutput->getCategories();
		if ($categories) {
			$appendString = "";
			foreach ($categories as $cat=>$val) {
				if ($val != $title->mTextform) {
					$appendString .= "<a href=\"Category:" . $cat ."\">" . $val ."</a> ";
				}
				else {
					$appendString .= "<a href=\"Category:" . $cat ."\">Category:" . $cat ."</a> ";
				}
			}
			$parserOutput->setText($parserOutput->getText() . $appendString);
		}

		if (!empty($this->fck_mw_strtr_span)) {
			global $leaveRawTemplates;
			if (!empty($leaveRawTemplates)) {
				foreach ($leaveRawTemplates as $l) {
					$this->fck_mw_strtr_span[$l] = substr($this->fck_mw_strtr_span[$l], 30, -7);
				}
			}
			$parserOutput->setText(strtr($parserOutput->getText(), $this->fck_mw_strtr_span));
		}

		if (!empty($this->fck_matches)) {
			$text = $parserOutput->getText() ;
			foreach ($this->fck_matches as $key => $m) {
				$text = str_replace( $key, $m[3], $text);
			}
			$parserOutput->setText($text);
		}
		
		if (!empty($parserOutput->mLanguageLinks)) {
			foreach ($parserOutput->mLanguageLinks as $l) {
				$parserOutput->setText($parserOutput->getText() . "\n" . "<a href=\"".$l."\">".$l."</a>") ;
			}
		}

		$parserOutput->setText(str_replace("<!--FCK_REDIRECT-->", "#REDIRECT", $parserOutput->getText()));

		return $parserOutput;
	}

	/**
	 * Make lists from lines starting with ':', '*', '#', etc.
	 *
	 * @private
	 * @return string the lists rendered as HTML
	 */
	function doBlockLevels( $text, $linestart ) {
		$fname = 'Parser::doBlockLevels';
		wfProfileIn( $fname );

		# Parsing through the text line by line.  The main thing
		# happening here is handling of block-level elements p, pre,
		# and making lists from lines starting with * # : etc.
		#
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
				$this->mInPre = !empty($preOpenMatch);
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
					if ($this->findColonNoLinks($t, $term, $t2) !== false) {
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
						if ($this->findColonNoLinks($t, $term, $t2) !== false) {
							$t = $t2;
							$output .= $term . $this->nextItem( ':' );
						}
					}
					++$commonPrefixLength;
				}
				$lastPrefix = $pref2;
			}
			if( 0 == $prefixLength ) {
				wfProfileIn( "$fname-paragraph" );
				# No prefix (not in list)--go to paragraph mode
				// XXX: use a stack for nestable elements like span, table and div
				$openmatch = preg_match('/(?:<table|<blockquote|<h1|<h2|<h3|<h4|<h5|<h6|<pre|<tr|<p|<ul|<ol|<li|<\\/tr|<\\/td|<\\/th)/iS', $t );
				$closematch = preg_match(
				'/(?:<\\/table|<\\/blockquote|<\\/h1|<\\/h2|<\\/h3|<\\/h4|<\\/h5|<\\/h6|'.
				'<td|<th|<\\/?div|<hr|<\\/pre|<\\/p|'.$this->mUniqPrefix.'-pre|<\\/li|<\\/ul|<\\/ol|<\\/?center)/iS', $t );
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
					if ( ' ' == $t{0} and ( $this->mLastSection == 'pre' or trim($t) != '' ) ) {
						// pre
						if ($this->mLastSection != 'pre') {
							$paragraphStack = false;
							$output .= $this->closeParagraph().'<pre class="_fck_mw_lspace">';
							$this->mLastSection = 'pre';
						}
						$t = substr( $t, 1 );
					} else {
						// paragraph
						if ( '' == trim($t) ) {
							if ( $paragraphStack ) {
								$output .= $paragraphStack.'<br />';
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
				wfProfileOut( "$fname-paragraph" );
			}
			// somewhere above we forget to get out of pre block (bug 785)
			if($preCloseMatch && $this->mInPre) {
				$this->mInPre = false;
			}
			if ($paragraphStack === false) {
				$output .= $t."\n";
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

		wfProfileOut( $fname );
		return $output;
	}
}
