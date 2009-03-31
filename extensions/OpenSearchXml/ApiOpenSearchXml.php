<?php

/*
 * Created on Oct 13, 2006
 * Adapted to XML output variant, plus extra text extraction 2008
 * Text extraction adapted from ActiveAbstract extension.
 *
 * API for MediaWiki 1.8+
 *
 * Copyright (C) 2006 Yuri Astrakhan <Firstname><Lastname>@gmail.com
 * Copyright (C) 2008 Brion Vibber <brion@wikimedia.org>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * @ingroup API
 */
class ApiOpenSearchXml extends ApiOpenSearch {

	public function getCustomPrinter() {
		$format = $this->validateFormat();
		$printer = $this->getMain()->createPrinterByName( $format );
		if( $this->inXmlMode() ) {
			$printer->setRootElement( 'SearchSuggestion' );
		}
		return $printer;
	}
	
	protected function validateFormat() {
		$params = $this->extractRequestParams();
		$format = $params['format'];
		$allowed = array( 'json', 'jsonfm', 'xml', 'xmlfm' );
		if( in_array( $format, $allowed ) ) {
			return $format;
		} else {
			return $allowed[0];
		}
	}

	protected function inXmlMode() {
		$format = $this->validateFormat();
		return ($format == 'xml' || $format == 'xmlfm');
	}

	public function execute() {
		if (!$this->inXmlMode()) {
			// Pass back to the JSON defaults
			return parent::execute();
		}
		
		$params = $this->extractRequestParams();
		$search = $params['search'];
		$limit = $params['limit'];
		$namespaces = $params['namespace'];
		
		// Open search results may be stored for a very long time
		$this->getMain()->setCacheMaxAge(1200);

		$srchres = PrefixSearch::titleSearch( $search, $limit, $namespaces );

		$items = array_filter( array_map( array( $this, 'formatItem' ), $srchres ) );
		
		$result = $this->getResult();
		$result->addValue( null, 'version', '2.0' );
		$result->addValue( null, 'xmlns', 'http://opensearch.org/searchsuggest2' );
		$result->addValue( null, 'Query', array( '*' => strval( $search ) ) );
		$result->setIndexedTagName( $items, 'Item' );
		$result->addValue( null, 'Section', $items );
	}
	
	public function getAllowedParams() {
		$params = parent::getAllowedParams();
		$params['format'] = null;
		return $params;
	}
	
	protected function formatItem( $name ) {
		$title = TItle::newFromText( $name );
		if( $title ) {
			$title = $this->_checkRedirect( $title );
			if( $this->_seen( $title ) ) {
				return false;
			}
			
			list( $extract, $badge ) = $this->getExtract( $title );
			$image = $this->getBadge( $title, $badge );
			
			$item['Text']['*'] = $title->getPrefixedText();
			$item['Description']['*'] = $extract;
			$item['Url']['*'] = $title->getFullUrl();
			if( $image ) {
				$thumb = $image->getThumbnail( 50, 50, false );
				$item['Image'] = array(
					'source' => wfExpandUrl( $thumb->getUrl() ),
					//alt
					'width' => $thumb->getWidth(),
					'height' => $thumb->getHeight() );
			}
		} else {
			$item = array( 'Text' => array( '*' => $name ) );
		}
		return $item;
	}
	
	protected function _checkRedirect( $title ) {
		$art = new Article( $title );
		$target = $art->getRedirectTarget();
		if( $target ) {
			return $target;
		} else {
			return $title;
		}
	}
	
	protected function _seen( $title ) {
		$name = $title->getPrefixedText();
		if( isset( $this->mSeen[$name] ) ) {
			return true;
		}
		$this->mSeen[$name] = true;
		return false;
	}

