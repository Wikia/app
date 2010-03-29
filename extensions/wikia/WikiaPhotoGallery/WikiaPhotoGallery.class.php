<?php
/**
 * This class renders Wikia custom galleries created using <gallery> tag.
 *
 * Supported <gallery> tag attributes:
 *  - caption
 *  - captionalign
 *  - perrow
 *  - widths
 *
 * 'heights' attribute is ignored
 *
 */

class WikiaPhotoGallery extends ImageGallery {

	/**
	 * Content of parsed <gallery> tag
	 */
	private $mText;

	/**
	 * Store gallery data (tag attributes, list of images)
	 */
	private $mData;

	/**
	 * Selected captions alignment
	 */
	private $mCaptionsAlign;

	/**
	 * Galleries counter for view mode
	 */
	private static $galleriesCounter = 0;

	function __construct() {
		parent::__construct();

		$this->mData = array(
			'id' => false,
			'params' => array(),
			'images' => array(),
			'hash' => false
		);

		// allows galleries to take up the full width of a page
		$this->mPerRow = 0;
	}

	/**
	 * Store content of parsed <gallery> tag
	 */
	public function setText($text) {
		$this->mText = $text;
		$this->mData['hash'] = md5($text);
	}

	/**
	 * Store attributes of parsed <gallery> tag
	 */
	public function setParams($params) {
		$this->mData['params'] = $params;

		// "columns" - alias for perrow
		if (!empty($params['columns'])) {
			$this->setPerRow($params['columns']);
		}
	}

	/**
	 * Set alignment (left/center/right) of all captions in the gallery
	 */
	public function setCaptionsAlign($align) {
		$align = strtolower($align);

		if (in_array($align, array('center', 'right'))) {
			$this->mCaptionsAlign = $align;
		}
	}

	/**
	 * "height" attribute is ignored
	 */
	public function setHeights($num) {}

	/**
	 * Add an image to the gallery.
	 *
	 * @param $title Title object of the image that is added to the gallery
	 * @param $html  String: additional HTML text to be shown. The name and size of the image are always shown.
	 * @param $link  String: value of link= parameter
	 */
	function add($title, $html='', $link='') {
		if ($title instanceof File) {
			// Old calling convention
			$title = $title->getTitle();
		}
		$this->mImages[] = array($title, $html, $link);
		wfDebug( __METHOD__ . ' - ' . $title->getText() . "\n" );
	}

	/**
	 * Parse content of <gallery> tag (add images with captions and links provided)
	 */
	public function parse() {
		global $wgTitle;
		wfProfileIn(__METHOD__);

		$lines = StringUtils::explode("\n", $this->mText);

		if (count($lines)) {
			$parser = new Parser();
			$parser->mOptions = new ParserOptions();
			$parser->setTitle($wgTitle);
			$parser->clearState();
		}
		foreach ($lines as $line) {
			if ($line == '') {
				continue;
			}

			$parts = (array) StringUtils::explode('|', $line);

			// get name of an image from current line and remove it from list of params
			$imageName = array_shift($parts);

			if (strpos($line, '%') !== false) {
				$imageName = urldecode($imageName);
			}

			// Allow <gallery> to accept image names without an Image: prefix
			$tp = Title::newFromText($imageName, NS_FILE);
			$nt =& $tp;
			if (is_null($nt)) {
				// Bogus title. Ignore these so we don't bomb out later.
				continue;
			}

			// search for caption and link= param
			$captionParts = array();
			$link = '';
			foreach($parts as $part) {
				if (substr($part, 0, 5) == 'link=') {
					$link = substr($part, 5);
				}
				else {
					$captionParts[] = trim($part);
				}
			}

			// support captions with internal links with pipe (Foo.jpg|link=Bar|[[test|link]])
			$caption = implode('|', $captionParts);

			// store list of images (to be used by front-end)
			$this->mData['images'][] = array(
				'name' => $imageName,
				'caption' => $caption,
				'link' => $link,
			);

			$caption = $parser->parse($caption, $wgTitle, $parser->mOptions)->getText();
			$this->add($nt, $caption, $link);

			// Only add real images (bug #5586)
			if ($nt->getNamespace() == NS_FILE) {
				$this->mParser->mOutput->addImage($nt->getDBkey());
			}
		}

		// store ID of gallery
		$this->mData['id'] = self::$galleriesCounter++;

		wfProfileOut(__METHOD__);
	}

