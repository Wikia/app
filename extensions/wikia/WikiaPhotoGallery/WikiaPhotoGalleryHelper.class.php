<?php

class WikiaPhotoGalleryHelper {

	// thumbnails shown in search results / list of recenlty uploaded images
	const resultsThumbnailMaxWidth = 120;
	const resultsThumbnailMaxHeight = 90;

	// thumbnails shown in  gallery preview
	const previewThumbnailMaxWidth = 125;
	const previewThumbnailMaxHeight = 125;

	// thumbnails shown on conflict resolving page / caption/link page
	const thumbnailMaxWidth = 200;
	const thumbnailMaxHeight = 200;

	// dimensions for the smallest slider image (BugId:2787)
	const SLIDER_MIN_IMG_WIDTH = 670;
	const SLIDER_MIN_IMG_HEIGHT = 360;
	const SLIDER_MOSAIC_MIN_IMG_WIDTH = 320;
	const SLIDER_MOSAIC_MIN_IMG_HEIGHT = 210;

	/* temp transition code until grid is fully rolled out, remove and integrate after transition */
	const WIKIA_GRID_THUMBNAIL_MAX_WIDTH = 160;
	const WIKIA_GRID_SLIDER_MOSAIC_MIN_IMG_WIDTH = 330;
	/* end temp transistion code */

	const STRICT_IMG_WIDTH_PREV = 320;
	const STRICT_IMG_HEIGHT_PREV = 157;

	/**
	 * Used to store wikitext between calls to useDefaultRTEPlaceholder and renderGalleryPlaceholder
	 */
	private static $mWikitextIdx;

	// used when parsing and getting gallery data
	private static $mGalleryHash;
	private static $mGalleryData;
	public static $lastGalleryData;

