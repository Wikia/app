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
class ReverseParserDOM {

	// DOM for HTML parsing
	private $htmlDOM;

	// DOM for wikimarkup
	private $wikiDOM;

	function __construct() {
		$this->htmlDOM = new DOMdocument();
	}

	public function preparse($html) {
		wfProfileIn(__METHOD__);

		$result = '';

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

			wfDebug("ReverseParserDOM HTML: {$html}\n");

			wfSuppressWarnings();
			if($this->htmlDOM->loadHTML($html)) {
				// create DOM for wikimarkup
				$this->wikiDOM = new DOMDocument();
				$this->wikiDOM->formatOutput = true; 
				$root = $this->wikiDOM->createElement('wikimarkup');
				
				$this->wikiDOM->appendChild($root);

				$body = $this->htmlDOM->getElementsByTagName('body')->item(0);
				wfDebug("ReverseParserDOM HTML from DOM: ".$this->htmlDOM->saveHTML()."\n");

				// recursively preparse HTML
				$this->preparseNode($body, &$root, 0);

				// dump wikimarkup XML
				$result = $this->wikiDOM->saveXML();
				wfDebug("ReverseParserDOM wikiDOM: ".$result."\n");
 
			}
			wfRestoreWarnings();
		}

		wfProfileOut(__METHOD__);
		return $result;
	}

	private function preparseNode($htmlNode, $wikiParentNode, $level = 0) {
		wfProfileIn(__METHOD__);

		// create new wikiNode and fill it
		$wikiNode = $this->wikiDOM->createElement('node');

		if($htmlNode->nodeType == XML_ELEMENT_NODE) {
			// get node attributes
			$refId = $htmlNode->getAttribute('refid');
			$hasRefId = is_numeric($refId);
			$wasHTML = $htmlNode->getAttribute('washtml') == 1;

			$wikiNode->setAttribute('name', $htmlNode->nodeName);

			// 1. element with refId - link, template, parser hook...	
			if ($hasRefId) {
				$wikiNode->setAttribute('refid', $refId);
			}
			// 2. element with wasHTML - <div>, <tt>, <code>, ...
			else if ($wasHTML) {
				$wikiNode->setAttribute('washtml', 1);

				// opening / closing tag
				switch ($htmlNode->nodeName) {
					case 'br':
					case 'hr':
						$wikiNode->setAttribute('open', "<{$htmlNode->nodeName} />");
						break;

					default:
						$wikiNode->setAttribute('open', "<{$htmlNode->nodeName}>");
						$wikiNode->setAttribute('close', "</{$htmlNode->nodeName}>");
				}
				
				$wikiNode->setAttribute('attr', $this->getAttributesStr($htmlNode));
			}
		}
		else if ($htmlNode->textContent != '' && $htmlNode->parentNode->nodeName != 'body')  {
			$wikiNode->setAttribute('text', 1);
			$wikiNode->appendChild( new DOMText($htmlNode->textContent) );
		}
		else {
			$wikiNode = false;
		}


		if ($wikiNode) {
			// add new node
			$wikiParentNode->appendChild($wikiNode);

			// parse child nodes
			if ($htmlNode->hasChildNodes()) {
				$nodes = $htmlNode->childNodes;

				// parse child nodes
				if ( ($nodes->length == 1) && ($htmlNode->firstChild->nodeType == XML_TEXT_NODE) ) {
					// node contains only text
					$wikiNode->appendChild(new DOMText($htmlNode->textContent));
				}
				else {
					$nodes = $htmlNode->childNodes;
					$level++;

					for($n=0; $n<$nodes->length; $n++) {
						 $this->preparseNode($nodes->item($n), &$wikiNode, $level);
					}
				}
			}
		}

		wfProfileOut(__METHOD__);
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

}
