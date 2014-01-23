<?php

class RTEParser extends Parser {

	// count empty lines before HTML tag
	private $emptyLinesBefore = 0;

	// used in tweaked doBlockLevels()
	private $lastLineWasEmpty = null;
	private $lastOutput = null;
	private $inDivStack = 0;

	// image params grabed in ParserMakeImageParams hook to be used in makeImage
	private static $imageParams = null;

	// place to store data of rendered image placeholder to be returned by makeImage()
	private static $mediaPlaceholder = null;

	// last wikitext parsed by makeImage()
	private static $lastWikitext = null;

	/**
	 * Clear Parser state
	 *
	 * @private
	 */
	function clearState() {
		parent::clearState();

		// don't show TOC in edit mode
		$this->mShowToc = false;
	}

	/*
	 * Find empty lines in wikitext and mark following element
	 */
	function doBlockLevelsLineStart(&$oLine, &$output) {
		wfProfileIn(__METHOD__);

		RTE::log(__METHOD__, $oLine);

		$this->checkForContextSensitiveEdgeCases( $oLine );
		// check if previous line was empty
		if ($this->lastLineWasEmpty) {
			// increase empty lines counter
			$this->emptyLinesBefore++;
		}

		// current line is not empty and we have empty lines before
		if ( ($oLine != '') && ($this->emptyLinesBefore > 0) ) {
			// add special comment with empty lines counter
			$output .= RTEReverseParser::addEmptyLinesBeforeComment($this->emptyLinesBefore);
		}

		// mark <th> and <td> nodes generated by "short" table wikimarkup (using || and !!)
		wfProfileIn(__METHOD__ . '::shortRow');
		if ( (strpos($oLine, '</td><td>') !== false) || (strpos($oLine, '</th><th>') !== false) ) {
			$oLine = preg_replace_callback('%(?<!^)(\s{0,})</t[dh]\><t[dh]%s', 'RTEParser::shortRowMarkupCallback', $oLine);
		}
		wfProfileOut(__METHOD__ . '::shortRow');

		// mark wasHTML elements starting the line of wikitext
		wfProfileIn(__METHOD__ . '::lineStart');
		$oLine = preg_replace('/^<([^>]+data-rte-washtml="1")/', '<$1 data-rte-line-start="true"', $oLine);
		wfProfileOut(__METHOD__ . '::lineStart');

		// store parser output before this line of wikitext is parsed
		$this->lastOutput = $output;

		wfProfileOut(__METHOD__);
	}

	/**
	 * Registers the wikitext as an edge case with RTE stack for cases where
	 * line-initial HTML tags interfere with wikitext that must be line-initial
	 * @param string $line
	 */
	public function checkForContextSensitiveEdgeCases( $line ) {
        // these are already escaped for regex
		$tokens = array(
				'\*',
				'{\|',
				'# ',
				'=',
		);

		foreach ( $tokens as $token ) {
			if ( preg_match( '/^<[^>]+>' . $token . '/is', $line ) ) {
				RTE::$edgeCases[] = 'CONTEXT_SENSITIVE_TOKEN_FOLLOWING_HTML_TAG';
			}
		}
	}

	/**
	 * Reset empty lines counter and store current line as previous one for next step of foreach
	 */
	function doBlockLevelsLineEnd(&$oLine, &$output) {
		wfProfileIn(__METHOD__);

		// reset empty lines counter
		if ( (rtrim($oLine) != '') && ($this->emptyLinesBefore > 0) ) {
			//RTE::log(__METHOD__, "resetting empty lines counter ({$this->emptyLinesBefore})");

			$this->emptyLinesBefore = 0;
		}

		// RT #37702: parser has added an empty paragraph for empty line of wikitext
		// when parsing wikitext inside <div></div> section
		if ($this->inDivStack > 0 && $this->lastLineWasEmpty && ($output != $this->lastOutput) && $this->emptyLinesBefore > 0) {
			//RTE::log(__METHOD__, 'parser has added an empty paragraph inside <div></div>');

			// two lines will be added when reverse parsing <p>
			$this->emptyLinesBefore -= 2;
		}

		// store this for next call of doBlockLevelsLineStart()
		$this->lastLineWasEmpty = ($oLine == '');

		wfProfileOut(__METHOD__);
	}

