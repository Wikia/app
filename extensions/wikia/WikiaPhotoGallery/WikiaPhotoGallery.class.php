<?php
/**
 * This class renders Wikia custom galleries created using <gallery> tag.
 *
 * Supported <gallery> tag attributes:
 *  - caption
 *  - captionalign
 *  - perrow
 *  - type
 *  - widths
 *
 * 'heights' attribute is ignored
 *
 */

class WikiaPhotoGallery extends ImageGallery {

	const WIKIA_PHOTO_GALLERY = 1;
	const WIKIA_PHOTO_SLIDESHOW = 2;

	const RESULTS_RECENT_UPLOADS = 0;
        const RESULTS_IMAGES_FROM_THIS_PAGE = 1;

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

	/**
	 * Gallery or slideshow?
	 */
	private $mType;

	/**
	 * Is slideshow using "crop" attribute
	 */
	private $mCrop = false;

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

		// set gallery type
		if (!empty($params['type']) && $params['type'] == 'slideshow') {
			$this->mType = self::WIKIA_PHOTO_SLIDESHOW;

			// use default slideshow width if "widths" attribute is not provided
			if (!isset($params['widths'])) {
				$this->setWidths(300);
			}

			// support "crop" attribute
			if (isset($params['crop']) && $params['crop'] == 'true') {
				$this->mCrop = true;
			}
		}
		else {
			$this->mType = self::WIKIA_PHOTO_GALLERY;
		}

		// calculate "unique" hash of each gallery
		$this->calculateHash();
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
	 * Calculate and store hash of current gallery / slideshow
	 */
	private function calculateHash() {
		$this->mData['hash'] = md5($this->mText);
	}

	/**
	 * Add an image to the gallery.
	 *
	 * @param $title Title object of the image that is added to the gallery
	 * @param $html  String: additional HTML text to be shown. The name and size of the image are always shown.
	 * @param $link  String: value of link= parameter
	 */
	function add($title, $html='', $link='') {
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
			$link = $linktext = '';
			foreach($parts as $part) {
				if (substr($part, 0, 5) == 'link=') {
					$link = substr($part, 5);
				}
				else if (substr($part, 0, 9) == 'linktext=') {
					$linktext = substr($part, 9);
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
				'linktext' => $linktext,
			);

			// use global instance of parser (RT #44689 / RT #44712)
			$caption = $this->mParser->recursiveTagParse($caption);

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
			'type' => $this->mType,
			'images' => $this->mData['images'],
			'params' => (object) $this->mData['params'],
			'hash' => $this->mData['hash']
		);
	}

	/**
	 * Parse given link and return link tag attributes
	 */
	private function parseLink($nt, $link) {
		return WikiaPhotoGalleryHelper::parseLink($this->mParser, $nt, $link);
	}

