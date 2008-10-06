<?php
/**
 * PHP Reverse Parser - Processes html and provides a one-way
 * transformation into wikimarkup
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

	function __construct() {
		$this->dom = new DOMdocument();
	}

	public function parse($html, $wysiwygData = array()) {
		wfProfileIn(__METHOD__);

		$out = '';

		if(is_string($html) && $html != '') {
			$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

			// remove whitespace after <br /> and decode &nbsp;
			$replacements = array(
				'<br /> ' => '<br />',
				'&nbsp;' => ' ',
				' <ol' => '<ol',
				' <ul' => '<ul',
				' <li' => '<li',
				' <pre>' => '<pre>'
			);

			$html = str_replace(array_keys($replacements), array_values($replacements), $html);

			$this->listLevel = 0;
			$this->listBullets = '';
			$this->fckData = $wysiwygData;

			wfDebug("ReverseParser HTML: {$html}\n");

			wfSuppressWarnings();
			if($this->dom->loadHTML($html)) {

				$body = $this->dom->getElementsByTagName('body')->item(0);
				$out = $this->parseNode($body);

			}
			wfRestoreWarnings();

			// final cleanup
			$out = rtrim($out);

			if ($out{0} == "\n" && $out{1} != "\n") {
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

			$textContent = ($childOut != '') ? $childOut : $this->cleanupTextContent($node->textContent);

			if(empty($washtml)) {
				switch($node->nodeName) {
					case 'body':
						$out = $textContent;
						break;

					case 'br':
						// <br /> as first child of <p> will be parsed as line break
						if($node->parentNode && $node->parentNode->nodeName == 'p' && $node->parentNode->hasChildNodes() && $node->parentNode->childNodes->item(0)->isSameNode($node)) {
							$out = "\n";
						} else {
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
						$head = str_repeat("=", $node->nodeName{1});
						$out = "{$head} {$textContent} {$head}";

						// new line logic
						if ($node->previousSibling || ($node->parentNode && $this->isTableCell($node->parentNode))) {
							$out = "\n{$out}";
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
					case 'i':
					case 'em':
						if(substr($textContent, -1) == "'" || substr($textContent, 0, 1) == "'" || substr($node->previousSibling->textContent, -1) == "'" || substr($node->nextSibling->textContent, 0, 1) == "'" || in_array($node->parentNode->nodeName, array('b', 'strong'))) {
							$open = '<em>';
							$close = '</em>';
						} else {
							$open = $close = "''";
						}

						$out = "{$open}{$textContent}{$close}";
						break;

					case 'b':
					case 'strong':
						if(substr($textContent, -1) == "'" || substr($textContent, 0, 1) == "'" || substr($node->previousSibling->textContent, -1) == "'" || substr($node->nextSibling->textContent, 0, 1) == "'" || in_array($node->parentNode->nodeName, array('i', 'em'))) {
							$open = '<strong>';
							$close = '</strong>';
						} else {
							$open = $close = "'''";
						}

						$out = "{$open}{$textContent}{$close}";
						break;

					// tables
					// @see http://en.wikipedia.org/wiki/Help:Table
					case 'table':
						$attStr = ltrim($this->getAttributesStr($node));
						$out = "{|{$attStr}\n{$textContent}|}\n";

						// there's something before the table or this is nested table - add line break
						if ($node->previousSibling || ($node->parentNode && $this->isTableCell($node->parentNode))) {
							$out = "\n{$out}";
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
						$attStr = ltrim($this->getAttributesStr($node));
						$out = "|-{$attStr}\n{$textContent}";
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
					case 'img':
					case 'div': // [[Image:foo.jpg|thumb]]
						$out = $this->handleImage($node, $textContent);
						break;

					// handle more complicated tags
					case 'a':
						$out = $this->handleLink($node, $textContent);
						break;
					case 'span':
					case 'input':
						$out = $this->handleSpan($node, $textContent);
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
						// nice formatting of nested HTML in wikimarkup
						if($node->hasChildNodes() && $node->childNodes->item(0)->nodeType != XML_TEXT_NODE) {
							// node with child nodes
							// add \n only when node is HTML block element
							if ($this->isInlineElement($node) && !in_array($node->nodeName, array('p', 'div'))) {
								$textContent = trim($textContent);
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
				$out = $this->cleanupTextContent($node->textContent);
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
	private function cleanupTextContent($text) {
		wfProfileIn(__METHOD__);

		if($text == '') {
			wfProfileOut(__METHOD__);
			return '';
		}

		wfDebug("WYSIWYG ReverseParser cleanupTextContent for: {$text}\n");

		// 1. wrap repeating apostrophes using <nowiki>
		$text = preg_replace("/('{2,})/", '<nowiki>$1</nowiki>', $text);

		// 2. wrap = using <nowiki>
		$text = preg_replace("/^(=+)/m", '<nowiki>$1</nowiki>', $text);

		// 3. wrap list bullets using <nowiki>
		$text = preg_replace("/^([#*]+)/", '<nowiki>$1</nowiki>', $text);

		// 4. semicolon at the beginning of the line
		if(in_array($text{0}, array(':', ';'))) {
			$text = '<nowiki>' . $text{0} . '</nowiki>' . substr($text, 1);
		}

		// 5. wrap magic words {{ }} using <nowiki>
		$text = preg_replace("/({{2,3})([^}]+)(}{2,3})/", '<nowiki>$1$2$3</nowiki>', $text);

		// 6. wrap [[foo]] using <nowiki>
		$text = preg_replace("/(\[{2,})([^]]+)(\]{2,})/", '<nowiki>$1$2$3</nowiki>', $text);

		// 7. wrap [<url protocol>...] using <nowiki>
		$protocols = wfUrlProtocols();
		$text = preg_replace("/\[(?=$protocols)([^\]]+)\]/", '<nowiki>[$1]</nowiki>', $text);

		wfProfileOut(__METHOD__);
		return $text;
	}


	/**
	 * Returns wikimarkup for <span> tag
	 *
	 * Span is used to wrap various elements like templates etc.
	 */
	private function handleSpan($node, $content) {

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
				case 'curly brackets':
					return $refData['description'];

				// __TOC__
				case 'double underscore':
					return $refData['description'];

				// <gallery> parser hook tag
				case 'gallery':
					return $refData['description'];
			}
		}

		return '<!-- unsupported span tag! -->';
	}

	/**
	 * Returns wikimarkup for <a> tag
	 */
	private function handleLink($node, $content) {

		$refid = $node->getAttribute('refid'); // handle links with refId attribute

		if(is_numeric($refid) && isset($this->fckData[$refid])) {

			// existing link

			$data = $this->fckData[$refid];

			if(!empty($data['href_new'])) {

				// link edited in FCK

				if(preg_match('%^(?:' . wfUrlProtocols() . ')%im', $data['href_new'])) {
					if($data['type'] != 'external link') {
						$data['type'] = 'external link: raw';
					}
				} else {
					$data['type'] = 'internal link';
				}
				$data['href'] = $data['href_new'];
			}

			switch($data['type']) {
				case 'internal link':
				case 'internal link: file':
					$tag =  "[[{$data['href']}";

					if($content != $data['href'] . $data['trial'] && $content != $data['description'] . $data['trial']) {
						$data['description'] = $content;
						$data['trial'] = null;
					}

					if(!empty($data['description'])) {
						$tag .=  "|{$data['description']}]]";
					} else {
						$tag .=  "]]";
					}
					if(!empty($data['trial'])) {
						$tag .= $data['trial'];
					}
					return $tag;
				case 'external link':
					if($content == '[link]') {
						return "[{$data['href']}]";
					} else {
						return "[{$data['href']} {$content}]";
					}
				case 'external link: raw':
					if($content == $data['href']) {
						return $data['href'];
					} else {
						return "[{$data['href']} {$content}]";
					}
			}

		} else {

			// new link (added in FCK)

			$href = $node->getAttribute('href');
			if(preg_match('%^(?:' . wfUrlProtocols() . ')%im', $href)) {
				// external
				if($href == $content) {
					return $href;
				} else if($content == '[link]') {
					return "[{$href}]";
				} else {
					return "[{$href} {$content}]";
				}
			} else {
				//internal
				if($href == $content) {
					$tag = "[[{$href}]]";
				} else if(strpos($content, $href) === 0) {
					$tag = "[[{$href}]]".substr($content, strlen($href));
				} else {
					$tag = "[[{$href}|{$content}]]";
				}
				if(substr(strtolower($tag), 0, 8) == '[[image:' || substr(strtolower($tag), 0, 8) == '[[media:' || substr(strtolower($tag), 0, 11) == '[[category:') {
					$tag = '[[:' . substr($tag, 2);
				}
				return $tag;
			}

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
	 * Return true if given node is inline HTNL element or can contain inline elements (p / div)
	 */
	private function isInlineElement($node) {
		return in_array($node->nodeName, array('u', 'b', 'strong', 'i', 'em', 'strike', 's', 'a', 'p', 'div'));
	}

	/**
	 * Return true if given node is table cell (td/th)
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
}
