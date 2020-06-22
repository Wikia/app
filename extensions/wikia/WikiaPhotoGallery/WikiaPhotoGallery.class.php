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
	const WIKIA_PHOTO_SLIDER = 3;

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
	private $mAvailableGalleryParams = [];

	/**
	 * Array of all available values of parameters
	 */
	private $mAvailableUniqueParams = [];

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

	/**
	 * List of files in a gallery
	 */
	public $mFiles = array();

	/**
	 * @var string play button html
	 * @todo refactor this extension so it's easier to insert a template instead of hard coded strings
	 */
	private $videoPlayButton;

	function __construct() {
		parent::__construct();

		$this->mData = array(
			'externalImages' => array(),
			'hash' => false,
			'id' => false,
			'images' => array(),
			'imagesShown' => array(),
			'params' => array()
		);

		// allows galleries to take up the full width of a page
		$this->mPerRow = 0;

		// defaults
		$this->mCrop = false;
		$this->mShowRecentUploads = false;
		$this->mShowAddButton = true;

		// list of supported gallery parameters with list of valid values
		// default are the first values, false for params with no defined list of values (colors, etc)
		$this->mAvailableGalleryParams = array(
			'bordercolor' => false,
			'bordersize' => array( 'small', 'medium', 'large', 'none' ),
			'captionalign' => array( 'left', 'center', 'right' ),
			'captionposition' => array( 'below', 'within' ),
			'captionsize' => array( 'medium', 'small', 'large' ),
			'captiontextcolor' => false,
			'orientation' => array( 'none', 'square', 'portrait', 'landscape' ),
			'position' => array( 'left', 'center', 'right' ),
			'spacing' => array( 'medium', 'large', 'small' ),
			'buckets' => false,
			'rowdivider' => false,
			'hideoverflow' => false,
			'sliderbar' => array( 'bottom', 'left' )
		);

		$this->mAvailableUniqueParams = array_values(
			array_unique(
				array_reduce(
					array_filter(
						array_values( $this->mAvailableGalleryParams ),
						function ( $var ) {
							return !empty( $var );
						}
					),
					"array_merge",
					[]
				)
			)
		);
	}

	private function getVideoPlayButton() {
		if ( empty( $this->videoPlayButton ) ) {
			$this->videoPlayButton = '<span class="thumbnail-play-icon-container">'
			. DesignSystemHelper::renderSvg('wds-player-icon-play', 'thumbnail-play-icon')
			. '</span>';
		}

		return $this->videoPlayButton;
	}

	/**
	 * Store content of parsed <gallery> tag
	 */
	public function setText( $text ) {
		$this->mText = $text;
	}

	/**
	 * Calculate and store hash of current gallery / slideshow
	 */
	public function calculateHash( $params ) {
		$this->mData['hash'] = md5( $this->mText . implode( '', $params ) );
	}

	/**
	 * Set value of parsed parameter
	 */
	private function setParam( $name, $value ) {
		$this->mParsedParams[$name] = $value;
	}

	/**
	 * set parser cache key
	 *
	 * @param $parser Parser
	 */
	public function recordParserOption( Parser $parser ) {
		if ( $this->mType == self::WIKIA_PHOTO_SLIDER ) {
			/**
			 * because slider tag contains elements of interface we need to
			 * inform parser to vary parser cache key by user lang option
			 **/
			$parser->mOutput->recordOption( 'userlang' );
		}
	}

	/**
	 * Get value of parsed parameter
	 */
	public function getParam( $name, $default = null ) {
		return isset( $this->mParsedParams[$name] ) ? $this->mParsedParams[$name] : $default;
	}

	/**
	 * Get list of default values of gallery parameters
	 */
	public function getDefaultParamValues() {
		wfProfileIn( __METHOD__ );
		$defaults = array();

		foreach ( $this->mAvailableGalleryParams as $paramName => $paramValues ) {
			if ( is_array( $paramValues ) ) {
				$defaults[$paramName] = $paramValues[0];
			}
		}

		wfProfileOut( __METHOD__ );
		return $defaults;
	}

	/**
	 * Cleanup the value of parameter containing CSS color value
	 */
	private function cleanupColorParam( $name ) {
		$value = $this->getParam( $name );
		$value = WikiaPhotoGalleryHelper::sanitizeCssColor( $value );

		$this->setParam( $name, $value );
	}

	/**
	 * Parse and store attributes of parsed <gallery> tag
	 *
	 * WARNING: This handles only additional parameters not handled by ImageGallery, see /includes/parser/Parser.php
	 * for setting width use setWidths!
	 */
	public function parseParams( $params ) {
		wfProfileIn( __METHOD__ );

		$this->mData['params'] = $params;

		// lowercase parameters
		foreach ( $params as &$param ) {
			$param = strtolower( $param );
		}

		if ( isset( $params['id'] ) ) {
			$this->mData['id'] = $params['id'];
		}

		// generic parameters

		// hide "Add photo" button
		if (
			( isset( $params['hideaddbutton'] ) && $params['hideaddbutton'] == 'true' ) ||
			F::app()->wg->EnableMediaGalleryExt
		) {
			$this->mShowAddButton = false;
 		}

		// set gallery type
		//
		// parse parameters supported by each type
		// default value will be used when set method is called with "false"
		if ( !empty( $params['type'] ) && $params['type'] == 'slideshow' ) {

			$this->mType = self::WIKIA_PHOTO_SLIDESHOW;

			// crop parameter is parsed only for slideshow
			if ( isset( $params['crop'] ) ) {
				$this->enableCropping( $params['crop'] );
			}

			// use default slideshow width if "widths" attribute is not provided
			if ( !isset( $params['widths'] ) ) {
				$this->setWidths( 300 );
			}

			// add recently uploaded images to the end of slideshow
			if ( isset( $params['showrecentuploads'] ) && $params['showrecentuploads'] == 'true' ) {
				$this->mShowRecentUploads = true;
				$this->mShowAddButton = false;
			}

			// choose slideshow alignment
			if ( isset( $params['position'] ) && in_array( $params['position'], array( 'left', 'center', 'right' ) ) ) {
				$this->setParam( 'position', $params['position'] );
			} else {
				$this->setParam( 'position', 'right' );
			}

		} elseif ( !empty( $params['type'] ) && $params['type'] == 'slider' ) {

			$this->mType = self::WIKIA_PHOTO_SLIDER;

			// choose slideshow alignment
			if ( isset( $params['orientation'] ) && in_array( $params['orientation'], array( 'bottom', 'right', 'mosaic' ) ) ) {
				$this->setParam( 'orientation', $params['orientation'] );
			} else {
				$this->setParam( 'orientation', 'bottom' );
			}

		} else {
			$this->mType = self::WIKIA_PHOTO_GALLERY;

			// use default gallery width if "widths" attribute is not provided
			if ( !isset( $params['widths'] ) ) {
				$this->setWidths( 185 );
			}

			// "columns" - alias for perrow
			if ( !empty( $params['columns'] ) ) {
				$this->setPerRow( $params['columns'] );
			}

			// loop through list of supported gallery parameters and use default value if none is set
			foreach ( $this->mAvailableGalleryParams as $paramName => $values ) {
				if ( !empty( $values ) ) {
					if ( isset( $params[$paramName] ) ) {
						// parameter is set, but wrong value is used - get default one
						if ( !in_array( $params[$paramName], $values ) ) {
							$params[$paramName] = $values[0];
						}
					} else {
						// parameter is not set - get default value
						$params[$paramName] = $values[0];
					}
				} else {
					// parameter not set
					if ( !isset( $params[$paramName] ) ) {
						$params[$paramName] = false;
					}
				}

				// store parsed parameters
				$this->setParam( $paramName, $params[$paramName] );
			}

			// cropping is always on for square, portrait and landscape galleries (none special case handled in render function)
			$this->enableCropping( true );

			// cleanup parameters containing CSS colors
			$this->cleanupColorParam( 'bordercolor' );
			$this->cleanupColorParam( 'captiontextcolor' );
		}

		// Read the 'navigation' parameter common to all gallery types
		$useNavigation = !empty( $params['navigation'] ) && strtolower( $params['navigation'] ) == 'true';
		$this->setParam( 'navigation', $useNavigation );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Turn on/off images cropping feature
	 */
	private function enableCropping( $crop ) {
		$this->mCrop = ( $crop == 'true' );
	}

	/**
	 * Sets width of slideshow / each image in gallery
	 */
	public function setWidths( $width ) {
		$width = intval( $width );

		// 100px is the smallest width for slideshows
		if ( $this->mType == self::WIKIA_PHOTO_SLIDESHOW ) {
			$width = max( 100, $width );
		}

		if ( $width > 0 ) {
			$this->mWidths = $width;
		}
	}

	/**
	 * "height" attribute is ignored
	 */
	public function setHeights( $num ) {}

	/**
	 * Add an image to the gallery.
	 *
	 * @param Title $title Title object of the image that is added to the gallery
	 * @param string $html Additional HTML text to be shown. The name and size of the image are always shown.
	 * @param string $link Value of link= parameter
	 * @param string $wikitext
	 */
	function add( $title, $html = '', $link = '', $wikitext = '' ) {
		if ( $title instanceof Title ) {
			$this->mFiles[] = array( $title, $html, $link, $wikitext );
			wfDebug( __METHOD__ . ' - ' . $title->getText() . "\n" );
		}
	}

	public function getImages() {
		return $this->mFiles;
	}

	/**
	 * Parse content of <gallery> tag (add images with captions and links provided)
	 * @param Parser|null $parser
	 */
	public function parse( Parser $parser = null ) {
		wfProfileIn( __METHOD__ );

		// use images passed inside <gallery> tag
		$lines = StringUtils::explode( "\n", $this->mText );

		foreach ( $lines as $line ) {
			if ( $line == '' ) {
				continue;
			}

			$parts = (array) StringUtils::explode( '|', $line );

			// get name of an image from current line and remove it from list of params
			$imageName = array_shift( $parts );

			if ( strpos( $line, '%' ) !== false ) {
				$imageName = urldecode( $imageName );
			}

			// Allow <gallery> to accept image names without an Image: prefix
			$tp = Title::newFromText( $imageName, NS_FILE );
			$nt =& $tp;
			if ( is_null( $nt ) ) {
				// Bogus title. Ignore these so we don't bomb out later.
				continue;
			}

			// search for caption and link= param
			$captionParts = array();
			$link = $linktext = $shorttext = '';

			foreach ( $parts as $part ) {
				if ( substr( $part, 0, 5 ) == 'link=' ) {
					$link = substr( $part, 5 );
				} else if ( substr( $part, 0, 9 ) == 'linktext=' ) {
					$linktext = substr( $part, 9 );
				} else if ( substr( $part, 0, 10 ) == 'shorttext=' ) {
					$shorttext = substr( $part, 10 );
				} else {
					$tempPart = trim( $part );

					// If it looks like Gallery param don't treat it as a caption part
					if ( !in_array( $tempPart, $this->mAvailableUniqueParams ) ) {
						$captionParts[] = $tempPart;
					}
				}
			}

			// support captions with internal links with pipe (Foo.jpg|link=Bar|[[test|link]])
			$caption = implode( '|', $captionParts );

			$imageItem = array(
				'name' => $imageName,
				'caption' => $caption,
				'link' => $link,
				'linktext' => $linktext,
				'shorttext' => $shorttext,
				'data-caption' => Sanitizer::removeHTMLtags( $caption ),
			);

			// Get article link if it exists. If the href attribute is identical to the local
			// file URL, then there is no article URL.
			$localUrl = $tp->getLocalUrl();
			$linkAttributes = $this->parseLink( $localUrl, $tp->getText(), $link );
			if ( $linkAttributes['href'] !== $localUrl ) {
				$imageItem['linkhref'] = $linkAttributes['href'];
			}

			// store list of images from inner content of tag (to be used by front-end)
			$this->mData['images'][] = $imageItem;

			// store list of images actually shown (to be used by front-end)
			$this->mData['imagesShown'][] = $imageItem;

			$this->add(
				$nt,
				// use global instance of parser (RT #44689 / RT #44712)
				$this->mParser->recursiveTagParse( $caption ),
				$link,
				$caption
			);

			// Only add real images (bug #5586)
			if ( $nt->getNamespace() == NS_FILE ) {
				$this->mParser->mOutput->addImage( $nt->getDBkey() );
			}
		}

		// support "showrecentuploads" attribute (add 20 recently uploaded images at the end of slideshow)
		if ( !empty( $this->mShowRecentUploads ) ) {
			$this->addRecentlyUploaded( self::RECENT_UPLOADS_IMAGES );
		}

		// store ID of gallery
		if ( empty( $this->mData['id'] ) ) {
			$this->mData['id'] = self::$galleriesCounter++;
		}

		if ( !empty( $parser ) ) {
			$this->recordParserOption( $parser );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get image gallery data (tag parameters, list of images and their parameters)
	 *
	 * This data is used by JS front-end in Visual Editor. Cast to object is needed to properly handle params in JS code.
	 */
	public function getData() {
		return array(
			'externalImages' => $this->mData['externalImages'],
			'hash' => $this->mData['hash'],
			'id' => $this->mData['id'],
			'images' => $this->mData['images'],
			'imagesShown' => $this->mData['imagesShown'],
			'params' => (object) $this->mData['params'],
			'type' => $this->mType
		);
	}

	/**
	 * Parse given link and return link tag attributes
	 */
	private function parseLink( $url, $text, $link ) {
		return WikiaPhotoGalleryHelper::parseLink( $this->mParser, $url, $text, $link );
	}

	/**
	 * Add given number of recently uploaded images to slideshow
	 */
	private function addRecentlyUploaded( $limit ) {
		wfProfileIn( __METHOD__ );

		$uploadedImages = MediaQueryService::getRecentlyUploaded( $limit );

		// remove images already added to slideshow
		$this->mFiles = array();
		$this->mData['imagesShown'] = array();

		// add recently uploaded images to slideshow
		if ( !empty( $uploadedImages ) ) {
			/** @var Title $image */
			foreach ( $uploadedImages as $image ) {
				$this->add( $image );

				// store list of images (to be used by front-end)
				$this->mData['imagesShown'][] = array(
					'name' => $image->getText(),
					'caption' => '',
					'link' => '',
					'linktext' => '',
					'recentlyUploaded' => true,
					'shorttext' => '',
				);

				// Only add real images (bug #5586)
				if ( $image->getNamespace() == NS_FILE ) {
					$this->mParser->mOutput->addImage( $image->getDBkey() );
				}
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Return a HTML representation of the image gallery / slideshow
	 */
	public function toHTML() {
		global $wgRTEParserEnabled;

		$out = '';

		wfProfileIn( __METHOD__ );

		if ( !Hooks::run( 'GalleryBeforeProduceHTML', array( $this->mData, &$out ) ) ) {
			wfProfileOut( __METHOD__ );

			return $out;
		}

		// render as placeholder in RTE
		if ( !empty( $wgRTEParserEnabled ) ) {
			if ( $this->mType == self::WIKIA_PHOTO_GALLERY ) {
				// gallery: 185x185px placeholder
				$width = $height = 185;
			} elseif ( $this->mType == self::WIKIA_PHOTO_SLIDER ) {
				$width = WikiaPhotoGalleryHelper::SLIDER_MIN_IMG_WIDTH;
				$height = WikiaPhotoGalleryHelper::SLIDER_MIN_IMG_HEIGHT;
			} else {
				// slideshow: use user specified size
				$width = $this->mWidths;
				$height = round( $this->mWidths * 3 / 4 );
			}

			$out = WikiaPhotoGalleryHelper::renderGalleryPlaceholder( $this, $width, $height );

			wfProfileOut( __METHOD__ );
			return $out;
		}

		switch ( $this->mType ) {
			case self::WIKIA_PHOTO_GALLERY:
				$out = $this->renderGallery();
				break;

			case self::WIKIA_PHOTO_SLIDESHOW:
				$out = $this->renderSlideshow();
				break;

			case self::WIKIA_PHOTO_SLIDER:
				$out = $this->renderSlider();
				break;
		}
		if ( !$this->canRenderMediaGallery() ) {
			$out .= $this->getBaseJSSnippets();
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * Add gallery JS and CSS assets
	 *
	 * Every WikiaPhotoGallery instance (including sliders and slideshows) uses these assets. The newer MediaGalleries,
	 * do not.
	 * @return string
	 */
	private function getBaseJSSnippets() {
		$out = JSSnippets::addToStack(
			array(
				'wikia_photo_gallery_js',
				'wikia_photo_gallery_scss',
			),
			array(),
			'WikiaPhotoGalleryView.init'
		);

		return $out;
	}

	/**
	 * Determine if media gallery should be rendered
	 * @return bool
	 */
	private function canRenderMediaGallery() {
		// Do not render media gallery for special pages - It is only for UGC pages
		$globalTitle = F::app()->wg->Title;
		if ( !$globalTitle || $globalTitle->getNamespace() === NS_SPECIAL ) {
			return false;
		}

		// If the extension isn't enabled we aren't rendering this as a media gallery
		if ( ! F::app()->wg->EnableMediaGalleryExt ) {
			return false;
		}

		// TODO: If Parsoid is the client always return "old gallery" so "alternative rendering" can work
		// like a charm. This is meant to be deleted when "new galleries" are the only galleries.
		if ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Parsoid' ) !== false ) {
			return false;
		}

		// Don't render navigational galleries.
		if ( $this->getParam( 'navigation' ) ) {
			return false;
		}

		// Don't render gallery sliders
		if ( $this->mType == self::WIKIA_PHOTO_SLIDER ) {
			return false;
		}

		// The last test; make sure when we ignore videos and red-linked files
		// that there are still at least two displayable images
		foreach ( $this->mFiles as $val ) {
			$file = wfFindFile( $val[0] );

			// Skip if we can't find this file
			if ( empty( $file ) ) {
				continue;
			}

			// We found at least one non-video file
			if ( ! WikiaFileHelper::isFileTypeVideo( $file ) &&
				 ! WikiaFileHelper::isFileTypeOgg( $file ) ) {
				return true;
			}
		}

		// We didn't find any images to display
		return false;
	}

	/**
 	 * Return a HTML representation of the image gallery
	 *
	 * The new gallery disables the old perrow control, and automatically fit the gallery to the available space in the browser.
	 */
	private function renderGallery() {
		wfProfileIn( __METHOD__ );

		// do not render empty gallery
		if ( empty( $this->mFiles ) ) {
			wfProfileOut( __METHOD__ );
			return '';
		}

		// Route to the mobile gallery or the new MediaGallery
		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			$html = $this->renderWikiaMobileMediaGroup();

			wfProfileOut( __METHOD__ );
			return $html;
		} elseif ( $this->canRenderMediaGallery() ) {
			$html =  $this->renderMediaGallery();

			// remove spaces from html produced by mustache template
			$html = trim( preg_replace( '/\n+/', ' ', $html ) );

			wfProfileOut( __METHOD__ );
			return $html;
		}

		/** @var Skin|Linker $skin The skin object falls back to Linker methods via __call */
		$skin = RequestContext::getMain()->getSkin();
		$thumbSize = $this->mWidths;
		$orientation = $this->getParam( 'orientation' );
		$ratio = WikiaPhotoGalleryHelper::getRatioFromOption( $orientation );
		$crop = $this->mCrop;

		// calculate height of the biggest image
		$maxHeight = 0;
		$fileObjectsCache = array();
		$heights = array();
		$widths = array();
		$thumbParams = array();

		// loop through the images and get height of the tallest one
		foreach ( $this->mFiles as $imageData ) {

			$img = $this->getImage( $imageData[0] );
			$fileObjectsCache[] = $img;
			if ( !empty( $img ) ) {

				// get thumbnail limited only by given width
				if ( $img->width > $thumbSize ) {
					$imageHeight = round( $img->height * ( $thumbSize / $img->width ) );
					$imageWidth = $thumbSize;
				} else {
					$imageHeight = $img->height;
					$imageWidth = $img->width;
				}

				$heights[] = $imageHeight;
				$widths[] = $imageWidth;

				if ( $imageHeight > $maxHeight ) {
					$maxHeight = $imageHeight;
				}
			}
		}


		// calculate height based on gallery width
		$height = round( $thumbSize / $ratio );

		if ( $orientation == 'none' ) {
			$this->enableCropping( $crop = false );

			// use the biggest height found
			if ( $maxHeight > 0 ) {
				$height = $maxHeight;
			}

			// limit height (RT #59355)
			$height = min( $height, $thumbSize );

			// recalculate dimensions (RT #59355)
			foreach ( $this->mFiles as $index => $image ) {
				if ( !empty( $heights[$index] ) && !empty( $widths[$index] ) ) {
					// fix #59355, min() added to let borders wrap images with smaller width
					// fix #63886, round ( $tmpFloat ) != floor ( $tmpFloat ) added to check if thumbnail will be generated from proper width
					$tmpFloat = ( $widths[$index] * $height / $heights[$index] );
					$widths[$index] = min( $widths[$index], floor( $tmpFloat ) );
					$heights[$index] = min( $height, $heights[$index] );
					if ( round ( $tmpFloat ) != floor ( $tmpFloat ) ) {
						$heights[$index] --;
					}
				} else {
					$widths[$index] = $thumbSize;
					$heights[$index] = $height;
				}
			}
		}

		$useBuckets = $this->getParam( 'buckets' );
		$useRowDivider = $this->getParam( 'rowdivider' );
		$captionColor = $this->getParam( 'captiontextcolor' );
		$borderColor = $this->getParam( 'bordercolor' );

		$perRow = ( $this->mPerRow > 0 ) ? $this->mPerRow : 'dynamic';
		$position = $this->getParam( 'position' );
		$captionsPosition = $this->getParam( 'captionposition', 'below' );
		$captionsAlign = $this->getParam( 'captionalign' );
		$captionsSize = $this->getParam( 'captionsize' );
		$captionsColor = ( !empty( $captionColor ) ) ? $captionColor : null;
		$spacing = $this->getParam( 'spacing' );
		$borderSize = $this->getParam( 'bordersize' );
		$borderColor = ( !empty( $borderColor ) ) ? $borderColor : 'accent';
		$isTemplate = ( isset( $this->mData['params']['source'] ) && $this->mData['params']['source'] == "template\x7f" );
		$hash = $this->mData['hash'];
		$id = 'gallery-' . $this->mData['id'];
		$showAddButton = ( $this->mShowAddButton == true );
		$hideOverflow = $this->getParam( 'hideoverflow' );

		if ( in_array( $borderColor, array( 'accent', 'color1' ) ) ) {
			$borderColorClass = " {$borderColor}";
		} else {
			$borderColorCSS = " border-color: {$borderColor};";

			if ( $captionsPosition == 'within' ) $captionsBackgroundColor = $borderColor;
		}

		$html = Xml::openElement( 'div', array(
			'id' => $id,
			'hash' => $hash,
			'class' =>  'wikia-gallery' .
				( ( $isTemplate ) ? ' template' : null ) .
				" wikia-gallery-caption-{$captionsPosition}" .
				" wikia-gallery-position-{$position}" .
				" wikia-gallery-spacing-{$spacing}" .
				" wikia-gallery-border-{$borderSize}" .
				" wikia-gallery-captions-{$captionsAlign}" .
				" wikia-gallery-caption-size-{$captionsSize}"

		) );

		// render gallery caption (RT #59241)
		if ( $this->mCaption !== false ) {
			$html .= Xml::openElement( 'div', array( 'class' => 'wikia-gallery-caption' ) ) .
				$this->mCaption .
				Xml::closeElement( 'div' );
		}

		$itemWrapperWidth = $thumbSize;
		$thumbWrapperHeight = $height;

		// compensate image wrapper width depending on the border size
		switch ( $borderSize ) {
			case 'large':
				$itemWrapperWidth += 10; // 5px * 2
				$thumbWrapperHeight += 10;
				break;
			case 'medium':
				$itemWrapperWidth += 4; // 2px * 2
				$thumbWrapperHeight += 4;
				break;
			case 'small':
				$itemWrapperWidth += 2; // 1px * 2
				$thumbWrapperHeight += 2;
				break;
		}

		// adding more width for the padding
		$outeritemWrapperWidth = $itemWrapperWidth + 20;

		$rowDividerCSS = '';
		if ( $useRowDivider ) {
			$rowDividerCSS = "height: " . ( $thumbWrapperHeight + 100 ) . "px; padding: 30px 15px 20px 15px; margin: 0px; border-bottom: solid 1px #CCCCCC;";
		}

		if ( $useBuckets ) {
			$itemSpanStyle = "width:{$outeritemWrapperWidth}px; " . ( $useRowDivider ? $rowDividerCSS : 'margin: 4px;' );
			$itemDivStyle = "background-color: #f9f9f9; height:{$thumbWrapperHeight}px; text-align: center; border: solid 1px #CCCCCC; padding: " . ( ( $outeritemWrapperWidth -$thumbWrapperHeight ) / 2 ) . "px 5px;";
		} else {
			$itemSpanStyle = "width:{$itemWrapperWidth}px; $rowDividerCSS";
			$itemDivStyle = "height:{$thumbWrapperHeight}px;";
		}

		foreach ( $this->mFiles as $index => $imageData ) {

			if ( $perRow != 'dynamic' && ( $index % $perRow ) == 0 ) {
				$html .= Xml::openElement( 'div', array( 'class' => 'wikia-gallery-row' ) );
			}

			$html .= Xml::openElement( 'div', array( 'class' => 'wikia-gallery-item', 'style' => $itemSpanStyle ) );

			$html .= Xml::openElement( 'div', array( 'class' => 'thumb', 'style' => $itemDivStyle ) );

			$image = array();

			// let's properly scale image (don't make it bigger than original size)
			/**
			 * @var $imageTitle Title
			 * @var $fileObject LocalFile
			 */
			$imageTitle = $imageData[0];
			$fileObject = $fileObjectsCache[$index];
			$imageTitleText = $imageTitle->getText();

			$image['height'] = $height;
			$image['width'] = $thumbSize;
			$image['caption'] = $imageData[1];

			if ( !is_object( $fileObject ) || ( $imageTitle->getNamespace() != NS_FILE ) ) {
				$image['linkTitle'] = $image['titleText'] = $imageTitleText;
				$image['thumbnail'] = false;
				$image['link'] = Skin::makeSpecialUrl( "Upload", array( 'wpDestFile' => $image['linkTitle'] ) );
				$image['classes'] = 'image broken-image accent new';
			} else {
				$thumbParams = WikiaPhotoGalleryHelper::getThumbnailDimensions( $fileObject, $thumbSize, $height, $crop );
				$image['thumbnail'] = $fileObject->createThumb( $thumbParams['width'], $thumbParams['height'] );
				$image['DBKey'] = $fileObject->getTitle()->getDBKey();
				$image['fileTitle'] = $fileObject->getTitle()->getText();

				$image['height'] = ( $orientation == 'none' ) ? $heights[$index] : min( $thumbParams['height'], $height );
				$imgHeightCompensation = ( $height - $image['height'] ) / 2;
				if ( $imgHeightCompensation > 0 ) $image['heightCompensation'] = $imgHeightCompensation;

				$image['width'] = min( $widths[$index], $thumbSize );

				// Fix #59914, shared.css has auto-alignment rules
				/*$imgWidthCompensation = ($thumbSize - $image['width']) / 2;
				if ($imgHeightCompensation > 0) $image['widthCompensation'] = $imgWidthCompensation;*/

				$image['link'] = $imageData[2];

				$linkAttribs = $this->parseLink( $imageTitle->getLocalUrl(), $imageTitleText, $image['link'] );

				$image['link'] = $linkAttribs['href'];
				$image['linkTitle'] = $linkAttribs['title'];
				$image['classes'] = $linkAttribs['class'];
				$image['bytes'] = $fileObject->getSize();

				if ( $this->mParser && $fileObject->getHandler() ) {
					$fileObject->getHandler()->parserTransformHook( $this->mParser, $fileObject );
				}
			}

			Hooks::run( 'GalleryBeforeRenderImage', array( &$image ) );

			// see Image SEO project
			$wrapperId = preg_replace( '/[^a-z0-9_]/i', '-', Sanitizer::escapeId( $image['linkTitle'] ) );

			$html .= Xml::openElement( 'div',
				array(
				'class' => 'gallery-image-wrapper' .
					( ( !$useBuckets && !empty( $borderColorClass ) ) ? $borderColorClass : null ),
				'id' => $wrapperId,
				'style' => 'position: relative;' .
					( $useBuckets ? " width: {$itemWrapperWidth}px; border-style: none;"
								 : " height:{$image['height']}px; width:{$image['width']}px;" ) .
					( ( !empty( $image['heightCompensation'] ) ) ? " top:{$image['heightCompensation']}px;" : null ) .
					// Fix #59914, shared.css has auto-alignment rules
					// ((!empty($image['widthCompensation'])) ? " left:{$image['widthCompensation']}px;" : null).
					( ( !empty( $borderColorCSS ) ) ? $borderColorCSS : null )
			) );

			$imgStyle = null;

			$isVideo = WikiaFileHelper::isFileTypeVideo( $fileObject );

			# Fix 59913 - thumbnail goes as <img /> not as <a> background.
			if ( $orientation != 'none' ) {

				# margin calculation for image positioning

				if ( isset( $thumbParams['height'] ) && $thumbParams['height'] > $image['height'] ) {
					$tempTopMargin = -1 * ( $thumbParams['height'] - $image['height'] ) / 2;
				} else {
					unset ( $tempTopMargin );
				}

				if ( isset( $thumbParams['width'] ) && $thumbParams['width'] > $image['width'] ) {
					$tempLeftMargin = -1 * ( $thumbParams['width'] - $image['width'] ) / 2;
				} else {
					unset ( $tempLeftMargin );
				}

				$imgStyle = ( ( !empty( $tempTopMargin ) ) ? " margin-top:" . $tempTopMargin . "px;" : null ) .
					( ( !empty( $tempLeftMargin ) ) ? " margin-left:" . $tempLeftMargin . "px;" : null );

				if ( $isVideo ) {
					$image['classes'] .= ' force-lightbox';
				}
			}

			$linkAttribs = array(
				'class' => empty( $image['thumbnail'] ) ? 'image-no-lightbox' : $image['classes'],
				'href' => $image['link'],
				'title' => $image['linkTitle'] . ( isset( $image['bytes'] ) ? ' (' . $skin->formatSize( $image['bytes'] ) . ')':"" ),
				'style' => "height:{$image['height']}px; width:{$image['width']}px;"
			);

			if ( !empty( $image['thumbnail'] ) ) {
				if ( $isVideo ) {
					$thumbHtml = '';
					$playButtonSize = ThumbnailHelper::getThumbnailSize( $image['width'] );
					$thumbHtml .= $this->getVideoPlayButton();
					$linkAttribs['class'] .= ' video video-thumbnail ' . $playButtonSize;
				} else {
					$thumbHtml = '';
				}

				$imgAttribs = array(
					'style' => ( ( !empty( $image['titleText'] ) ) ? " line-height:{$image['height']}px;" : null ) . $imgStyle,
					'src' => ( ( $image['thumbnail'] ) ? $image['thumbnail'] : null ),
					'title' => $image['linkTitle'] . ( isset( $image['bytes'] ) ? ' (' . $skin->formatSize( $image['bytes'] ) . ')':"" ),
					'class' => 'thumbimage',
					'alt' => preg_replace( '/\.[^\.]+$/', '', $image['linkTitle'] ),
					// 'width' => isset($thumbParams) ? $thumbParams['width'] : $image['width'], // TODO: reinstate this with some WPG refactoring (BugId:38660)
					// 'height' => isset($thumbParams) ? $thumbParams['height'] : $image['height'],
				);

				if ( $isVideo ) {
					$imgAttribs['data-video-name'] = htmlspecialchars( $image['fileTitle'] );
					$imgAttribs['data-video-key'] = urlencode( htmlspecialchars( $image['DBKey'] ) );
					$imgAttribs['width'] = isset($thumbParams['width']) ? $thumbParams['width'] : $image['width'];
				} else {
					$imgAttribs['data-image-name'] = htmlspecialchars( $image['fileTitle'] );
					$imgAttribs['data-image-key'] = urlencode( htmlspecialchars( $image['DBKey'] ) );
				}

				if ( !empty( $image['data-caption'] ) ) {
					$imgAttribs['data-caption'] = $image['data-caption'];
				}

				if ( isset( $image['thumbnail-classes'] ) &&
					isset( $image['thumbnail-src'] ) &&
					isset( $image['thumbnail-onload'] ) ) {

					$thumbHtml .= '<noscript>' . Xml::openElement( 'img', $imgAttribs ) . '</noscript>';
					$imgAttribs['class'] .= ' ' . $image['thumbnail-classes'];
					$imgAttribs['data-src'] = $imgAttribs['src'];
					$imgAttribs['src'] = $image['thumbnail-src'];
					$imgAttribs['onload'] = $image['thumbnail-onload'];
				}

				$thumbHtml .= Xml::openElement( 'img', $imgAttribs );
			} else {
				$thumbHtml = $image['linkTitle'];
			}

			$html .= Xml::openElement( 'a', $linkAttribs );
			$html .= $thumbHtml;
			$html .= Xml::closeElement( 'a' );

			if ( $captionsPosition == 'below' ) {
				$html .= Xml::closeElement( 'div' );
				$html .= Xml::closeElement( 'div' );
			}

			// Insert video titles here
			if ( $isVideo ) {
				$html .= '<div class="title">' . $imageTitleText . '</div>';
			}

			if ( !empty( $image['caption'] ) ) {
				$html .= Xml::openElement(
					'div',
					array(
						'class' => 'lightbox-caption' .
							( ( !empty( $borderColorClass )  && $captionsPosition == 'within' ) ? $borderColorClass : null ),
						'style' => ( ( $captionsPosition == 'below' ) ? "width:{$thumbSize}px;" : null ) .
							( ( !empty( $captionsColor ) ) ? " color:{$captionsColor};" : null ) .
							( ( !empty( $captionsBackgroundColor ) ) ? " background-color:{$captionsBackgroundColor}" : null ) .
							( $useBuckets ? " margin-top: 0px;" : '' ) .
							( ( !empty( $hideOverflow ) ) ? " overflow: hidden" : null )
					)
				);

				$html .= $image['caption'];
				$html .= Xml::closeElement( 'div' );
			}

			if ( $captionsPosition == 'within' ) {
				$html .= Xml::closeElement( 'div' );
				$html .= Xml::closeElement( 'div' );
			}

			$html .= Xml::closeElement( 'div' ); // /div.wikia-gallery-item

			if ( $perRow != 'dynamic' && ( ( $index % $perRow ) == ( $perRow - 1 ) || $index == ( count( $this->mFiles ) - 1 ) ) ) {
				$html .= Xml::closeElement( 'div' );
			}
		}

		// "Add image to this gallery" button (this button is shown by JS only in Monaco)
		if ( $showAddButton ) {
			if ( $perRow == 'dynamic' ) {
				$html .= Xml::element( 'br' );
			}

			// add button for Oasis
			$html .= Xml::openElement( 'a', array( 'class' => 'wikia-photogallery-add wikia-button noprint', 'style' => 'display: none' ) );
			$html .= Xml::element( 'img', array( 'src' => F::app()->wg->BlankImgUrl, 'class' => 'sprite photo', 'width' => 26, 'height' => 16 ) );
			$html .= wfMessage( 'wikiaPhotoGallery-viewmode-addphoto' )->inContentLanguage()->text();
			$html .= Xml::closeElement( 'a' );
		}

		$html .= Xml::closeElement( 'div' );

		wfProfileOut( __METHOD__ );

		return $html;
	} // end renderGallery()

	/**
 	 * Return a HTML representation of the image slideshow
	 */
	private function renderSlideshow() {
		global $wgStylePath;

		wfProfileIn( __METHOD__ );

		// don't render empty slideshows
		if ( empty( $this->mFiles ) ) {
			wfProfileOut( __METHOD__ );
			return '';
		}

		// If we can, render this as a media gallery
		if ( $this->canRenderMediaGallery() ) {
			$html =  $this->renderMediaGallery();

			wfProfileOut( __METHOD__ );
			return trim( preg_replace( '/\n+/', ' ', $html ) );
		}

		/** @var Skin|Linker $sk The Skin object falls back to Linker methods */
		$sk = RequestContext::getMain()->getSkin();

		// slideshow wrapper CSS class
		$class = 'wikia-slideshow clearfix';

		$id = "slideshow-{$this->mData['id']}";

		// do not add button for galleries from templates
		if ( isset( $this->mData['params']['source'] ) && $this->mData['params']['source'] == "template\x7f" ) {
			$class .= ' template';
		}

		// support "position" attribute (slideshow alignment)
		switch ( $this->getParam( 'position' ) ) {
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
		$attribs = Sanitizer::mergeAttributes( $this->mAttribs, array(
			'class' => $class,
			'data-hash' => $this->mData['hash'],
			'data-crop' => $this->mCrop,
			'id' => $id,
		) );

		// renderSlideshow for WikiaMobile
		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			$slideshowHtml = $this->renderWikiaMobileMediaGroup();
		} else {

			$slideshowHtml = Xml::openElement( 'div', $attribs );

			// render slideshow caption
			if ( $this->mCaption ) {
				$slideshowHtml .= '<div class="wikia-slideshow-caption">' . $this->mCaption . '</div>';
			}

			// fit images inside width:height = 4:3 box
			$this->mHeights = round( $this->mWidths * 3 / 4 );
			$params = array( 'width' => $this->mWidths, 'height' => $this->mHeights );

			wfDebug( __METHOD__ . ": slideshow {$params['width']}x{$params['height']}\n" );

			$slideshowHtml .= Xml::openElement( 'div', array(
				'class' => 'wikia-slideshow-wrapper',
				'style' => 'width: ' . ( $this->mWidths + 10 ) . 'px'
			) );

			// wrap images inside <div> and <ul>
			$slideshowHtml .= Xml::openElement( 'div', array( 'class' => 'wikia-slideshow-images-wrapper accent' ) );
			$slideshowHtml .= Xml::openElement( 'ul', array(
				'class' => 'wikia-slideshow-images neutral',
				'style' => "height: {$params['height']}px; width: {$params['width']}px",
			) );

			$index = 0;

			foreach ( $this->mFiles as $p => $pair ) {
				/**
				 * @var $nt Title
				 */
				$nt = $pair[0];
				$text = $pair[1];
				$link = $pair[2];

				$img = wfFindFile( $nt );

				if ( WikiaFileHelper::isFileTypeVideo( $img ) ) {
					continue;
				}

				$thumb = null;

				// let's properly scale image (don't make it bigger than original size) and handle "crop" attribute
				if ( is_object( $img ) && ( $nt->getNamespace() == NS_FILE ) ) {
					$thumbParams = WikiaPhotoGalleryHelper::getThumbnailDimensions( $img, $params['width'], $params['height'], $this->mCrop );
				}

				$caption = $linkOverlay = '';

				// render caption overlay
				if ( $text != '' ) {
					$caption = Xml::openElement( 'span', array( 'class' => 'wikia-slideshow-image-caption' ) )
						. Xml::openElement( 'span', array( 'class' => 'wikia-slideshow-image-caption-inner' ) )
						. $text
						. Xml::closeElement( 'span' )
						. Xml::closeElement( 'span' );
				}

				// parse link
				$linkAttribs = $this->parseLink( $nt->getLocalUrl(), $nt->getText(), $link );
				// extra link tag attributes
				$linkAttribs['id'] = "{$id}-{$index}";
				$linkAttribs['style'] = 'width: ' . ( $params['width'] - 80 ) . 'px';

				if ( $link == '' ) {
					// tooltip to be used for not-linked images
					$linkAttribs['title'] = wfMessage( 'wikiaPhotoGallery-slideshow-view-popout-tooltip' )->text();
					$linkAttribs['class'] = 'wikia-slideshow-image';
					unset( $linkAttribs['href'] );
				} else {
					// linked images
					$linkAttribs['class'] .= ' wikia-slideshow-image';

					// support |linktext= syntax
					if ( $this->mData['images'][$p]['linktext'] != '' ) {
						$linkText = $this->mData['images'][$p]['linktext'];
					} else {
						$linkText = $link;
					}

					// add link overlay
					$linkOverlay = Xml::openElement( 'span', array( 'class' => 'wikia-slideshow-link-overlay' ) )
						. wfMessage( 'wikiaPhotoGallery-slideshow-view-link-overlay', Sanitizer::removeHTMLtags( $linkText ) )->text()
						. Xml::closeElement( 'span' );
				}

				// generate HTML for a single slideshow image
				$thumbHtml = null;
				$liAttribs = array(
					'title' => null
				);

				if ( $nt->getNamespace() != NS_FILE || !$img ) {
					# We're dealing with a non-image, spit out the name and be done with it.
					$thumbHtml = '<a class="image broken-image new" style="line-height: ' . ( $this->mHeights ) . 'px;">'
						. $nt->getText() . '</a>';
				} elseif ( $this->mHideBadImages && wfIsBadImage( $nt->getDBkey(), $this->getContextTitle() ) ) {
					# The image is blacklisted, just show it as a text link.
					$thumbHtml = '<div style="height: ' . ( $this->mHeights * 1.25 + 2 ) . 'px;">'
						. $sk->makeKnownLinkObj( $nt, $nt->getText() ) . '</div>';
				} elseif ( !( $thumb = $img->transform( $thumbParams ) ) ) {
					# Error generating thumbnail.
					$thumbHtml = '<div style="height: ' . ( $this->mHeights * 1.25 + 2 ) . 'px;">'
						. htmlspecialchars( $img->getLastError() ) . '</div>';
				} else {
					$thumbAttribs = array(
						'data-src' => $thumb->url,
						'class' => 'thumbimage',
						'width' => $thumb->width,
						'height' => $thumb->height,
						'style' => 'border: 0px;',
						'data-image-name' => $img->getTitle()->getText(),
						'data-image-key' => $img->getTitle()->getDBKey(),
					);
					if ( !empty( $this->mData['images'][$p]['data-caption'] ) ) {
						$thumbAttribs['data-caption'] = $this->mData['images'][$p]['data-caption'];
					}
					$thumbHtml = Xml::element( 'img', $thumbAttribs );
				}

				// add CSS class so we can show first slideshow image before JS is loaded
				if ( $index == 0 ) {
					$liAttribs['class'] = 'wikia-slideshow-first-image';
				}

				$slideshowHtml .= Xml::openElement( 'li', $liAttribs )
					. $thumbHtml
					. Xml::element( 'a', $linkAttribs, ' ' )
					. $caption
					. $linkOverlay
					. '</li>';


				$index++;

				// Call parser transform hook
				if ( $this->mParser && is_object( $img ) && $img->getHandler() ) {
					$img->getHandler()->parserTransformHook( $this->mParser, $img );
				}

				if (  is_object( $thumb ) ) {
					wfDebug( __METHOD__ . ": image '" . $nt->getText() . "' {$thumb->width}x{$thumb->height}\n" );
				}
			}

			$slideshowHtml .= Xml::closeElement( 'ul' );
			$slideshowHtml .= Xml::closeElement( 'div' );

			// render prev/next buttons
			global $wgBlankImgUrl;

			$top = ( $params['height'] >> 1 ) - 30 /* button height / 2 */ + 5 /* top border of slideshow area */;
			$slideshowHtml .= Xml::openElement( 'div', array( 'class' => 'wikia-slideshow-prev-next' ) );

			// prev
			$slideshowHtml .= Xml::openElement( 'a',
				array( 'class' => 'wikia-slideshow-sprite wikia-slideshow-prev', 'style' => "top: {$top}px",
					'title' => wfMessage( 'wikiaPhotoGallery-slideshow-view-prev-tooltip' )->text() ) );
			$slideshowHtml .= Xml::openElement( 'span' );
			$slideshowHtml .= Xml::element( 'img', array( 'class' => 'chevron', 'src' => $wgBlankImgUrl ) );
			$slideshowHtml .= Xml::closeElement( 'span' );
			$slideshowHtml .= Xml::closeElement( 'a' );

			// next
			$slideshowHtml .= Xml::openElement( 'a',
				array( 'class' => 'wikia-slideshow-sprite wikia-slideshow-next', 'style' => "top: {$top}px",
					'title' =>  wfMessage( 'wikiaPhotoGallery-slideshow-view-next-tooltip' )->text() ) );
			$slideshowHtml .= Xml::openElement( 'span' );
			$slideshowHtml .= Xml::element( 'img', array( 'class' => 'chevron', 'src' => $wgBlankImgUrl ) );
			$slideshowHtml .= Xml::closeElement( 'span' );
			$slideshowHtml .= Xml::closeElement( 'a' );

			$slideshowHtml .= Xml::closeElement( 'div' );

			// render slideshow toolbar
			$slideshowHtml .= Xml::openElement( 'div', array( 'class' => 'wikia-slideshow-toolbar clearfix', 'style' => 'display: none' ) );

			// Pop-out icon, "X of X" counter
			$counterValue = wfMessage( 'wikiaPhotoGallery-slideshow-view-number', '$1', $index )->text();

			$slideshowHtml .= Xml::openElement( 'div', array( 'style' => 'float: left' ) );
				$slideshowHtml .= Xml::element( 'img',
					array(
						'class' => 'wikia-slideshow-popout lightbox',
						'height' => 11,
						'src' => "{$wgStylePath}/common/images/magnify-clip.png",
						'title' => wfMessage( 'wikiaPhotoGallery-slideshow-view-popout-tooltip' )->text(),
						'width' => 15,
					) );
				$slideshowHtml .= Xml::element( 'span',
					array( 'class' => 'wikia-slideshow-toolbar-counter', 'data-counter' => $counterValue ),
					str_replace( '$1', '1', $counterValue ) );
			$slideshowHtml .= Xml::closeElement( 'div' );

			// "Add Image"
			if ( !empty( $this->mShowAddButton ) ) {
				$slideshowHtml .= Xml::element( 'a',
					array( 'class' => 'wikia-slideshow-addimage wikia-button secondary', 'style' => 'float: right' ),
					wfMessage( 'wikiaPhotoGallery-slideshow-view-addphoto' )->inContentLanguage()->text() );
			}
			$slideshowHtml .= Xml::closeElement( 'div' );

			// close slideshow wrapper
			$slideshowHtml .= Xml::closeElement( 'div' );
			$slideshowHtml .= Xml::closeElement( 'div' );

			// output JS to init slideshow
			$width = "{$params['width']}px";
			$height = "{$params['height']}px";

			$slideshowHtml .= JSSnippets::addToStack(
				array(
					'wikia_photo_gallery_slideshow_js',
					'wikia_photo_gallery_slideshow_scss'
				),
				array(),
				'WikiaPhotoGallerySlideshow.init',
				array( 'id' => $id, 'width' => $width, 'height' => $height )
			);
		}

		wfProfileOut( __METHOD__ );
		return $slideshowHtml;
	} // renderSlideshow()

	/**
 	 * Return a HTML representation of the image slider
	 *
	 * @author Jakub Kurcek
	 */

	private function renderSlider() {
		wfProfileIn( __METHOD__ );

		// do not render empty sliders
		if ( empty( $this->mFiles ) ) {
			wfProfileOut( __METHOD__ );
			return '';
		}

		$orientation = $this->getParam( 'orientation' );

		// setup image serving for main images and navigation thumbnails
		if ( $orientation == 'mosaic' ) {
			$imagesDimensions = array(
				'w' => WikiaPhotoGalleryHelper::WIKIA_GRID_SLIDER_MOSAIC_MIN_IMG_WIDTH,
				'h' => WikiaPhotoGalleryHelper::SLIDER_MOSAIC_MIN_IMG_HEIGHT,
			);
			$sliderClass = 'mosaic';
			$thumbDimensions = array(
				"w" => WikiaPhotoGalleryHelper::WIKIA_GRID_THUMBNAIL_MAX_WIDTH,
				"h" => 100,
			);
		} else {
			$imagesDimensions = array(
				'w' => WikiaPhotoGalleryHelper::SLIDER_MIN_IMG_WIDTH,
				'h' => WikiaPhotoGalleryHelper::SLIDER_MIN_IMG_HEIGHT,
			);
			if ( $orientation == 'right' ) {
				$sliderClass = 'vertical';
				$thumbDimensions = array(
					"w" => 110,
					"h" => 50,
				);
			} else {
				$sliderClass = 'horizontal';
				$thumbDimensions = array(
					"w" => 90,
					"h" => 70,
				);
			}
		}

		$out = array();

		$sliderImageLimit = $orientation == 'mosaic' ? 5 : 4;

		foreach ( $this->mFiles as $p => $pair ) {
			/**
			 * @var $nt Title
			 * @var $text String
			 * @var $link String
			 */
			$nt = $pair[0];
			$text = $pair[1];
			$link = $pair[2];
			$linkText = $this->mData['images'][$p]['linktext'];
			$shortText = $this->mData['images'][$p]['shorttext'];

			// parse link (RT #142515)
			$linkAttribs = $this->parseLink( $nt->getLocalUrl(), $nt->getText(), $link );


			$file = wfFindFile( $nt );
			if ( $file instanceof File && ( $nt->getNamespace() == NS_FILE ) ) {
				list( $adjWidth, $adjHeight ) = $this->fitWithin( $file, $imagesDimensions );

				if ( F::app()->checkSkin( 'wikiamobile' ) ) {
					$imageUrl = wfReplaceImageServer( $file->getUrl(), $file->getTimestamp() );
				} else {
					$imageUrl = $this->resizeURL( $file, $imagesDimensions );
				}

				// generate navigation thumbnails
				$thumbUrl = $this->cropURL( $file, $thumbDimensions );

				// Handle videos
				$videoHtml = false;
				$videoPlayButton = false;
				$navClass = '';

				if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
					// Get HTML for main video image
					$htmlParams = array(
						'file-link' => true,
						'linkAttribs' => array( 'class' => 'wikiaPhotoGallery-slider force-lightbox' ),
					);

					$videoHtml = $file->transform( array( 'width' => $imagesDimensions['w'] ) )->toHtml( $htmlParams );

					// Get play button overlay for little video thumb
					$videoPlayButton = $this->getVideoPlayButton();
					$navClass = 'xxsmall video-thumbnail';
				}

				$data = array(
					'imageUrl' => $imageUrl,
					'imageTitle' => Sanitizer::removeHTMLtags( $text ),
					'imageName' => $file->getTitle()->getText(),
					'imageKey' => $file->getTitle()->getDBKey(),
					'imageShortTitle' => Sanitizer::removeHTMLtags( $shortText ),
					'imageLink' => !empty( $link ) ? $linkAttribs['href'] : '',
					'imageDescription' => Sanitizer::removeHTMLtags( $linkText ),
					'imageThumbnail' => $thumbUrl,
					'adjWidth' => $adjWidth,
					'adjHeight' => $adjHeight,
					'centerTop' => ( $imagesDimensions['h'] > $adjHeight ) ? intval( ( $imagesDimensions['h'] - $adjHeight ) / 2 ) : 0,
					'centerLeft' => ( $imagesDimensions['w'] > $adjWidth ) ? intval( ( $imagesDimensions['w'] - $adjWidth ) / 2 ) : 0,
					'videoHtml' => $videoHtml,
					'videoPlayButton' => $videoPlayButton,
					'navClass' => $navClass,
				);

				if ( F::app()->checkSkin( 'wikiamobile' ) ) {
					$origWidth = $file->getWidth();
					$origHeight = $file->getHeight();
					$size = WikiaMobileMediaService::calculateMediaSize( $origWidth, $origHeight );
					$thumb = $file->transform( $size );

					$imageAttribs = array(
						'src' => wfReplaceImageServer( $thumb->getUrl(), $file->getTimestamp() ),
						'width' => $size['width'],
						'height' => $size['height']
					);

					$imageParams = array( 'full' => $imageUrl );

					if ( $this->mParser ) {
						$this->mParser->replaceLinkHolders( $text );
					}

					$data['mediaInfo'] = array(
						'attributes' => $imageAttribs,
						'parameters' => $imageParams,
						'caption' => $text,
						'noscript' => Xml::element( 'img', $imageAttribs, '', true )
					);
				}

				$out[] = $data;
			}

			if ( count( $out ) >= $sliderImageLimit ) {
				break;
			}
		}

		$html = '';

		// check if we have something to show (images might not match required sizes)
		if ( count( $out ) ) {
			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates' );
			$template->set_vars( array(
				'sliderClass' => $sliderClass,
				'files' => $out,
				'thumbDimensions' => $thumbDimensions,
				'sliderId' => $this->mData['id'],
				'imagesDimensions' => $imagesDimensions,
			) );

			if ( F::app()->checkSkin( 'wikiamobile' ) ) {
				$html = $template->render( 'renderWikiaMobileSlider' );
			} else if ( $orientation == 'mosaic' ) {
				$html = $template->render( 'renderMosaicSlider' );
			} else {
				$html = $template->render( 'renderSlider' );
			}

			if ( $orientation == 'mosaic' ) {
				$sliderResources = array(
					'wikia_photo_gallery_mosaic_js',
					'wikia_photo_gallery_mosaic_scss'
				);
				$javascriptInitializationFunction = 'WikiaMosaicSliderMasterControl.init';
			} else {
				$sliderResources = array(
					'wikia_photo_gallery_slider_js',
					'wikia_photo_gallery_slider_scss'
				);
				$javascriptInitializationFunction = 'WikiaPhotoGallerySlider.init';
			}

			$html .= JSSnippets::addToStack(
				$sliderResources,
				array(),
				$javascriptInitializationFunction,
				array( $this->mData['id'] )
			);

			// load WikiaMobile resources if needed using JSSnippets filtering mechanism
			$html .= JSSnippets::addToStack(
				array(
					'wikiaphotogallery_slider_scss_wikiamobile',
					'wikiaphotogallery_slider_js_wikiamobile'
				)
			);
		}

		wfProfileOut( __METHOD__ );
		return $html;

	}

	/**
	 * Return height and width for the image $file, to fit within the bounds given by $dim.  This
	 * preserves the aspect ratio for $file.  The original file height and width will be returned for images
	 * both shorter and narrower than $dim.
	 *
	 * @param File $file
	 * @param array $dim
	 * @return array
	 */
	public function fitWithin( File $file, array $dim ) {
		$adjWidth = $file->getWidth();
		$adjHeight = $file->getHeight();

		// If the image extends beyond the given dimensions in height or width then scale down the image to fit
		// entirely within the dimensions
		if (
			( $adjWidth > 0 && $adjHeight > 0 ) &&
			( ( $adjWidth > $dim['w'] ) || ( $adjHeight > $dim['h'] ) )
		) {
			$aspect = $adjWidth / $adjHeight;
			if ( ( $adjWidth - $dim['w'] ) > ( $adjHeight - $dim['h'] ) ) {
				// Oversized image, constrain on width
				$adjWidth = $dim['w'];
				$adjHeight = intval( $adjWidth / $aspect );
			} else {
				// Oversized image, constrain on height
				$adjHeight = $dim['h'];
				$adjWidth = intval( $adjHeight * $aspect );
			}
		}

		return [$adjWidth, $adjHeight];
	}

	/**
	 * Return height and width for image $file such that the image is shrunk (keeping aspect ratio) to just the
	 * height or width of $dim, whichever is closest.  Typically the image will then be cropped to the $dim bounds.
	 * The original file height and width will be returned for images both shorter and narrower than $dim.
	 *
	 * @param File $file
	 * @param array $dim
	 * @return array
	 */
	public function fitClosest( File $file, array $dim ) {
		$aspect = $file->getWidth() / $file->getHeight();
		$adjWidth = $file->getWidth();
		$adjHeight = $file->getHeight();

		// Adjust the image to the closest dimension.
		if ( ( $file->getWidth() > $dim['w'] ) || ( $file->getHeight() > $dim['h'] ) ) {
			$widthDelta = $file->getWidth() - $dim['w'];
			$heightDelta = $file->getHeight() - $dim['h'];

			if ( ( $widthDelta > 0 ) && ( $widthDelta < $heightDelta ) ) {
				// Oversized image, constrain on width
				$adjWidth = $dim['w'];
				$adjHeight = intval( $adjWidth / $aspect );
			} else {
				// Oversized image, constrain on height
				$adjHeight = $dim['h'];
				$adjWidth = intval( $adjHeight * $aspect );
			}
		}

		return [$adjWidth, $adjHeight];
	}

	/**
	 * Return a URL that displays $file shrunk to fit within the bounding box $box.  Images smaller than the bounding
	 * box will not be affected.  The effect is an image that fits completely within the $box, but may have empty space
	 * on either side or on top and bottom.
	 *
	 * @param File $file
	 * @param array $box An array of width and height giving the bounds (as a height and width) of the new image.
	 *                   Keys are:
	 *                   w : the bounding width
	 *                   h : the bounding height
	 * @return String
	 */
	public function resizeURL( File $file, array $box ) {
		list( $adjWidth, $_ ) = $this->fitWithin( $file, $box );

		return $file->getUrlGenerator()
			->scaleToWidth( $adjWidth )
			->url();
	}

	/**
	 * Return a URL that displays $file shrunk to have the closest dimension meet $box.  Images smaller than the
	 * bounding box will not be affected.  The part of the image that extends beyond the $box dimensions will be
	 * cropped out.  The result is an image that completely fills the box with no empty space, but is cropped.
	 *
	 * @param File $file
	 * @param array $box
	 *
	 * @return String
	 */
	private function cropURL( File $file, array $box ) {
		return $file->getUrlGenerator()
			->zoomCropDown()
			->width( $box['w'] )
			->height( $box['h'] )
			->url();
	}

	/**
	 * Get object for given image (and call hook)
	 *
	 * @param Title $nt Title object for the image
	 *
	 * @return File
	 */
	private function getImage( $nt ) {
		wfProfileIn( __METHOD__ );

		// Render image thumbnail
		$img = wfFindFile( $nt );

		wfProfileOut( __METHOD__ );
		return $img;
	}

	/**
	 * Renders a gallery/slideshow as a media group in the WikiaMobile skin
	 */
	private function renderWikiaMobileMediaGroup() {
		$media = [];
		$result = '';

		foreach ( $this->mFiles as $val ) {
			$item = wfFindFile( $val[0] );

			if ( !empty( $item ) ) {
				$media[] = array(
					'title' => $val[0],
					'caption' => $val[3],
					'link' => $val[2]
				);
			}
		}

		if ( !empty( $media ) ) {
			$result = F::app()->renderView(
				'WikiaMobileMediaService',
				'renderMediaGroup',
				[
					'items' => $media,
					'parser' => $this->mParser
				]
			);
		}

		return $result;
	}

	/**
	 * Render Media Gallery (gallery version 2014)
	 * @return string
	 */
	private function renderMediaGallery() {
		$media = [];
		$result = '';

		foreach ( $this->mFiles as $val ) {
			$file = wfFindFile( $val[0] );

			if ( empty( $file ) ||
				WikiaFileHelper::isFileTypeVideo( $file ) ||
				WikiaFileHelper::isFileTypeOgg( $file ) ) {
				continue;
			}

			$media[] = [
				'title' => $val[0],
				'caption' => $val[3],
				'link' => $val[2],
			];
		}

		if ( !empty( $media ) ) {
			$result = F::app()->renderView(
				'MediaGalleryController',
				'gallery',
				[
					'items' => $media,
					'gallery_params' => $this->mData['params'],
					'parser' => $this->mParser,
				]
			);
		}

		return $result;
	}
}