	/**
	 * Creates instance of object to be used to render an image gallery by MW parser
	 */
	static public function setup(&$ig, &$text, &$params) {
		wfProfileIn(__METHOD__);

		$ig = new WikiaPhotoGallery();

		// store content of <gallery> tag
		$ig->setText($text);

		// parse attributes of <gallery> tag
		$ig->parseParams($params);

		// calculate "unique" hash of each gallery
		$ig->calculateHash($params);

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Allow this extension to use its own "parser" for <gallery> tag content
	 */
	static public function beforeRenderImageGallery(&$parser, &$ig) {
		$ig->parse($parser);
		// by returning false we're telling MW parser to return gallery's HTML immediatelly
		return false;
	}

	/**
	 * Skip rendering of RTE placeholders for <gallery> and generate our own
	 */
	static public function useDefaultRTEPlaceholder($name, $params, $frame, $wikitextIdx) {
		$name = strtolower($name);

		if ($name == 'gallery') {
			self::$mWikitextIdx = $wikitextIdx;

			// generate custom placeholder for <gallery> tag
			return false;
		}
		else {
			return true;
		}
	}

	/**
	 * Load extension's JS on edit page
	 */
	static public function setupEditPage($editform) {
		$app = F::app();

		wfProfileIn( __METHOD__ );

		if ( $app->checkSkin( [ 'oasis' ] ) ) {
			$app->wg->Out->addModules( 'ext.WikiaPhotoGallery' );

			// load message for MW toolbar button tooltip
			$wgHooks['MakeGlobalVariablesScript'][] = 'WikiaPhotoGalleryHelper::makeGlobalVariablesScript';
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Add message for MW toolbar button tooltip
	 */
	static public function makeGlobalVariablesScript(Array &$vars) {
		$vars['WikiaPhotoGalleryAddGallery'] = wfMsg('wikiaPhotoGallery-add-gallery');
		return true;
	}

	/* temp transition code until grid is fully rolled out, remove and integrate after transition */
	static public function makeGlobalVariablesScriptForWikiaGrid(Array &$vars) {
		global $wgOasisGrid;

		$vars['wgEnableWikiaPhotoGalleryExt'] = true;
		$vars['wgOasisGrid'] = $wgOasisGrid;

		return true;
	}
	/* end temp transistion code */

	/**
	 * Render gallery placeholder for RTE
	 *
	 * @param $gallery WikiaPhotoGallery
	 * @param $width Integer
	 * $param $height Integer
	 */
	static public function renderGalleryPlaceholder($gallery, $width, $height) {
		wfProfileIn(__METHOD__);

		$data = $gallery->getData();
		$class = 'media-placeholder image-gallery';

		if ( $data['type'] == WikiaPhotoGallery::WIKIA_PHOTO_SLIDESHOW ) {
			$class .= ' image-slideshow';
		}

		// support "position" attribute (gallery alignment)
		switch ($gallery->getParam('position')) {
			case 'left':
				$class .= ' alignLeft';
				break;
			case 'center':
				$class .= ' alignCenter';
				break;
			case 'right':
				$class .= ' alignRight';
				break;
		}

		if ( $data['type'] == WikiaPhotoGallery::WIKIA_PHOTO_SLIDER ) {
			$class .= ' image-gallery-slider';
		}

		global $wgBlankImgUrl;
		$attribs = array(
			'src' => $wgBlankImgUrl,
			'class' => $class,
			'type' => 'image-gallery',
			'height' => $height,
			'width' => $width,
		);

		// render image for media placeholder
		$ret = Xml::element('img', $attribs);

		// store wikitext
		$data['wikitext'] = RTEData::get('wikitext', self::$mWikitextIdx);

		// store data and mark HTML
		$dataIdx = RTEData::put('data', $data);
		$ret = RTEData::addIdxToTag($dataIdx, $ret);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Parse given link and return link tag attributes
	 */
	static public function parseLink(&$parser, $url, $text, $link) {
		// fallback: link to image page + lightbox
		$linkAttribs = array(
			'class' => 'image lightbox',
			'href' => $url,
			'title' => $text,
		);

		// detect internal / external links (|links= param)
		if ($link != '') {
			$chars = Parser::EXT_LINK_URL_CLASS;
			$prots = $parser->mUrlProtocols;

			if (preg_match( "/^$prots/", $link)) {
				if (preg_match( "/^($prots)$chars+$/", $link, $m)) {
					// external link found
					$parser->mOutput->addExternalLink($link);

					$linkAttribs['class'] = 'image link-external';
					$linkAttribs['href'] = $link;
					$linkAttribs['title'] = $link;
				}
			} else {
				$linkTitle = Title::newFromText($link);
				if ($linkTitle) {
					// internal link found
					$parser->mOutput->addLink( $linkTitle );

					$linkAttribs['class'] = 'image link-internal';
					$linkAttribs['href'] = $linkTitle->getLocalUrl();
					$linkAttribs['title'] = $link;
				}
			}
		}

		return $linkAttribs;
	}

	/**
	 * Return dimensions for thumbnail of given image to fit given area (handle "crop" attribute)
	 *
	 * @param $img File
	 * @param $maxWidth Integer
	 * @param $maxHeight Integer
	 * @param $crop Bool
	 *
	 * @return array
	 */
	static public function getThumbnailDimensions($img, $maxWidth, $maxHeight, $crop = false) {
		wfProfileIn(__METHOD__);

		// image has to fit width x height box
		$thumbParams = array(
			'height' => min($img->getHeight(), $maxHeight),
			'width' => min($img->getWidth(), $maxWidth),
		);

		// support "crop" attribute
		if (!empty($crop)) {
			//avoid division by zero #59972
			$widthResize = (!empty($maxWidth)) ? $img->getWidth() / $maxWidth : 1;
			$heightResize = (!empty($maxHeight)) ? $img->getHeight() / $maxHeight : 1;

			$resizeRatio = min($widthResize, $heightResize);

			//avoid division by zero
			if(!$resizeRatio) $resizeRatio = 1;

			if(!$resizeRatio) $resizeRatio = 1;

			$thumbParams = array(
				'height' => min($img->getHeight(), round($img->getHeight() / $resizeRatio)),
				'width' => min($img->getWidth(), round($img->getWidth() / $resizeRatio)),
			);
		}

		wfProfileOut(__METHOD__);
		return $thumbParams;
	}

	/**
	 * Get URL of given image's thumbnail with given dimensions (or use default values)
	 */
	static public function getThumbnailUrl($title, $width = false, $height = false) {
		wfProfileIn(__METHOD__);

		$url = false;

		if ($title instanceof Title) {
			$image = wfFindFile($title);

			if (!empty($image)) {
				if (empty($width))  $width = self::thumbnailMaxWidth;
				if (empty($height)) $height = self::thumbnailMaxHeight;

				$width = min($width, $image->getWidth());
				$height = min($height, $image->getHeight());

				$url = $image->createThumb( $width, $height );
			}
		}

		wfProfileOut(__METHOD__);
		return $url;
	}

	/**
	 * Return HTML of given image's thumbnail with given dimensions (or use default values)
	 */
	static public function renderThumbnail($title, $width = false, $height = false) {
		wfProfileIn(__METHOD__);

		$html = false;

		if ($title instanceof Title) {
			$image = wfFindFile($title);

			if (!empty($image)) {
				if (empty($width))  $width = self::thumbnailMaxWidth;
				if (empty($height)) $height = self::thumbnailMaxHeight;

				$width = min($width, $image->getWidth());
				$height = min($height, $image->getHeight());

				$thumb = $image->transform( array( 'width' => $width, 'height' => $height ) );
				$html = $thumb->toHtml();
			}
		}

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Return URL of given image's thumbnail for search results
	 */
	static public function getResultsThumbnailUrl($title) {
		return self::getThumbnailUrl($title, self::resultsThumbnailMaxWidth, self::resultsThumbnailMaxHeight);
	}

	/**
	 * Render list of images to HTML
	 */
	static public function renderImagesList($type, $images) {
		wfProfileIn(__METHOD__);

		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'type' => $type,
			'images' => $images,
			'perRow' => 4,
		));

		$html = $template->render('imagesList');

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Render gallery preview
	 *
	 * @author Macbre, Lox
	 */
	static public function renderGalleryPreview($gallery) {
		global $wgTitle, $wgParser, $wgExtensionsPath;
		wfProfileIn(__METHOD__);

		//wfDebug(__METHOD__ . "\n" . print_r($gallery, true));

		// use global instance of parser (RT #44689 / RT #44712)
		$parserOptions = new ParserOptions();

		// render thumbnail and parse caption for each image (default "box" is 200x200)
		$thumbSize = !empty($gallery['params']['widths']) && is_numeric($gallery['params']['widths']) ? $gallery['params']['widths'] : 185;
		$borderSize = (!empty($gallery['params']['bordersize'])) ? $gallery['params']['bordersize'] : 'small';
		$orientation = !empty($gallery['params']['orientation']) ? $gallery['params']['orientation'] : 'none';
		$ratio = self::getRatioFromOption($orientation);
		$crop = true;

		//calculate height of the biggest image
		$maxHeight = 0;
		$imageTitlesCache = array();
		$fileObjectsCache = array();
		$heights = array();
		$widths = array();

		// loop throught the images and get height of the tallest one
		if(!empty($gallery['images'])){
			foreach ($gallery['images'] as $index => $image) {
				$imageTitlesCache[$index] = Title::newFromText($image['name'], NS_FILE);
				$fileObjectsCache[$index] = wfFindFile($imageTitlesCache[$index]);

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

				if ( $imageHeight >  $maxHeight ) {
					$maxHeight = $imageHeight;
				}
			}
		}

		// calculate height based on gallery width
		$height = round($thumbSize / $ratio);

		if ($orientation == 'none') {
			$crop = false;

			// use the biggest height found
			if ($maxHeight > 0) {
				$height = $maxHeight;
			}

			// limit height (RT #59355)
			$height = min($height, $thumbSize);

			// recalculate dimensions (RT #59355)
			if(!empty($gallery['images'])){
				foreach($gallery['images'] as $index => $image) {
					if(!empty($heights[$index]) && !empty($widths[$index])) {
						//fix #59355, min() added to let borders wrap images with smaller width
						//fix #63886, round ( $tmpFloat ) != floor ( $tmpFloat ) added to check if thumbnail will be generated from proper width
						$tmpFloat = ( $widths[$index] * $height / $heights[$index] );
						$widths[$index] = min( $widths[$index], floor( $tmpFloat ));
						$heights[$index] = min( $height, $heights[$index]);
						if ( round ( $tmpFloat ) != floor ( $tmpFloat ) ){
							$heights[$index] --;
						}
					} else {
						$widths[$index] = $thumbSize;
						$heights[$index] = $height;
					}
				}
			}
		}

		if(!empty($gallery['images'])){
			foreach($gallery['images'] as $index => &$image) {
				$image['placeholder'] = false;

				$imageTitle = (!empty($imageTitlesCache[$index])) ? $imageTitlesCache[$index] : Title::newFromText($image['name'], NS_FILE);
				$fileObject = (!empty($fileObjectsCache[$index])) ? $fileObjectsCache[$index] : wfFindFile($imageTitle);

				if (empty($imageTitle)) {
					continue;
				}

				$image['height'] = $height;
				$image['width'] = $thumbSize;

				if (!is_object($fileObject) || ($imageTitle->getNamespace() != NS_FILE)) {
					$image['titleText'] = $imageTitle->getText();
					$image['thumbnail'] = false;
					continue;
				}

				$thumbParams = self::getThumbnailDimensions($fileObject, $thumbSize, $height, $crop);
				$image['thumbnail'] = self::getThumbnailUrl($imageTitle, $thumbParams['width'], $thumbParams['height']);

				$image['height'] = ($orientation == 'none') ? $heights[$index] : min($thumbParams['height'], $height);
				$imgHeightCompensation = ($height - $image['height']) / 2;
				if($imgHeightCompensation > 0) $image['heightCompensation'] = $imgHeightCompensation;

				$image['width'] = min($widths[$index], $thumbSize);
				//Fix #59914, shared.css has auto-alignment rules
				/*$imgWidthCompensation = ($thumbSize - $image['width']) / 2;
				if($imgHeightCompensation > 0) $image['widthCompensation'] = $imgWidthCompensation;*/


				//need to use parse() - see RT#44270
				//need to remove wapping p coming from caption editor to match view
				$image['caption'] = str_replace(array('<p>', '</p>'), array(null, '<br />'), $wgParser->parse($image['caption'], $wgTitle, $parserOptions)->getText());
			}
		}

		// filter out skipped images
		//$gallery['images'] = array_filter($gallery['images']);

		// show at least four placeholders:
		// - if we don't have enough images - show "Add a picture" placeholders
		// - if we have four and more images - show just one "Add a picture" placeholder
		$placeholdersCount = max(4 - count($gallery['images']), 1);

		for ($p = 0; $p < $placeholdersCount; $p++) {
			$gallery['images'][] = array(
				'placeholder' => true,
				'height' => $height,
				'width' => $thumbSize,
				'thumbnail' => "{$wgExtensionsPath}/wikia/WikiaPhotoGallery/images/gallery_addimage.png",
				'caption' => wfMsg('wikiaPhotoGallery-preview-placeholder-caption'),
				'heightCompensation' => false,
			);
		}

		//compensate image wrapper width depending on the border size
		switch($borderSize) {
			case 'large':
				$thumbSize += 10; //5px * 2
				$height += 10;
				break;
			case 'medium':
				$thumbSize += 4; //2px * 2
				$height += 4;
				break;
			case 'small':
				$thumbSize += 2; //1px * 2
				$height += 2;
				break;
		}

		//wfDebug(__METHOD__.'::after' . "\n" . print_r($gallery, true));

		// render gallery HTML preview
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'gallery' => $gallery,
			'width' => $thumbSize,
			'perRow' => (!empty($gallery['params']['columns'])) ? intval($gallery['params']['columns']): 'dynamic',
			'position' => (!empty($gallery['params']['position'])) ? $gallery['params']['position'] : 'left',
			'captionsPosition' => (!empty($gallery['params']['captionposition'])) ? $gallery['params']['captionposition'] : 'below',
			'captionsAlign' => (!empty($gallery['params']['captionalign'])) ? $gallery['params']['captionalign'] : 'left',
			'captionsSize' => (!empty($gallery['params']['captionsize'])) ? $gallery['params']['captionsize'] : 'medium',
			'captionsColor' => (!empty($gallery['params']['captiontextcolor'])) ? $gallery['params']['captiontextcolor'] : null,
			'spacing' => (!empty($gallery['params']['spacing'])) ? $gallery['params']['spacing'] : 'medium',
			'borderSize' => $borderSize,
			'borderColor' => (!empty($gallery['params']['bordercolor'])) ? $gallery['params']['bordercolor'] : 'accent',
			'maxHeight' => $height
		));

		$html = $template->render('galleryPreview');

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Render slideshow preview
	 */
	static public function renderSlideshowPreview($slideshow) {
		global $wgTitle, $wgParser;
		wfProfileIn(__METHOD__);

		// use global instance of parser (RT #44689 / RT #44712)
		$parserOptions = new ParserOptions();

		wfDebug(__METHOD__ . "\n" . print_r($slideshow, true));

		// handle "crop" attribute
		$crop = isset($slideshow['params']['crop']) ? ($slideshow['params']['crop'] == 'true') : false;

		// render thumbnail
		$maxWidth = isset($slideshow['params']['widths']) && is_numeric($slideshow['params']['widths']) ? $slideshow['params']['widths'] : 300;
		$maxHeight = round($maxWidth * 3/4);

		wfDebug(__METHOD__ . " - {$maxWidth}x{$maxHeight}\n");

		if (!empty($slideshow['params']['showrecentuploads'])) {
			// add recently uploaded images only
			$uploadedImages = MediaQueryService::getRecentlyUploaded(WikiaPhotoGallery::RECENT_UPLOADS_IMAGES);

			$slideshow['images'] = array();

			foreach($uploadedImages as $imageTitle) {
				$img = wfFindFile($imageTitle);
				if (empty($img)) {
					continue;
				}

				// render thumbnail
				$dimensions = self::getThumbnailDimensions($img, $maxWidth, $maxHeight, $crop);

				$slideshow['images'][] = array(
					'name' => $imageTitle->getText(),
					'thumbnailBg' => self::getThumbnailUrl($imageTitle, $dimensions['width'], $dimensions['height']),
					'recentlyUploaded' => true,
				);
			}
		} else {
			// render slideshow images
			foreach($slideshow['images'] as &$image) {
				// don't render recently uploaded images now, render them after "regular" images
				if (!empty($image['recentlyUploaded'])) {
					$image = false;
					continue;
				}

				$imageTitle = Title::newFromText($image['name'], NS_FILE);
				$img = wfFindFile($imageTitle);

				$image['isFileTypeVideo'] = WikiaFileHelper::isFileTypeVideo($img);

				//need to use parse() - see RT#44270
				$image['caption'] = $wgParser->parse($image['caption'], $wgTitle, $parserOptions)->getText();

				// remove <p> tags from parser caption
				if (preg_match('/^<p>(.*)\n?<\/p>\n?$/sU', $image['caption'], $m)) {
					$image['caption'] = $m[1];
				}

				if (empty($imageTitle) || empty($img)) {
					continue;
				}

				if ($imageTitle->getNamespace() == NS_FILE) {
					// render thumbnail
					$dimensions = self::getThumbnailDimensions($img, $maxWidth, $maxHeight, $crop);
					$image['thumbnailBg'] = self::getThumbnailUrl($imageTitle, $dimensions['width'], $dimensions['height']);
				} else {
					$image[ 'pageTitle' ] = $imageTitle->getText();
				}
			}

			// filter out skipped images
			//$slideshow['images'] = array_filter($slideshow['images']);
		}

		wfDebug(__METHOD__.'::after' . "\n" . print_r($slideshow, true));

		// render gallery HTML preview
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'height' => $maxHeight,
			'slideshow' => $slideshow,
			'width' => $maxWidth,
		));
		$html = $template->render('slideshowPreview');

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Render slider preview
	 *
	 * @author Jakub Kurcek
	 */

	static public function renderSliderPreview($slider) {
		global $wgTitle, $wgParser;
		wfProfileIn(__METHOD__);

		// use global instance of parser (RT #44689 / RT #44712)
		$parserOptions = new ParserOptions();

		wfDebug(__METHOD__ . "\n" . print_r($slider, true));

		// render slider images
		foreach($slider['images'] as &$image) {
			$imageTitle = Title::newFromText($image['name'], NS_FILE);
			$image['pageTitle'] = '';
			$img = wfFindFile($imageTitle);

			if ( is_object( $img ) && ( $imageTitle->getNamespace() == NS_FILE ) ) {
				// render thumbnail
				$is = new ImageServing(null, self::STRICT_IMG_WIDTH_PREV, array(
					'w' => self::STRICT_IMG_WIDTH_PREV,
					'h' => self::STRICT_IMG_HEIGHT_PREV)
				);
				$image['thumbnailBg'] = $is->getUrl($image['name'],  $img->getWidth(),  $img->getHeight());
			} elseif ( is_object( $imageTitle ) ) {
				$image[ 'pageTitle' ] = $imageTitle->getText();
			}

			$image['videoPlayButton'] = false;
			if( WikiaFileHelper::isFileTypeVideo($img) ) {
				// Get play button overlay for video thumb
				$image['videoPlayButton'] = '<span class="play-circle"></span>';
			}

			//need to use parse() - see RT#44270
			$image['caption'] = $wgParser->parse($image['caption'], $wgTitle, $parserOptions)->getText();

			// remove <p> tags from parser caption
			if (preg_match('/^<p>(.*)\n?<\/p>\n?$/sU', $image['caption'], $m)) {
				$image['caption'] = $m[1];
			}
		}

		wfDebug(__METHOD__.'::after' . "\n" . print_r($slider, true));

		// render gallery HTML preview
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'height' => self::STRICT_IMG_HEIGHT_PREV,
			'slider' => $slider,
			'width' => self::STRICT_IMG_WIDTH_PREV,
		));
		$html = $template->render('sliderPreview');

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Get thumbs of recently uploaded files
	 */
	static public function getRecentlyUploadedThumbs($limit = 50) {
		wfProfileIn(__METHOD__);
		$ret = array();

		// get list of recently uploaded images
		$uploadedImages = MediaQueryService::getRecentlyUploaded($limit);
		if(is_array($uploadedImages)) {
			foreach($uploadedImages as $image) {

				$thumb = self::getResultsThumbnailUrl($image);
				if ($thumb) {
					// use keys to remove duplicates
					$ret[] = array(
						'name' => $image->getText(),
						'thumb' => $thumb
					);
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Get thumbs of images from given page
	 */
	static public function getImagesFromPageThumbs($title, $limit = 50) {
		wfProfileIn(__METHOD__);

		$ret = array();

		// get list of images linked with given article
		/**
		 * @var $mediaQuery MediaQueryService
		 */
		$mediaQuery =  (new MediaQueryService);
		$images = $mediaQuery->getMediaFromArticle($title, MediaQueryService::MEDIA_TYPE_IMAGE, $limit);

		foreach($images as $entry) {
			$image = Title::newFromText($entry['title'], NS_FILE);
			$thumb = self::getResultsThumbnailUrl($image);
			if ($thumb) {
				$ret[] = array(
					'name' => $image->getText(),
					'thumb' => $thumb

				);
			}
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Return thumbs of images search result
	 */
	static public function getSearchResultThumbs( $query, $limit = 50 ) {
		wfProfileIn(__METHOD__);
		$images = array();

		if( !empty( $query ) ) {
			$mediaService = new MediaQueryService();
			$results = $mediaService->searchInTitle( $query, 1, $limit );

			if( !empty( $results['images'] ) ) {
				foreach( $results['images'] as $img ) {
					$oImageTitle = Title::newFromText($img['title'], NS_FILE );

					$thumb = self::getResultsThumbnailUrl( $oImageTitle );
					if ( $thumb ) {
						$images[] = array(
							'name' => $oImageTitle->getText(),
							'thumb' => $thumb
						);
					}
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $images;
	}

	/**
	 * AJAX helper called from view mode to save gallery data
	 * @author Marooned
	 */
	static public function saveGalleryDataByHash($hash, $wikitext, $starttime) {
		global $wgTitle, $wgUser;

		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . ": {$wikitext}\n");

		$result = array();

		// save changed gallery
		$rev = Revision::newFromTitle($wgTitle);

		// try to fix fatal (article has been removed since user opened the page)
		if (empty($rev)) {
			$result['info'] = 'conflict';

			wfDebug(__METHOD__ . ": revision is empty\n");
			wfProfileOut(__METHOD__);
			return $result;
		}

		$articleWikitext = $rev->getText();
		$gallery = '';

		preg_match_all('%<gallery([^>]*)>(.*?)</gallery>%s', $articleWikitext, $matches, PREG_PATTERN_ORDER);
		for ($i = 0; $i < count($matches[0]); $i++) {
			$attribs = Sanitizer::decodeTagAttributes($matches[1][$i]);
			//count hash from attribs and content
			if (md5($matches[2][$i] . implode('', $attribs)) == $hash) {
				$gallery = $matches[0][$i];
				break;
			}
		}

		if (empty($gallery)) {
			$result['info'] = 'conflict';

			wfDebug(__METHOD__ . ": conflict found\n");
		} else {
			$articleWikitext = str_replace($gallery, $wikitext, $articleWikitext);

			//saving
			if($wgTitle->userCan('edit') && !$wgUser->isBlocked()) {
				$result = null;
				$article = new Article($wgTitle);
				$editPage = new EditPage($article);
				$editPage->edittime = $article->getTimestamp();
				$editPage->starttime = $starttime;
				$editPage->textbox1 = $articleWikitext;
				$editPage->summary = wfMsgForContent('wikiaPhotoGallery-edit-summary');

				// watch all my edits / preserve watchlist (RT #59138)
				if ($wgUser->getGlobalPreference('watchdefault')) {
					$editPage->watchthis = true;
				}
				else {
					$editPage->watchthis = $editPage->mTitle->userIsWatching();
				}

				$bot = $wgUser->isAllowed('bot');
				$status = $editPage->internalAttemptSave( $result, $bot );
				$retval = $status->value;

				Wikia::log( __METHOD__, "editpage", "Returned value {$retval}" );

				switch ($retval) {
					case EditPage::AS_SUCCESS_UPDATE:
					case EditPage::AS_SUCCESS_NEW_ARTICLE:
						$wgTitle->invalidateCache();
						Article::onArticleEdit($wgTitle);
						$result['info'] = 'ok';
						break;

					case EditPage::AS_SPAM_ERROR:
						$result['error'] = wfMsg('spamprotectiontext') . '<p>( Call #4 )</p>';
						break;

					default:
						$result['error'] = wfMsg('wikiaPhotoGallery-edit-abort');
				}
			} else {
				$result['error'] = wfMsg('wikiaPhotoGallery-error-user-rights');
			}
			if (isset($result['error'])) {
				$result['errorCaption'] = wfMsg('wikiaPhotoGallery-error-caption');
			}
			//end of saving

			wfDebug(__METHOD__ . ": saving from view mode done\n");

			// commit (RT #48304)
			$dbw = wfGetDB(DB_MASTER);
			$dbw->commit();
		}

		wfProfileOut(__METHOD__);

		return $result;
	}

	static public function initParserHook() {
		global $wgHooks;
		//overwrite previous hooks returning `false`
		$wgHooks['BeforeParserrenderImageGallery'] = array('WikiaPhotoGalleryHelper::beforeParserrenderImageGallery');
	}

	/**
	 * AJAX helper called from view mode to get gallery data
	 * @author Marooned
	 */
	static public function getGalleryDataByHash( $hash, $articleId, $revisionId = 0, $type = WikiaPhotoGallery::WIKIA_PHOTO_GALLERY ) {
		global $wgUser, $wgOut;
		wfProfileIn( __METHOD__ );

		self::initParserHook();
		self::$mGalleryHash = $hash;

		$parserOptions = new ParserOptions();

		$title = Title::newFromId( $articleId );
		if ( !$title ) {
			$result['error'] = wfMsg( 'wikiaPhotoGallery-error-wrong-title' );
			$result['errorCaption'] = wfMsg( 'wikiaPhotoGallery-error-caption' );

			wfProfileOut( __METHOD__ );
			return $result;
		}

		// let's parse current version of wikitext and store data of gallery with provided hash in self::$mGalleryData
		$rev = Revision::newFromTitle( $title, $revisionId );
		//should never happen
		if (!is_null($rev)) {
			$wikitext = $rev->getText();
			ParserPool::parse( $wikitext, $title, $parserOptions )->getText();
		}

		// Marooned: check block state of user (RT #55274)
		$permissionErrors = $title->getUserPermissionsErrors('edit', $wgUser);
		if (count($permissionErrors) && $type == WikiaPhotoGallery::WIKIA_PHOTO_GALLERY) {
			$result['error'] = $wgOut->parse($wgOut->formatPermissionsErrorMessage($permissionErrors));
			$result['errorCaption'] = wfMsg('wikiaPhotoGallery-error-caption');
		}
		elseif (empty(self::$mGalleryData)) {
			$result['error'] = wfMsg('wikiaPhotoGallery-error-outdated');
			$result['errorCaption'] = wfMsg('wikiaPhotoGallery-error-caption');
		} else {
			$result['info'] = 'ok';
			$result['gallery'] = self::$mGalleryData;
			$result['gallery']['starttime'] = wfTimestampNow();
		}
		wfProfileOut(__METHOD__);

		return $result;
	}

	/**
	 * Hook handler
	 * @author Marooned
	 *
	 * @param $parser Parser
	 * @param $ig WikiaPhotoGallery
	 */
	static public function beforeParserrenderImageGallery($parser, $ig) {
		wfProfileIn(__METHOD__);

		// parse each gallery / slideshow and get its data
		$ig->parse();
		$data = $ig->getData();

		// get data of gallery / slideshow we're interested in
		if ($data['hash'] == self::$mGalleryHash) {
			self::$mGalleryData = $data;
		}

		self::$lastGalleryData = $data;

		wfProfileOut(__METHOD__);

		// by returning false we're telling MW parser to return gallery's HTML immediatelly
		return false;
	}

	/**
	 * Hook handler
	 * @author Marooned
	 */
	static public function fetchTemplateAndTitle(&$text, $finalTitle) {
		if( $text !== false ) {
			$text = str_replace('<gallery ', "<gallery source=\"template\x7f\" ", $text);
		}
		return true;
	}

	/**
	 * Hook handler - Add a key for new gallery to parser cache
	 * TODO: Remove this hook once media gallery is ready to be fully deployed
	 *
	 * @param $hash
	 * @return bool
	 */
	public static function addMediaGalleryCacheKey( &$hash ) {
		global $wgRequest, $wgEnableMediaGalleryExt;

		if ( $wgRequest->getVal( 'gallery' ) == 'new' ) {

			$wgEnableMediaGalleryExt = true;

			// Add a key to parser cache key
			$hash .= '!' . 'NewGallery';
		}

		return true;
	}

	/**
	 * Check whether upload is allowed for current user and with current config
	 * @author Macbre
	 */
	static public function isUploadAllowed() {
		global $wgEnableUploads, $wgUser;

		$result = $wgUser->isLoggedIn() &&
			$wgUser->isAllowed('upload') &&
			$wgEnableUploads &&
			!wfReadOnly();

		if ($result == false) {
			wfDebug(__METHOD__ . ": upload is disabled\n");
		}

		return $result;
	}

	/**
	 * Cleanup provided string to contain characters allowed for CSS color definition
	 *
	 * Syntax allowed: #fff, white
	 *
	 * @author Macbre
	 */
	static public function sanitizeCssColor($color) {
		$color = preg_replace('@[^a-z0-9#]@i', '', $color);
		return $color;
	}

	/**
	 * Render dropdown for given option
	 *
	 * @author Macbre
	 */
	 static public function renderOptionDropdown($id, $message, $values, $defaultIndex = 0, $renderLabel = true) {
		wfProfileIn(__METHOD__);

		$ret = '';

		// render label
		if($renderLabel)
			$ret .= Xml::element('label', array('for' => $id), wfMsg($message));

		// render dropdown
		$ret .= Xml::openElement('select', array('id' => $id));

		foreach($values as $i => $value) {
			$msg = is_numeric($value) ? $value : wfMsg("{$message}-{$value}");
			$ret .= Xml::option($msg, $value, $i == $defaultIndex);
		}

		$ret .= Xml::closeElement('select');

		wfProfileOut(__METHOD__);
		return $ret;
	 }

	 /**
	 * Render image based option widget for given option
	 *
	 * @author Lox
	 */
	 static public function renderImageOptionWidget($id, $message, $values, $optionWidth, $defaultIndex = 0, $renderLabel = true) {
		wfProfileIn(__METHOD__);
		$ret = '';

		// render label
		if($renderLabel)
			$ret .= Xml::element('label', array('for' => $id), wfMsg($message));

		// render dropdown
		$ret .= Xml::openElement('ul', array('id' => $id, 'class' => 'clearfix', 'rel' => $optionWidth));

		foreach($values as $index => $value) {
			$ret .= Xml::Element('li', array('id' => "{$id}_{$value}", 'rel' => $value, 'title' => wfMsg("{$message}-{$value}-tooltip"), 'style' => 'background-position: -' . (($optionWidth * 2 * $index) + (($index != $defaultIndex) ? $optionWidth : 0)) . 'px 0px;'), '');
		}

		$ret .= Xml::closeElement('ul');
		$ret .= Xml::element('label', array('id' => "{$id}_option_label", 'class' => 'ImageOptionTip'), wfMsg("{$message}-{$values[0]}-tooltip"));

		wfProfileOut(__METHOD__);
		return $ret;
	 }

	/**
	 * Render checkbox for given option
	 *
	 * @author Macbre
	 */
	 static public function renderOptionCheckbox($id, $message, $renderLabel = true) {
		wfProfileIn(__METHOD__);

		// render checkbox
		$ret = Xml::check($id, false, array('id' => $id));

		// render label
		if($renderLabel)
			$ret .= Xml::element('label', array('for' => $id), wfMsg($message));

		wfProfileOut(__METHOD__);
		return $ret;
	 }

	/**
	 * Render color picker
	 *
	 * @author Macbre
	 * @param Array $colors A list of the colors to show,
	 * a multidimensional array with 'class' or 'color' sub-elements, false results in a hr separator
	 * <code>
	 * array(
	 *	#CSS classes
	 *	array('class' => 'accent', property => 'border'),
	 *	array('class' => 'color1', property => 'background'),
	 *	#horizontal line
	 *	false,
	 *	#defined colors
	 *	array('color' => '2daccd')
	 * )
	 * </code>
	 */
	 static public function renderColorPicker($id, $message, $colors, $default = null, $renderLabel = true) {
		wfProfileIn(__METHOD__);
		$ret = '';

		// render label
		if($renderLabel)
			$ret .= Xml::element('label', array('for' => $id), wfMsg($message));

		// render color picker box
		$ret .= Xml::openElement('span', array('id' => $id, 'class' => 'WikiaPhotoGalleryColorPicker'), '');

		$options = array('id' => "{$id}_trigger");

		if(!empty($default) && is_string($default) && strpos($default, '#') === 0) {
			$options['style'] = "background-color:{$default}";
			$options['title'] = $default;
		}
		elseif(!empty($default) && is_array($default)){
			$options['title'] = "{$default[0]}--{$default[1]}";
		}

		$ret .= Xml::element('span', $options, '');
		$ret .= Xml::closeElement('span');

		// render color picker popup box
		$ret .= Xml::openElement('div', array('class' =>'WikiaPhotoGalleryColorPickerPopUp', 'id' =>"{$id}_popup"));
		$ret .= Xml::element('label', array(), wfMsg('wikiaPhotoGallery-preview-colorpicker-title'));

		foreach($colors as $row) {
			if($row == 'hr') {
				$ret .= Xml::element('hr');
			}
			else{
				$ret .= Xml::openElement('ul', array('style' => 'clear: both;'));

				foreach($row as $entry) {
					$attribs = array();

					if (isset($entry['class'])) {
						$attribs['class'] = $entry['class'];
						$attribs['title'] = ".{$entry['class']}";
						$attribs['rel'] = $entry['property'];
					}
					else {
						if($entry['color'] == 'transparent') {
							$attribs['class'] = "transparent-color";
						}
						else {
							$attribs['style'] = "background-color: {$entry['color']}";
						}

						$attribs['title'] = "{$entry['color']}";
					}

					$ret .= Xml::openElement('li');
					$ret .= Xml::Element('span', $attribs, '');
					$ret .= Xml::closeElement('li');
				}

				$ret .= Xml::closeElement('ul');
			}
		}

		// hex code input field
		$ret .= Xml::element('hr');
		$ret .= Xml::element('label', array('for' => "{$id}HexCode"), wfMsg('wikiaPhotoGallery-preview-colorpicker-hex'));
		$ret .= Xml::element('input', array('id' => "{$id}HexCode", 'type' => 'text'));

		// Ok button
		$ret .= Xml::element('button', array(), wfMsg('ok'));

		$ret .= Xml::closeElement('div');

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Renders a label for a form control
	 *
	 * @author Lox
	 */
	static public function renderLabel($msgKey, $forID = null) {
		$options = array();

		if(!empty($forID))
			$options['for'] = $forID;

		return Xml::element('label', $options, wfMsg($msgKey));
	}

	/**
	 * Returns the correct aspect ratio given the option name
	 *
	 * @author Lox
	 */
	static public function getRatioFromOption($optionName) {
		switch($optionName) {
			case 'portrait':
				return 3/4;
				break;

			case 'landscape':
				return 4/3;
				break;

			case 'none':
			case 'square':
			default:
				return 1;
				break;
		}
	}

	/**
	 * Checks if the gallery parameter navigation="true" needs to be added to or removed from galleries.
	 * See checkNavigationParamGalleries for more information.
	 * @param $editPage
	 * @param $request
	 * @return bool
	 */
	static public function onImportFormData( $editPage, $request ) {
		$editPage->textbox1 = preg_replace_callback(
			'/< *gallery([^>]*)>([^<]+)< *\/ *gallery *>/',
			'WikiaPhotoGalleryHelper::checkNavigationParamGalleries',
			$editPage->textbox1
		);

		return True;
	}

	/**
	 * Checks if a gallery needs to have the parameter navigation="true" added or removed from
	 * its tag. The spec says that if the gallery has 2 or more images, one of which is linked,
	 * and the gallery is not a slider (ie, has type="slider" as a parameter), then the gallery
	 * should have navigation="true" added to the tag. If it has navigation="true" already and
	 * the gallery is edited to removed all linked images, the parameter should be removed.
	 * See VID-1888 for more information.
	 * @param $matches
	 * @return string
	 */
	static public function checkNavigationParamGalleries( $matches ) {
		$galleryParams = trim( $matches[1] );
		$galleryContent = trim( $matches[2] );
		$galleryLines = array_filter( explode( "\n", $galleryContent ) );
		$hasNavigationParam = false;

		if ( preg_match_all( "/([^ =\"']+) *= *[\"']?([^ \"']+)[\"']?/", $galleryParams, $paramMatches ) ) {
			$paramNames = $paramMatches[1];
			$paramValues = $paramMatches[2];
			foreach ( $paramNames as $paramIndex => $paramName ) {
				$paramName = strtolower( $paramName );

				// If this gallery is a slider, return untouched
				if ( $paramName == 'type' && strtolower( $paramValues[$paramIndex] ) == 'slider' ) {
					return $matches[0];
				}

				if ( $paramName == 'navigation' ) {
					$hasNavigationParam = true;
				}

			}
		}

		// Requirements state not to convert galleries that only contain one image
		if ( count( $galleryLines ) <= 1 ) {
			return $matches[0];
		}

		// Look for any linked images
		$hasLink = false;
		foreach ( $galleryLines as $line ) {
			if ( preg_match( '/\| *link=/', $line ) ) {
				$hasLink = true;
				break;
			}
		}

		if ( $hasLink && !$hasNavigationParam ) {
			// Add navigation if gallery has links
			$gallery = "<gallery".( empty( $galleryParams ) ? '' : " $galleryParams" )." navigation=\"true\">\n$galleryContent\n</gallery>";
		} elseif ( !$hasLink && $hasNavigationParam ) {
			// Removed navigation param if gallery has no links
			$galleryParams = preg_replace( '/navigation\s*=[\'"]\s*true[\'"]/i', '', $galleryParams );
			$gallery =  "<gallery".( empty( $galleryParams ) ? '' : " $galleryParams" ).">\n$galleryContent\n</gallery>";
		} else {
			// Return gallery tag unaltered if there are no linked gallery images
			$gallery = $matches[0];
		}

		return $gallery;
	}
}
