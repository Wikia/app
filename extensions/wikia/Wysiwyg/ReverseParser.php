<?php
/**
 * PHP Reverse Parser - Processes given HTML into wikimarkup
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

	// lists handling
	private $listLevel;
	private $listBullets;
	private $listIndent;

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

	/**
	 * Parses given HTML into DOM tree (using XML/HTML parser)
	 */
	private function parseToDOM($html, $parseAsXML = true) {
			wfProfileIn(__METHOD__);

			$ret = false;

			wfSuppressWarnings();

			if ($parseAsXML) {
				// form proper XML string
				$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><body>{$html}</body>";

				// try to parse as XML
				if($this->dom->loadXML($xml)) {
					$ret = $this->dom->getElementsByTagName('body')->item(0);
				}
			}
			else {
				// form proper HTML string
				$html = "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/></head><body>{$html}</body></html>";

				// try to parse as HTML
				if($this->dom->loadHTML($html)) {
					$ret = $this->dom->getElementsByTagName('body')->item(0);
				}
			}

			wfRestoreWarnings();

			wfProfileOut(__METHOD__);

			// return <body> node or false if XML parsing failed
			return $ret;
	}

	/**
	 * Converts given HTML into wikitext using extra information stored in meta data
	 */
	public function parse($html, $data = array()) {
		wfProfileIn(__METHOD__);

		$out = '';

		if(is_string($html) && $html != '') {

			// save meta-data
			$this->data = is_array($data) ? $data : array();

			// HTML cleanup
			// trying to fix RT #9466
			// </b><a ...><b>     => <a ...>
			// </b></a><b>        => </a>
			// </b></a><a ...><b> => </a><a>
			// formatting tags: one of b, i, u, strike
			$formatTags = '(b|i|u|strike)';
			$replacements = array(
				"#<\/{$formatTags}>(<a[^>]+>)<\\1>#i"		=> '$2',
				"#<\/{$formatTags}>(<\/a>)<\\1>#i"		=> '$2',
				"#<\/{$formatTags}>(<\/a><a[^>]+>)<\\1>#i"	=> '$2'
			);

			$htmlFixed = preg_replace(array_keys($replacements), array_values($replacements), $html, -1, $count);
			wfDebug("Wysiwyg ReverseParserNew: made {$count} replacements for RT #9466\n");

			// try to parse fixed HTML as XML
			$bodyNode = $this->parseToDOM($htmlFixed);

			// in some edge-cases it may fail - then try to parse original HTML as HTML
			if (empty($bodyNode)) {
				wfDebug("Wysiwyg ReverseParserNew: parsing as XML failed! Trying HTML parser\n");
				$bodyNode = $this->parseToDOM($html, false);
			}

			// now we should have properly parsed HTML
			if (!empty($bodyNode)) {
				wfDebug("Wysiwyg ReverseParserNew XML (as seen by DOM): ".$this->dom->saveXML()."\n");

				// do recursive reverse parsing
				$out = $this->parseNode($bodyNode);

				wfDebug("Wysiwyg ReverseParserNew wikitext: {$out}\n");
			}
			else {
				wfDebug("Wysiwyg ReverseParserNew: HTML parsing failed!\n");
				$out = '';
			}
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 * Recursively parses given DOM node
	 */
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
							$this->listIndent = str_repeat(':', $indentation);
						}
						else {
							$this->listIndent = '';
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
					$childOut = "\n" . $childOut;
				} else {
					$childOut = $childOut;
				}

				if (!$node->getAttribute('washtml')) {
					$this->listLevel--;
					$this->listBullets = substr($this->listBullets, 0, -1);
				}
			}
		}

		// parse current node
		$out = '';

		$textContent = ($childOut != '') ? $childOut : $this->cleanupTextContent($node);

		if($node->nodeType == XML_ELEMENT_NODE) {

			$washtml = $node->getAttribute('washtml');
			$newNode = $node->getAttribute('_wysiwyg_new');

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

						// <br /> inside paragraphs (without ' <!--NEW_LINE_1-->' following it)
						if($node->nextSibling && $node->nextSibling->nextSibling &&
							$node->nextSibling->nodeType != XML_COMMENT_NODE &&
							$node->nextSibling->nextSibling->nodeType != XML_COMMENT_NODE) {
							$out = '<br />';
						}

						// <br /> added in FCK by pressing Shift+ENTER
						else if ($newNode) {
							$out = "\n";
						}

						break;

					case 'p':
						// detect indented paragraph (margin-left CSS property)
						$indentation = $this->getIndentationLevel($node);

						// get previous node (ignoring whitespaces and comments)
						$previousNode = $this->getPreviousElementNode($node);

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
							$prefix = $node->getAttribute('_new_lines_before') ? "\n\n" : "\n";
							$isDefinitionList = true;
						}

						// handle indentations
						if ($indentation > 0) {
							$textContent = str_repeat(':', $indentation) . rtrim($textContent);
							$prefix = $node->getAttribute('_new_lines_before') ? "\n\n" : "\n";
							$isDefinitionList = true;
						}

						// paragraph following indented paragraph
						if ($previousNode && $this->getIndentationLevel($previousNode) !== false) {
							$newLinesBefore = intval($node->getAttribute('_new_lines_before')) + 1;
							$prefix = str_repeat("\n", $newLinesBefore);
						}

						// <p><br /> </p>
						if ( ($textContent == ' ') && ($node->firstChild->nodeType == XML_ELEMENT_NODE) &&
							($node->firstChild->nodeName == 'br') ) {
							$textContent = '';
						}

						// if the first previous XML_ELEMENT_NODE (so no text and no comment) of the current
						// node is <p> then add new line before the current one
						if ($previousNode && $previousNode->nodeName == 'p' && $node->parentNode->nodeName != 'li') {
							$textContent = $prefix . $textContent;
						} else if($textContent == ""){
							// empty paragraph
							$textContent = "\n";

							// add \n if previous node is <pre>
							if ($previousNode && $previousNode->nodeName == 'pre') {
								$textContent = "\n{$textContent}";
							}

							// add \n if previous node has wasHTML attribute set
							if ($previousNode && $previousNode->hasAttribute('washtml')) {
								$textContent = "\n{$textContent}";
							}

						} else {
							if ( !empty($node->parentNode) && $node->parentNode->nodeName == 'li' ) {
								// indented paragraph inside list item
								// *: foo

								// remove one :
								$textContent = substr($textContent, 1);

								// if previous node was paragraph or text node
								// then we should add bullets as it's next list item
								if ( ($previousNode && $previousNode->nodeName == 'p') || $this->getPreviousTextNode($node) ) {
									$textContent = "\n" . $this->listIndent . $this->listBullets . $textContent;
								}
							}
							// add new lines before paragraph
							else if ($isDefinitionList) {
								// for : and ; lists use prefix value
								if (empty($node->previousSibling)) {
									// current node begins the wikitext - remove one new line
									$prefix = substr($prefix, 1);
								}
								$textContent = $prefix . $textContent;
							}
							else {
								// for paragraphs use _new_lines_before attribute value
								$newLinesBefore = intval($node->getAttribute('_new_lines_before'));
								if($newLinesBefore > 0) {
									$textContent = str_repeat("\n", $newLinesBefore).$textContent;
								}

								// add newline before paragraph if previous node ...
								if(!empty($previousNode) && (!$isDefinitionList) ) {
									// is list
									if ($this->isList($previousNode)) {
										$textContent = "\n{$textContent}";
									}

									// is <pre> or <div>
									if ( $previousNode->nodeName == 'pre' ) {
										$textContent = "\n{$textContent}";
									}

									// has wasHTML attribute set
									if ($previousNode->hasAttribute('washtml')) {
										$textContent = "\n{$textContent}";
									}
								}
							}

							// <p> is second child of <td> and previous sibling is text node
							// and first child of parent node
							if ( ($node->parentNode->nodeName == 'td') && $node->previousSibling && $node->previousSibling->isSameNode($node->parentNode->firstChild) && ($node->previousSibling->nodeType == XML_TEXT_NODE) ) {
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
							$nextNode = $this->getNextElementNode($node);

							$linesBefore = 0;
							$linesAfter = $nodeData['linesAfter']-1;

							// do not remove one lineAfter if paragraph is following
							if ( $nextNode && ($nextNode->nodeName == 'p') && $this->getIndentationLevel($nextNode) === false ) {
								$linesAfter++;
							}
							$textContent = $node->getAttribute('space_after') . $textContent;
						} else {
							$linesBefore = $node->previousSibling ? 2 : 0;
							$linesAfter = 1;
							$textContent = " ".trim($textContent)." ";
						}

						// heading at the beginning of table cell
						if ( $this->isTableCell($node->parentNode) && $node->isSameNode($node->parentNode->firstChild) ) {
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

					// <strike>foo</strike>
					case 'strike':
						$out ="<strike>{$textContent}</strike>";
						break;

					// <u>foo</u>
					case 'u':
						$out = "<u>{$textContent}</u>";
						break;

					// ----
					case 'hr':
						$out = "----\n";
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

							$nextNode = $this->getNextElementNode($node);

							// we have non-table content after current table
							if (!empty($nextNode)) {
								switch($nextNode->nodeName) {
									case 'table':
										break;

									case 'p':
										if ($nextNode->hasAttribute('_new_lines_before') && $this->getIndentationLevel($nextNode) === false) {
											$out = "$out\n";
										}
										break;

									case 'pre':
										break;

									default:
										$out = "$out\n";
								}
							}
						}
						else {
							// thumbnail generation error - handle as an image
							$out = $this->handleMedia($node, $textContent);
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

						// if first child of table cell is paragraph,
						// then add linebreak after pipe beginning the table cell
						if ( !empty($node->firstChild) && ($node->firstChild->nodeName == 'p') ) {
							$textContent = "\n{$textContent}";
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
						$out = rtrim($textContent, "\n");
						break;

					// lists elements
					case 'li':
					case 'dd':
					case 'dt':
						$out = $this->handleListItem($node, $textContent);
						break;

					// image / video
					case 'div':
					case 'iframe':
						if (!empty($nodeData)) {
							$out = $this->handleMedia($node, $textContent);

							// add newline if next node is paragraph
							// and was in next line of wikitext
							$nextNode = $this->getNextElementNode($node);

							if ( $nextNode && ($nextNode->nodeName == 'p') && $nextNode->hasAttribute('_new_lines_before') && $this->getIndentationLevel($nextNode) === false ) {
								$out = "$out\n";
							}

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
				wfDebug("Wysiwyg ReverseParserNew - has new line before\n");
				$out = "\n{$out}";
			}

			// do the same with nodes containing _wysiwyg_line_start and washtml attributes (added in Parser.php)
			if($this->nodeHasLineStart($node)) {
				wfDebug("Wysiwyg ReverseParserNew - starts new line\n");
				$out = "\n{$out}";
			}

			// add newlines before/after wikimarkup if current node has been added in FCK wysiwyg mode
			// FCK formats HTML a bit different then MW parser
			if ($newNode) {
				$prevNode = $this->getPreviousElementNode($node);

				if (!empty($prevNode)) {
					switch($node->nodeName) {
						case 'ol':
						case 'ul':
							$out = "\n\n{$out}\n";
							break;

						case 'table':
							$out = "\n\n{$out}\n";
							break;
					}
				}
			}

		} else if($node->nodeType == XML_COMMENT_NODE) {

			// if the next sibling node of the current one comment node is text or node (so any sibling)
			// then add new line
			// e.g. "<!--NEW_LINE_1-->abc" => "\nabc"

			// ignore <!--NEW_LINE_1--> comment inside list item
			if($node->data == "NEW_LINE_1" && $node->nextSibling && $node->parentNode->nodeName != 'li') {
				$out = "\n";
			}

		} else if($node->nodeType == XML_TEXT_NODE) {

			// if the next sibling node of the current one text node is comment (NEW_LINE_1)
			// then cut the last character of current text node (it must be space added by FCK after convertion of \n)
			// e.g. "abc <!--NEW_LINE_1-->" => "abc<!--NEW_LINE_1-->"
			if($node->nextSibling && $node->nextSibling->nodeType == XML_COMMENT_NODE && $node->nextSibling->data == "NEW_LINE_1") {
				$textContent = substr($textContent, 0, -1);
			}

			// remove last space from last child of paragraph
			// this way we keep whitespaces at the end of paragraphs and remove
			// extra space added by FCK (after convertion of \n)
			else if ( substr($textContent, -1) == ' ' && $node->parentNode->nodeName == 'p' && $node->isSameNode($node->parentNode->lastChild)) {
				$textContent = substr($textContent, 0, -1);
			}

			// check whether we should allow whitespaces inclusion into wikitext
			// e.g. we don't want to add whitespaces inside tables HTML markup
			else if ( strspn($textContent, ' ') == strlen($textContent) ) {
				switch($node->parentNode->nodeName) {
					case 'table':
					case 'tbody':
					case 'tr':
					case 'body':
						$textContent = '';
						break;

					case 'li':
						// we may have single space before <ul> nested inside another <li>
						// e.g.
						// * <strike>foo</strike>
						// ** test
						if ( $node->nextSibling && $this->isList($node->nextSibling) ) {
							$textContent = substr($textContent, 0, -1);
						}
						break;
					default:
				}
			}

			// remove last space (added by FCK after convertion of \n) from text node
			// before HTML tag with _wysiwyg_line_start attribute
			// e.g. ' <div _wysiwyg_new_line="true">...' => '\n<div>...'
			else if ( substr($textContent, -1) == ' ' && $this->nextSiblingIsInNextLine($node)) {
				$textContent = substr($textContent, 0, -1);
			}

			$out = $textContent;
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 * Clean up node text content
	 */
	private function cleanupTextContent($node) {
		wfProfileIn(__METHOD__);

		$text = $node->textContent;

		$text = strtr($text, array('<' => '&lt;', '>' => '&gt;'));

		if($text == '') {
			wfProfileOut(__METHOD__);
			return '';
		}

		// is text node the first child of parent node?
		$isFirstChild = $node->isSameNode($node->parentNode->firstChild);

		wfDebug("ReverseParserNew cleanupTextContent for: >>{$text}<<\n");

		// 1. wrap repeating apostrophes using <nowiki>
		$text = preg_replace("/('{2,})/", '<nowiki>$1</nowiki>', $text);

		// 2. wrap = using <nowiki>
		$text = preg_replace("/^(=+)/m", '<nowiki>$1</nowiki>', $text);

		// 3. wrap wikimarkup special characters (only when they're at the beginning of the p/td, don't do it for link descriptions...)
		if ( $isFirstChild && !in_array($node->parentNode->nodeName, array('a')) ) {
			// 3a. wrap list bullets using <nowiki>
			$text = preg_replace("/^([#*]+)/", '<nowiki>$1</nowiki>', $text);

			// 3b. semicolon at the beginning of the line
			if(in_array($text{0}, array(':', ';'))) {
				$text = '<nowiki>' . $text{0} . '</nowiki>' . substr($text, 1);
			}
		}

		// 4. wrap curly brackets {{ }} using <nowiki>
		$text = preg_replace("/({{2,3})([^}]+)(}{2,3})/", '<nowiki>$1$2$3</nowiki>', $text);

		// 5. wrap magic words __ __ using <nowiki>
		$text = preg_replace("/__([\d\D]+)__/", '<nowiki>__$1__</nowiki>', $text);

		// 6. wrap [[foo]] using <nowiki>
		$text = preg_replace("/(\[{2,})([^]]+)(\]{2,})/", '<nowiki>$1$2$3</nowiki>', $text);

		// 7. wrap [<url protocol>...] using <nowiki> (don't apply to link descriptions)
		if ($node->parentNode->nodeName != 'a') {
			$text = preg_replace("/\[(?=".$this->getUrlProtocols().")([^\]]+)\]/", '<nowiki>[$1]</nowiki>', $text);
		}

		// 8. wrap repeating ~ using <nowiki>
		$text = preg_replace("/(~{3,5})/", '<nowiki>$1</nowiki>', $text);

		wfProfileOut(__METHOD__);
		return $text;
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

				// [[foo|{{bar}}]]
				case 'internal link: placeholder':
					return $refData['original'];

				// [[en:foo]]
				case 'interwiki':
					return $refData['originalCall'];

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
					$prefix = !empty($refData['whiteSpacePrefix']) ? $refData['whiteSpacePrefix'] : '';
					return "{$prefix}{$refData['original']}";

				// parser hooks
				case 'hook':
					return $refData['description'];

				// wikitext placeholders
				// used for non-existing video
				case 'placeholder':
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

				// WikiaVideo
				case 'video':
					return $refData['original'];

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
				// generate new refid
				$refid = !empty($this->data) ? (max( array_keys($this->data) ) + 1) : 0;

				$this->data[$refid] = array(
					'type' => ($content == $href) ? 'external link: raw' : 'external link',
					'text' => $content,
					'href' => $href
				);
			}
		}

		$data = $this->data[$refid];

		switch($data['type']) {
			case 'image';
				return $this->handleMedia($node, $content);

			case 'internal link':
			case 'internal link: file':
			case 'internal link: special page':

				// leave already existing link which hasn't been edited
				// as for feedback from Tor
				// don't try to make everyone happy :)
				if ( isset($data['description']) && ($data['description'] != $content) ) {
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
				}
				else if (!isset($data['description'])) {
					$data['description'] = $content;
				}

				// generate wikisyntax
				$tag =  "[[{$data['href']}";

				if ($data['description'] != '') {
					$tag .=  "|{$data['description']}]]";
				} else {
					$tag .=  "]]";
				}
				if ( isset($data['trial']) && ($data['trial'] != '') ) {
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
	 * Returns wikimarkup for image/video tags
	 */
	private function handleMedia($node, $content) {

		// check is perfomed earlier
		$data = $this->data[ $node->getAttribute('refid') ];

		switch($data['type']) {
			case 'image':
			case 'video':
				$out = $data['original'];
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
				if( $node->hasChildNodes() && in_array($node->firstChild->nodeName, array('ul', 'ol')) ) {
					// nested lists like
					// *** foo
					// *** bar
					return $content . "\n";
				} else {
					// remove last char only (if space) from list items containing only text
					// so without nested lists
					if (substr($content, -1) == ' ') {
						$content = substr($content, 0, -1);
					}

					return $this->listIndent . $this->listBullets . $content . "\n";
				}
			break;
		}
	}

	/**
	 * Returns previous node element ignoring any text/comment elements
	 */
	private function getPreviousElementNode($node) {
		while($node->previousSibling) {
			$node = $node->previousSibling;
			if($node->nodeType == XML_ELEMENT_NODE) {
				return $node;
			}
		}
		return false;
	}

	/**
	 * Returns next node element ignoring any text/comment elements
	 */
	private function getNextElementNode($node) {
		while($node->nextSibling) {
			$node = $node->nextSibling;
			if($node->nodeType == XML_ELEMENT_NODE) {
				return $node;
			}
		}
		return false;
	}

	/**
	 * Returns previous text element ignoring any node/comment elements
	 */
	private function getPreviousTextNode($node) {
		while($node->previousSibling) {
			$node = $node->previousSibling;
			if($node->nodeType == XML_TEXT_NODE) {
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

		if($node->getAttribute('_wysiwyg_new_line') && !in_array($node->nodeName, array('a')) )  {
			return true;
		}

		return false;
	}

	/*
	 * Detect whether given node starts line of wikitext and perfrom extra check
	 */
	private function nodeHasLineStart($node) {

		if (empty($node->previousSibling) && ($node->parentNode->nodeName == 'body')) {
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

		// <ul> / <ol> should always have _wysiwyg_line_start attribute
		// lists added in FCK won't have it -> force return of TRUE
		if ($this->isList($node) && !$node->getAttribute('washtml')) {
			return true;
		}

		// they start new line, but we don't have to add new line before them
		if ($node->nodeName == 'p') {
			return false;
		}

		// add \n before <pre>
		if ($node->nodeName == 'pre') {
			return true;
		}

		// HTML tags (e.g. image containers, ignore inline tags)
		if ($node->getAttribute('_wysiwyg_line_start') && !in_array($node->nodeName, array('a')) ) {
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

	/**
	 * Return true if given node is header
	 */
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

		// replace style attribute with _wysiwyg_style
		if ($node->hasAttribute('_wysiwyg_style')) {
			$node->setAttribute('style', $node->getAttribute('_wysiwyg_style'));
			$node->removeAttribute('_wysiwyg_style');
		}

		$attStr = '';
		foreach ($node->attributes as $attrName => $attrNode) {
			// ignore attributes used internally by Wysiwyg
			if( in_array($attrName, array('washtml', '_wysiwyg_new_line', '_wysiwyg_line_start', '_wysiwyg_new')) ) {
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
		while (!empty($node->parentNode)) {
			$cssStyle = $node->getAttribute('style');

			if(!empty($cssStyle)) {
				$margin = (substr($cssStyle, 0, 11) == 'margin-left') ? intval(substr($cssStyle, 12)) : 0;
				return intval($margin/40);
			}

			$node = $node->parentNode;
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