	/**
	 * Handle wikitext inside <div></div> sections
	 */
	function doOpenCloseMatch($t, $openmatch, $closematch) {
		wfProfileIn(__METHOD__);

		if ($closematch) {
			if (preg_match('/<div/iS', $t)) {
				$this->inDivStack++;
			}

			if (preg_match('/<\/div/iS', $t)) {
				$this->inDivStack--;
			}
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Parse headers and return html
	 *
	 * Don't remove whitespaces following header
	 */
	function doHeadings($text) {
		wfProfileIn(__METHOD__);
		for ( $i = 6; $i >= 1; --$i ) {
			$h = str_repeat( '=', $i );
			$text = preg_replace( "/^$h(.+)$h(\\s*)$/m",
				"<h$i>\\1</h$i>\\2", $text );
		}
		wfProfileOut(__METHOD__);
		return $text;
	}

	/**
	 * Parse image options text and use it to make an image
	 * @param Title $title
	 * @param string $options
	 * @param LinkHolderArray $holders
	 * @param int $wikitextIdx
	 */
	function makeImage($title, $options, $holders = false) {
		wfProfileIn(__METHOD__);

		$wikitextIdx = RTEMarker::getDataIdx(RTEMarker::IMAGE_DATA, $options);

		// store wikitext for media placeholder rendering method
		self::$lastWikitext = RTEData::get('wikitext', $wikitextIdx);

		// call MW parser - image params will be populated
		parent::makeImage($title, $options, $holders);

		// maybe it's an image placeholder
		global $wgEnableImagePlaceholderExt;
		if (!empty($wgEnableImagePlaceholderExt)) {
			$isImagePlaceholder = ImagePlaceholderIsPlaceholder($title->getText());

			// pass rendered image placeholder
			if ($isImagePlaceholder) {
				// return HTML stored by renderMediaPlaceholder() method
				$ret = self::$mediaPlaceholder;

				wfProfileOut(__METHOD__);
				return $ret;
			}
		}

		// check that given image exists
		$image = wfFindFile($title);
		$isBrokenImage = empty($image);

		// render broken image placeholder
		if ($isBrokenImage) {
			// handle not existing images
			$ret = RTELinkerHooks::makeBrokenImageLinkObject($title, '', '', '', '', false, $wikitextIdx);

			wfProfileOut(__METHOD__);
			return $ret;
		}

		// get and merge image parameters returned by Parser::makeImage
		$params = array_merge(self::$imageParams['frame'], self::$imageParams['handler']);

		// cleanup
		if (isset($params['title'])) {
			unset($params['title']);
		}

		// generate image data
		$data = array(
			'type' => 'image',
			'wikitext' => RTEData::get('wikitext', $wikitextIdx),
			'title' => $title->getDBkey(),
		);

		// try to resolve internal links in image caption (RT #90616)
		if (RTEData::resolveLinksInMediaCaption($data['wikitext'])) {
			// now resolve link markers in caption parsed to HTML
			if (!empty($holders)) {
				$holders->replace($params['caption']);
			}

			RTE::log(__METHOD__ . ': resolved internal link');
		}

		// trigger an edgecase when image caption contains double brackets markers
		if (RTEData::checkWikitextForMarkers($data['wikitext'])) {
			RTE::$edgeCases[] = 'COMPLEX.09';
		}

		// small fix: set value of thumbnail entry
		if (isset($params['thumbnail'])) {
			$params['thumbnail'] = true;
		}

		// keep caption only for thumbs and framed images
		if (!isset($params['thumbnail']) && !isset($params['framed'])) {
			$params['caption'] = '';
		}

		// get "unparsed" caption from original wikitext and store parsed one as 'captionParsed'
		if ($params['caption'] != '') {
			$wikitext = trim($data['wikitext'], '[]');
			$wikitextParts = self::explodeImageArgs( $wikitext );

			// let's assume caption is the last part of image wikitext
			$originalCaption = end($wikitextParts);
			$originalCaption = htmlspecialchars_decode($originalCaption);

			// keep parsed caption and store its wikitext
			$params['captionParsed'] = $params['caption'];
			$params['caption'] = $originalCaption;
		}

		// pass link image parameter (BugId:6506)
		// this can be either link-title (internal links) or link-url (external links)
		if (isset($params['link-title']) && $params['link-title'] instanceof Title) {
			$params['link'] = $params['link-title']->getPrefixedText();
			unset($params['link-title']);
		}
		else if (isset($params['link-url'])) {
			$params['link'] = $params['link-url'];
			unset($params['link-url']);
		}

		// parameters are cleaned up - store them in image's meta data
		$data['params'] = $params;

		RTE::log(__METHOD__, $data);

		// image width
		$imageWidth = intval($image->getWidth());

		if (!empty($data['params']['width'])) {
			// width provided in wikitext
			$width = $data['params']['width'];

			// images with width provided should not be resized larger than the original file resolution (RT #41805)
			if ($imageWidth < $width) {
				$width = $imageWidth;
			}
		}
		// image height (RT #37266)
		// [[Image:foo|x250px|caption]]
		else if (!empty($data['params']['height'])) {
			$height = $data['params']['height'];

			$width = round( $image->getWidth() * ($height / $image->getHeight()) );
		}
		// thumb
		else if (isset($data['params']['thumbnail'])) {
			// width not provided - get default for thumbs
			global $wgUser, $wgThumbLimits;
			$wopt = $wgUser->getOption('thumbsize');

			if(!isset($wgThumbLimits[$wopt])) {
				$wopt = User::getDefaultOption('thumbsize');
			}

			$width = $wgThumbLimits[$wopt];

			// thumbed images should not be resized larger than the original file resolution
			if ($imageWidth < $width) {
				$width = $imageWidth;
			}
		}
		else {
			// full size
			$width = $image->getWidth();
		}

		// add extra CSS classes
		$imgClass = array('image');

		if (isset($data['params']['thumbnail'])) {
			$imgClass[] = 'thumb';
		}
		if (isset($data['params']['framed'])) {
			$imgClass[] = 'frame';
		}
		if (isset($data['params']['frameless'])) {
			$imgClass[] = 'frameless';
		}
		if (isset($data['params']['border'])) {
			$imgClass[] = 'border';
		}

		if (isset($data['params']['align'])) {
			$imgClass[] = 'align' . ucfirst($data['params']['align']);
		}
		if ($data['params']['caption'] != '') {
			$imgClass[] = 'withCaption';
		}

		// generate image thumbnail
		$thumb = $image->transform( array('width' => $width) );
		$thumbClass = get_class($thumb);

		// RT #25329
		if ($thumbClass == 'OggAudioDisplay') {
			$data['type'] = 'ogg-file';
			$ret = RTEMarker::generate(RTEMarker::PLACEHOLDER, RTEData::put('placeholder', $data));

			wfProfileOut(__METHOD__);
			return $ret;
		}

		$ret = $thumb->toHtml( array('img-class' => implode(' ', $imgClass)) );

		$mediaType = "image";

		$file = wfFindFile( $title );
		if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
			$mediaType = "video";
		}

		// add type attribute
		$ret = substr($ret, 0, -2). ' type="' . $mediaType .'" />';

		RTE::log(__METHOD__, $ret);

		// store data and mark HTML
		$ret = RTEData::addIdxToTag(RTEData::put('data', $data), $ret);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Render media (image / video) placeholder
	 */
	static public function renderMediaPlaceholder($data) {
		wfProfileIn(__METHOD__);

		global $wgBlankImgUrl;
		$attribs = array(
			'src' => $wgBlankImgUrl,
			'class' => "media-placeholder {$data['type']} thumb",
			'type' => $data['type'],
			'height' => intval($data['params']['height']),
			'width' => intval($data['params']['width']),
		);

		if (isset($data['params']['align'])) {
			$align = $data['params']['align'] ? $data['params']['align'] : 'none';
			$attribs['class'] .= ' align' . ucfirst($align);
		}

		// set original wikitext of none provided (used by ImagePlaceholder)
		if (!isset($data['wikitext'])) {
			$data['wikitext'] = self::$lastWikitext;
		}

		// render image for media placeholder
		$ret = Xml::element('img', $attribs);

		// store data and mark HTML
		$dataIdx = RTEData::put('data', $data);
		$ret = RTEData::addIdxToTag($dataIdx, $ret);

		// store marked HTML to be used by makeImage() method
		self::$mediaPlaceholder = $ret;

		RTE::log(__METHOD__, $data['wikitext']);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Handle ParserMakeImageParams hook (get parsed image options)
	 */
	static public function makeImageParams($title, $file, &$params) {
		wfProfileIn(__METHOD__);

		// run only when parsing for RTE
		global $wgRTEParserEnabled;
		if (empty($wgRTEParserEnabled)) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// store image params (to be used in makeImage)
		self::$imageParams = $params;

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * make an image if it's allowed, either through the global
	 * option, through the exception, or through the on-wiki whitelist
	 * @private
	 */
	function maybeMakeExternalImage( $url ) {
		wfProfileIn(__METHOD__);

		$text = parent::maybeMakeExternalImage($url);

		// MW parser has rendered an external whitelisted image
		if ($text !== false) {
			//RTE::log(__METHOD__, $url);

			// mark rendered image with RTE marker
			$data = array(
				'type' => 'image-whitelisted',
				'wikitext' => $url,
			);

			$text = RTEData::addIdxToTag(RTEData::put('data', $data), $text);
		}

		wfProfileOut(__METHOD__);
		return $text;
	}

	/**
	 * Convert wikitext to HTML and add extra HTML attributes for RTE
	 *
	 * @param $text String: text we want to parse
	 * @param $title A title object
	 * @param $options ParserOptions
	 * @param $linestart boolean
	 * @param $clearState boolean
	 * @param $revid Int: number to pass in {{REVISIONID}}
	 * @return ParserOutput a ParserOutput
	 */
	public function parse( $text, Title $title, ParserOptions $options, $linestart = true, $clearState = true, $revid = null ) {
		wfProfileIn(__METHOD__);

		// get rid of all \r in wikitext
		$text = str_replace("\r\n", "\n", $text);

		// count newlines at the beginning of the wikitext
		$emptyLinesAtStart = strspn($text, "\n");

		if ($emptyLinesAtStart > 0) {
			 // don't double count empty lines at the beginning of wikitext
			$this->emptyLinesBefore = $emptyLinesAtStart * -1;
		}

		// mark HTML entities from wikitext (&amp; &#58; &#x5f;)
		$text = self::markEntities($text);

		// set flag indicating parsing for CK
		global $wgRTEParserEnabled;
		$wgRTEParserEnabled = true;

		// don't use XML cache in preprocessor
		global $wgPreprocessorCacheThreshold;
		$wgPreprocessorCacheThreshold = 1000000;

		//RTE::log(__METHOD__ . '::beforeParse', $text);

		// parse to HTML
		$output = parent::parse($text, $title, $options, $linestart, $clearState, $revid);

		$wgRTEParserEnabled = false;

		// add extra RTE attributes to HTML elements (for correct handling of spaces and newlines when parsing back to wikitext)
		$html = $output->getText();

		// add RTE_EMPTY_LINES_BEFORE comment
		if ($emptyLinesAtStart > 0) {
			$html = RTEReverseParser::addEmptyLinesBeforeComment($emptyLinesAtStart) . $html;
		}

		//RTE::log(__METHOD__ . '::beforeReplace', $html);

		// wrap HTML entities inside span "placeholders" (&amp; &#58; &#x5f;)
		$html = self::wrapEntities($html);

		wfProfileIn(__METHOD__ . '::regexp');

		// remove EMPTY_LINES_BEFORE comments which are before closing tags - refs RT#38889
		// <!-- RTE_EMPTY_LINES_BEFORE_1 --></td></tr></table>  <= remove this one
		// <!-- RTE_EMPTY_LINES_BEFORE_1 --><p>
		$html = preg_replace('%<!-- RTE_EMPTY_LINES_BEFORE_(\d+) -->(</[^>]+></)%s', '\2', $html);

		// move empty lines counter data from comment to next opening tag attribute (thx to Marooned)
		$html = preg_replace('%<!-- RTE_EMPTY_LINES_BEFORE_(\d+) -->(?!<!)(.*?)(<[^/][^>]*)>%s', '\2\3 data-rte-empty-lines-before="\1">', $html);

		// remove not replaced EMPTY_LINES_BEFORE comments
		// <!-- RTE_EMPTY_LINES_BEFORE_1 -- data-rte-empty-lines-before="1">
		$html = preg_replace('%<!-- RTE_EMPTY_LINES_BEFORE_(\d+) [^>]+>%s', '', $html);

		// add data-rte-spaces-before for list items and table cells
		$html = preg_replace_callback("/<(li|dd|dt|td|th)([^>]*)>(\x20+)/", 'RTEParser::spacesBeforeCallback', $html);

		// replace placeholder markers with placeholders
		$html = preg_replace_callback("/\x7f-01-(\d{4})/", 'RTE::replacePlaceholder', $html);

		// replace dataidx attribute with data-rte-meta attribute storing JSON encoded meta data
		$html = preg_replace_callback('/ _rte_dataidx="(\d{4})" /', 'RTEData::replaceIdxByData', $html);

		$html = preg_replace("/\x7f-(?:".RTEMarker::INTERNAL_WIKITEXT."|".RTEMarker::EXTERNAL_WIKITEXT.")-\d{4}/", '', $html);
		// RT#40786: add empty paragraphs between headings (</h3>\n<h3 ...)
		$html = preg_replace("%(</h\d>\s)(<h\d)%s", '$1<p data-rte-filler="true"></p>$2', $html);

		wfProfileOut(__METHOD__ . '::regexp');

		// add extra attribute for p tags coming from parser
		$html = strtr($html, array('<p>' => '<p data-rte-fromparser="true">', '<p ' => '<p data-rte-fromparser="true" '));

		// add empty paragraph for new / empty pages
		if ($html == '') {
			$html = Xml::element('p');
		}

		// update parser output
		RTE::log(__METHOD__, $html);
		$output->setText($html);

		wfProfileOut(__METHOD__);
		return $output;
	}

	/**
	 * Special handling of entities when doing internal links parsing (RT #38844)
	 */
	public function replaceInternalLinks2(&$s) {
		wfProfileIn(__METHOD__);

		// use MW parser to parse internal links
		$holders = parent::replaceInternalLinks2($s);

		// add now let's mark entities in captions of internal links
		if (!empty($holders->internals)) {
			foreach ($holders->internals as &$entries) {
				foreach ($entries as &$entry) {
					$entry['text'] = self::markEntities($entry['text']);
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $holders;
	}

	public function makeKnownLinkHolder( $nt, $text = '', $query = '', $trail = '', $prefix = '' ) {
		wfProfileIn(__METHOD__);

		$dataIdx = RTEMarker::getDataIdx(RTEMarker::INTERNAL_DATA, $text);
		$ret = parent::makeKnownLinkHolder($nt, $text, $query, $trail, $prefix);
		$ret = RTEData::addIdxToTag($dataIdx, $ret);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	public function doDoubleUnderscore( $text ) {
		wfProfileIn(__METHOD__);

		$mwa = MagicWord::getDoubleUnderscoreArray();
		$regexes = $mwa->getRegex();
		foreach($regexes as $regex) {
			if($regex === '') continue;
			$text = preg_replace_callback($regex, 'RTEParser::doDoubleUnderscoreReplace', $text);
		}

		wfProfileOut(__METHOD__);
		return $text;
	}

	public static function doDoubleUnderscoreReplace($matches) {
		wfProfileIn(__METHOD__);

		$dataIdx = RTEData::put('placeholder', array('type' => 'double-underscore', 'wikitext' => $matches[0]));
		$ret = RTEMarker::generate(RTEMarker::PLACEHOLDER, $dataIdx);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	public function getStripList() {
		return array_merge((array)parent::getStripList(), array('noinclude', 'includeonly', 'onlyinclude', 'references'));
	}

	/**
	 * Callback for marking table cells added using short markup
	 */
	private static function shortRowMarkupCallback($matches) {
		wfProfileIn(__METHOD__);

		$ret = $matches[0] . ' data-rte-short-row-markup="true"';

		$spacesAfterLastCell = strlen($matches[1]);
		if ($spacesAfterLastCell > 0) {
			$ret .= " data-rte-spaces-after-last-cell=\"{$spacesAfterLastCell}\"";
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Callback for marking list items and table cells
	 */
	private static function spacesBeforeCallback($matches) {
		wfProfileIn(__METHOD__);

		$spacesBefore = strlen($matches[3]);
		$ret = "<{$matches[1]}{$matches[2]} data-rte-spaces-before=\"{$spacesBefore}\">";

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Mark HTML entities using \x7f "magic" character
	 */
	public static function markEntities($text) {
		wfProfileIn(__METHOD__);

		$res = preg_replace('%&(#?[\w\d]+);%s', "\x7f-ENTITY-\\1-\x7f", $text);

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Unmark HTML entities marked using \x7f "magic" character (and decode not marked HTML entities if requested)
	 */
	public static function unmarkEntities($text, $decode = false) {
		wfProfileIn(__METHOD__);

		if ($decode) {
			$text = htmlspecialchars_decode($text);
		}

		$res = preg_replace("%\x7f-ENTITY-(#?[\w\d]+)-\x7f%", '&\1;', $text);

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Wrap marked HTML entities inside <span> placeholders
	 */
	private static function wrapEntities($text) {
		wfProfileIn(__METHOD__);

		$res = preg_replace("%\x7f-ENTITY-(#?[\w\d]+)-\x7f%", '<span data-rte-entity="\1">&\1;</span>', $text);

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Generate data-rte-attribs attribute storing original list of HTML node attributes
	 */
	public static function encodeAttributesStr($attribs) {
		wfProfileIn(__METHOD__);

		$encoded = Sanitizer::encodeAttribute($attribs);

		// encode &quot; entity (fix for IE) and &#039; entity (RT #55179)
		$encoded = strtr($encoded, array(
			'&quot;' => "\x7f",
			'&#039;' => '\'',
		));

		$ret = "data-rte-attribs=\"{$encoded}\"";

		wfProfileOut(__METHOD__);

		return $ret;
	}

	/**
	 * Correctly splits out pipe-separated image arguments (solves bugid: 2240)
	 * @param  string $wikiText
	 * @return array
	 */
	public static function explodeImageArgs( $wikiText ) {
		wfProfileIn(__METHOD__);
		$bracketContext = false;
		$counter		= 0;
		$results		= array();
		$length			= strlen( $wikiText );
		$substr			= '';

		while ( $counter < $length ) {
			$char = $wikiText[$counter++];

			switch ( $char ) {
				case ']':
				    $bracketContext = false;
				    $substr .= $char;
				    break;
				case '|':
					if (! $bracketContext ) {
						$results[] = $substr;
						$substr = '';
						break;
					}
				case '[':
				    $bracketContext = true;
				default:
					$substr .= $char;
			}
		}

		if ( ! empty( $substr ) ) {
			$results[]  = $substr;
		}
		wfProfileOut(__METHOD__);
		return $results;
	}
}
