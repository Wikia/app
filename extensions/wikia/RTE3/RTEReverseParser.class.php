<?php

class RTEReverseParser {

	/**
	 * data-rte-* constant's
	 */
	const DATA_RTE_ENTITY = 'data-rte-entity';
	const DATA_RTE_LINE_START = 'data-rte-line-start';
	const DATA_RTE_NEW_NODE = 'data-rte-new-node';
	const DATA_RTE_NEW_MODE = 'data-rte-new-mode';
	const DATA_RTE_FILTER = 'data-rte-filler';
	const DATA_RTE_ATTRIBS = 'data-rte-attribs';
	const DATA_RTE_STYLE = 'data-rte-style';
	const DATA_RTE_SHIFT_ENTER = 'data-rte-shift-enter';
	const DATA_RTE_SHORT_ROW_MARKUP = 'data-rte-short-row-markup';
	const DATA_RTE_SPACES_AFTER_LAST_CELL = 'data-rte-spaces-after-last-cell';
	const DATA_RTE_FROMPARSER = 'data-rte-fromparser';
	const DATA_RTE_WASHTML = 'data-rte-washtml';
	const DATA_RTE_EMPTY_LINES_BEFORE = 'data-rte-empty-lines-before';
	const DATA_RTE_META = 'data-rte-meta';
	const DATA_RTE_SPACES_AFTER = 'data-rte-spaces-after';
	const DATA_RTE_SPACES_BEFORE = 'data-rte-spaces-before';

	// DOMdocument used to process HTML
	private $dom;

	// lists handling
	private $listLevel;
	private $listBullets;

	/**
	 * Stores all nodes iteratively so we can associate indices to nodes, and indices to outputs
	 * @var array
	 */
	private $nodes = array();

	/**
	 * Stores the output for each node, at any level, so we can locate it easily
	 * @var array
	 */
	private $nodeOutputs = array();

	// node ID counter
	private $nodeId = 0;

	function __construct() {
		$this->dom = new DOMdocument();

		// enable libxml errors and allow user to fetch error information as needed
		libxml_use_internal_errors(true);
	}