	/**
	 * Strip markup to show plaintext
	 * @param string $text
	 * @return string
	 * @access private
	 */
	function _stripMarkup( $text ) {
		global $wgContLang;
		
		$text = substr( $text, 0, 4096 ); // don't bother with long text...
		
		$text = str_replace( "'''", "", $text );
		$text = str_replace( "''", "", $text );
		
		$text = preg_replace( '#__[a-z0-9_]+__#i', '', $text ); // magic words
		
		$cleanChar = "[^|\[\]]";
		$subLink = "\[\[$cleanChar*(?:\|$cleanChar*)*\]\]";
		$pipeContents = "(?:$cleanChar|$subLink)*";
		$text = preg_replace_callback( "#
			\[\[
				($cleanChar*)
				(?:\|($pipeContents))?
				(?:\|$pipeContents)*
			\]\]
			#six", array( $this, '_stripLink' ), $text );
		
		$protocols = wfUrlProtocols();
		$text = preg_replace( '#\\[(?:$protocols).*? (.*?)\\]#s', '$1', $text ); // URL links
		$text = preg_replace( '#</?[a-z0-9]+.*?>#s', '', $text ); // HTML-style tags
		$text = preg_replace( '#\\{\\|.*?\\|\\}#s', '', $text ); // tables

		$text = preg_replace( '#^:.*$#m', '', $text ); // indented lines near start are usually disambigs or notices
		$text = Sanitizer::decodeCharReferences( $text );
		return trim( $text );
	}
	
	function _stripLink( $matches ) {
		$target = trim( $matches[1] );
		if( isset( $matches[2] ) ) {
			$text = trim( $matches[2] );
		} else {
			$text = $target;
		}
		
		$title = Title::newFromText( $target );
		if( $title ) {
			$ns = $title->getNamespace();
			if( $title->getInterwiki() || $ns == NS_IMAGE || $ns == NS_CATEGORY ) {
				return "";
			} else {
				return $text;
			}
		} else {
			return $matches[0];
		}
	}
	
	/**
	 * Extract the first two sentences, if detectable, from the text.
	 * @param string $text
	 * @return string
	 * @access private
	 */
	function _extractStart( $text ) {
		$endchars = array(
			'([^\d])\.\s', '\!\s', '\?\s', // regular ASCII
			'。', // full-width ideographic full-stop
			'．', '！', '？', // double-width roman forms
			'｡', // half-width ideographic full stop
			);
		
		$endgroup = implode( '|', $endchars );
		$end = "(?:$endgroup)";
		$sentence = ".*?$end+";
		$firstone = "/^($sentence)/u";
		if( preg_match( $firstone, $text, $matches ) ) {
			return $matches[1];
		} else {
			// Just return the first line
			$lines = explode( "\n", $text );
			return trim( $lines[0] );
		}
	}
	
	/**
	 * Grab the first thing that looks like an image link from the body text.
	 * This will exclude any templates, including infoboxes...
	 */
	function _extractBadge( $text ) {
		global $wgContLang;
		$image = preg_quote( $wgContLang->getNsText( NS_IMAGE ), '#' );
		if( preg_match( "#\[\[\s*(?:image|$image)\s*:\s*([^|\]]+)#", $text, $matches ) ) {
			return trim( $matches[1] );
		} else {
			return false;
		}
	}
	
	function _validateBadge( $arg ) {
		// Some templates want an entire [[Image:Foo.jpg|250px]]
		if( substr( $arg, 0, 2 ) == '[[' ) {
			return $this->_extractBadge( $arg );
		}
		
		// Others will take Image:Foo.jpg or Foo.jpg
		$title = Title::newFromText( $arg, NS_IMAGE );
		if( $title && $title->getNamespace() == NS_IMAGE ) {
			return $title->getDBKey();
		}
		return false;
	}
	
	protected function getExtract( $title, $chars=50 ) {
		$rev = Revision::newFromTitle( $title );
		if( $rev ) {
			$text = substr( $rev->getText(), 0, 16384 );
			
			// Ok, first note this is a TERRIBLE HACK. :D
			//
			// First, we use the system preprocessor to break down the text
			// into text, templates, extensions, and comments:
			global $wgParser;
			$wgParser->clearState();
			$wgParser->mOptions = new ParserOptions();
			$frame = $wgParser->getPreprocessor()->newFrame();
			$dom = $wgParser->preprocessToDom( $text );
			
			$imageArgs = array(
				'image',
				'image_skyline',
				'img',
				'Img',
			);
			
			// Now, we strip out everything that's not text.
			// This works with both DOM and Hash parsers, but feels fragile.
			$node = $dom->getFirstChild();
			$out = '';
			$badge = false;
			while( $node ) {
				if( $node->getName() == '#text' ) {
					$out .= $frame->expand( $node, PPFrame::RECOVER_ORIG );
				} elseif( !$badge && $node->getName() == 'template' ) {
					// Look for an "image" parameter child node
					$parts = $node->getFirstChild();
					while( $parts ) {
						if( $parts->getName() == "part" ) {
							$arg = $parts->splitArg();
							//var_dump( $arg );
							$argName = trim( $frame->expand( $arg["name"], PPFrame::RECOVER_ORIG ) );
							if( in_array( $argName, $imageArgs ) ) {
								$badge = $this->_validateBadge(
									trim(
										$frame->expand( $arg["value"], PPFrame::RECOVER_ORIG ) ) );
								if( $badge ) {
									break; // from the arg loop
								}
							}
						}
						$parts = $parts->getNextSibling();
					}
				}
				$node = $node->getNextSibling();
			}
			
			if( !$badge ) {
				// Look for the first image in the body text if there wasn't
				// one in an infobox.
				$badge = $this->_extractBadge( $out );
			}

			// The remaining text may still contain wiki and HTML markup.
			// We'll use our shitty hand parser to strip most of those from
			// the beginning of the text.
			$stripped = $this->_stripMarkup( $out );
			
			// And now, we'll grab just the first sentence as text, and
			// also try to rip out a badge image.
			return array(
				$this->_extractStart( $stripped ),
				$badge );
		}
		return '';
	}
	
	protected function getBadge( $title, $fromText ) {
		if( $title->getNamespace() == NS_IMAGE ) {
			$image = wfFindFile( $title );
			if( $image && $image->exists() ) {
				return $image;
			}
		} else {
			// See if we found an [[Image:xxx]] in the text...
			if( $fromText ) {
				$image = wfFindFile( $fromText );
				if( $image && $image->exists() ) {
					return $image;
				}
			}
		}
	}
}