	/**
	 * Return a HTML representation of the image gallery / slideshow
	 */
	public function toHTML() {
		global $wgRTEParserEnabled;

		wfProfileIn(__METHOD__);

		// render as placeholder in RTE
		if (!empty($wgRTEParserEnabled)) {
			if ($this->mType == self::WIKIA_PHOTO_GALLERY) {
				// gallery: 200x200px placeholder
				$width = $height = 200;
			}
			else {
				// slideshow: use user specified size
				$width = $this->mWidths;
				$height = round($this->mWidths * 3 / 4);
			}

			$out = WikiaPhotoGalleryHelper::renderGalleryPlaceholder($this->getData(), $width, $height);

			wfProfileOut(__METHOD__);
			return $out;
		}

		switch($this->mType) {
			case self::WIKIA_PHOTO_GALLERY:
				$out = $this->renderGallery();
				break;

			case self::WIKIA_PHOTO_SLIDESHOW:
				$out = $this->renderSlideshow();
				break;
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
 	 * Return a HTML representation of the image gallery
	 *
	 * The new gallery disables the old perrow control, and automatically fit the gallery to the available space in the browser.
	 */
	private function renderGallery() {
		global $wgLang, $wgBlankImgUrl;

		wfProfileIn(__METHOD__);

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
		foreach ($this->mImages as $pair) {
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

				// let's render redlink for not existing image
				$height = floor( 1.25*$this->mHeights ) - 4;

				$thumbhtml = "\n\t\t\t".
					Xml::openElement('div', array(
						'class' => 'thumb broken-image neutral',
						'style' => "height: {$height}px; width: " . ($this->mWidths+30) . 'px'
					))
					. Xml::openElement('span', array('style' => "line-height: {$height}px"))
					. $sk->link($nt)
					. Xml::closeElement('span')
					. Xml::closeElement('div');

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

				// parse link
				$linkAttribs = $this->parseLink($nt, $link);

				// generate thumbnail
				$imgTag = Xml::element('img', array(
					'alt' => $linkAttribs['title'],
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
					. Xml::openElement('a', $linkAttribs)
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
				. $textlink
				. '<div class="lightbox-caption">'
				. $text
				. '</div>'
				. $nb
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

	/**
 	 * Return a HTML representation of the image slideshow
	 */
	private function renderSlideshow() {
		global $wgLang, $wgBlankImgUrl, $wgStylePath;

		wfProfileIn(__METHOD__);
		$sk = $this->getSkin();

		// slideshow wrapper CSS class
		$class = 'wikia-slideshow clearfix';

		$id = "slideshow-{$this->mData['id']}";

		// do not add button for galleries from templates
		if (isset($this->mData['params']['source']) && $this->mData['params']['source'] == "template\x7f") {
			$class .= ' template';
		}

		// wrap image slideshow inside div.slideshow
		$attribs = Sanitizer::mergeAttributes(
			array(
				'class' => $class,
				'hash' => $this->mData['hash'],
				'id' => $id,
				'style' => 'width: ' . ($this->mWidths + 10) . 'px',
			),
			$this->mAttribs );
		$s = Xml::openElement('div', $attribs);

		// render slideshow caption
		if ($this->mCaption) {
			$s .= '<div class="wikia-slideshow-caption">' . $this->mCaption . '</div>';
		}

		// fit images inside width:height = 4:3 box
		$this->mHeights = round($this->mWidths * 3 / 4);
		$params = array('width' => $this->mWidths, 'height' => $this->mHeights);

		wfDebug(__METHOD__ . ": slideshow {$params['width']}x{$params['height']}\n");

		$s .= Xml::openElement('div', array('class' => 'wikia-slideshow-wrapper'));

		// wrap images inside <div> and <ul>
		$s .= Xml::openElement('div', array('class' => 'wikia-slideshow-images-wrapper accent'));
		$s .= Xml::openElement('ul', array(
			'class' => 'wikia-slideshow-images neutral',
			'style' => "height: {$params['height']}px; width: {$params['width']}px",
		));

		wfLoadExtensionMessages('WikiaPhotoGallery');

		$i = 0;
		foreach ($this->mImages as $p => $pair) {
			$nt = $pair[0];
			$text = $pair[1];
			$link = $pair[2];

			# Give extensions a chance to select the file revision for us
			$time = $descQuery = false;
			wfRunHooks( 'BeforeGalleryFindFile', array( &$this, &$nt, &$time, &$descQuery ) );

			$img = wfFindFile( $nt, $time );

			// let's properly scale image (don't make it bigger than original size) and handle "crop" attribute
			if (is_object($img) && ($nt->getNamespace() == NS_FILE)) {
				$thumbParams = WikiaPhotoGalleryHelper::getThumbnailDimensions($img, $params['width'], $params['height'], $this->mCrop);
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
				$caption = $linkOverlay = '';

				// render caption overlay
				if ($text != '') {
					$caption = Xml::openElement('span', array('class' => 'wikia-slideshow-image-caption'))
						. Xml::openElement('span', array('class' => 'wikia-slideshow-image-caption-inner'))
						. $text
						. Xml::closeElement('span')
						. Xml::closeElement('span');
				}

				// parse link
				$linkAttribs = $this->parseLink($nt, $link);

				// extra link tag attributes
				$linkAttribs['id'] = "{$id}-{$i}";
				$linkAttribs['style'] = 'width: ' . ($params['width'] - 80) . 'px';

				if ($link == '') {
					// tooltip to be used for not-linked images
					$linkAttribs['title'] = wfMsg('wikiaPhotoGallery-slideshow-view-popout-tooltip');
					$linkAttribs['class'] = 'wikia-slideshow-image';
					unset($linkAttribs['href']);
				}
				else {
					// linked images
					$linkAttribs['class'] .= ' wikia-slideshow-image';

					// support |linktext= syntax
					if ($this->mData['images'][$p]['linktext'] != '') {
						$linkText = $this->mData['images'][$p]['linktext'];
					}
					else {
						$linkText = $link;
					}

					// add link overlay
					$linkOverlay = Xml::openElement('span', array('class' => 'wikia-slideshow-link-overlay'))
						. wfMsg('wikiaPhotoGallery-slideshow-view-link-overlay', $linkText)
						. Xml::closeElement('span');
				}

				// generate HTML for a single slideshow image
				$liAttribs = array(
					'title' => $thumb->url,
				);

				// add CSS class so we can show first slideshow image before JS is loaded
				if ($i == 0) {
					$liAttribs['class'] = 'wikia-slideshow-first-image';
				}

				$s .= Xml::openElement('li', $liAttribs)
					. Xml::element('a', $linkAttribs, ' ')
					. $caption
					. $linkOverlay
					. '</li>';

				$i++;

				// Call parser transform hook
				if ( $this->mParser && $img->getHandler() ) {
					$img->getHandler()->parserTransformHook( $this->mParser, $img );
				}

				wfDebug(__METHOD__ . ": image '" . $nt->getText() . "' {$thumb->width}x{$thumb->height}\n");
			}
		}

		$s .= Xml::closeElement('ul');
		$s .= Xml::closeElement('div');

		// render prev/next buttons
		$top = ($params['height'] >> 1) - 30 /* button height / 2 */ + 5 /* top border of slideshow area */;
		$s .= Xml::openElement('div', array('class' => 'wikia-slideshow-prev-next'));
		$s .= Xml::element('a',
			array('class' => 'wikia-slideshow-sprite wikia-slideshow-prev', 'style' => "top: {$top}px", 'title' => wfMsg('wikiaPhotoGallery-slideshow-view-prev-tooltip')),
			' ');
		$s .= Xml::element('a',
			array('class' => 'wikia-slideshow-sprite wikia-slideshow-next', 'style' => "top: {$top}px", 'title' =>  wfMsg('wikiaPhotoGallery-slideshow-view-next-tooltip')),
			' ');
		$s .= Xml::closeElement('div');

		// render slideshow toolbar
		$s .= Xml::openElement('div', array('class' => 'wikia-slideshow-toolbar clearfix', 'style' => 'display: none'));

		// Pop-out icon, "X of X" counter
		$counterValue = wfMsg('wikiaPhotoGallery-slideshow-view-number', '$1', $i);

		$s .= Xml::openElement('div', array('style' => 'float: left'));
			$s .= Xml::element('img',
				array(
					'class' => 'wikia-slideshow-popout',
					'height' => 11,
					'src' => "{$wgStylePath}/common/images/magnify-clip.png",
					'title' => wfMsg('wikiaPhotoGallery-slideshow-view-popout-tooltip'),
					'width' => 15,
				));
			$s .= Xml::element('span',
				array('class' => 'wikia-slideshow-toolbar-counter', 'value' => $counterValue),
				str_replace('$1', '1', $counterValue));
		$s .= Xml::closeElement('div');

		// "Add Image"
		$s .= Xml::element('a',
			array('class' => 'wikia-slideshow-addimage wikia-button secondary', 'style' => 'float: right'),
			wfMsg('wikiaPhotoGallery-slideshow-view-addphoto'));
		$s .= Xml::closeElement('div');

		// close slideshow wrapper
		$s .= Xml::closeElement('div');
		$s .= Xml::closeElement('div');

		// output JS to init slideshow
		$width = "{$params['width']}px";

		$js = <<<JS
wgAfterContentAndJS.push(function() {
	$.getScript(stylepath + '/common/jquery/jquery-slideshow-0.4.js?' + wgStyleVersion, function() {
		var slideshow = $('#$id');

		slideshow.find('li').each(function() {
			var item = $(this);

			item.css('backgroundImage', 'url(' + item.attr('title') + ')');
			item.removeAttr('title');
		});

		slideshow.slideshow({
			buttonsClass:	'wikia-button',
			nextClass:	'wikia-slideshow-next',
			prevClass:	'wikia-slideshow-prev',
			slideWidth:	'$width',
			slidesClass:	'wikia-slideshow-images'
		});

		$().log('#$id initialized', 'Slideshow');
	});
});
JS;

		// remove whitespaces from inline JS code
		$js = preg_replace("#[\n\t]+#", '', $js);
		$s .= '<script type="text/javascript">/*<![CDATA[*/' . $js . '/*]]>*/</script>';

		wfProfileOut(__METHOD__);
		return $s;
	}
}
