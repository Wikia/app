<?php
/**
 * PHP Reverse Parser - Processes given HTML into wikimarkup (new development version)
 *
 * @author Maciej 'macbre' Brencz <macbre(at)wikia-inc.com>
 * @author Inez Korczynski <inez(at)wikia-inc.com>
 *
 * @see http://meta.wikimedia.org/wiki/Help:Editing
 */
class ReverseParser {

	// DOMDocument for processes HTML
	private $dom;

	// Wysiwyg/FCK meta data
	private $data = array();

	// cache results of wfUrlProtocols()
	private $urlProtocols;

	private function getUrlProtocols() {
		if(empty($this->urlProtocols)) {
			$this->urlProtocols = wfUrlProtocols();
		}
		return $this->urlProtocols;
	}

	function __construct() {
		$this->dom = new DOMdocument();
	}

	public function parse($html, $data = array()) {
		wfProfileIn(__METHOD__);

		$out = '';

		if(is_string($html) && $html != '') {

			// fix for proper encoding of UTF characters

			wfDebug("Wysiwyg ReverseParserNew HTML original: $html\n");

			$html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>'.$html.'</body></html>';

			$this->data = $data;

			wfDebug("Wysiwyg ReverseParserNew data: ".print_r($this->data, true)."\n");

			wfDebug("Wysiwyg ReverseParserNew HTML: $html\n");

			wfSuppressWarnings();
			if($this->dom->loadHTML($html)) {
				$body = $this->dom->getElementsByTagName('body')->item(0);
				wfDebug("Wysiwyg ReverseParserNew HTML from DOM: ".$this->dom->saveHTML()."\n");
				$out = $this->parseNode($body);
			}
			wfRestoreWarnings();

			wfDebug("Wysiwyg ReverseParserNew wikitext: {$out}\n");
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	private function parseNode($node, $level = 0) {
		wfProfileIn(__METHOD__);

		wfDebug("Wysiwyg ReverseParserNew level: ".str_repeat('.', $level).$node->nodeName."\n");

		$childOut = '';

		// parse child nodes
		if($node->hasChildNodes()) {
			$nodes = $node->childNodes;

			// handle lists (open)
			$isListNode = in_array($node->nodeName, array('ul', 'ol', 'dl'));

			if($isListNode) {
				// build bullets stack
				switch ($node->nodeName) {
					case 'ul':
						$bullet = '*';
						break;
					case 'ol':
						$bullet = '#';
						break;
					case 'dl':
						$bullet = ':';
						break;
				}
				if (!$node->getAttribute('washtml')) {
					// handle (un)ordered lists indentation done by FCK (margin-left/right CSS property)
					if (in_array($node->nodeName, array('ol','ul'))) {
						$indentation = $this->getIndentationLevel($node);
						if ($indentation !== false) {
							$this->listBullets = str_repeat(':', $indentation);
						}
					}
					$this->listLevel++;
					$this->listBullets .= $bullet;
				}
			}

			for($n = 0; $n < $nodes->length; $n++) {
				$childOut .= $this->parseNode($nodes->item($n), $level+1);
			}

			// handle lists (close)
			if($isListNode) {
				// fix for different list types on the same level of nesting
				if($node->previousSibling && in_array($node->previousSibling->nodeName, array('ol', 'ul', 'dl')) && $this->listLevel > 1) {
					$childOut = "\n" . trim($childOut);
				} else {
					$childOut = trim($childOut);
				}

				if (!$node->getAttribute('washtml')) {
					$this->listLevel--;
					$this->listBullets = substr($this->listBullets, 0, -1);
				}
			}
		}

		// parse current node
		$out = '';

		$textContent = ($childOut != '') ? $childOut : $node->textContent;

		if($node->nodeType == XML_ELEMENT_NODE) {

			$washtml = $node->getAttribute('washtml');

			if(empty($washtml)) {

				$refid = $node->getAttribute('refid');

				if(is_numeric($refid)) {
					$nodeData = $this->data[$refid];
				}
				else {
					$nodeData = false;
				}

				switch($node->nodeName) {
					case 'body':
						$out = $textContent;
						break;

					case 'br':
						// ignore <br type="_moz"> (fix for IE)
						if($node->getAttribute('type') == '_moz') {
							$out = '';
						}

						// <br /> inside paragraphs (without <!--NEW_LINE_1--> comment following it)
						if($node->nextSibling && $node->nextSibling->nodeType != XML_COMMENT_NODE) {
							$out = "<br />";
						}
						
						break;

					case 'p':
						// detect indented paragraph (margin-left CSS property)
						$indentation = $this->getIndentationLevel($node);

						// is current <p> node of definition list?
						$isDefinitionList = false;

						// default prefix -> empty line after previous paragraph
						// doesn't apply to definition lists parsed as <p> tags
						// ;foo
						// :bar
						$prefix = "\n\n";
	
						// handle <dt> elements being rendered as p.definitionTerm
						if ($this->hasCSSClass($node, 'definitionTerm')) {
							$textContent = ';' . rtrim($textContent);
							$prefix = $node->previousSibling ? "\n" : '';

							$isDefinitionList = true;
						}

						// handle indentations
						if ($indentation > 0) {
							$textContent = str_repeat(':', $indentation) . rtrim($textContent);
							$prefix = $node->previousSibling ? "\n" : '';

							$isDefinitionList = true;
						}

						$previousNode = $this->getPreviousElementNode($node);

						// if the first previous XML_ELEMENT_NODE (so no text and no comment) of the current
						// node is <p> then add new line before the current one
						if ($previousNode && $previousNode->nodeName == 'p') {

							// previous <p> node was related to definion lists
							// take just _new_lines_before value under consideration
							if ( ($this->hasCSSClass($previousNode, 'definitionTerm') || $this->getIndentationLevel($previousNode) > 0 ) && $prefix == "\n\n") {
								$newLinesBefore = $node->getAttribute('_new_lines_before');
								$prefix = str_repeat("\n",  $newLinesBefore);
							}
							$textContent = $prefix . $textContent;
						} else if($textContent == ""){
							// empty paragraph
							$textContent = "\n";
						} else {
							// add new lines before paragraph
							$newLinesBefore = $node->getAttribute('_new_lines_before');
							if(is_numeric($newLinesBefore)) {
								$textContent = str_repeat("\n", $newLinesBefore).$textContent;
							}

							// we're in definion list and previous node wasn't paragraph -> add extra line break
							if($isDefinitionList && $node->previousSibling) {
								$textContent = "\n{$textContent}";
							}
						}

						$out = $textContent;
						break;

					case 'h1':
					case 'h2':
					case 'h3':
					case 'h4':
					case 'h5':
					case 'h6':
						$head = str_repeat("=", $node->nodeName{1});
						if(!empty($nodeData)) {
							$linesBefore = ((($previousNode = $this->getPreviousElementNode($node)) && $this->isHeaderNode($previousNode)) || empty($node->previousSibling)) ? 0 : ($nodeData['linesBefore']+1)%2;
							$linesAfter = $nodeData['linesAfter']-1;
						} else {
							$linesBefore = 0;
							$linesAfter = 1;
							$textContent = " ".trim($textContent)." ";
						}

						// headings inside table cell
						if ( $this->isTableCell($node->parentNode) ) {
							$linesBefore++;
						}

						$out = str_repeat("\n", $linesBefore) . $head . $textContent . $head . str_repeat("\n", $linesAfter);
						break;

					// preformatted text
					case 'pre':
						$textContent = trim(str_replace("\n", "\n ", $textContent)); // add white space before each line
						$out = " {$textContent}";
						break;

					// text formatting
					// 1 '</b><i><b>' => '<i>'
					// 2 '</i><b><i>' => '<b>'
					// 3 '</b></i><b>' => '</i>'
					// 4 '</i></b><i>' => '</b>'
					case 'i':
					case 'b':
						switch($node->nodeName) {
							case 'i':
								$open = $close = "''";
								break;
							case 'b':
								$open = $close = "'''";
								break;
						}

						// A) opening tags
						// 1, 2
						if($node->parentNode && $node->parentNode->previousSibling &&
							$node->isSameNode($node->parentNode->firstChild) &&
							in_array($node->parentNode->nodeName, array('i','b')) &&
							$node->parentNode->nodeName != $node->nodeName &&
							$node->parentNode->previousSibling->nodeName == $node->nodeName) {
							// don't open bold (1) / italic (2)
							$open = '';
						}

						// 3, 4
						if($node->previousSibling && $node->previousSibling->hasChildNodes() &&
							in_array($node->previousSibling->nodeName, array('i','b')) &&
							$node->previousSibling->nodeName != $node->nodeName &&
							$node->previousSibling->lastChild->nodeName == $node->nodeName) {
							// don't open bold (3) / italic (4)
							$open = '';
						}

						// B) closing tags
						// 1, 2
						if($node->nextSibling && $node->nextSibling->hasChildNodes() &&
							in_array($node->nextSibling->nodeName, array('i','b')) &&
							$node->nextSibling->nodeName != $node->nodeName &&
							$node->nextSibling->firstChild->nodeName == $node->nodeName) {
							// don't close bold (1) / italic (2)
							$close = '';
						}

						// 3, 4
						if($node->parentNode && $node->parentNode->nextSibling &&
							$node->isSameNode($node->parentNode->lastChild) &&
							in_array($node->parentNode->nodeName, array('i','b')) &&
							$node->parentNode->nodeName != $node->nodeName &&
							$node->parentNode->nextSibling->nodeName == $node->nodeName) {
							// don't close bold (3) / italic (4)
							$close = '';
						}

						$out = "{$open}{$textContent}{$close}";
						break;

					// tables
					// @see http://en.wikipedia.org/wiki/Help:Table
					case 'table':
						if (empty($nodeData)) {
							$attStr = ltrim($this->getAttributesStr($node));
							$textContent = rtrim($textContent);
							$out = "{|{$attStr}\n{$textContent}\n|}";

							// handle nested tables
							if ($node->parentNode->nodeName != 'body') {
								$out = "\n$out";
							}
						}
						else {
							// thumbnail generation error - handle as an image
							$out = $this->handleImage($node, $textContent);
						}
						break;

					case 'caption':
						$attStr = $this->getAttributesStr($node);
						if ($attStr != '') {
							$attStr = ltrim("{$attStr}|");
						}
						$out = "|+{$attStr}{$textContent}\n";
						break;

					case 'tr':
						$isFirstRow = $node->isSameNode($node->parentNode->firstChild);
						$attStr = ltrim($this->getAttributesStr($node));

						// don't convert first table row into |-
						if ($isFirstRow && $attStr == '') {
							$out = rtrim($textContent) . "\n";
						}
						else {
							$out = "|-{$attStr}\n".rtrim($textContent)."\n";
						}
						break;

					case 'th':
						$attStr = $this->getAttributesStr($node);
						if ($attStr != '') {
							$attStr = ltrim("{$attStr}|");
						}
						$out = "!{$attStr}{$textContent}\n";
						break;

					case 'td':
						$attStr = $this->getAttributesStr($node);
						if ($attStr != '') {
							$attStr = ltrim("{$attStr}|");
						}
						$textContent = rtrim($textContent);

						// |- |+ |} are reserved wikimarkup syntax inside table - just add space before
						if ($textContent!='' && in_array($textContent{0}, array('-', '+', '}'))) {
							$textContent = " {$textContent}";
						}

						$out = "|{$attStr}{$textContent}\n";
						break;

					// ignore tbody tag - just pass it through
					case 'tbody':
						$out = $textContent;
						break;

					// lists
					case 'ul':
					case 'ol':
						// rtrim used to remove \n added by the last list item
						$out = rtrim($textContent, " \n");
						break;

					// lists elements
					case 'li':
					case 'dd':
					case 'dt':
						$out = $this->handleListItem($node, $textContent);
						break;

					// images
					case 'div':
					case 'iframe':
						if (!empty($nodeData)) {
							$out = $this->handleImage($node, $textContent);
						}
						break;

					// links
					case 'a':
						$out = $this->handleLink($node, $textContent);
						break;

					// templates, magic words, parser hooks placeholders
					case 'input':
						$out = $this->handlePlaceholder($node, $textContent);
						break;
				}

			} else {

				$attStr = $this->getAttributesStr($node);

				if($node->nodeName == 'br' || $node->nodeName == 'hr') {
					$out = "<{$node->nodeName}{$attStr} />";
				} else {
					// remove prohibited HTML tags (may occur after pasting content from external site)
					if(in_array($node->nodeName, array('script', 'embed'))) {
						$out = '';
						break;
					}
					$out = "<{$node->nodeName}{$attStr}>{$textContent}</{$node->nodeName}>";
				}

			}

			// if current processed node contains _wysiwyg_new_line attribute (added in Parser.php)
			// then add new line before it
			if($this->nodeHasNewLineBefore($node)) {
				$out = "\n" . $out;
			}
			
			// do the same with nodes containing _wysiwyg_line_start and washtml attributes (added in Parser.php)
			if($this->nodeHasLineStart($node)) {
				$out = "\n" . $out;
			}
		} else if($node->nodeType == XML_COMMENT_NODE) {

			// if the next sibling node of the current one comment node is text or node (so any sibling)
			// then add new line
			// e.g. "<!--NEW_LINE_1-->abc" => "\nabc"
			if($node->data == "NEW_LINE_1" && $node->nextSibling) { 
				$out = "\n";
			}

		} else if($node->nodeType == XML_TEXT_NODE) {

			// if the next sibling node of the current one text node is comment (NEW_LINE_1)
			// then cut the last character of current text node (it must be space added by FCK after convertion of \n)
			// e.g. "abc <!--NEW_LINE_1-->" => "abc<!--NEW_LINE_1-->"
			if($node->nextSibling && $node->nextSibling->nodeType == XML_COMMENT_NODE && $node->nextSibling->data == "NEW_LINE_1") {
				$textContent = substr($textContent, 0, -1);
			}

			// remove last space (added by FCK after convertion of \n) from text node
			// before HTML tag with _wysiwyg_line_start attribute
			// e.g. ' <div _wysiwyg_new_line="true">...' => '\n<div>...'
			else if ( substr($textContent, -1) == ' ' && $this->nextSiblingIsInNextLine($node) ) {
				$textContent = substr($textContent, 0, -1);
			}

			$out = $textContent;

		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 * Returns wikimarkup for <span> tag
	 *
	 * Span is used to wrap various elements like templates etc.
	 */
	private function handlePlaceholder($node, $content) {

		// handle spans with refId attribute: images, templates etc.
		$refid = $node->getAttribute('refid');

		if ( is_numeric($refid) && isset($this->data[$refid]) ) {
			$refData = (array) $this->data[$refid];

			switch($refData['type']) {
				// [[Image:Jimbo.jpg|thumb]]
				case 'image':
				// [[Media:foo.jpg]]
				case 'internal link: media':
					$pipe = ($refData['description'] != '') ? '|'.$refData['description'] : '';
					return "[[{$refData['href']}{$pipe}]]";

				// <gallery></gallery>
				case 'gallery':
					return $refData['description'];

				// <nowiki></nowiki>
				case 'nowiki':
					return "<nowiki>{$refData['description']}</nowiki>";

				// <html></html>
				case 'html':
					return "<html>{$refData['description']}</html>";

				// [[Category:foo]]
				case 'category':
					$pipe = ($refData['description'] != '') ? '|'.$refData['description'] : '';
					return "[[{$refData['href']}{$pipe}]]{$refData['trial']}";

				// parser hooks
				case 'hook':
					return $refData['description'];

				// {{template}}
				//case 'curly brackets':
				case 'template':
					return $refData['originalCall'];

				// __NOTOC__ ...
				case 'double underscore':
				// __TOC__
				case 'double underscore: toc':
					return $refData['description'];

				// <gallery> parser hook tag
				case 'gallery':
					return $refData['description'];

				// ~~~~
				case 'tilde':
					return $refData['description'];

				// link with template inside description
				case 'internal link':
					return $this->handleLink($node, $refData['description']);

				// fallback
				default:
					return '<!-- unsupported placeholder type -->';
			}
		}
		// sometimes FCK adds empty spans with "display: none"
		return '';
	}

	/**
	 * Returns wikimarkup for <a> tag
	 */
	private function handleLink($node, $content) {

		$refid = $node->getAttribute('refid');

		// handle links pasted from external sites -> assign new refid
		if (!is_numeric($refid) || !isset($this->data[$refid])) {
			$href = $node->getAttribute('href');

			if( is_string($href) ) {
				array_push($this->data, array(
					'type' => ($content == $href) ? 'external link: raw' : 'external link',
					'text' => $content,
					'href' => $href
				));
				// generate new refid
				$refid = count($this->fckData);
			}
		}


		$data = $this->data[$refid];

		switch($data['type']) {
			case 'image';
				return $this->handleImage($node, $content);
			
			case 'internal link':
			case 'internal link: file':
			case 'internal link: special page':
				// take link description from parsed HTML
				$data['description'] = $content;
				$data['trial'] = '';

				// * [[foo|foo]] -> [[foo]]
				if ($data['href'] == $data['description']) {
					$data['description'] = '';
				}
				// * [[:foo]]
				else if ( ($data['href']{0} == ':') && (substr($data['href'],1) == $data['description']) ) {
					$data['description'] = '';
				}
				// * [[foo|foots]] -> [[foo]]ts (trial can't contain numbers)
				else if ($data['description'] != '' && substr($data['description'], 0, strlen($data['href'])) == $data['href']) {
					$trial = substr($data['description'], strlen($data['href']));

					// validate $trial (might only contain chars)
					if ( ctype_alpha($trial) ) {
						$data['trial'] = $trial;
						$data['description'] = '';
					}
				}

				// generate wikisyntax
				$tag =  "[[{$data['href']}";

				if($data['description'] != '') {
					$tag .=  "|{$data['description']}]]";
				} else {
					$tag .=  "]]";
				}
				if($data['trial'] != '') {
					$tag .= $data['trial'];
				}
				return $tag;

			case 'external link':
			case 'external link: raw':
				// do we have text before the link?
				$textBefore = $node->previousSibling && $node->previousSibling->nodeType == XML_TEXT_NODE && substr($node->previousSibling->textContent, -1) != ' ';
				$textAfter = $node->nextSibling && $node->nextSibling->nodeType == XML_TEXT_NODE && $node->nextSibling->textContent{0} != ' ';

				// validate URL
				if (strpos($data['href'], ':')) {
					list($protocol, $path) = explode(':', $data['href'], 2);
				}
				else {
					// default to http if none protocol provided
					$protocol = 'http';
					$path = '//'.$data['href'];
				}

				// make sure to have protocol name in lower case
				$protocol = strtolower($protocol);

				// put it back together
				$data['href'] = $protocol . ':' . $path;

				// fill FCK data
				if (preg_match('%^(?:' . $this->urlProtocols . ')%im', $data['href'])) {
					// external links
					if ($data['type'] == 'external link: raw' && !$textBefore && !$textAfter) {
						// use http://foo.com
						return $data['href'];
					}
					else if ($this->hasCSSClass($node, 'autonumber') && strlen($content) > 2 && is_numeric(substr($content,1,-1))) {
						// use [http://foo.com] - numbered external links
						return "[{$data['href']}]";
					} else {
						// use [http://foo.com desc]
						return "[{$data['href']} {$content}]";
					}
				}
				else {
					// internal links
					return "[{$data['href']} {$content}]";
				}
		}

	}

	/**
	 * Returns wikimarkup for image tags
	 */
	private function handleImage($node, $content) {

		// check is perfomed earlier
		$data = $this->data[ $node->getAttribute('refid') ];

		switch($data['type']) {
			case 'image':
				$prefix = ''; //( in_array($node->nodeName, array('div', 'table')) ) ? "\n\n" : '';
				$out = $prefix . $data['original'];
				return $out;

			default:
				return '';
		}
	}

	/**
	 * Returns wikimarkup for ordered, unordered and definition lists
	 */
	private function handleListItem($node, $content) {
		switch($node->nodeName) {
			case 'li':
				if( $node->hasChildNodes() && in_array($node->childNodes->item(0)->nodeName, array('ul', 'ol')) ) {
					// nested lists like
					// *** foo
					// *** bar
					return $content . "\n";
				} else {
					return $this->listBullets . ' ' . ltrim($content) . "\n";
				}
			break;
		}
	}

	private function getPreviousElementNode($node) {
		$temp = $node;
		while($node->previousSibling) {
			$node = $node->previousSibling;
			if($node->nodeType == XML_ELEMENT_NODE) {
				return $node;
			}
		}
		return false;
	}

	/*
	 * Detect _wysiwyg_new_line attribute (empty line of wikitext before given node) and perform extra check
	 */
	private function nodeHasNewLineBefore($node) {

		// no node before <p>
		if(empty($node->previousSibling) && $node->nodeName == 'p') {
			return false;
		}

		if($node->getAttribute('_wysiwyg_new_line') && !$this->isHeaderNode($node)) {
			return true;
		}

		return false;
	}

	/*
	 * Detect whether given node starts line of wikitext and perfrom extra check
	 */
	private function nodeHasLineStart($node) {

		if (!$node->previousSibling) {
			return false;
		}

		// support for HTML tags in wikitext
		if ($node->getAttribute('washtml') && $node->getAttribute('_wysiwyg_line_start')) {
			return true;
		}

		// we have proper handling of tables wikisyntax so don't add any new \n for table nodes
		if (in_array($node->nodeName, array('tr', 'th', 'td')) && !$node->getAttribute('washtml')) {
			return false;
		}

		// they start new line, but we don't have to add new line before them
		if (in_array($node->nodeName, array('p', 'pre'))) {
			return false;
		}

		// HTML tags in wikitext
		if ($node->getAttribute('_wysiwyg_line_start')) {
			return true;
		}

		return false;
	}

	/*
	 * Check if next sibling of given node starts next line of wikitext (based on _wysiwyg_line_start attribute and node name)
	 *
	 * Used to remove last char (space) of text node
	 */
	private function nextSiblingIsInNextLine($node) {

		$node = $node->nextSibling;

		if (empty($node)) {
			return false;
		}

		if ($node->nodeType != XML_ELEMENT_NODE) {
			return false;
		}

		// we have proper handling of tables wikisyntax so don't add any new \n for table nodes
		if (in_array($node->nodeName, array('tr', 'th', 'td')) && !$node->getAttribute('washtml')) {
			return false;
		}

		// "by definition" <p> and <pre> nodes starts line of wikitext
		if (in_array($node->nodeName, array('p', 'pre'))) {
			return true;
		}

		// HTML tags in wikitext
		if ($node->getAttribute('_wysiwyg_line_start')) {
			return true;
		}

		return false;
	}

	private function isHeaderNode($node) {
		return ($node->nodeName{0} == 'h') && is_numeric($node->nodeName{1});
	}

	/**
	 * Return true if given node is table cell (td/th) - used to add newline before certain wikimarkup when is table cell
	 */
	private function isTableCell($node) {
		return in_array($node->nodeName, array('td', 'th', 'caption'));
	}

	/**
	 * Return true if given node is list container
	 */
	private function isList($node) {
		return in_array($node->nodeName, array('ol', 'ul', 'dl'));
	}

	/**
	 * input: '<div id="123" washtml="true" _wysiwyg_new_line="false" style="border: solid 1px">'
	 * output: ' id="123" style="border: solid 1px"'
	 */
	private function getAttributesStr($node) {
		if(!$node->hasAttributes()) {
			return '';
		}
		$attStr = '';
		foreach ($node->attributes as $attrName => $attrNode) {
			if( in_array($attrName, array('washtml', '_wysiwyg_new_line', '_wysiwyg_line_start')) ) {
				continue;
			}
			$attStr .= ' ' . $attrName . '="' . $attrNode->nodeValue  . '"';
		}
		return $attStr;
	}

	/**
	 * Returns level of indentation from value of margin-left CSS property
	 */
	private function getIndentationLevel($node) {
		if(!$node->hasAttributes()) {
			return false;
		}

		$cssStyle = $node->getAttribute('style');

		if(!empty($cssStyle)) {
			$margin = (substr($cssStyle, 0, 11) == 'margin-left') ? intval(substr($cssStyle, 12)) : 0;
			return intval($margin/40);
		}

		return false;
	}

	/**
	 * Returns true if given node has CSS class set
	 */
	private function hasCSSClass($node, $class) {
		$classes = $node->getAttribute('class');

		if (is_string($classes)) {
			return in_array($class, explode(' ', $classes));
		}
		else {
			return false;
		}
	}

}
