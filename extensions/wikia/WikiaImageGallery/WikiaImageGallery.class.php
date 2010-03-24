<?php

class WikiaImageGallery extends ImageGallery {

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

	function __construct() {
		parent::__construct();

		$this->mData = array(
			'params' => array(),
			'images' => array(),
		);
	}

	/**
	 * Store content of parsed <gallery> tag
	 */
	public function setText($text) {
		$this->mText = $text;
	}

	/**
	 * Store attributes of parsed <gallery> tag
	 */
	public function setParams($params) {
		$this->mData['params'] = $params;
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
	 * "perrow" and "height" attributes are ignored
	 */
	public function setPerRow($num) {}
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
		wfDebug( __METHOD__ . $title->getText() . "\n" );
	}

	/**
	 * Parse content of <gallery> tag (add images with captions and links provided)
	 */
	public function parse() {
		wfProfileIn(__METHOD__);

		$lines = StringUtils::explode("\n", $this->mText);
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
			$caption = $link = '';
			foreach($parts as $part) {
				if (substr($part, 0, 5) == 'link=') {
					$link = substr($part, 5);
				}
				else {
					$caption = trim($part);
				}
			}

			// store list of images (to be used by front-end)
			$this->mData['images'][] = array(
				'name' => $imageName,
				'caption' => $caption,
				'link' => $link,
			);

			$this->add($nt, $this->mParser->recursiveTagParse($caption), $link);

			// Only add real images (bug #5586)
			if ($nt->getNamespace() == NS_FILE) {
				$this->mParser->mOutput->addImage($nt->getDBkey());
			}

			//print_pre($line);print_pre($parts);
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Get image gallery data (tag parameters, list of images and their parameters)
	 */
	public function getData() {
		return $this->mData;
	}

	/**
	 * Return a HTML representation of the image gallery
	 *
	 * The new gallery disables the old perrow control, and automatically fit the gallery to the available space in the browser.
	 */
	public function toHTML() {
		global $wgLang, $wgRTEParserEnabled;

		wfProfileIn(__METHOD__);

		// render as placeholder in RTE
		if (!empty($wgRTEParserEnabled)) {
			$out = WikiaImageGalleryHelper::renderGalleryPlaceholder($this->getData(), 200, 200);

			wfProfileOut(__METHOD__);
			return $out;
		}

		$sk = $this->getSkin();

		// gallery wrapper CSS class
		$class = 'wikia-gallery clearfix';
		if (!empty($this->mCaptionsAlign)) {
			$class .= " wikia-gallery-captions-{$this->mCaptionsAlign}";
		}

		// wrap image gallery inside div.gallery
		$attribs = Sanitizer::mergeAttributes(
			array(
				'class' => $class,
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

			if( $nt->getNamespace() != NS_FILE || !$img ) {
				# We're dealing with a non-image, spit out the name and be done with it.
				$thumbhtml = "\n\t\t\t".'<div style="height: '.($this->mHeights*1.25+2).'px;">'
					. htmlspecialchars( $nt->getText() ) . '</div>';
			} elseif( $this->mHideBadImages && wfIsBadImage( $nt->getDBkey(), $this->getContextTitle() ) ) {
				# The image is blacklisted, just show it as a text link.
				$thumbhtml = "\n\t\t\t".'<div style="height: '.($this->mHeights*1.25+2).'px;">'
					. $sk->makeKnownLinkObj( $nt, htmlspecialchars( $nt->getText() ) ) . '</div>';
			} elseif( !( $thumb = $img->transform( $params ) ) ) {
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
						}
					} else {
						$linkTitle = Title::newFromText($link);
						if ($linkTitle) {
							// internal link found
							$this->mParser->mOutput->addLink( $linkTitle );

							$linkParams['class'] = 'image link-internal';
							$linkParams['href'] = $linkTitle->getLocalUrl();
						}
					}
				}

				$thumbhtml = "\n\t\t\t".
					Xml::openElement('div', array(
						'class' => 'thumb',
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
					. $thumb->toHtml()
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
		}

		// clear the float introduced by display: inline-block
		$s .= '<div></div>';

		// "Add image to this gallery" button (this button is shown by JS only in Monaco)
		wfLoadExtensionMessages('WikiaImageGallery');

		$s .= Xml::openElement('div', array('class' => 'wikia-gallery-add noprint', 'style' => 'display: none'));
		$s .= Xml::element('a', array('href' => '#'), wfMsgForContent('wig-add-picture-to-gallery'));
		$s .= Xml::closeElement('div');

		// close gallery wrapper
		$s .= Xml::closeElement('div');

		wfProfileOut(__METHOD__);

		return $s;
	}
}
