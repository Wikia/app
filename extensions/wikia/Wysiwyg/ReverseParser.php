<?php
/**
 * PHP Reverse Parser - Processes given HTML into DOM tree and
 * transform it into wikimarkup
 *
 * @author Maciej 'macbre' Brencz <macbre(at)wikia-inc.com>
 * @author Inez Korczynski <inez(at)wikia-inc.com>
 *
 * @see http://meta.wikimedia.org/wiki/Help:Editing
 */
class ReverseParser {

	private $dom;

	// FCK meta data
	private $fckData = array();

	// used by nested lists parser
	private $listLevel = 0;

	// bullets stack for nested lists
	private $listBullets = '';

	// cache results of wfUrlProtocols()
	private $protocols;

	function __construct() {
		$this->dom = new DOMdocument();
		$this->protocols = wfUrlProtocols();
	}

	public function parse($html, $wysiwygData = array()) {
		wfProfileIn(__METHOD__);

		$out = '';

		if(is_string($html) && $html != '') {
			$replacements = array(
				// remove whitespace and decode &nbsp;
				' <p>' => '<p>',
				'<br /> ' => '<br />',
				'&nbsp;' => ' ',
				' <ol' => '<ol',
				' <ul' => '<ul',
				' <li' => '<li',
				' <dl' => '<dl',
				' </dd>' => '</dd>',
				' </dt>' => '</dt>',
				' <pre>' => '<pre>',
				' <h'    => '<h',
			);

			$html = strtr($html, $replacements);

			// fix for proper encoding of UTF characters
			$html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>'.$html.'</body></html>';

			$this->listLevel = 0;
			$this->listBullets = '';
			$this->fckData = $wysiwygData;

			wfDebug("ReverseParser HTML: {$html}\n");

			wfSuppressWarnings();
			if($this->dom->loadHTML($html)) {
				$body = $this->dom->getElementsByTagName('body')->item(0);
				wfDebug("ReverseParser HTML from DOM: ".$this->dom->saveHTML()."\n");
				$out = $this->parseNode($body);
			}
			wfRestoreWarnings();

			// final cleanup
			$out = rtrim($out);

			if (strlen($out) > 1 && $out{0} == "\n" && $out{1} != "\n") {
				// remove ONE empty line from the beginning of wikitext
				$out = substr($out, 1);
			}

			wfDebug("ReverseParser wikitext: {$out}\n");

		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	private function parseNode($node, $level = 0) {
		wfProfileIn(__METHOD__);

		$childOut = '';

		if($node->hasChildNodes()) {

			$nodes = $node->childNodes;

			// handle lists
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

			for($i = 0; $i < $nodes->length; $i++) {
				$childOut .= $this->parseNode($nodes->item($i), $level+1);
			}

			// handle lists
			if($isListNode) {
				// fix for different list types on the same level of nesting
				if($node->previousSibling && in_array($node->previousSibling->nodeName, array('ol', 'ul', 'dl')) && $this->listLevel > 1) {
					$childOutput = "\n" . trim($childOutput);
				} else {
					$childOutput = trim($childOutput);
				}

				if (!$node->getAttribute('washtml')) {
					$this->listLevel--;
					$this->listBullets = substr($this->listBullets, 0, -1);
				}
			}
		}

		if($node->nodeType == XML_ELEMENT_NODE) {

			wfDebug("ReverseParser XML_ELEMENT_NODE " . str_repeat('-', $level) . " {$node->nodeName}\n");

			$washtml = $node->getAttribute('washtml');

			$textContent = ($childOut != '') ? $childOut : $this->cleanupTextContent($node);

			if(empty($washtml)) {
				
				$refid = $node->getAttribute('refid');
				$hasRefId = (is_numeric($refid) || isset($this->fckData[$refid]));

				switch($node->nodeName) {
					case 'body':
						$out = $textContent;
						break;

					case 'br':
						// <br /> as first child of <p> will be parsed as line break
						if($node->parentNode->nodeName == 'p' && $node->parentNode->hasChildNodes() && $node->parentNode->childNodes->item(0)->isSameNode($node)) {
							$out = "\n";
						}
						// remove <br /> when it's the last child of parent being inline element
						else if ($this->isFormattingElement($node->parentNode) && $node->isSameNode($node->parentNode->lastChild) ) {
							$out = '';
						}
						// render <br /> only when it's inside block element
						else if ($node->parentNode->nodeName != 'body') {
							$out = '<br />';
						}

						break;

					case 'p':
						if($textContent{0} == ' ') {
							$textContent = '<nowiki> </nowiki>' . substr($textContent, 1);
						}

						$out = $textContent;

						// handle indentations
						$indentation = $this->getIndentationLevel($node);
						if ($indentation !== false) {
							$out = str_repeat(':', $indentation) . $out;
						}

						// new line logic
						if($node->previousSibling && $node->previousSibling->nodeName == 'p') {
							// paragraph after paragraph
							$out = "\n\n{$out}";
						} else {
							$out = "\n{$out}";
						}
						break;

					// horizontal line
					case 'hr':
						if ($node->previousSibling || ($node->parentNode && $this->isTableCell($node->parentNode))) {
							$out = "\n----";
						}
						else {
							$out = "----";
						}
						break;

					// headings
					case 'h1':
					case 'h2':
					case 'h3':
					case 'h4':
					case 'h5':
					case 'h6':
						$out = '';

						// ignore 'empty' headers
						if ( trim($textContent) == '' ) {
							$out = "\n";
							break;
						}

						// ignore headers inside lists
						if (in_array($node->parentNode->nodeName, array('li', 'dt', 'dd'))) {
							$out = $textContent;
							break;
						}

						// remove <br /> when it's the first child of header tag
						// and add empty line before paragraph
						if ($node->firstChild->nodeType == XML_ELEMENT_NODE && $node->firstChild->nodeName == 'br') {
							$textContent = substr($textContent, strpos($textContent, '/>')+2); // remove <br /> tag
							$out = "\n\n";
						}

						$head = str_repeat("=", $node->nodeName{1});
						$out .= "{$head} {$textContent} {$head}";

						// new line logic
						if ($node->previousSibling || ($node->parentNode && $this->isTableCell($node->parentNode))) {
							$out = "\n{$out}";
						}

						// fix for "external HTML" pasted into FCK
						if ($node->nextSibling && $node->nextSibling->nodeName != 'p' && !$this->isHeader($node->nextSibling)) {
							$out = "{$out}\n";
						}
						break;

					// preformatted text
					case 'pre':
						$textContent = trim(str_replace("\n", "\n ", $textContent)); // add white space before each line
						$out = " {$textContent}";

						// new line logic
						if ($node->previousSibling) {
							// separate <pre> tags
							$out = ($node->previousSibling->nodeName == 'pre') ? "\n\n{$out}" : "\n{$out}";
						}
						else if ($node->parentNode && $this->isTableCell($node->parentNode)) {
							$out = "\n{$out}";
						}

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
						if ($node->parentNode && $node->parentNode->previousSibling &&
							$node->isSameNode($node->parentNode->firstChild) &&
							in_array($node->parentNode->nodeName, array('i','b')) &&
							$node->parentNode->nodeName != $node->nodeName &&
							$node->parentNode->previousSibling->nodeName == $node->nodeName) {
							// don't open bold (1) / italic (2)
							wfDebug("ReverseParser: </b><i><b> open\n");
							$open = '';
						}

						// 3, 4
						if ($node->previousSibling && $node->previousSibling->hasChildNodes() &&
							in_array($node->previousSibling->nodeName, array('i','b')) &&
							$node->previousSibling->nodeName != $nodeName &&
							$node->previousSibling->lastChild->nodeName == $node->nodeName) {
							// don't open bold (3) / italic (4)
							wfDebug("ReverseParser: </b></i><b> open\n");
							$open = '';
						}

						// B) closing tags
						// 1, 2
						if ($node->nextSibling && $node->nextSibling->hasChildNodes() &&
							in_array($node->nextSibling->nodeName, array('i','b')) &&
							$node->nextSibling->nodeName != $node->nodeName &&
							$node->nextSibling->firstChild->nodeName == $node->nodeName) {
							// don't close bold (1) / italic (2)
							wfDebug("ReverseParser: </b><i><b> close\n");
							$close = '';
						}

						// 3, 4
						if ($node->parentNode && $node->parentNode->nextSibling &&
							$node->isSameNode($node->parentNode->lastChild) &&
							in_array($node->parentNode->nodeName, array('i','b')) &&
							$node->parentNode->nodeName != $node->nodeName &&
							$node->parentNode->nextSibling->nodeName == $node->nodeName) {
							// don't close bold (3) / italic (4)
							wfDebug("ReverseParser: </i></b><i> close\n");
							$close = '';
						}
						$out = "{$open}{$textContent}{$close}";

						wfDebug("ReverseParser: $out\n");
						break;
					// tables
					case 'table':
						if (!$hasRefId) {
							// @see http://en.wikipedia.org/wiki/Help:Table
							$attStr = ltrim($this->getAttributesStr($node));
							$out = "{|{$attStr}\n{$textContent}|}\n";

							// there's something before the table or this is nested table - add line break
							if ($node->previousSibling || ($node->parentNode && $this->isBlockElement($node->parentNode))) {
								$out = "\n{$out}";
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
							$out = $textContent;
						}
						else {
							$out = "|-{$attStr}\n{$textContent}";
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
					case 'dl':
						$prefix = $suffix = '';
						// handle indentations created using definition lists
						if($node->nodeName == 'dl') {
							$indentation = $this->getIndentationLevel($node);
							if($indentation !== false) {
								$prefix = str_repeat(':', $indentation);
							}
							// paragraph is following this <dl> list
							if($node->nextSibling && $node->nextSibling->nodeName == 'p') {
								$suffix = ($node->nextSibling->textContent != '') ? "\n" : "\n\n";
							}
						}
						if($node->previousSibling) {
							// first item of nested list
							$prefix = "\n{$prefix}";

							// add space after previous list, so we won't break numbers
							if ($this->listLevel == 0 && $this->isList($node->previousSibling)) {
								$prefix = "\n{$prefix}";
							}
						}
						// lists inside table cell
						else if ($node->parentNode && $this->isTableCell($node->parentNode)) {
							$prefix = "\n{$prefix}";
						}
						// rtrim used to remove \n added by the last list item
						$out = $prefix . rtrim($textContent, " \n") . $suffix;
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
						if ($hasRefId) {
							$out = $this->handleImage($node, $textContent);
						}
						break;

					// handle more complicated tags
					case 'a':
						$out = $this->handleLink($node, $textContent);
						break;
					case 'input':
						$out = $this->handlePlaceholder($node, $textContent);
						break;

					// ignore tbody tag
					case 'tbody':
						$out = $textContent;
						break;

					// HTML tags
					default:
						$washtml = true;
						break;
				}
			}

			if(!empty($washtml)) {

				$attStr = $this->getAttributesStr($node);

				switch ($node->nodeName) {
					case 'br':
					case 'hr':
						$out = "<{$node->nodeName}{$attStr} />";
						break;

					default:
						// remove prohibited HTML tags
						if ( in_array($node->nodeName, array('script', 'embed')) ) {
							$out = '';
							break;
						}

						// nice formatting of nested HTML in wikimarkup
						if($node->hasChildNodes() && $node->childNodes->item(0)->nodeType != XML_TEXT_NODE) {
							// node with child nodes
							// add \n only when node is HTML block element
							if ($this->isInlineElement($node)) {
								$textContent = $textContent;
								$trial = '';
								$prefix = '';
							}
							else {
								$textContent = "\n".trim($textContent)."\n";
								$trial = '';
								$prefix = "\n";
							}
						} else {
							$trial = $this->isInlineElement($node) ? '' : "\n";
							$prefix = '';
						}
						$out = "{$prefix}<{$node->nodeName}{$attStr}>{$textContent}</{$node->nodeName}>{$trial}";
				}
			}

		} else if($node->nodeType == XML_TEXT_NODE) {

			wfDebug("ReverseParser XML_TEXT_NODE    " . str_repeat('-', $level) . " #text\n");

			if ( trim($node->textContent) == '' && $node->parentNode && !$this->isInlineElement($node->parentNode) ) {
				// get rid of whitespaces between tags we don't need
				$out = '';
			}
			else {
				$out = $this->cleanupTextContent($node);
			}

		}

		wfProfileOut(__METHOD__);
		return $out;
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

			case 'dt':
				return substr($this->listBullets, 0, -1) . ";{$node->textContent}\n";

			case 'dd':
				// hack for :::::foo markup used for indentation
				// <dl><dl>...</dl></dl> (produced by MW markup) would generate wikimarkup like the one below:
				// :
				// ::
				// ::: ...
				if($node->hasChildNodes() && $node->childNodes->item(0)->nodeName == 'dl') {
					return rtrim($content, ' ') . "\n";
				} else if ($this->hasListInside($node)) {
					return $content . "\n";
				} else {
					return $this->listBullets . $content . "\n";
				}
		}
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

		wfDebug("WYSIWYG ReverseParser cleanupTextContent for: >>{$text}<<\n");

		// 1. wrap repeating apostrophes using <nowiki>
		$text = preg_replace("/('{2,})/", '<nowiki>$1</nowiki>', $text);

		// 2. wrap = using <nowiki>
		$text = preg_replace("/^(=+)/m", '<nowiki>$1</nowiki>', $text);

		// 3. wrap wikimarkup special characters (only when they're at the beginning of the p/td...)
		if ($isFirstChild) {
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
			$text = preg_replace("/\[(?={$this->protocols})([^\]]+)\]/", '<nowiki>[$1]</nowiki>', $text);
		}

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
		$refId = $node->getAttribute('refid');

		if ( is_numeric($refId) && isset($this->fckData[$refId]) ) {
			$refData = (array) $this->fckData[$refId];

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

				// [[Category:foo]]
				case 'category':
					$pipe = ($refData['description'] != '') ? '|'.$refData['description'] : '';
					return "\n[[{$refData['href']}{$pipe}]]{$refData['trial']}";

				// parser hooks
				case 'hook':
					return $refData['description'];

				// {{template}}
				//case 'curly brackets':
				case 'template':
					if(!empty($refData['lineStart'])) {
						if(!$node->isSameNode($node->parentNode->firstChild)) {
							return "\n".$refData['originalCall'];
						}
					}
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
					return $this->handleLink($node, $content);

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

		if (!is_numeric($refid) || !isset($this->fckData[$refid])) {
			$href = $node->getAttribute('href');

			if( is_string($href) ) {
				// generate new refid
				$refid = count($this->fckData);

				$this->fckData[$refid] = array(
					'type' => ($content == $href) ? 'external link: raw' : 'external link',
					'text' => $content,
					'href' => $href
				);
			}
		}


		$data = $this->fckData[$refid];

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
				if (preg_match('%^(?:' . $this->protocols . ')%im', $data['href'])) {
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
		$data = $this->fckData[$node->getAttribute('refid')  ];

		switch($data['type']) {
			case 'image':
				$prefix = ( in_array($node->nodeName, array('div', 'table')) ) ? "\n\n" : '';
				$out = $prefix . '[[' . $data['href'] . ($data['description'] != '' ? "|{$data['description']}]]" : ']]');
				return $out;

			default:
				return '';
		}
	}	

	/**
	 * Returns HTML string containing node arguments
	 */
	 private function getAttributesStr($node) {
		if(!$node->hasAttributes()) {
			return '';
		}

		$attStr = '';

		foreach ($node->attributes as $attrName => $attrNode) {
			if ($attrName == 'washtml') {
				continue;
			}
			$attStr .= ' ' . $attrName . '="' . $attrNode->nodeValue  . '"';
		}
		return $attStr;
	 }

	/**
	 * Return true if given node is inline formatting element (used for removal of unneeded <br/> tags)
	 */

	private function isFormattingElement($node) {
		return in_array($node->nodeName, array('u', 'b', 'strong', 'i', 'em', 'strike', 's', 'code', 'tt', 'cite', 'var', 'span', 'font'));
	}

	/**
	 * Return true if given node is inline HTNL element or can contain inline elements (p / div) - used for nice HTML formatting
	 */
	private function isInlineElement($node) {
		return in_array($node->nodeName, array('u', 'b', 'strong', 'i', 'em', 'strike', 's', 'code', 'tt', 'cite', 'var', 'span', 'font', 'a', 'p', 'div'));
	}

	/**
	 * Return true if given node is block HTML element (used for handling nested tables)
	 */
	private function isBlockElement($node) {
		return in_array($node->nodeName, array('p', 'div', 'tr', 'td' ,'th', 'table'));
	}

	/**
	 * Return true if given node is table cell (td/th) - used to add newline before certain wikimarkup when is table cell
	 */
	private function isTableCell($node) {
		return in_array($node->nodeName, array('td', 'th', 'caption'));
	}

	/**
	 * Return true if given node is heading node
	*/
	private function isHeader($node) {
		return (strlen($node->nodeName) == 2) && ($node->nodeName{0} == 'h') && is_numeric($node->nodeName{1});
	}

	/**
	 * Return true if given node is list container
	 */
	private function isList($node) {
		return in_array($node->nodeName, array('ol', 'ul', 'dl'));
	}

	/**
	 * Return true if given node has list element as one of his nested child
	 */
	private function hasListInside($node, $lists) {
		while($node->hasChildNodes()) {
			$node = $node->firstChild;
			if ( in_array($node->nodeName, array('ol', 'ul')) ) {
				return true;
			}
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