	/**
	 * Converts given HTML into wikitext using extra information stored in meta data
	 */
	public function parse($html, $data = array()) {
		wfProfileIn(__METHOD__);
		$out = '';

		$this->nodeId = 0;

		if(is_string($html) && $html != '') {
			// apply pre-parse HTML fixes
			wfProfileIn(__METHOD__.'::preFixes');

			// fix IE bug with &nbsp; being added add the end of HTML
			$html = str_replace('<p><br data-rte-bogus="true" />&nbsp;</p>', '', $html);

			// fix &nbsp; entity b0rken by CK
			$html = str_replace("\xC2\xA0", '&nbsp;', $html);

			wfProfileOut(__METHOD__.'::preFixes');

			// try to parse fixed HTML as XML
			$bodyNode = $this->parseToDOM($html);

			// in some edge-cases it may fail - then try to parse original HTML as HTML (refs RT #37253)
			if (empty($bodyNode)) {
				RTE::log(__METHOD__, 'parsing as XML failed! Trying HTML parser');
				$bodyNode = $this->parseToDOM($html, false);
			}

			// now we should have properly parsed HTML
			if (!empty($bodyNode)) {
				//RTE::log('XML (as seen by DOM)', $this->dom->saveXML());

				// do recursive reverse parsing
				$out = $this->parseNode($bodyNode);

				// apply post-parse modifications
				wfProfileIn(__METHOD__.'::postFixes');

				// handle HTML entities (&lt; -> <)
				$out = html_entity_decode($out);

				// replace HTML entities markers with entities (\x7f-ENTITY-lt-\x7f -> &lt;)
				$out = preg_replace('%\x7f-ENTITY-(#?[\w\d]+)-\x7f%', '&\1;', $out);

				//RTE::hex(__METHOD__, $html); RTE::hex(__METHOD__, $out);  // debug

				// fix nbsp to be a valid UTF space
				// don't break UTF characters (à - \xC3\xA0 / 誠 - \xE8\xAA / ム - \xE3\x83)
				// don't break hardspace (BugId:68668)
				$out = preg_replace('%(?<=[\x00-\x7F]|^|\xA0)\xA0%', ' ', $out);

				//RTE::hex(__METHOD__, $out); // debug

				// trim trailing whitespaces
				$out = rtrim($out, "\n ");

				// ultimate fix for invalid utf8 characets
				if (function_exists('mb_convert_encoding')) {
					$out = mb_convert_encoding($out, 'UTF-8', 'UTF-8');
				}

				wfProfileOut(__METHOD__.'::postFixes');

				RTE::log('wikitext', $out);
			}
			else {
				RTE::log('HTML parsing failed!');
				$out = '';
			}
		}

		wfProfileOut(__METHOD__);
		return $out;
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
			$html = str_replace('&', '&amp;', $html);

			$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><body>{$html}</body>";

			// try to parse as XML
			if($this->dom->loadXML($xml)) {
				// parsing successful
				$ret = $this->dom->getElementsByTagName('body')->item(0);
			}
			else {
				$this->handleParseErrors(__METHOD__);
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
	 * Handle XML/HTML parsing error errors
	 */
	private function handleParseErrors($method) {
		wfProfileIn(__METHOD__);

		foreach (libxml_get_errors() as $err) {
			RTE::log("{$method} - XML parsing error '". trim($err->message) ."' (line {$err->line}, col {$err->column})");
		}

		libxml_clear_errors();

		wfProfileOut(__METHOD__);
	}

	/**
	 * Recursively parses given DOM node
	 */
	private function parseNode($node, $level = 0) {
		$nodeId = $this->nodeId++;

		wfProfileIn(__METHOD__ );
		wfProfileIn(__METHOD__ . "::{$node->nodeName}");
		//wfProfileIn(__METHOD__ . "::{$node->nodeName}::{$nodeId}");

		RTE::log('node ' . str_repeat('.', $level) . "{$node->nodeName} (#{$nodeId})");

		$childOut = '';

		// parse child nodes
		if($node->hasChildNodes()) {
			$nodes = $node->childNodes;

			// handle lists (update stack)
			if (self::isListNode($node)) {
				$this->handleListOpen($node);
			}

			// recursively parse child nodes
			for($n = 0; $n < $nodes->length; $n++) {
				$childOut .= $this->parseNode($nodes->item($n), $level+1);
			}
		}

		// parse current node
		$out = '';

		$textContent = ($childOut != '') ? $childOut : $node->textContent;

		// handle HTML nodes
		if($node->nodeType == XML_ELEMENT_NODE) {
			$out = $this->handleTag($node, $textContent);
		}
		// handle comments
		else if($node->nodeType == XML_COMMENT_NODE) {
			$out = $this->handleComment($node);
		}
		// handle text
		else if($node->nodeType == XML_TEXT_NODE) {
			$out = $this->handleText($node, $textContent);
		}

		// close lists (update stack)
		if($node->hasChildNodes()) {
			if (self::isListNode($node)) {
				$this->handleListClose($node);
			}
		}

		$this->nodes[] = $node;
		$this->nodeOutputs[] = $out;

		//wfProfileOut(__METHOD__ . "::{$node->nodeName}::{$nodeId}");
		wfProfileOut(__METHOD__ . "::{$node->nodeName}");
		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handles HTML tags
	 */
	private function handleTag($node, $textContent) {
		wfProfileIn(__METHOD__);

		$out = '';

		// handle placeholders
		if (self::isPlaceholder($node)) {
			$out = $this->handlePlaceholder($node, $textContent);

			wfProfileOut(__METHOD__);
			return $out;
		}
		// handle nodes with wasHTML
		// (always handle paragraphs as wikitext)
		else if (self::wasHtml($node) && ($node->nodeName != 'p')) {
			$out = $this->handleHtml($node, $textContent);
		}
		// handle nodes wrapping HTML entities
		else if ($node->hasAttribute(self::DATA_RTE_ENTITY)) {
			$out = $this->handleEntity($node, $textContent);
		}
		// handle other elements
		else switch($node->nodeName) {
			case 'body':
				$out = $textContent;
				break;

			// paragraphs
			case 'p':
				$out = $this->handleParagraph($node, $textContent);
				break;

			// line breaks
			case 'br':
				$out = $this->handleLineBreaks($node);
				break;

			// horizontal lines
			case 'hr':
				$out = $this->handleHorizontalLines($node);
				break;

			// links
			case 'a':
				$out = $this->handleLink($node, $textContent);
				break;

			// bold / italics
			case 'b':
			case 'i':

			// strike/underline
			case 'strike':
			case 'u':

			// indexes
			case 'sub':
			case 'sup':
				$out = $this->handleFormatting($node, $textContent);
				break;

			// preformatted text
			case 'pre':
				$out = $this->handlePre($node, $textContent);
				break;

			// lists ...
			case 'ul':
			case 'ol':
			case 'li':
			// ... and definition lists
			case 'dl':
			case 'dt':
			case 'dd':
				$out = $this->handleListItem($node, $textContent);
				break;

			// headings
			case 'h1':
			case 'h2':
			case 'h3':
			case 'h4':
			case 'h5':
			case 'h6':
				$out = $this->handleHeading($node, $textContent);
				break;

			// tables
			case 'tbody':
				$out = $textContent;
				break;

			case 'table':
			case 'caption':
			case 'tr':
			case 'th':
			case 'td':
				$out = $this->handleTable($node, $textContent);
				break;

			// images
			case 'img':
				$out = $this->handleImage($node, $textContent);
				break;

			// try to fix RT #38262 / RT #38262
			case 'script':
			case 'object':
			case 'iframe':
				$out = '';
				break;

			// spans are used for styling pieces of content
			case 'span':
				$out = $this->handleSpan($node, $textContent);
				break;

			// rest of tags
			default:
				$out = $textContent;
				break;
		}

		// support data-rte-empty-lines-before attribute
		if (self::getEmptyLinesBefore($node) % 2 == 1) {
			$out = "\n{$out}";
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 * Handle RTE placeholders (templates, magic words, media placeholders, HTML comments, custom placeholders)
	 */
	private function handlePlaceholder($node, $textContent) {
		wfProfileIn(__METHOD__);

		// get meta data
		$data = self::getRTEData($node);

		// support custom placeholder added by extensions
		if(!empty($data['custom-placeholder'])) {
			$out = '';

			wfDebug(__METHOD__ . ": triggering hook for '{$node->nodeName}' custom placeholder\n");
			wfRunHooks('RTEcustomHandleTag', array($node, &$out));

			if($out != '') {
				wfProfileOut(__METHOD__);
				return $out;
			}
		}

		$out = $data['wikitext'];

		// extra fixes for different types of placeholders
		if (isset($data['type'])) {
			switch($data['type']) {
				case 'comment':
					// FIXME: dirty fix for RT #83859
					// assuming here that comments in wysiyg mode must be placed at the beginning of new line
					if (self::isChildOf($node->parentNode, 'div')) {
						$out = "\n{$out}";
					}
					break;
			}
		}

		// protect HTML entities (RT #38844)
		$out = RTEParser::markEntities($out);

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 * Handle HTML nodes
	 */
	private function handleHtml($node, $textContent) {
		wfProfileIn(__METHOD__);

		$prefix = $suffix = $beforeText = $beforeClose = '';

		// add line break
		if ($node->hasAttribute(self::DATA_RTE_LINE_START)) {
			$parentWasHtml = !empty($node->parentNode) && self::wasHtml($node->parentNode);

			if ($parentWasHtml) {
				// nested HTML
				$prefix = "\n";
			}
			else {
				// only add line break if there's no empty line before and previous sibling was not a tag
				if ( self::getEmptyLinesBefore($node) == 0
					&& !self::isFirstChild($node)
					&& !$this->wasTag( $node->previousSibling )
					&& $node->nodeName != 'blockquote' ) {
					$prefix = "\n";
				}

				// if node follows LINE_BREAK comment, don't add line break
				if (self::previousCommentIs($node, 'LINE_BREAK')) {
					$prefix = '';
				}

				// if the first / last child of this HTML block have data-rte-line-start, add line break before closing tag
				$child = ($node->nodeName == 'div') ? $node->lastChild /* BugId:4748 */ : $node->firstChild;

				if ( !empty($child) && ($child->nodeType == XML_ELEMENT_NODE) ) {
					if ($child->hasAttribute(self::DATA_RTE_LINE_START)) {
						$beforeClose = "\n";
					}
				}

				// always end HTML block with line break
				$suffix = "\n";
			}
		}

		// wasHTML nodes inside paragraphs - don't add any line breaks
		if (self::isChildOf($node, 'p')) {
			$suffix = $prefix = '';
		}

		// fix for first paragraph / pre / table / .. inside <div>
		if ($node->nodeName == 'div') {
			// ignore nodes rendered from HTML (with "data-rte-washtml" attribute)
			if (self::firstChildIs($node, array('pre', 'table', 'ul', 'ol', 'dl')) && !self::wasHtml($node->firstChild)) {
				$beforeText = "\n";
			}

			else if (self::firstChildIs($node, array('p'))) {
				$para = $node->firstChild;

				// fix for non-empty paragraphs (<div>\n123\n</div>)
				if ($para->textContent != '&nbsp;') {
					$beforeText = "\n";
				}

				// next node is text node (<div>\n\nfoo</div>)
				if (self::nextSiblingIsTextNode($para)) {
					$beforeText = "\n";
				}
				// next node is not a "wasHtml" node  (<div>\n\n\n preformatted text</div>)
				else if (!empty($para->nextSibling) && !self::wasHtml($para->nextSibling)) {
					$beforeText = "\n";
				}
			}
		}

		// fix for wikitext that is context-sensitive
		// these are escaped for regex matching
		$lineInitialTokens = array(
				'\*',
				'{\|',
				'#',
				'=',
		);
		foreach ( $lineInitialTokens as $token ) {
			if ( preg_match( "/^{$token}/is", $textContent ) ) {
				$beforeText = "\n";
			}
		}

		// special handling of headings in <div> tags (BugId:4908)
		if (self::isHeadingNode($node) && self::isChildOf($node, 'div') && !self::isFirstChild($node)) {
			$prefix = '';
			$suffix = "\n";
		}

		// generate HTML
		$attr = self::getAttributesStr($node);

		$isShort = in_array($node->nodeName, array('br', 'hr'));
		if ($isShort) {
			if ($attr == '') {
				// render br with no attributes as <br />
				$attr = ' ';
			}
			$out = "{$prefix}<{$node->nodeName}{$attr}/>";
		}
		else {
			$out = "{$prefix}<{$node->nodeName}{$attr}>{$beforeText}{$textContent}{$beforeClose}</{$node->nodeName}>{$suffix}";
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handle HTML entities
	 */
	private function handleEntity($node, $textContent) {
		wfProfileIn(__METHOD__);

		$entity = $node->getAttribute(self::DATA_RTE_ENTITY);
		$out = self::getEntityMarker($entity);

		wfProfileOut(__METHOD__);

		return $out;
	}

	/*
	 * Returns marker for given entity
	 */
	private static function getEntityMarker($entity) {
		wfProfileIn(__METHOD__);

		$out = "\x7f-ENTITY-{$entity}-\x7f";

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handles comments
	 */
	private function handleComment($node) {
		wfProfileIn(__METHOD__);

		$out = '';

		// (try to) parse special comments
		$comment = self::parseComment($node);

		if (empty($comment)) {
			wfProfileOut(__METHOD__);
			return '';
		}

		//RTE::log(__METHOD__, $comment);

		// handle <!-- RTE_LINE_BREAK --> comment
		// used for following wikitext (line breaks within single paragraph)
		// 123
		// 456
		// 789
		//
		// ignore cases like: <p><br /><!-- RTE_LINE_BREAK -->foo</p>
		if ($comment['type'] == 'LINE_BREAK') {
			$spaces = str_repeat(' ', intval($comment['data']['spaces']));
			$out = "{$spaces}\n";
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handles text nodes
	 */
	private function handleText($node, $textContent) {
		wfProfileIn(__METHOD__);

		$out = $textContent;

		// remove trailing space from text node which is followed by <!-- RTE_LINE_BREAK --> comment
		if (self::nextCommentIs($node, 'LINE_BREAK')) {
			$out = rtrim( $out, ' ' );
		}

		// fix for tables created in CK
		// <td>&nbsp;</td> -> empty cell
		if ( ($out == '&nbsp;') && (self::isChildOf($node, 'td')) ) {
			$out = '';
		}

		// remove spaces from the beginning of paragraph (people use spaces to centre text)
		// add from text nodes following <br /> (RT #38980)
		if (self::isChildOf($node, 'p') && (self::isFirstChild($node) || self::previousSiblingIs($node, 'br'))) {
			// grab &nbsp; and "soft" spaces
			preg_match('%^(&nbsp;)+[ ]?%', $out, $matches);

			if (!empty($matches)) {
				RTE::log(__METHOD__ . '::removeSpaces', $matches[0]);

				// remove those spaces
				$out = substr($out, strlen($matches[0]));
			}
		}

		$out = $this->fixForTableCell($node, $out);

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handle paragraphs
	 */
	private function handleParagraph($node, $textContent) {
		wfProfileIn(__METHOD__);

		// handle empty paragraphs (<p>&nbsp;</p>)
		// empty paragraphs added in CK / already existing in wikitext
		// RT #37897
		if (($textContent == self::getEntityMarker('nbsp')) || ($textContent == '&nbsp;')) {
			if ($node->hasAttribute(self::DATA_RTE_NEW_NODE)) {
				$textContent = '';
			}
			else {
				$textContent = "\n";
			}
		}

		/**
		 * bugid: 51621 -- an empty p tag preceding a blockquote should be nixed when reverse-parsing
		 */
		if ( self::nextSiblingIs( $node, 'blockquote' )
			&& $node->hasAttribute( self::DATA_RTE_FROMPARSER )
			&& $textContent == "\n" ) {
			wfProfileOut(__METHOD__);
			return '';
		}
		if ( self::previousSiblingIs( $node, 'blockquote' )
			&& $textContent == "\n" ) {
			wfProfileOut(__METHOD__);
		    return '';
		}

		// RT#40786: handle "filler" paragraphs added between headings
		if ($node->hasAttribute(self::DATA_RTE_FILTER) && $textContent == "\n") {
			RTE::log(__METHOD__.'::filler', 'empty filler paragraph found');

			wfProfileOut(__METHOD__);
			return '';
		}

		// handle "raw" HTML paragraphs within wikitext (BugId:3359)
		if (self::wasHtml($node) && !$node->hasAttribute(self::DATA_RTE_ATTRIBS)) {
			wfProfileOut(__METHOD__);
			return "<p>{$textContent}</p>";
		}

		if (self::hasCustomAttributes($node)) {
			if ($node->hasAttribute('style') && self::countCustomAttributes($node) == 1 && trim($textContent) != '') {
				$style = $node->getAttribute(self::DATA_RTE_STYLE);

				if (empty($style)) {
					$style = $node->getAttribute('style');
				}

				// does paragraph has only style=""margin-left:80px;" ? - style added by CKeditor when doing indent/outdent
				if (preg_match('#^margin\\-left:[\s\d]+px;$#', trim($style))) {
					// parse "margin-left" style attribute
					$indentLevel = self::getIndentationLevel($node);
					if ($indentLevel) {
						$textContent = str_repeat(':', $indentLevel) . " {$textContent}";
					}
				}
				else {
					// wrap text content inside HTML
					$textContent = "<p style=\"{$style}\">{$textContent}</p>";
				}
			}
			// don't remove paragraph tag if there are some attributes (BugId: 47994)
			else {
				$attrStr = self::getAttributesStr($node);
				$textContent = "<p{$attrStr}>{$textContent}</p>";
			}
		}

		if (self::nextSiblingIs($node,'p') && self::wasHtml($node->nextSibling) && !$node->nextSibling->hasAttribute(self::DATA_RTE_LINE_START)) {
			// support foo<p>bar</p> (BugId:3559)
			$out = $textContent;
		}
		else {
			$out = "{$textContent}\n";
		}

		// if next paragraph has been pasted into CK add extra newline
		if (self::nextSiblingIs($node, 'p') && self::isPasted($node->nextSibling)) {
			$out = "{$out}\n";
		}

		// this node was added in CK
		// handle paragraphs outside tables only (RT #56402)
		else if (self::isNewNode($node) && self::isChildOf($node, 'body')) {
			// next element is (not pasted) paragraph
			if (self::nextSiblingIs($node, 'p') && self::isNewNode($node->nextSibling)) {
				$out = "{$out}\n";
			}
		}

		// RT #40935
		else if (self::isChildOf($node, 'div') && (trim($textContent) != '')) {
			// this is first paragraph in this <div>
			if (self::previousSiblingIsTextNode($node)) {
				$out = "\n{$out}";
			}

			// this is last paragraph in this <div>
			if (self::nextSiblingIsTextNode($node)) {
				$out .= "\n";
			}
		}

		// BugId:4748
		else if (self::isChildOf($node, 'center') && self::isFirstChild($node)) {
			$out = "\n{$out}";
		}

		$out = $this->fixForTableCell($node, $out);

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 * Handle <br /> tags
	 */
	private function handleLineBreaks($node) {
		wfProfileIn(__METHOD__);

		$out = "\n";

		// handle <br /> added by Shift+Enter
		if ($node->hasAttribute(self::DATA_RTE_SHIFT_ENTER)) {
			$out = "<br />";
			if(!empty($node->parentNode->parentNode) && !self::isListNode($node->parentNode->parentNode)) { // (RT#37118)
				$out .= "\n";
			}
		}

		// handle <br /> in list added by text copy (RT#37118)
		if(!empty($node->parentNode->parentNode) && self::isListNode($node->parentNode->parentNode)) {
			$out = "<br />";
		}

		// don't break lists added in CK
		if ( self::isChildOf($node, 'li') && self::nextSiblingIs($node, array('ul', 'ol')) ) {
			$out = '';
		}

		// don't break headings with formatted (bold/italic) content (RT #33860)
		if ( self::isLastChild($node) && self::isChildOf($node, array('b', 'i')) ) {
			$out = '';
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handle <hr /> tags
	 */
	private function handleHorizontalLines($node) {
		wfProfileIn(__METHOD__);

		$out = "----\n";

		// RT #45087
		$out = self::fixForTableCell($node, $out);

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handle links
	 *
	 * @see http://www.mediawiki.org/wiki/Help:Links
	 */
	private function handleLink($node, $textContent) {
		wfProfileIn(__METHOD__);

		// get RTE data
		$data = self::getRTEData($node);

		// handle pasted links
		if (empty($data)) {
			$data = array(
				'type' => 'pasted',
				'link' => $node->getAttribute('href'),
			);
		}

		// generate wikitext
		$out = '';

		// unmark HTML entities and decode not marked HTML entities (RT #38844)
		$textContentOriginal = RTEParser::unmarkEntities($textContent, true);

		switch($data['type']) {
			case 'internal':
				// following wikitext optimization will be performed:
				//
				// [[foo|foo]] -> [[foo]]
				// [[foo|foos]] -> [[foo]]s

				// check for possible trails
				$trail = false;

				// start link wikitext
				$out = "[[";

				// handle [[:Category:foo]]
				if (isset($data['noforce']) && $data['noforce'] == false) {
					$out .= ':';
				}
				// and add : before [[Category:Foo]] links (RT #41323)
				else if (self::isNamespacedLink($node, $data)) {
					$out .= ':';
				}

				// [[<current_page_name>/foo|/foo]] -> [[/foo]]
				global $wgTitle;
				$pageName = $wgTitle->getPrefixedText();
				if ($data['link'] == $pageName . $textContentOriginal) {
					$data['link'] = $textContent;
				}

				// support [[/foo/]] (RT #56095) and [[Page/foo|foo]] (RT #143377)
				// both are giving the same entries in $data - detect them using original wikitext
				if ($data['link'] == "{$pageName}/{$textContentOriginal}") {

					// keep [[/foo/]] links (RT #56095)
					if (strpos($data['wikitext'], '|') === false) {
						$data['link'] = "/{$textContent}/";

						// don't check for possible trails and after-pipe descriptions
						$trail = '';
					}
				}

				$out .= $data['link'];

				// check for possible trail
				// [[foo|foos]] -> [[foo]]s
				if ( (strlen($textContentOriginal) > strlen($data['link'])) ) {
					if (substr($textContentOriginal, 0, strlen($data['link'])) == $data['link']) {
						$possibleTrail = substr($textContentOriginal, strlen($data['link']));
						// check against trail valid characters regexp
						// if there are matches, and there are no trailing characters
						// fbId::45461 - [[Tower|Towers of Wizardry]] should not convert to [[Tower]]s of Wizardry
						preg_match(self::getTrailRegex(), $possibleTrail, $matches);
						$trail = $matches && empty($matches[2]) ? $matches[1] : $trail;
					}
				}

				// link description after pipe
				if ( ($trail === false) && ($data['link'] != $textContentOriginal) ) {
					$out .= "|{$textContent}";
				}

				// close link wikitext + trail
				$out .= "]]{$trail}";

				// protect HTML entities (RT #38844)
				$out = RTEParser::markEntities($out);
				break;

			case 'external':
				// optimize external links
				// [http://wp.pl http://wp.pl] -> http://wp.pl
				if ($textContent == $data['link']) {
					$out = $data['link'];
					break;
				}

				// handle autonumbered links
				$autonumber = false;
				if ( isset($data['linktype']) && ($data['linktype'] == 'autonumber') ) {
					// validate text content - should be [x]
					if (preg_match("%\[(\d+)\]%", $textContent)) {
						// yes, this is autonumbered external link
						$autonumber = true;
					}
				}

				$out = "[{$data['link']}";

				if (!$autonumber) {
					// add link description
					$out .= " {$textContent}";
				}

				$out .= ']';
				break;

			case 'external-raw':
				// validate textContent (should be valid URL)
				$regex = '%' . self::getUrlProtocols() . '%';

				if (preg_match($regex, $textContent)) {
					// let's return it as raw link
					$out = $textContent;
				}
				else {
					// URL text content has changed -> use external link like [http://wp.pl link]
					$out = "[{$data['link']} {$textContent}]";
				}

				break;

			case 'pasted':
				// validate link (should be valid URL)
				$regex = '%' . self::getUrlProtocols() . '%';

				if (preg_match($regex, $data['link'])) {
					// optimize wikisyntax
					if ($data['link'] == $textContent) {
						$out = $data['link'];
					}
					else {
						$out = "[{$data['link']} {$textContent}]";
					}
				}
				else {
					// just return link content
					$out = $textContent;
				}

				break;
		}

		// RT #34043
		$out = self::fixForTableCell($node, $out);

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handle formattings (bold / italic / underline / strike / sub / sup)
	 *
	 * This is "reverse" implementation of code from Parser handling bolds and italics
	 */
	private function handleFormatting($node, $textContent) {
		wfProfileIn(__METHOD__);

		switch($node->nodeName) {
			case 'u':
			case 'strike':
			case 'sup':
			case 'sub':
				$attributes = self::getAttributesStr($node);

				$out = "<{$node->nodeName}{$attributes}>{$textContent}</{$node->nodeName}>";
				wfProfileOut(__METHOD__);
				return $out;

			// 1 '</b><i><b>' => '<i>'
			// 2 '</i><b><i>' => '<b>'
			// 3 '</b></i><b>' => '</i>'
			// 4 '</i></b><i>' => '</b>'
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

		// don't output formatting markup with empty content (RT #37899)
		if ($textContent == '') {
			$out = '';
		}
		else {
			$out = "{$open}{$textContent}{$close}";

			// RT #34043
			$out = self::fixForTableCell($node, $out);
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handle preformatted text
	 */
	private function handlePre($node, $textContent) {
		wfProfileIn(__METHOD__);

		$textContent = rtrim($textContent);

		// add spaces after every line break
		$textContent = str_replace("\n", "\n ", $textContent);

		$out = " {$textContent}\n";

		$out = $this->fixForTableCell($node, $out);

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handle list item
	 */
	private function handleListItem($node, $textContent) {
		wfProfileIn(__METHOD__);

		$out = '';

		switch($node->nodeName) {
			case 'ul':
			case 'ol':
				$out = rtrim($textContent, "\n");

				// this list (789) is nested list
				// <ul><li>abc<ul><li>789</li></ul></li></ul>
				if ( self::isChildOf($node, 'li') && !self::isFirstChild($node) ) {
					$out = "\n{$out}";
				}

				// bugfix: fogbugz BugID 11537
				// losing newline before : and * following h[1-6] or div
				if(self::wasHtml($node->previousSibling)) {
					$out = "\n{$out}";
				}

				// this list is indented list (RT #38268)
				// <dl><dd>foo<ul><li>bar...
				if ( self::isChildOf($node, array('dd', 'dt')) && !self::isFirstChild($node) && !self::isListNode($node->previousSibling) ) {
					$out = "\n{$out}";
				}

				// mixed nested lists
				// *** foo
				// **# bar
				// next sibling has the same parent (same list level),
				// but is list of different type
				$nextNode = $node->nextSibling;
				if ( !empty($nextNode) && self::isListNode($nextNode) &&
					!empty($node->parentNode->parentNode) && self::isListNode($node->parentNode->parentNode) &&
					($nextNode->nodeName != $node->nodeName) && self::haveSameParent($node, $nextNode) ) {
						// don't add line break
				}
				else {
					$out = "{$out}\n";
				}

				$out = $this->fixForTableCell($node, $out);
				$out = $this->fixForDiv($node, $out);

				break;

			case 'li':
				$textContent = rtrim( self::addSpaces($node, $textContent) );

				// check for <ul><li><ul><li>789</li></ul></li></ul>
				// this is list item with nested list inside
				if ( self::startsWithListWikitext($textContent) ) {
					// RT #41140 - maintain following wikitext:
					// *[spaces]
					// **foo
					// **bar
					$spaces = strspn($textContent, ' '); // count [spaces]
					if ($spaces > 0) {
						$out = $this->listBullets . str_repeat(' ', $spaces) . "\n" . ltrim($textContent) . "\n";
					}
					else {
						$out = "{$textContent}\n";
					}
				}
				else {
					$out = "{$this->listBullets}{$textContent}\n";
				}
				break;

			// definition lists
			case 'dl':
				$out = rtrim($textContent, "\n");

				// bugfix: fogbugz BugID 11537
				// losing newline before : and * following h[1-6] or div
				if(self::wasHtml($node->previousSibling)) {
					$out = "\n{$out}";
				}

				// handle nested intended list
				// :1
				// ::2
				// and
				// ::*: foo
				// :::# bar
				if ( self::isChildOf($node, 'dd') && !self::isFirstChild($node)
					&& !self::isListNode($node->parentNode->firstChild) ) {
					$out = "\n{$out}";
				}

				// fix for lists like
				// *: a
				// * b
				$isIntended = (strspn($this->listBullets, ':') > 0);
				if ( self::isChildOf($node, 'li') && !$isIntended ) {
					$out = "\n{$out}";
				}
				else {
					$out = "{$out}\n";
				}

				$out = $this->fixForTableCell($node, $out);
				break;

			case 'dt':
			case 'dd':
				$textContent = rtrim( self::addSpaces($node, $textContent) );

				// fix for empty list item between items (BugId:4821)
				// MW parser skips those items, we should maintain empty line
				if (($textContent == '') && self::isNewNode($node) && self::nextSiblingIs($node, $node->nodeName)) {
					$out = "\n";
				}
				// fix for single ":::: foo" gaining extra :
				else if (strspn($textContent, ':') > 0) {
					$out = "{$textContent}\n";
				}
				// check for <dl><dd><ul><li>1</li></ul></dd></dl>
				// this is intended list item with nested list inside
				else if (self::startsWithListWikitext($textContent)) {
					$out = "{$textContent}\n";
				}
				// allow UL/OL inside DT (RT#52593)
				else if(self::firstChildIs($node, array('ul', 'ol'))) {
					$out = "{$textContent}\n";
				}
				// handle indentation changes made in wysiwyg mode (RT #74089)
				else if ($indentLevel = self::getIndentationLevel($node)) {
					$out = $this->listBullets . str_repeat(':', $indentLevel) . "{$textContent}\n";
				}
				else {
					$out = "{$this->listBullets}{$textContent}\n";
				}

				break;
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handles lists opening
	 */
	private function handleListOpen($node) {
		wfProfileIn(__METHOD__);

		if (self::wasHtml($node)) {
			wfProfileOut(__METHOD__);
			return;
		}

		// build bullets stack
		switch ($node->nodeName) {
			case 'ul':
				$bullet = '*';
				break;
			case 'ol':
				$bullet = '#';
				break;
			case 'dd':
				$bullet = ':';
				break;
			case 'dt':
				$bullet = ';';
				break;
		}

		// update lists stack ("push")
		$this->listLevel++;
		$this->listBullets .= $bullet;

		//RTE::log("list level #{$this->listLevel}: {$this->listBullets}");

		wfProfileOut(__METHOD__);
	}

	/**
	 * Handles lists closing
	 */
	private function handleListClose($node) {
		wfProfileIn(__METHOD__);

		if (self::wasHtml($node)) {
			wfProfileOut(__METHOD__);
			return;
		}

		// update lists stack ("pop")
		$this->listLevel--;
		$this->listBullets = substr($this->listBullets, 0, -1);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Handle header
	 */
	private function handleHeading($node, $textContent) {
		wfProfileIn(__METHOD__);

		$level = str_repeat('=', intval($node->nodeName{1}));

		$textContent = self::addSpaces($node, $textContent);

		// RT #75625
		$textContent = trim($textContent, "\n");

		if ($textContent != '') {
			$out = "{$level}{$textContent}{$level}\n";

			$out = $this->fixForTableCell($node, $out);

			if (self::isChildOf($node, 'div')) {
				if (self::isFirstChild($node) /* RT#38254 */ || self::previousSiblingIs($node, 'center') /* BugId:4748 */) {
					$out = "\n{$out}";
				}
			}
		}
		else {
			// RT #75625: don't render empty headings
			$out = "\n";
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handle row/cell/table
	 */
	private function handleTable($node, $textContent) {
		wfProfileIn(__METHOD__);

		$out = '';

		// get node attributes
		$attributes = self::getAttributesStr($node);

		switch($node->nodeName) {
			case 'table':
				// remove row line breaks
				$textContent = trim($textContent, "\n");

				// don't render empty tables (<table ... />)
				if ($textContent == '') {
					RTE::log(__METHOD__, 'empty table found');
					$out = '';
					break;
				}

				$out = "{|{$attributes}\n{$textContent}\n|}\n";

				$out = $this->fixForTableCell($node, $out);
				$out = $this->fixForDiv($node, $out);

				// add \n if previous node is header and table is inside <div> (RT #44119)
				if (self::isChildOf($node, 'div')) {
					if (!empty($node->previousSibling) && self::isHeadingNode($node->previousSibling)) {
						$out = "\n{$out}";
					}
				}

				// add \n if previous node is <div> (RT #54113) or <span> (RT #83859)
				if (self::previousSiblingIs($node, array('div', 'span'))) {
					$out = "\n{$out}";
				}

				break;

			case 'caption':
				// add pipe after attributes
				if ($attributes != '') {
					$attributes .= '|';
				}

				$out = "\n|+{$attributes}{$textContent}";
				break;

			case 'tr':
				// remove cell line breaks
				$textContent = trim($textContent, "\n");

				$addRowDelimiter = false;

				if (self::isFirstChild($node)) {
					// add |- before first table row when table header (caption) is present
					$tableNode = $node->parentNode->parentNode;
					if (self::firstChildIs($tableNode, 'thead') || self::firstChildIs( $tableNode, 'caption' ) ) {
						$addRowDelimiter = true;
					}
				}
				else {
					// for next rows always add row delimiter
					$addRowDelimiter = true;
				}

				// delimiter is needed when <tr> has attributes provided
				if ($attributes != '') {
					$addRowDelimiter = true;
				}

				// preserve row delimiter from wikitext
				if (self::getEmptyLinesBefore($node)) {
					$addRowDelimiter = true;
				}

				// add row delimiter and attributes when needed
				if ($addRowDelimiter) {
					$out = "\n|-{$attributes}";
				}

				$out .= "\n{$textContent}";
				break;

			case 'th':
			case 'td':
				$out = '';
				$char = ($node->nodeName == 'td') ? '|' : '!';

				// support cells separated using double pipe
				$shortRowMarkup = $node->hasAttribute(self::DATA_RTE_SHORT_ROW_MARKUP);
				$spacesAfterLastCell = intval( $node->getAttribute(self::DATA_RTE_SPACES_AFTER_LAST_CELL) );

				if($shortRowMarkup) {
					// add trailing spaces from previous cell (RT #33879)
					if ($spacesAfterLastCell) {
						$out .= str_repeat(' ', $spacesAfterLastCell);
					}
					$out .= "{$char}{$char}";
				}
				else {
					 $out .= "\n{$char}";
				}

				// add pipe after attributes
				if ($attributes != '') {
					$attributes .= '|';
				}

				// remove trailing line breaks
				$textContent = rtrim(self::addSpaces($node, $textContent), "\n");

				// add space before + and - (RT #53351)
				if (isset($textContent{0}) && in_array($textContent{0}, array('-', '+'))) {
					$textContent = " {$textContent}";
				}
				// encode pipe (RT #53351)
				else if (isset($textContent{0}) && $textContent{0} == '|') {
					$textContent = RTEParser::markEntities('&#124;') . substr($textContent, 1);
				}

				$out .= "{$attributes}{$textContent}";
				break;
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handle image
	 *
	 * @see http://www.mediawiki.org/wiki/Images
	 */
	private function handleImage($node, $textContent) {
		wfProfileIn(__METHOD__);

		// get RTE data
		$data = self::getRTEData($node);

		// TODO: try to generate wikitext based on data
		$out = $data['wikitext'];

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Handle <span> nodes
	 *
	 * @see http://www.mediawiki.org/wiki/Images
	 */
	private function handleSpan($node, $textContent) {
		// if tag contains style attribute, preserve full HTML (BugId:7098)
		if ($node->hasAttribute('style')) {
			$attrs = self::getAttributesStr($node);
			$out = "<{$node->nodeName}{$attrs}>{$textContent}</{$node->nodeName}>";
		}
		else {
			$out = $textContent;
		}

		return $out;
	}

	/**
	 * Adds extra line break before/after given element which is the first child of table cell (td/th)
	 */
	private function fixForTableCell($node, $out) {
		wfProfileIn(__METHOD__);

		// just fix elements which are children of <td> or <th>
		if ( !self::isChildOf($node, 'td') && !self::isChildOf($node, 'th') ) {
			wfProfileOut(__METHOD__);
			return $out;
		}

		// $node must be first child of table cell / header (td/th)
		if ( self::isFirstChild($node) ) {
			if ($node->nodeType == XML_ELEMENT_NODE) {
				switch($node->nodeName) {
					// link (RT #34043)
					case 'a':
					// simple formatting tags (RT #34043)
					case 'b':
					case 'i':
					case 'u':
					case 's':
					case 'strike':
						// if next element is text node, don't add line break (refs RT #34043)
						// if next element is <br />, don't add line break (refs RT #38257)
						// if next element is <sup> or <sub>, don't add line break (ref RT #67354)
						if (!self::nextSiblingIsTextNode($node) &&
							!self::nextSiblingIs($node, 'br') &&
							!self::nextSiblingIs($node, 'sub') &&
							!self::nextSiblingIs($node, 'sup')
						) {
							$out = "{$out}\n";
						}
						break;

					default:
						// for HTML elements add extra line break before
						$out = "\n{$out}";
				}
			} else {
				// for text nodes check what is next sibling
				// add line break before tables and lists
				if ( self::nextSiblingIs($node, array('table', 'ul', 'ol')) ) {
					$out = "{$out}\n";
				}
			}

		// Non-child nodes
		} else if (
			// Break before lists if previous node is text node (RT #34043)
			( self::isListNode( $node ) && self::previousSiblingIsTextNode( $node ) ) ||
			// (BugId:11235, BugId:95911) Fix paragraphs created by newlines.
			( self::isNewlineParagraph( $node ) && !self::isNewlineParagraph( $node->previousSibling ) &&
				( self::previousSiblingIsTextNode( $node ) || !self::isFirstChild( $node->previousSibling ) )
			)
		) {
			$out = "\n{$out}";
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Checks if given node is a paragraph created by newlines
	 * (as opposed to an explicit <p> tag).
	 */
	private function isNewlineParagraph( $node ) {
		return $node->nodeName == 'p' && !self::wasHtml( $node );
	}

	/**
	 * Adds extra line break before given element not being first child of div
	 */
	private function fixForDiv($node, $out) {
		wfProfileIn(__METHOD__);

		// add \n before when inside div
		if (self::isChildOf($node, 'div') && !self::isFirstChild($node)) {
			// only add \n if node before given one is plain text node
			if (self::previousSiblingIsTextNode($node)) {
				$out = "\n{$out}";
			}
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Checks if given node is list node
	 */
	private static function isListNode($node) {
		return in_array($node->nodeName, array('ul', 'ol', 'dt', 'dd'));
	}

	/**
	 * Checks if given node is heading
	 */
	private static function isHeadingNode($node) {
		return !empty($node->nodeName) && $node->nodeName{0} == 'h' && is_numeric($node->nodeName{1});
	}

	/**
	 * Checks if given text starts with list wikisyntax
	 */
	private static function startsWithListWikitext($text) {
		$text = ltrim($text, ' :');

		return ( (strspn($text, '*') > 0) || (strspn($text, '#') > 0) );
	}

	/**
	 * Checks name of previous node
	 */
	private static function previousSiblingIs($node, $nodeName) {
		if (is_string($nodeName)) {
			$nodeName = array($nodeName);
		}

		return ( !empty($node->previousSibling->nodeName) && in_array($node->previousSibling->nodeName, $nodeName) );
	}

	/**
	 * Checks name of next node
	 */
	private static function nextSiblingIs($node, $nodeName) {
		if (is_string($nodeName)) {
			$nodeName = array($nodeName);
		}

		return ( !empty($node->nextSibling->nodeName) && in_array($node->nextSibling->nodeName, $nodeName) );
	}

	/**
	 * Checks if previous node is text node
	 */
	private static function previousSiblingIsTextNode($node) {
		return ( !empty($node->previousSibling) && $node->previousSibling->nodeType == XML_TEXT_NODE );
	}

	/**
	 * Checks if next node is text node
	 */
	private static function nextSiblingIsTextNode($node) {
		return ( !empty($node->nextSibling) && $node->nextSibling->nodeType == XML_TEXT_NODE );
	}

	/**
	 * Checks name of previous special comment node
	 */
	private static function previousCommentIs($node, $type) {
		if ( !empty($node->previousSibling) && ($node->previousSibling->nodeType == XML_COMMENT_NODE) ) {
			// try to parse the comment
			$comment = self::parseComment($node->previousSibling);

			if ( !empty($comment) && ($comment['type'] == $type) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks name of next special comment node
	 */
	private static function nextCommentIs($node, $type) {
		if ( !empty($node->nextSibling) && ($node->nextSibling->nodeType == XML_COMMENT_NODE) ) {
			// try to parse the comment
			$comment = self::parseComment($node->nextSibling);

			if ( !empty($comment) && ($comment['type'] == $type) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks if given node is first child of its parent
	 */
	private static function isFirstChild($node) {
		return ( !empty($node->parentNode) && $node->parentNode->firstChild->isSameNode($node) );
	}

	/**
	 * Checks if given node is last child of its parent
	 */
	private static function isLastChild($node) {
		return ( !empty($node->parentNode) && $node->parentNode->lastChild->isSameNode($node) );
	}

	/**
	 * Checks name of parent of given node
	 */
	private static function isChildOf($node, $parentName) {
		wfProfileIn(__METHOD__);

		if (is_string($parentName)) {
			$parentName = array($parentName);
		}

		$ret = ( !empty($node->parentNode) && in_array($node->parentNode->nodeName, $parentName) );

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Checks whether two given nodes have the same parent node
	 */
	private static function haveSameParent($nodeA, $nodeB) {
		wfProfileIn(__METHOD__);

		$ret = !empty($nodeA->parentNode) && !empty($nodeB->parentNode) && $nodeA->parentNode->isSameNode($nodeB->parentNode);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Checks if first child of given node has given name
	 */
	private static function firstChildIs($node, $nodeName) {
		wfProfileIn(__METHOD__);

		if (is_string($nodeName)) {
			$nodeName = array($nodeName);
		}
		$firstChild = $node->firstChild;

		$ret = !empty($firstChild) && $firstChild->nodeType == XML_ELEMENT_NODE && in_array($firstChild->nodeName, $nodeName);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Checks if given node (check is only performed for paragraphs) was pasted
	 */
	private static function isPasted($node) {
		return !$node->hasAttribute(self::DATA_RTE_FROMPARSER) && !$node->hasAttribute(self::DATA_RTE_NEW_MODE);
	}

	/**
	 * Checks if given node was added into CK
	 */
	private static function isNewNode($node) {
		return $node->hasAttribute(self::DATA_RTE_NEW_NODE) && (self::getEmptyLinesBefore($node) == 0);
	}

	/**
	 * Checks if given node is placeholder
	 */
	private static function isPlaceholder($node) {
		$data = self::getRTEData($node);
		return !empty($data) && !empty($data['placeholder']);
	}

	/**
	 * Check if given node was rendered from HTML node
	 */
	private static function wasHtml($node) {
		return ($node instanceof DOMElement) && $node->hasAttribute(self::DATA_RTE_WASHTML);
	}

	/**
	 * Get value of data-rte-empty-lines-before attribute
	 */
	private static function getEmptyLinesBefore($node) {
		return intval($node->getAttribute(self::DATA_RTE_EMPTY_LINES_BEFORE));
	}

	/**
	 * Get string with "HTML" formatted list of node attributes (attributes with _rte prefixes will be removed)
	 */
	private static function getAttributesStr($node) {
		if(!$node->hasAttributes()) {
			return '';
		}

		wfProfileIn(__METHOD__);

		// replace style attribute with data-rte-style
		if ($node->hasAttribute(self::DATA_RTE_STYLE)) {
			$node->setAttribute('style', $node->getAttribute(self::DATA_RTE_STYLE));
		}

		// try to get attributes from previously stored attribute (RT #23998)
		$attrStr = $node->getAttribute(self::DATA_RTE_ATTRIBS);

		if ( $attrStr != '' ) {
			// decode entities
			$attrStr = str_replace("\x7f", '&quot;', $attrStr);
			$attrStr = htmlspecialchars_decode($attrStr);
		}
		else {
			foreach ($node->attributes as $attrName => $attrNode) {
				// ignore attributes used internally by RTE ("data-rte-" or "jquery" prefix)
				if (self::isDataRTEAttribute($attrName) || self::isJqueryAttribute($attrName)) {
					continue;
				}
				$attrStr .= ' ' . $attrName . '="' . $attrNode->nodeValue  . '"';
			}
		}

		wfProfileOut(__METHOD__);

		return $attrStr;
	}

	/**
	 * Get value of given CSS property
	 */
	private static function getCssProperty($node, $property) {
		wfProfileIn(__METHOD__);

		if ($node->hasAttribute('style')) {
			$style = $node->getAttribute('style');

			// parse style attribute
			preg_match('%' . preg_quote($property) . ':([^;]+)%', $style, $matches);

			if (!empty($matches[1])) {
				$value = trim($matches[1]);
				RTE::log(__METHOD__, "{$property}: {$value}");

				wfProfileOut(__METHOD__);

				return $value;
			}
		}

		wfProfileOut(__METHOD__);

		return false;
	}

	/**
	 * Returns indentation level of give node
	 */
	private static function getIndentationLevel($node) {
		wfProfileIn(__METHOD__);

		$indentLevel = 0;

		$marginLeft = self::getCssProperty($node, 'margin-left');
		if (!empty($marginLeft)) {
			$indentLevel = intval($marginLeft / 24);
		}

		wfProfileOut(__METHOD__);
		return $indentLevel;
	}

	/**
	 * Decode and return meta data stored in data-rte-meta attribute
	 */
	public static function getRTEData($node) {
		wfProfileIn(__METHOD__);

		// check cached result
		if (!empty($node->data)) {
			wfProfileOut(__METHOD__);
			return $node->data;
		}

		$value = $node->getAttribute(self::DATA_RTE_META);

		if (!empty($value)) {
			$value = htmlspecialchars_decode($value);
			$value = rawurldecode($value);

			RTE::log(__METHOD__, $value);

			$data = json_decode($value, true);

			if (!empty($data)) {
				RTE::log(__METHOD__, $data);

				// cache data
				$node->data = $data;

				wfProfileOut(__METHOD__);
				return $data;
			}
		}

		wfProfileOut(__METHOD__);

		return null;
	}

	/**
	 * Encode meta data to be stored in data-rte-meta attribute
	 */
	public static function encodeRTEData($data) {
		wfProfileIn(__METHOD__);

		$encoded = rawurlencode(json_encode($data));

		wfProfileOut(__METHOD__);

		return $encoded;
	}

	/**
	 * Build RTE special comment with extra data in it
	 */
	public static function buildComment($type, $data = null) {
		wfProfileIn(__METHOD__);

		$data['type'] = $type;
		$data = json_encode($data);

		wfProfileOut(__METHOD__);

		return "<!-- RTE::{$data} -->";
	}

	/**
	 * Parse special comment and returns its name and data
	 */
	private static function parseComment($node) {
		wfProfileIn(__METHOD__);

		$fields = explode('::', trim($node->data, ' '));

		// validate comment
		if ( (count($fields) != 2) || ($fields[0] != 'RTE') ) {
			wfProfileOut(__METHOD__);
			return false;
		}

		$data = json_decode($fields[1], true);

		wfProfileOut(__METHOD__);

		return array(
			'type' => $data['type'],
			'data' => $data,
		);
	}

	/*
	 * Helper caching methods
	 */
	private static function getTrailRegex() {
		static $regex = false;
		if ( $regex === false ) {
			global $wgContLang;
			$regex = $wgContLang->linkTrail();

			RTE::log(__METHOD__, $regex);
		}

		return $regex;
	}

	private static function getUrlProtocols() {
		static $regex = false;
		if ( $regex === false ) {
			$regex = wfUrlProtocols();

			RTE::log(__METHOD__, $regex);
		}

		return $regex;

	}

	/**
	 * Returns textContent of given node with spaces added
	 *
	 * Number of spaces is based on data-rte-spaces-after and data-rte-spaces-before attributes
	 */
	private static function addSpaces($node, $textContent) {
		wfProfileIn(__METHOD__);

		$textContent =  trim($textContent, ' ');

		// RT #40013
		if ( ($textContent != '') && ($textContent != '&nbsp;') ) {
			$spacesAfter = intval($node->getAttribute(self::DATA_RTE_SPACES_AFTER));
			$spacesBefore = intval($node->getAttribute(self::DATA_RTE_SPACES_BEFORE));
		}
		else {
			$textContent = '';
			$spacesAfter = intval($node->getAttribute(self::DATA_RTE_SPACES_AFTER));
			$spacesBefore = 0;
		}

		$out = str_repeat(' ', $spacesBefore) . $textContent . str_repeat(' ', $spacesAfter);

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Returns special comment with number of empty lines before
	 *
	 * Value stored in this comment will be moved to attribute of following HTML element
	 */
	public static function addEmptyLinesBeforeComment($count) {
		RTE::log(__METHOD__, $count);

		return "<!-- RTE_EMPTY_LINES_BEFORE_{$count} -->";
	}

	/**
	 * Check given link whether it is in Category/File namespace (refs RT #41323)
	 */
	private static function isNamespacedLink($node, $data) {
		wfProfileIn(__METHOD__);

		$ret = false;

		if (strpos($data['link'], ':') !== false) {
			// get localised names of namespaces and cache them
			global $wgContLang;
			static $namespaces = false;
			if ($namespaces === false) {
				$namespaces = array(
					$wgContLang->getNsText(NS_CATEGORY),
					$wgContLang->getNsText(NS_FILE),
				);

				RTE::log(__METHOD__, 'got localised namespaces');
			}

			foreach($namespaces as $NSprefix) {
				if ( substr($data['link'], 0, strlen($NSprefix) + 1) == ($NSprefix . ':') ) {
					RTE::log(__METHOD__, $data['link']);

					$ret = true;
					break;
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Has custom (non data-rte-* & non jquery*) attributes
	 *
	 * @param $node
	 * @return bool
	 */
	public static function hasCustomAttributes($node){
		if ($node->hasAttributes()) {
			foreach ($node->attributes as $attrName => $attrNode) {
				if (!self::isDataRTEAttribute($attrName) && !self::isJqueryAttribute($attrName)) {
					return true;
				}
			}
		}

		return false;
	}


	public static function countCustomAttributes($node){
		$count = 0;

		if ($node->hasAttributes()) {
			foreach ($node->attributes as $attrName => $attrNode) {
				if (!self::isDataRTEAttribute($attrName) && !self::isJqueryAttribute($attrName)) {
					$count++;
				}
			}
		}

		return $count;
	}

	/**
	 * Is attribute data-rte*
	 *
	 * @param $attrName
	 * @return bool
	 */
	public static function isDataRTEAttribute($attrName){
		if (substr($attrName, 0, 9) == 'data-rte-') {
			return true;
		}

		return false;
	}

	/**
	 * Is attribute jquery*
	 *
	 * @param $attrName
	 * @return bool
	 */
	public static function isJqueryAttribute($attrName){
		if (substr($attrName, 0, 6) == 'jquery') {
			return true;
		}

		return false;
	}

	/**
	 * Determines if a tag was either html or a parser tag hook
	 * @param DomNode $node
	 * @return bool
	 */
	private function wasTag( $node ) {
		global $wgParser;
		$wgParser->firstCallInit();
		if ( self::wasHtml( $node ) ) {
			return true;
		}
		for ( $i = 0; $i < count( $this->nodes ); $i++ ) {
			if ( $this->nodes[$i]->isSameNode( $node ) ) {
				// pull the tag name out of a single-line confused hook or get the same output back
				// it doesn't matter, because we need an exact match to make this work
				$stripped = preg_replace( '/^\s*<([^>\/]+)\/?+>\s*$/', '$1', $this->nodeOutputs[$i] );
				return in_array( $stripped, $wgParser->getTags() );
			}
		}
		return false;
	}
}