	/**
	 * Get image gallery data (tag parameters, list of images and their parameters)
	 *
	 * This data is used by JS front-end in Wysiwyg editor. Cast to object is needed to properly handle params in JS code.
	 */
	public function getData() {
		return array(
			'id' => $this->mData['id'],
			'images' => $this->mData['images'],
			'params' => (object) $this->mData['params'],
			'hash' => $this->mData['hash']
		);
	}

	/**
	 * Return a HTML representation of the image gallery
	 *
	 * The new gallery disables the old perrow control, and automatically fit the gallery to the available space in the browser.
	 */
	public function toHTML() {
		global $wgLang, $wgRTEParserEnabled, $wgBlankImgUrl;

		wfProfileIn(__METHOD__);

		// render as placeholder in RTE
		if (!empty($wgRTEParserEnabled)) {
			$out = WikiaPhotoGalleryHelper::renderGalleryPlaceholder($this->getData(), 200, 200);

			wfProfileOut(__METHOD__);
			return $out;
		}

		$sk = $this->getSkin();

		// gallery wrapper CSS class
		$class = 'wikia-gallery clearfix';
		if (!empty($this->mCaptionsAlign)) {
			$class .= " wikia-gallery-captions-{$this->mCaptionsAlign}";
		}
		// do not add button for galleries from templates
		if (isset($this->mData['params']['source']) && $this->mData['params']['source'] == "template\x7f") {
			$class .= ' template';
		}

		// wrap image gallery inside div.gallery
		$attribs = Sanitizer::mergeAttributes(
			array(
				'class' => $class,
				'hash' => $this->mData['hash'],
				'id' => 'gallery-' . $this->mData['id']
			),
			$this->mAttribs );
		$s = Xml::openElement('div', $attribs);

		// render gallery caption
		if ($this->mCaption) {
			$s .= '<div class="wikia-gallery-caption">' . $this->mCaption . '</div>';
		}

		// fit images inside (width)x(width) box
		$this->mHeights = $this->mWidths;
		$params = array('width' => $this->mWidths, 'height' => $this->mHeights);

		// perrow = columns
		$perRow = intval($this->mPerRow);
		$inRow = 0;

		// open row wrapper when using "perrow" attribute
		if ($perRow) {
			$s .= Xml::openElement('div', array('class' => 'wikia-gallery-row'));
		}

		// render each image
		$i = 0;
		foreach ( $this->mImages as $pair ) {
			$nt = $pair[0];
			$text = $pair[1];
			$link = $pair[2];

			# Give extensions a chance to select the file revision for us
			$time = $descQuery = false;
			wfRunHooks( 'BeforeGalleryFindFile', array( &$this, &$nt, &$time, &$descQuery ) );

			$img = wfFindFile( $nt, $time );

			// let's properly scale image (don't make it bigger than original size)
			if (is_object($img) && ($nt->getNamespace() == NS_FILE)) {
				$thumbParams = array(
					'height' => min($img->getHeight(), $params['height']),
					'width' => min($img->getWidth(), $params['width']),
				);
			}

			if( $nt->getNamespace() != NS_FILE || !$img ) {
				# We're dealing with a non-image, spit out the name and be done with it.
				$thumbhtml = "\n\t\t\t".'<div style="height: '.($this->mHeights*1.25+2).'px;">'
					. htmlspecialchars( $nt->getText() ) . '</div>';
			} elseif( $this->mHideBadImages && wfIsBadImage( $nt->getDBkey(), $this->getContextTitle() ) ) {
				# The image is blacklisted, just show it as a text link.
				$thumbhtml = "\n\t\t\t".'<div style="height: '.($this->mHeights*1.25+2).'px;">'
					. $sk->makeKnownLinkObj( $nt, htmlspecialchars( $nt->getText() ) ) . '</div>';
			} elseif( !( $thumb = $img->transform( $thumbParams ) ) ) {
				# Error generating thumbnail.
				$thumbhtml = "\n\t\t\t".'<div style="height: '.($this->mHeights*1.25+2).'px;">'
					. htmlspecialchars( $img->getLastError() ) . '</div>';
			} else {
				$vpad = floor( ( 1.25*$this->mHeights - $thumb->height ) /2 ) - 2;

				// fallback: link to image page + lightbox
				$linkParams = array(
					'class' => 'image lightbox',
					'href' => $nt->getLocalUrl(),
					'title' => $nt->getText(),
				);

				// "caption" attribute is used by ImageLightbox extension
				if ($text != '') {
					$linkParams['caption'] = $text;
				}

				// detect internal / external links (|links= param)
				if ($link != '') {
					$chars = Parser::EXT_LINK_URL_CLASS;
					$prots = $this->mParser->mUrlProtocols;

					if (preg_match( "/^$prots/", $link)) {
						if (preg_match( "/^($prots)$chars+$/", $link, $m)) {
							// external link found
							$this->mParser->mOutput->addExternalLink($link);

							$linkParams['class'] = 'image link-external';
							$linkParams['href'] = $link;
							$linkParams['title'] = $link;
						}
					} else {
						$linkTitle = Title::newFromText($link);
						if ($linkTitle) {
							// internal link found
							$this->mParser->mOutput->addLink( $linkTitle );

							$linkParams['class'] = 'image link-internal';
							$linkParams['href'] = $linkTitle->getLocalUrl();
							$linkParams['title'] = $link;
						}
					}
				}

				// generate thumbnail
				$imgTag = Xml::element('img', array(
					'alt' => $linkParams['title'],
					'height' => $thumb->getHeight(),
					'src' => $thumb->url,
					'width' => $thumb->getWidth(),
				));

				$thumbhtml = "\n\t\t\t".
					Xml::openElement('div', array(
						'class' => 'thumb neutral',
						'style' => "padding: {$vpad}px 0; width: " . ($this->mWidths+30) . 'px'
					))
					# Auto-margin centering for block-level elements. Needed now that we have video
					# handlers since they may emit block-level elements as opposed to simple <img> tags.
					# ref http://css-discuss.incutio.com/?page=CenteringBlockElement
					. Xml::openElement('div', array(
						'style' => "width: {$this->mWidths}px",
					))

					# Add links for images (from |link= param) or link them to image page (and use JS lightbox)
					. Xml::openElement('a', $linkParams)
					. $imgTag
					. '</a></div></div>';

				// Call parser transform hook
				if ( $this->mParser && $img->getHandler() ) {
					$img->getHandler()->parserTransformHook( $this->mParser, $img );
				}
			}

			//TODO
			//$ul = $sk->makeLink( $wgContLang->getNsText( MWNamespace::getUser() ) . ":{$ut}", $ut );

			if( $this->mShowBytes ) {
				if( $img ) {
					$nb = wfMsgExt( 'nbytes', array( 'parsemag', 'escape'),
						$wgLang->formatNum( $img->getSize() ) );
				} else {
					$nb = wfMsgHtml( 'filemissing' );
				}
				$nb = "$nb<br />\n";
			} else {
				$nb = '';
			}

			$textlink = $this->mShowFilename ?
				$sk->makeKnownLinkObj( $nt, htmlspecialchars( $wgLang->truncate( $nt->getText(), 20 ) ) ) . "<br />\n" :
				'' ;

			// generate HTML for a single image from gallery
			$s .= Xml::openElement('span', array(
					'class' => 'wikia-gallery-item',
					'style' => 'width: '.($this->mWidths+35).'px'
				))
				. $thumbhtml
				. $textlink . $text . $nb
				. '</span>';

			// handle "perrow" attribute
			if ($perRow) {
				$inRow++;

				if ($i % $perRow == $perRow-1) {
					$s .= Xml::closeElement('div');

					$inRow = 0;

					// is next row needed?
					if ($i < count($this->mImages) - 1) {
						$s .= Xml::openElement('div', array('class' => 'wikia-gallery-row'));
					}
				}
			}

			// increment gallery images counter
			$i++;
		}

		// close gallery row when using "perrow" attribute
		if ($perRow && $inRow) {
			$s .= Xml::closeElement('div');
		}

		// "Add image to this gallery" button (this button is shown by JS only in Monaco)
		wfLoadExtensionMessages('WikiaPhotoGallery');

		if (!$perRow) {
			$s .= Xml::element('br');
		}
		$s .= Xml::openElement('div', array('class' => 'wikia-gallery-add noprint', 'style' => 'display: none'));
		$s .= Xml::element('img', array('src' => $wgBlankImgUrl, 'class' => 'sprite-small add'));
		$s .= Xml::element('a', array('href' => '#'), wfMsgForContent('wikiaPhotoGallery-viewmode-addphoto'));
		$s .= Xml::closeElement('div');

		// close gallery wrapper
		$s .= Xml::closeElement('div');

		wfProfileOut(__METHOD__);

		return $s;
	}
}
