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

	/**
	 * Used to store wikitext between calls to useDefaultRTEPlaceholder and renderGalleryPlaceholder
	 */
	private static $mWikitextIdx;

	// used when parsing and getting gallery data
	private static $mGalleryHash;
	private static $mGalleryData;

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
		$ig->calculateHash();

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Allow this extension to use its own "parser" for <gallery> tag content
	 */
	static public function beforeRenderImageGallery(&$parser, &$ig) {
		$ig->parse();

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
		global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;

		wfProfileIn(__METHOD__);

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.js?{$wgStyleVersion}\"></script>\n");

		// load message for MW toolbar button tooltip
		global $wgHooks;
		$wgHooks['MakeGlobalVariablesScript'][] = 'WikiaPhotoGalleryHelper::makeGlobalVariablesScript';

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Add message for MW toolbar button tooltip
	 */
	static public function makeGlobalVariablesScript(&$vars) {
		wfProfileIn(__METHOD__);
		wfLoadExtensionMessages('WikiaPhotoGallery');

		$vars['WikiaPhotoGalleryAddGallery'] = wfMsg('wikiaPhotoGallery-add-gallery');

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Render gallery placeholder for RTE
	 */
	static public function renderGalleryPlaceholder($gallery, $width, $height) {
		wfProfileIn(__METHOD__);

		$data = $gallery->getData();
		$class = 'media-placeholder image-gallery';

		if ($data['type'] == WikiaPhotoGallery::WIKIA_PHOTO_SLIDESHOW) {
			$class .= ' image-slideshow';

			// support "position" attribute (slideshow alignment)
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
		}

		$attribs = array(
			'src' => 'http://images.wikia.com/common/skins/monobook/blank.gif?1',
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
	static public function parseLink(&$parser, $imageTitle, $link) {
		// fallback: link to image page + lightbox
		$linkAttribs = array(
			'class' => 'image lightbox',
			'href' => $imageTitle->getLocalUrl(),
			'title' => $imageTitle->getText(),
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
	 */
	static public function getThumbnailDimensions($img, $maxWidth, $maxHeight, $crop = false) {
		wfProfileIn(__METHOD__);
		$imageRatio = $img->getWidth() / $img->getHeight();

		// image has to fit width x height box
		$thumbParams = array(
			'height' => min($img->getHeight(), $maxHeight),
			'width' => min($img->getWidth(), $maxWidth),
		);

		// support "crop" attribute
		if (!empty($crop)) {
			$widthResize = $img->getWidth() / $maxWidth;
			$heightResize = $img->getHeight() / $maxHeight;

			$resizeRatio = min($widthResize, $heightResize);

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

				$thumb = $image->getThumbnail($width, $height);
				$url = $thumb->url;
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

				$thumb = $image->getThumbnail($width, $height);
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
		$thumbSize = !empty($gallery['params']['widths']) ? $gallery['params']['widths'] : 200;
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

			if ($imageHeight > $maxHeight) {
				$maxHeight = $imageHeight;
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
			$height = min($height, $thumbSize * 2);

			// recalculate dimensions (RT #59355)
			foreach($gallery['images'] as $index => $image) {
				$widths[$index] = round($widths[$index] * ($height / $heights[$index]));
				$heights[$index] = min($height, $heights[$index]);
			}
		}

		foreach($gallery['images'] as $index => &$image) {
			$image['placeholder'] = false;

			$imageTitle = (!empty($imageTitlesCache[$index])) ? $imageTitlesCache[$index] : Title::newFromText($image['name'], NS_FILE);
			$fileObject = (!empty($fileObjectsCache[$index])) ? $fileObjectsCache[$index] : wfFindFile($imageTitle);

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
			$imgWidthCompensation = ($thumbSize - $image['width']) / 2;
			if($imgHeightCompensation > 0) $image['widthCompensation'] = $imgWidthCompensation;


			//need to use parse() - see RT#44270
			//need to remove wapping p coming from caption editor to match view
			$image['caption'] = str_replace(array('<p>', '</p>'), array(null, '<br />'), $wgParser->parse($image['caption'], $wgTitle, $parserOptions)->getText());
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
				'height' => ($orientation == 'none') ? $thumbSize : $height /* RT #59355 */,
				'width' => $thumbSize,
				'thumbnail' => "{$wgExtensionsPath}/wikia/WikiaPhotoGallery/images/gallery_addimage.png",
				'caption' => wfMsg('wikiaPhotoGallery-preview-placeholder-caption'),
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
		$maxWidth = isset($slideshow['params']['widths']) ? $slideshow['params']['widths'] : 300;
		$maxHeight = round($maxWidth * 3/4);

		wfDebug(__METHOD__ . " - {$maxWidth}x{$maxHeight}\n");

		if (!empty($slideshow['params']['showrecentuploads'])) {
			// add recently uploaded images only
			$uploadedImages = WikiaPhotoGalleryHelper::getRecentlyUploaded(WikiaPhotoGallery::RECENT_UPLOADS_IMAGES);

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
		}
		else {
			// render slideshow images
			foreach($slideshow['images'] as &$image) {
				// don't render recently uploaded images now, render them after "regular" images
				if (!empty($image['recentlyUploaded'])) {
					$image = false;
					continue;
				}

				$imageTitle = Title::newFromText($image['name'], NS_FILE);
				if (empty($imageTitle)) {
					$image = false;
					continue;
				}

				$img = wfFindFile($imageTitle);
				if (empty($img)) {
					$image = false;
					continue;
				}

				// render thumbnail
				$dimensions = self::getThumbnailDimensions($img, $maxWidth, $maxHeight, $crop);

				$image['thumbnailBg'] = self::getThumbnailUrl($imageTitle, $dimensions['width'], $dimensions['height']);

				//need to use parse() - see RT#44270
				$image['caption'] = $wgParser->parse($image['caption'], $wgTitle, $parserOptions)->getText();

				// remove <p> tags from parser caption
				if (preg_match('/^<p>(.*)\n?<\/p>\n?$/sU', $image['caption'], $m)) {
					$image['caption'] = $m[1];
				}
			}

			// filter out skipped images
			$slideshow['images'] = array_filter($slideshow['images']);
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
	 * Render slideshow popout
	 */
	static public function renderSlideshowPopOut($slideshow, $maxWidth = false, $maxHeight = false) {
		global $wgTitle, $wgParser;
		wfProfileIn(__METHOD__);

		//wfDebug(__METHOD__ . "\n" . print_r($slideshow, true));

		// use global instance of parser (RT #44689 / RT #44712)
		$parserOptions = new ParserOptions();

		// images for carousel (91x68 and 115x87)
		$carousel = array();

		// let's calculate size of slideshow area
		$width = 0;
		$height = 0;

		// let's use images actually shown for end user
		$slideshow['images'] = $slideshow['imagesShown'];

		// go through the list of images and calculate width and height of slideshow
		foreach($slideshow['images'] as &$image) {
			$imageTitle = Title::newFromText($image['name'], NS_FILE);

			// "broken" image - skip
			if (!$imageTitle->exists()) {
				continue;
			}

			// get image dimensions
			$imageFile = wfFindFile($imageTitle);
			$imageWidth = $imageFile->getWidth();
			$imageHeight = $imageFile->getHeight();

			if ($width < $imageWidth) {
				$width = $imageWidth;
			}

			if ($height < $imageHeight) {
				$height = $imageHeight;
			}
		}

		// recalculate width for maxHeight
		$width = max($width, round($height * 4/3));

		wfDebug(__METHOD__ . ": calculated width is {$width} px\n");
		wfDebug(__METHOD__ . ": user area is {$maxWidth}x{$maxHeight} px\n");

		// take maxWidth and maxHeight into consideration
		$width = min($width, $maxWidth);
		$width = min($width, round($maxHeight * 4/3));

		// minimum width (don't wrap carousel - 580px)
		$width = max($width, 600);

		// keep 4:3 ratio
		$height = round($width * 3/4);

		// limit the height ignoring the ratio
		$height = min($height, $maxHeight);

		wfDebug(__METHOD__ . ": rendering {$width}x{$height} slideshow...\n");

		// render thumbnail, "big" image and parse caption for each image
		foreach($slideshow['images'] as &$image) {
			$imageTitle = Title::newFromText($image['name'], NS_FILE);

			// "broken" image - skip
			if (!$imageTitle->exists()) {
				$image = false;
				continue;
			}

			// big image to be used for slideshow area
			$image['big'] = self::getThumbnailUrl($imageTitle, $width, $height);

			// carousel images in two sizes
			$carousel[] = array(
				'current' => self::getThumbnailUrl($imageTitle, 115, 87),
				'small' => self::getThumbnailUrl($imageTitle, 91, 68),
			);

			//need to use parse() - see RT#44270
			$image['caption'] = $wgParser->parse($image['caption'], $wgTitle, $parserOptions)->getText();

			// link to image page (details)
			$image['imagePage'] = $imageTitle->getLocalUrl();

			// image with link
			if ($image['link'] != '') {
				$linkAttribs = self::parseLink($wgParser, $imageTitle, $image['link']);
				$image['url'] = $linkAttribs['href'];
			}
		}

		// filter out skipped images
		$slideshow['images'] = array_filter($slideshow['images']);

		wfDebug(__METHOD__.'::after' . "\n" . print_r($slideshow, true));

		wfLoadExtensionMessages('WikiaPhotoGallery');

		// slideshow "overall caption"
		$title = isset($slideshow['params']->caption) ? $slideshow['params']->caption : wfMsg('wikiaPhotoGallery-slideshow-view-title');

		// render slideshow pop out dialog
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'height' => $height,
			'slideshow' => $slideshow,
			'width' => $width,
		));
		$html = $template->render('slideshowPopOut');

		wfProfileOut(__METHOD__);
		return array(
			'carousel' => $carousel,
			'html' => $html,
			'title' => $title,
			'width' => $width,
		);
	}

	/**
	 * Get list of recently uploaded files
	 */
	static public function getRecentlyUploaded($limit) {
		wfProfileIn(__METHOD__);

		$ret = false;

		// get list of recent log entries (type = 'upload')
		// limit*2 because of possible duplicates in log caused by image reuploads
		$params = array(
			'action' => 'query',
			'list' => 'logevents',
			'letype' => 'upload',
			'leprop' => 'title',
			'lelimit' => $limit * 2,
		);

		try {
			wfProfileIn(__METHOD__ . '::apiCall');

			$api = new ApiMain(new FauxRequest($params));
			$api->execute();
			$res = $api->getResultData();

			wfProfileOut(__METHOD__ . '::apiCall');

			if (!empty($res['query']['logevents'])) {
				foreach($res['query']['logevents'] as $entry) {
					// ignore Video:foo entries from VET
					if ($entry['ns'] == NS_IMAGE) {
						$image = Title::newFromText($entry['title']);
						if (!empty($image)) {
							// use keys to remove duplicates
							$ret[$image->getDBkey()] = $image;

							// limit number of results
							if (count($ret) == $limit) {
								break;
							}
						}
					}
				}

				// use numeric keys
				$ret = array_values($ret);
				$count = count($ret);

				wfDebug(__METHOD__ . ": {$count} results\n");
			}
		}
		catch(Exception $e) {};

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Get thumbs of recently uploaded files
	 */
	static public function getRecentlyUploadedThumbs($limit = 50) {
		wfProfileIn(__METHOD__);
		$ret = array();

		// get list of recenlty uploaded images
		$uploadedImages = self::getRecentlyUploaded($limit);

		if(is_array($uploadedImages)) {
			foreach($uploadedImages as $image) {
				$thumb = self::getResultsThumbnailUrl($image);
				if ($thumb) {
					// use keys to remove duplicates
					$ret[] = array(
						'name' => $image->getText(),
						'thumb' => $thumb,
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
		$params = array(
			'action' => 'query',
			'prop' => 'images',
			'titles' => $title->getText(),
			'imlimit' => $limit,
		);

		try {
			wfProfileIn(__METHOD__ . '::apiCall');

			$api = new ApiMain(new FauxRequest($params));
			$api->execute();
			$res = $api->getResultData();

			wfProfileOut(__METHOD__ . '::apiCall');

			if (!empty($res['query']['pages'])) {
				$data = array_pop($res['query']['pages']);

				if (!empty($data['images'])) {
					foreach($data['images'] as $entry) {
						// ignore Video:foo entries from VET
						if ($entry['ns'] == NS_IMAGE) {
							$image = Title::newFromText($entry['title']);

							$thumb = self::getResultsThumbnailUrl($image);
							if ($thumb) {
								// use keys to remove duplicates
								$ret[$image->getDBkey()] = array(
									'name' => $image->getText(),
									'thumb' => $thumb,
								);
							}
						}
					}

					// use numeric keys
					$ret = array_values($ret);
					$count = count($ret);

					wfDebug(__METHOD__ . ": {$count} results\n");
				}
			}
		}
		catch(Exception $e) {};

		wfProfileOut(__METHOD__);
		return $ret;
	}


	/**
	 * Return thumbs of images search result
	 */
	static public function getSearchResultThumbs($query) {
		wfProfileIn(__METHOD__);
		global $wgRequest, $wgContentNamespaces;

		$images = array();

		if(!empty($query)) {
			$query_select = "SELECT il_to FROM imagelinks JOIN page ON page_id=il_from WHERE page_title = '%s' and page_namespace = %s";
			$query_glue = ' UNION DISTINCT ';
			$articles = $query_arr = array();

			//get search result from API
			$oFauxRequest = new FauxRequest(
				array(
					'action' => 'query',
					'list' => 'search',
					'srnamespace' => implode('|', array_merge($wgContentNamespaces, array(NS_FILE))),
					'srlimit' => '20',
					'srsearch' => $query,
				)
			);
			$oApi = new ApiMain($oFauxRequest);
			$oApi->execute();
			$aResult =& $oApi->GetResultData();

			$dbr = wfGetDB(DB_SLAVE);

			if (count($aResult['query']['search']) > 0) {
				if (!empty($aResult['query']['search'])) {
					foreach ($aResult['query']['search'] as $aResult) {
						$query_arr[] = sprintf($query_select, $dbr->strencode(str_replace(' ', '_', $aResult['title'])), $aResult['ns']);
					}
				}
			}

			if (count($query_arr)) {
				$query_sql = implode($query_glue, $query_arr);
				$res = $dbr->query($query_sql, __METHOD__);

				if($res->numRows() > 0) {
					while( $row = $res->fetchObject() ) {
						$articles[] = $row->il_to;
					}
					$dbr->freeResult($res);

					foreach($articles as $title) {
						$oImageTitle = Title::makeTitleSafe(NS_FILE, $title);

						$thumb = self::getResultsThumbnailUrl($oImageTitle);
						if ($thumb) {
							$images[] = array(
								'name' => $oImageTitle->getText(),
								'thumb' => $thumb,
							);
						}
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
		global $wgHooks, $wgTitle, $wgUser;

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

		preg_match_all('%<gallery[^>]*>(.*?)</gallery>%s', $articleWikitext, $matches, PREG_PATTERN_ORDER);
		for ($i = 0; $i < count($matches[0]); $i++) {
			if (md5($matches[1][$i]) == $hash) {
				$gallery = $matches[0][$i];
				break;
			}
		}

		wfLoadExtensionMessages('WikiaPhotoGallery');
		if (empty($gallery)) {
			$result['info'] = 'conflict';

			wfDebug(__METHOD__ . ": conflict found\n");
		} else {
			$articleWikitext = str_replace($gallery, $wikitext, $articleWikitext);

			//saving
			if($wgTitle->userCan('edit') && !$wgUser->isBlocked()) {
				global $wgOut;

				$result = null;
				$article = new Article($wgTitle);
				$editPage = new EditPage($article);
				$editPage->edittime = $article->getTimestamp();
				$editPage->starttime = $starttime;
				$editPage->textbox1 = $articleWikitext;
				$editPage->summary = wfMsgForContent('wikiaPhotoGallery-edit-summary');

				// watch all my edits / preserve watchlist (RT #59138)
				if ($wgUser->getOption('watchdefault')) {
					$editPage->watchthis = true;
				}
				else {
					$editPage->watchthis = $editPage->mTitle->userIsWatching();
				}

				$bot = $wgUser->isAllowed('bot');
				$retval = $editPage->internalAttemptSave( $result, $bot );
				Wikia::log( __METHOD__, "editpage", "Returned value {$retval}" );
				if ( $retval == EditPage::AS_SUCCESS_UPDATE || $retval == EditPage::AS_SUCCESS_NEW_ARTICLE ) {
					$wgTitle->invalidateCache();
					Article::onArticleEdit($wgTitle);
					$result['info'] = 'ok';
				} elseif ( $retval == EditPage::AS_SPAM_ERROR ) {
					$result['error'] = wfMsg('spamprotectiontext');
				} else {
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

	/**
	 * AJAX helper called from view mode to get gallery data
	 * @author Marooned
	 */
	static public function getGalleryDataByHash($hash, $revisionId = 0) {
		global $wgHooks, $wgTitle, $wgUser, $wgOut;

		wfProfileIn(__METHOD__);

		//overwrite previous hooks returning `false`
		$wgHooks['BeforeParserrenderImageGallery'] = array('WikiaPhotoGalleryHelper::beforeParserrenderImageGallery');
		self::$mGalleryHash = $hash;

		$parser = new Parser();
		$parserOptions = new ParserOptions();

		// let's parse current version of wikitext and store data of gallery with provided hash in self::$mGalleryData
		$rev = Revision::newFromTitle($wgTitle, $revisionId);
		//should never happen
		if (!is_null($rev)) {
			$wikitext = $rev->getText();
			$parser->parse($wikitext, $wgTitle, $parserOptions)->getText();
		}

		// Marooned: check block state of user (RT #55274)
		$permissionErrors = $wgTitle->getUserPermissionsErrors('edit', $wgUser);
		if (count($permissionErrors)) {
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

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Hook handler
	 * @author Marooned
	 */
	static public function fetchTemplateAndTitle($text, $finalTitle) {
		if( $text !== false ) {
			$text = str_replace('<gallery ', "<gallery source=\"template\x7f\" ", $text);
		}
		return true;
	}

	/**
	 * Check whether upload is allowed for current user and with current config
	 * @author Macbre
	 */
	static public function isUploadAllowed() {
		global $wgEnableUploads, $wgDisableUploads, $wgUser;

		$result = $wgUser->isLoggedIn() &&
			$wgUser->isAllowed('upload') &&
			$wgEnableUploads && empty($wgDisableUploads) &&
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
		$ret .= Xml::openElement('div', array('class' =>'WikiaPhotoGalleryColorPickerPopUp'));
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
}
