<?php
/**
 * This class renders Wikia custom galleries created using <gallery> tag.
 *
 * Supported <gallery> tag attributes:
 *  - caption
 *  - captionalign
 *  - perrow
 *  - position
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

	const RECENT_UPLOADS_IMAGES = 20;

	/**
	 * Content of parsed <gallery> tag
	 */
	private $mText;

	/**
	 * Store gallery data (tag attributes, list of images)
	 */
	private $mData;

	/**
	 * Galleries / slideshows counter for view mode
	 */
	private static $galleriesCounter = 0;

	/**
	 * Gallery or slideshow?
	 */
	private $mType;

	/**
	 * Array to store parsed values of parameters
	 */
	private $mParsedParams = array();

	/**
	 * Array of supported (and default) values of parameters
	 */
	private $mAvalaibleGalleryParams = array();

	/**
	 * Is slideshow / gallery using "crop" attribute
	 */
	private $mCrop;

	/**
	 * Is slideshow using "showrecentuploads" attribute (RT #55201)
	 */
	private $mShowRecentUploads;

	/**
	 * Show "Add photo" button?
	 */
	private $mShowAddButton;

	function __construct() {
		parent::__construct();

		$this->mData = array(
			'id' => false,
			'params' => array(),
			'images' => array(),
			'imagesShown' => array(),
			'hash' => false
		);

		// allows galleries to take up the full width of a page
		$this->mPerRow = 0;

		// defaults
		$this->mCrop = false;
		$this->mShowRecentUploads = false;
		$this->mShowAddButton = true;

		// list of supported gallery parameters with list of valid values
		// default are the first values, false for params with no defined list of values (colors, etc)
		$this->mAvalaibleGalleryParams = array(
			'bordercolor' => false,
			'bordersize' => array('small', 'medium', 'large', 'none'),
			'captionalign' => array('left', 'center', 'right'),
			'captionposition' => array('below', 'within'),
			'captionsize' => array('medium', 'small', 'large'),
			'captiontextcolor' => false,
			'orientation' => array('none', 'square', 'portrait', 'landscape'),
			'position' => array('left', 'center', 'right'),
			'spacing' => array('medium', 'large', 'small'),
			'buckets' => false,
			'rowdivider' => false,
		);
	}

	/**
	 * Store content of parsed <gallery> tag
	 */
	public function setText($text) {
		$this->mText = $text;
	}

	/**
	 * Calculate and store hash of current gallery / slideshow
	 */
	public function calculateHash() {
		$this->mData['hash'] = md5($this->mText);
	}

	/**
	 * Set value of parsed parameter
	 */
	private function setParam($name, $value) {
		$this->mParsedParams[$name] = $value;
	}

	/**
	 * Get value of parsed parameter
	 */
	public function getParam($name) {
		return isset($this->mParsedParams[$name]) ? $this->mParsedParams[$name] : null;
	}

	/**
	 * Get list of default values of gallery parameters
	 */
	public function getDefaultParamValues() {
		wfProfileIn(__METHOD__);
		$defaults = array();

		foreach($this->mAvalaibleGalleryParams as $paramName => $paramValues) {
			if (is_array($paramValues)) {
				$defaults[$paramName] = $paramValues[0];
			}
		}

		wfProfileOut(__METHOD__);
		return $defaults;
	}

	/**
	 * Cleanup the value of parameter containing CSS color value
	 */
	private function cleanupColorParam($name) {
		$value = $this->getParam($name);
		$value = WikiaPhotoGalleryHelper::sanitizeCssColor($value);

		$this->setParam($name, $value);
	}

	/**
	 * Parse and store attributes of parsed <gallery> tag
	 */
	public function parseParams($params) {
		wfProfileIn(__METHOD__);

		$this->mData['params'] = $params;

		// lowercase parameters
		$params = array_map('strtolower', $params);

		// generic parameters

		// hide "Add photo" button
		if (isset($params['hideaddbutton']) && $params['hideaddbutton'] == 'true') {
			$this->mShowAddButton = false;
		}

		// set gallery type
		//
		// parse parameters supported by each type
		// default value will be used when set method is called with "false"
		if (!empty($params['type']) && $params['type'] == 'slideshow') {
			$this->mType = self::WIKIA_PHOTO_SLIDESHOW;

			// crop parameter is parsed only for slideshow
			if (isset($params['crop'])) {
				$this->enableCropping($params['crop']);
			}

			// use default slideshow width if "widths" attribute is not provided
			if (!isset($params['widths'])) {
				$this->setWidths(300);
			}

			// add recently uploaded images to the end of slideshow
			if (isset($params['showrecentuploads']) && $params['showrecentuploads'] == 'true') {
				$this->mShowRecentUploads = true;
			}

			// choose slideshow alignment
			if (isset($params['position']) && in_array($params['position'], array('left', 'center', 'right'))) {
				$this->setParam('position', $params['position']);
			}
			else {
				$this->setParam('position', 'right');
			}
		}
		else {
			$this->mType = self::WIKIA_PHOTO_GALLERY;

			// use default gallery width if "widths" attribute is not provided
			if (!isset($params['widths'])) {
				$this->setWidths(200);
			}

			// "columns" - alias for perrow
			if (!empty($params['columns'])) {
				$this->setPerRow($params['columns']);
			}

			// loop through list of supported gallery parameters and use default value if none is set
			foreach($this->mAvalaibleGalleryParams as $paramName => $values) {
				if (!empty($values)) {
					if (isset($params[$paramName])) {
						// parameter is set, but wrong value is used - get default one
						if (!in_array($params[$paramName], $values)) {
							$params[$paramName] = $values[0];
						}
					}
					else {
						// parameter is not set - get default value
						$params[$paramName] = $values[0];
					}
				}
				else {
					// parameter not set
					if (!isset($params[$paramName])) {
						$params[$paramName] = false;
					}
				}

				// store parsed parameters
				$this->setParam($paramName, $params[$paramName]);
			}

			//cropping is always on for square, portrait and landscape galleries (none special case handled in render function)
			$this->enableCropping(true);

			// cleanup parameters containing CSS colors
			$this->cleanupColorParam('bordercolor');
			$this->cleanupColorParam('captiontextcolor');
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Turn on/off images cropping feature
	 */
	private function enableCropping($crop) {
		$this->mCrop = ($crop == 'true');
	}

	/**
	 * Sets width of slideshow / each image in gallery
	 */
	public function setWidths($width) {
		$width = intval($width);

		// 100px is the smallest width for slideshows
		if ($this->mType == self::WIKIA_PHOTO_SLIDESHOW) {
			$width = max(100, $width);
		}

		if ($width > 0) {
			$this->mWidths = $width;
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

			$imageItem = array(
				'name' => $imageName,
				'caption' => $caption,
				'link' => $link,
				'linktext' => $linktext,
			);

			// store list of images from inner content of tag (to be used by front-end)
			$this->mData['images'][] = $imageItem;

			// store list of images actually shown (to be used by front-end)
			$this->mData['imagesShown'][] = $imageItem;

			// use global instance of parser (RT #44689 / RT #44712)
			$caption = $this->mParser->recursiveTagParse($caption);

			$this->add($nt, $caption, $link);

			// Only add real images (bug #5586)
			if ($nt->getNamespace() == NS_FILE) {
				$this->mParser->mOutput->addImage($nt->getDBkey());
			}
		}

		// support "showrecentuploads" attribute (add 20 recently uploaded images at the end of slideshow)
		if (!empty($this->mShowRecentUploads)) {
			$this->addRecentlyUploaded(self::RECENT_UPLOADS_IMAGES);
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
			'imagesShown' => $this->mData['imagesShown'],
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
	 * Add given number of recently uploaded images to slideshow
	 */
	private function addRecentlyUploaded($limit) {
		wfProfileIn(__METHOD__);

		$uploadedImages = WikiaPhotoGalleryHelper::getRecentlyUploaded($limit);

		// remove images already added to slideshow
		$this->mImages = array();
		$this->mData['imagesShown'] = array();

		// add recently uploaded images to slideshow
		foreach($uploadedImages as $image) {
			$this->add($image);

			// store list of images (to be used by front-end)
			$this->mData['imagesShown'][] = array(
				'name' => $image->getText(),
				'caption' => '',
				'link' => '',
				'linktext' => '',
				'recentlyUploaded' => true,
			);

			// Only add real images (bug #5586)
			if ($image->getNamespace() == NS_FILE) {
				$this->mParser->mOutput->addImage($image->getDBkey());
			}
		}

		wfProfileOut(__METHOD__);
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

			$out = WikiaPhotoGalleryHelper::renderGalleryPlaceholder($this, $width, $height);

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

		// debug
		/*
		$out = '<pre>' .
			Wikia::json_encode($this->mData['params']) .
			"\n" .
			Wikia::json_encode($this->mParsedParams) .
			'</pre>' . $out;
		*/

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
		$thumbSize = $this->mWidths;
		$orientation = $this->getParam('orientation');
		$ratio = WikiaPhotoGalleryHelper::getRatioFromOption($orientation);
		$crop = $this->mCrop;

		//calculate height of the biggest image
		$maxHeight = 0;
		$fileObjectsCache = array();
		$heights = array();
		$widths = array();

		// loop throught the images and get height of the tallest one
		foreach ($this->mImages as $index => $imageData) {
			$fileObjectsCache[$index] = $this->getImage($imageData[0]);

			if(!$fileObjectsCache[$index]) continue;

			// get thumbnail limited only by given width
			if ($fileObjectsCache[$index]->width > $thumbSize) {
				$imageHeight = round( $fileObjectsCache[$index]->height * ($thumbSize / $fileObjectsCache[$index]->width) );
				$imageWidth = $thumbSize;
			}
			else {
				$imageHeight = $fileObjectsCache[$index]->height;
				$imageWidth = $fileObjectsCache[$index]->width;
			}

			$heights[$index] = $imageHeight;
			$widths[$index] = $imageWidth;

			if ($imageHeight > $maxHeight) {
				$maxHeight = $imageHeight;
			}
		}

		// calculate height based on gallery width
		$height = round($thumbSize / $ratio);

		if ($orientation == 'none') {
			$this->enableCropping($crop = false);

			// use the biggest height found
			if ($maxHeight > 0) {
				$height = $maxHeight;
			}

			// limit height (RT #59355)
			$height = min($height, $thumbSize);

			// recalculate dimensions (RT #59355)
			foreach($this->mImages as $index => $image) {
				if(!empty($heights[$index]) && !empty($widths[$index])) {
					//fix #59355, min() added to let borders wrap images with smaller width
					//fix #63886, round ( $tmpFloat ) != floor ( $tmpFloat ) added to check if thumbnail will be generated from proper width
					$tmpFloat = ( $widths[$index] * $height / $heights[$index] );
					$widths[$index] = min( $widths[$index], floor( $tmpFloat ) );
					$heights[$index] = min( $height, $heights[$index] );
					if ( round ( $tmpFloat ) != floor ( $tmpFloat ) ){
						$heights[$index] --;
					}
				} else {
					$widths[$index] = $thumbSize;
					$heights[$index] = $height;
				}
			}
		}

		$useBuckets = $this->getParam('buckets');
		$useRowDivider = $this->getParam('rowdivider');
		$captionColor = $this->getParam('captiontextcolor');
		$borderColor = $this->getParam('bordercolor');

		$perRow = ($this->mPerRow > 0) ? $this->mPerRow : 'dynamic';
		$position = $this->getParam('position');
		$captionsPosition = $this->getParam('captionposition');
		$captionsAlign = $this->getParam('captionalign');
		$captionsSize = $this->getParam('captionsize');
		$captionsColor = (!empty($captionColor)) ? $captionColor : null;
		$spacing = $this->getParam('spacing');
		$borderSize = $this->getParam('bordersize');
		$borderColor = (!empty($borderColor)) ? $borderColor : 'accent';
		$isTemplate = (isset($this->mData['params']['source']) && $this->mData['params']['source'] == "template\x7f");
		$hash = $this->mData['hash'];
		$id = 'gallery-' . $this->mData['id'];
		$caption = $this->mCaption;
		$showAddButton = ($this->mShowAddButton == true);

		if(in_array($borderColor, array('accent', 'color1'))) {
			$borderColorClass = " {$borderColor}";
		}
		else {
			$borderColorCSS = " border-color: {$borderColor};";

			if($captionsPosition == 'within') $captionsBackgroundColor = $borderColor;
		}

		$html = Xml::openElement('div', array(
			'id' => $id,
			'hash' => $hash,
			'class' =>  'wikia-gallery clearfix'.
				(($isTemplate) ? ' template' : null).
				" wikia-gallery-position-{$position}".
				" wikia-gallery-spacing-{$spacing}".
				" wikia-gallery-border-{$borderSize}".
				" wikia-gallery-captions-{$captionsAlign}".
				" wikia-gallery-caption-size-{$captionsSize}"

		));

		// render gallery caption (RT #59241)
		if ($this->mCaption !== false) {
			$html .= Xml::openElement('div', array('class' => 'wikia-gallery-caption')) .
				$this->mCaption .
				Xml::closeElement('div');
		}

		$itemWrapperWidth = $thumbSize;
		$thumbWrapperHeight = $height;

		//compensate image wrapper width depending on the border size
		switch($borderSize) {
			case 'large':
				$itemWrapperWidth += 10; //5px * 2
				$thumbWrapperHeight += 10;
				break;
			case 'medium':
				$itemWrapperWidth += 4; //2px * 2
				$thumbWrapperHeight += 4;
				break;
			case 'small':
				$itemWrapperWidth += 2; //1px * 2
				$thumbWrapperHeight += 2;
				break;
		}

		//adding more width for the padding
		$outeritemWrapperWidth = $itemWrapperWidth + 20;

		$rowDividerCSS = '';
		if ($useRowDivider) {
			$rowDividerCSS = "height: ".($thumbWrapperHeight+100)."px; padding: 30px 15px 20px 15px; margin: 0px; border-bottom: solid 1px #CCCCCC;";
		}

		if ($useBuckets) {
			$itemSpanStyle = "width:{$outeritemWrapperWidth}px; ".($useRowDivider ? $rowDividerCSS : 'margin: 4px;');
			$itemDivStyle = "background-color: #f9f9f9; height:{$thumbWrapperHeight}px; text-align: center; border: solid 1px #CCCCCC; padding: ".(($outeritemWrapperWidth-$thumbWrapperHeight)/2)."px 5px;";
		} else {
			$itemSpanStyle = "width:{$itemWrapperWidth}px; $rowDividerCSS";
			$itemDivStyle = "height:{$thumbWrapperHeight}px;";
		}

		foreach($this->mImages as $index => $imageData) {

			if($perRow != 'dynamic' && ($index % $perRow) == 0){
				$html .= Xml::openElement('div', array('class' => 'wikia-gallery-row'));
			}

			$html .= Xml::openElement('div', array('class' => 'wikia-gallery-item', 'style' => $itemSpanStyle));

			$html .= Xml::openElement('div', array('class' => 'thumb', 'style' => $itemDivStyle));

			$image = array();

			// let's properly scale image (don't make it bigger than original size)
			$imageTitle = $imageData[0];
			$fileObject = $fileObjectsCache[$index];

			$image['height'] = $height;
			$image['width'] = $thumbSize;
			$image['caption'] = $imageData[1];

			if (!is_object($fileObject) || ($imageTitle->getNamespace() != NS_FILE)) {
				$image['linkTitle'] = $image['titleText'] = $imageTitle->getText();
				$image['thumbnail'] = false;
				$image['link'] = Skin::makeSpecialUrl("Upload", array( 'wpDestFile' => $image['linkTitle'] ) );
				$image['classes'] = 'image broken-image accent new';
			}
			else {
				$thumbParams = WikiaPhotoGalleryHelper::getThumbnailDimensions($fileObject, $thumbSize, $height, $crop);
				$image['thumbnail'] = $fileObject->getThumbnail($thumbParams['width'], $thumbParams['height'])->url;

				$image['height'] = ($orientation == 'none') ? $heights[$index] : min($thumbParams['height'], $height);
				$imgHeightCompensation = ($height - $image['height']) / 2;
				if($imgHeightCompensation > 0) $image['heightCompensation'] = $imgHeightCompensation;

				$image['width'] = min($widths[$index], $thumbSize);

				//Fix #59914, shared.css has auto-alignment rules
				/*$imgWidthCompensation = ($thumbSize - $image['width']) / 2;
				if($imgHeightCompensation > 0) $image['widthCompensation'] = $imgWidthCompensation;*/

				$image['link'] = $imageData[2];
				$linkAttribs = $this->parseLink($imageTitle, $image['link']);

				$image['link'] = $linkAttribs['href'];
				$image['linkTitle'] = $linkAttribs['title'];
				$image['classes'] = $linkAttribs['class'];
				$image['bytes'] = $fileObject->getSize();


				if($this->mParser && $fileObject->getHandler()) {
					$fileObject->getHandler()->parserTransformHook($this->mParser, $fileObject);
				}
			}

			$html .= Xml::openElement('div', array(
				'class' => 'gallery-image-wrapper'.
					((!$useBuckets && !empty($borderColorClass)) ? $borderColorClass : null),
				'style' => 'position: relative;'.
					($useBuckets ? " width: {$itemWrapperWidth}px; border-style: none;"
								 : " height:{$image['height']}px; width:{$image['width']}px;").
					((!empty($image['heightCompensation'])) ? " top:{$image['heightCompensation']}px;" : null).
					//Fix #59914, shared.css has auto-alignment rules
					//((!empty($image['widthCompensation'])) ? " left:{$image['widthCompensation']}px;" : null).
					((!empty($borderColorCSS)) ? $borderColorCSS : null)
			));

			# Fix 59913 - thumbnail goes as <img /> not as <a> background.
			$html .= Xml::openElement(
				'a',
				array(
					'class' => $image['classes'],
					'href' => $image['link'],
					'title' => $image['linkTitle'].' ('.$sk->formatSize($image['bytes']).')'
				)
			);
			$html .= Xml::openElement(
				'img',
				array(
					'class' => $image['classes'],
					'style' => ((!empty($image['titleText'])) ? " line-height:{$image['height']}px;" : null).
						" height:{$image['height']}px;".
						($useBuckets ? '' : " width:{$image['width']}px;"),
					'src' => (($image['thumbnail']) ? $image['thumbnail'] : null),
					'title' => $image['linkTitle'].' ('.$sk->formatSize($image['bytes']).')'
				)
			);

			$html .=Xml::closeElement('a');
			if($captionsPosition == 'below') {
				$html .= Xml::closeElement('div');
				$html .= Xml::closeElement('div');
			}

			if(!empty($image['caption'])) {
				$html .= Xml::openElement(
					'div',
					array(
						'class' => 'lightbox-caption'.
							((!empty($borderColorClass)  && $captionsPosition == 'within') ? $borderColorClass : null),
						'style' => (($captionsPosition == 'below') ? "width:{$thumbSize}px;" : null).
							((!empty($captionsColor)) ? " color:{$captionsColor};" : null).
							((!empty($captionsBackgroundColor)) ? " background-color:{$captionsBackgroundColor}" : null).
							($useBuckets ? " margin-top: 0px;" : '')
					)
				);

				$html .= $image['caption'];

				$html .= Xml::closeElement('div');
			}

			if($captionsPosition == 'within') {
				$html .= Xml::closeElement('div');
				$html .= Xml::closeElement('div');
			}

			$html .= Xml::closeElement('div');

			if($perRow != 'dynamic' && (($index % $perRow) == ($perRow - 1) || $index == (count($this->mImages) - 1))) {
				$html .= Xml::closeElement('div');
			}
		}

		// "Add image to this gallery" button (this button is shown by JS only in Monaco)
		if($showAddButton) {
			wfLoadExtensionMessages('WikiaPhotoGallery');

			if ($perRow == 'dynamic') {
				$html .= Xml::element('br');
			}

			$html .= Xml::openElement('span', array('class' => 'wikia-gallery-add noprint', 'style' => 'display: none'));
			$html .= Xml::element('img', array('src' => $wgBlankImgUrl, 'class' => 'sprite-small add'));
			$html .= Xml::element('a', array('href' => '#'), wfMsgForContent('wikiaPhotoGallery-viewmode-addphoto'));
			$html .= Xml::closeElement('span');
		}

		$html .= Xml::closeElement('div');

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
 	 * Return a HTML representation of the image slideshow
	 */
	private function renderSlideshow() {
		global $wgLang, $wgBlankImgUrl, $wgStylePath;

		wfProfileIn(__METHOD__);

		// don't render empty slideshows
		if (empty($this->mImages)) {
			wfProfileOut(__METHOD__);
			return '';
		}

		$sk = $this->getSkin();

		// slideshow wrapper CSS class
		$class = 'wikia-slideshow clearfix';

		$id = "slideshow-{$this->mData['id']}";

		// do not add button for galleries from templates
		if (isset($this->mData['params']['source']) && $this->mData['params']['source'] == "template\x7f") {
			$class .= ' template';
		}

		// support "position" attribute (slideshow alignment)
		switch ($this->getParam('position')) {
			case 'left':
				$class .= ' floatleft';
				break;
			case 'center':
				$class .= ' slideshow-center';
				break;
			case 'right':
				$class .= ' floatright';
				break;
		}

		// wrap image slideshow inside div.slideshow
		$attribs = Sanitizer::mergeAttributes(
			array(
				'class' => $class,
				'hash' => $this->mData['hash'],
				'id' => $id,
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

		$s .= Xml::openElement('div', array(
			'class' => 'wikia-slideshow-wrapper',
			'style' => 'width: ' . ($this->mWidths + 10) . 'px'
		));

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
		if (!empty($this->mShowAddButton)) {
			$s .= Xml::element('a',
				array('class' => 'wikia-slideshow-addimage wikia-button secondary', 'style' => 'float: right'),
				wfMsg('wikiaPhotoGallery-slideshow-view-addphoto'));
		}
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

	/**
	 * Get object for given image (and call hook)
	 */
	private function getImage($nt) {
		wfProfileIn(__METHOD__);

		# Give extensions a chance to select the file revision for us
		$time = $descQuery = false;
		wfRunHooks( 'BeforeGalleryFindFile', array( &$this, &$nt, &$time, &$descQuery ) );

		# Render image thumbnail
		$img = wfFindFile( $nt, $time );

		wfProfileOut(__METHOD__);
		return $img;
	}
}
