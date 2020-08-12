<?php

class ArticleAsJson {
	static $heroImage = null;
	static $mediaDetailConfig = [
		'imageMaxWidth' => false
	];

	const CACHE_VERSION = 3.40;

	const ICON_MAX_SIZE = 48;
	// Line height in Mercury
	const ICON_SCALE_TO_MAX_HEIGHT = 20;
	const MAX_MERCURY_CONTENT_WIDTH = 985;

	const MEDIA_CONTEXT_ARTICLE_IMAGE = 'article-image';
	const MEDIA_CONTEXT_ARTICLE_VIDEO = 'article-video';
	const MEDIA_CONTEXT_GALLERY_IMAGE = 'gallery-image';
	const MEDIA_CONTEXT_ICON = 'icon';

	const MEDIA_ICON_TEMPLATE = 'extensions/wikia/ArticleAsJson/templates/media-icon.mustache';
	const MEDIA_THUMBNAIL_TEMPLATE = 'extensions/wikia/ArticleAsJson/templates/media-thumbnail.mustache';
	const MEDIA_GALLERY_TEMPLATE = 'extensions/wikia/ArticleAsJson/templates/media-gallery.mustache';

	private static function renderIcon( $media ) {
		$scaledSize = self::scaleIconSize( $media['height'], $media['width'] );

		try {
			$thumbUrl = VignetteRequest::fromUrl( $media['url'] )
				->thumbnailDown()
				->height( $scaledSize['height'] )
				->width( $scaledSize['width'] )
				->url();
		} catch (InvalidArgumentException $e) {
			// Media URL isn't valid Vignette URL so we can't generate the thumbnail
			$thumbUrl = null;
		}

		return self::removeNewLines(
			\MustacheService::getInstance()->render(
				self::MEDIA_ICON_TEMPLATE,
				[
					'url' => $thumbUrl,
					'height' => $scaledSize['height'],
					'width' => $scaledSize['width'],
					'title' => $media['title'],
					'href' => $media['href'],
					'caption' => $media['caption'] ?? ''
				]
			)
		);
	}

	private static function renderImage( $media ) {
		return self::removeNewLines(
			\MustacheService::getInstance()->render(
				self::MEDIA_THUMBNAIL_TEMPLATE,
				[
					'media' => $media,
					'mediaAttrs' => json_encode( self::getDataAttrsForImage( $media ) ),
					'downloadIcon' => DesignSystemHelper::renderSvg( 'wds-icons-download', 'wds-icon' ),
					'chevronIcon' => DesignSystemHelper::renderSvg('wds-icons-menu-control-tiny', 'wds-icon wds-icon-tiny chevron'),
					'hasFigcaption' => !empty( $media['caption'] ) || ( !empty( $media['title'] ) && ( $media['isVideo'] || $media['isOgg'] ) )
				]
			)
		);
	}

	private static function renderGallery( $media ) {
		$rows = self::prepareGalleryRows( $media );

		return self::removeNewLines(
			\MustacheService::getInstance()->render(
				self::MEDIA_GALLERY_TEMPLATE,
				[
					'galleryAttrs' => json_encode( self::getDataAttrsForGallery( $media ) ),
					'rows' => $rows,
					'downloadIcon' => DesignSystemHelper::renderSvg( 'wds-icons-download', 'wds-icon' ),
					'viewMoreLabel' => count($media) > 20 ? wfMessage('communitypage-view-more')->escaped() : false, // TODO:  XW-4793
				]
			)
		);
	}

	public static function getDataAttrsForImage( $media ) {
		$dataAttrs = [
			'type' => $media['type'],
			'url' => $media['url'],
			'title' => $media['title'],
			'isLinkedByUser' => $media['isLinkedByUser'],
			'href' => $media['href'],
			'isVideo' => $media['isVideo'],
			'width' => $media['width'],
			'height' => $media['height'],
		];

		if ( array_key_exists( 'embed', $media ) ) {
			$dataAttrs['embed'] = $media['embed'];
		}

		if ( array_key_exists( 'caption', $media ) ) {
			$dataAttrs['caption'] = $media['caption'];
		}

		return $dataAttrs;
	}

	public static function getDataAttrsForGallery( $media ) {
		return array_map("self::getDataAttrsForImage", $media );
	}

	private static function prepareGalleryRows( $media ): array {
		switch ( count( $media ) ) {
			case 0:
				$result = [];
				break;
			case 1:
				$result = [
					self::getGalleryRow1items( $media ),
				];
				break;
			case 2:
				$result = [
					self::getGalleryRow2items( $media ),
				];
				break;
			case 3:
				$result = [
					self::getGalleryRow3ItemsLeft( $media ),
				];
				break;
			case 4:
				$result = [
					self::getGalleryRow2items( array_slice( $media, 0, 2 ) ),
					self::getGalleryRow2items( array_slice( $media, 2, 2 ) ),
				];
				break;
			case 7:
				$result = [
					self::getGalleryRow2items( array_slice( $media, 0, 2 ) ),
					self::getGalleryRow3ItemsLeft( array_slice( $media, 2, 3 ) ),
					self::getGalleryRow2items( array_slice( $media, 5, 2 ) ),
				];
				break;
			default:
				$result = self::getGalleryRows( $media );
		}

		return $result;
	}

	private static function getGalleryRow1items( $items ) {
		$thumbsize = 450;
		$items[0]['thumbnailUrl'] = self::getGalleryThumbnail( $items[0], $thumbsize );
		$items[0]['thumbSize'] = $thumbsize;

		return [
			'typeRow1' => true,
			'items' => $items,
		];
	}

	private static function getGalleryRow2items( $items, $hidden = false ) {
		$thumbsize = 220;
		$items[0]['thumbnailUrl'] = self::getGalleryThumbnail( $items[0], $thumbsize);
		$items[0]['thumbSize'] = $thumbsize;
		$items[1]['thumbnailUrl'] = self::getGalleryThumbnail( $items[1], $thumbsize);
		$items[1]['thumbSize'] = $thumbsize;

		return [
			'typeRow2' => true,
			'items' => $items,
			'rowHidden' => $hidden,
		];
	}

	private static function getGalleryRow3ItemsLeft( $items, $hidden = false ) {
		$items[0]['thumbnailUrl'] = self::getGalleryThumbnail( $items[0], 300);
		$items[0]['thumbSize'] = 300;
		$items[1]['thumbnailUrl'] = self::getGalleryThumbnail( $items[1], 150);
		$items[1]['thumbSize'] = 150;
		$items[2]['thumbnailUrl'] = self::getGalleryThumbnail( $items[2], 150);
		$items[2]['thumbSize'] = 150;

		return [
			'typeRow3' => true,
			'left' => true,
			'leftColumn' => [ $items[0] ],
			'rightColumn' => [ $items[1], $items[2] ],
			'rowHidden' => $hidden,
		];
	}

	private static function getGalleryRow3ItemsRight( $items, $hidden = false ) {
		$items[0]['thumbnailUrl'] = self::getGalleryThumbnail( $items[0], 150);
		$items[0]['thumbSize'] = 150;
		$items[1]['thumbnailUrl'] = self::getGalleryThumbnail( $items[1], 150);
		$items[1]['thumbSize'] = 150;
		$items[2]['thumbnailUrl'] = self::getGalleryThumbnail( $items[2], 300);
		$items[2]['thumbSize'] = 300;

		return [
			'typeRow3' => true,
			'right' => true,
			'leftColumn' => [ $items[0], $items[1] ],
			'rightColumn' => [ $items[2] ],
			'rowHidden' => $hidden,
		];
	}

	private static function getGalleryThumbnail( $item, int $width ): string {
		if ( VignetteRequest::isVignetteUrl( $item['url'] ) ) {
			return VignetteRequest::fromUrl( $item['url'] )
				->topCrop()
				->width( $width )
				->height( $width )
				->url();
		} else {
			$file = wfFindFile( $item['title'] );

			return self::getThumbUrl( $file, $width, $width );
		}
	}

	private static function getGalleryRows( $items ) {
		$itemsLeft = count( $items );
		$evenRow = false;
		$rowSequence = [];

		while ( $itemsLeft > 2 ) {
			// every odd row should have 3 images and every even row should have 2 images
			if ( $evenRow ) {
				$rowSequence[] = 2;
				$itemsLeft -= 2;
			} else {
				$rowSequence[] = 3;
				$itemsLeft -= 3;
			}

			$evenRow = !$evenRow;
		}

		switch ( $itemsLeft ) {
			case 0:
				break;
			case 1:
				// if there is one image left, change the last row with two images to have 3 images
				if ( $rowSequence[count( $rowSequence ) - 1] === 2 ) {
					$rowSequence[count( $rowSequence ) - 1] = 3;
				} else {
					$rowSequence[count( $rowSequence ) - 2] = 3;
				}
				break;
			case 2:
				// if there are 2 images left:
				//      if the last row has 2 images then add an image to last two rows with 2 images
				//      if the last row has 3 images just add new row with two images
				if ( $rowSequence[count( $rowSequence ) - 1] === 2 ) {
					$rowSequence[count( $rowSequence ) - 1] = 3;
					$rowSequence[count( $rowSequence ) - 3] = 3;
				} else {
					$rowSequence[] = 2;
				}
				break;
		}

		$result = [];
		$itemsTaken = 0;
		foreach ( $rowSequence as $index => $value ) {
			// By default ~20 first images is shown in gallery (first 8 rows), rest is hidden
			$rowHidden = $index > 7;

			switch ( $value ) {
				case 2:
					$result[] = self::getGalleryRow2items( array_slice( $items, $itemsTaken, 2 ), $rowHidden );
					$itemsTaken += 2;

					break;
				case 3:
					if ( $index % 2 != 0 ) {
						$result[] = self::getGalleryRow3ItemsRight( array_slice( $items, $itemsTaken, 3 ), $rowHidden );
					} else {
						$result[] = self::getGalleryRow3ItemsLeft( array_slice( $items, $itemsTaken, 3 ), $rowHidden );
					}
					$itemsTaken += 3;

					break;
				default:
					Wikia\Logger\WikiaLogger::instance()->warning(
						'Error while generating gallery, unexpected number of images in row'
					);
					break;
			}
		}

		return $result;
	}

	private static function removeNewLines( $string ) {
		return trim( preg_replace( '/\s+/', ' ', $string ) );
	}

	private static function createMarker( $media, $isGallery = false ) {
		if ( $isGallery ) {
			return self::renderGallery( $media );
		} else if ( $media['context'] === self::MEDIA_CONTEXT_ICON ) {
			return self::renderIcon( $media );
		} else {
			return self::renderImage( $media );
		}
	}

	public static function createMediaObject( $details, $imageName, $caption = null, $link = null ) {
		$context = '';
		$media = [
			'type' => $details['mediaType'],
			'url' => $details['rawImageUrl'],
			'fileUrl' => $details['fileUrl'],
			'fileName' => str_replace( ' ', '_', $imageName),
			'title' => $imageName,
			'user' => $details['userName'],
			'mime' => $details['mime'],
			'isVideo' => $details['mediaType'] === 'video',
			'isOgg' => $details['mime'] === 'application/ogg'
		];

		// Only images are allowed to be linked by user
		if ( is_string( $link ) && $link !== '' && $media['type'] === 'image' ) {
			$media['href'] = $link;
			$media['isLinkedByUser'] = true;
		} else {
			// There is no easy way to link directly to a video, so we link to its file page
			$media['href'] = $media['type'] === 'video' ? $media['fileUrl'] : $media['url'];
			$media['isLinkedByUser'] = false;
		}

		if ( !empty( $details['width'] ) ) {
			$media['width'] = (int) $details['width'];
		}

		if ( !empty( $details['height'] ) ) {
			$media['height'] = (int) $details['height'];
		}

		if ( is_string( $caption ) && $caption !== '' ) {
			$media['caption'] = $caption;
		}

		if ( $details['mediaType'] == 'video' ) {
			$media['context'] = self::MEDIA_CONTEXT_ARTICLE_VIDEO;
			$media['views'] = (int) $details['videoViews'];
			$media['embed'] = $details['videoEmbedCode'];
			$media['duration'] = $details['duration'];
			$media['provider'] = $details['providerName'];
		}

		if ( isset( $details['context'] ) ) {
			$context = $details['context'];
		}

		if ( is_string( $context ) && $context !== '' ) {
			$media['context'] = $context;
		}

		return $media;
	}

	public static function onGalleryBeforeProduceHTML( $data, &$out ) {
		global $wgArticleAsJson;

		if ( $wgArticleAsJson ) {
			$parser = ParserPool::get();
			$parserOptions = new ParserOptions();
			$title = F::app()->wg->Title;
			$media = [ ];

			foreach ( $data['images'] as $index => $image ) {
				$details = self::getMediaDetailWithSizeFallback(
					Title::newFromText( $image['name'], NS_FILE ),
					self::$mediaDetailConfig
				);
				$details['context'] = self::MEDIA_CONTEXT_GALLERY_IMAGE;

				if ( $details['exists'] === false ) {
					continue;
				}

				$caption = $image['caption'];

				if ( !empty( $caption ) ) {
					$caption = $parser->parse( $caption, $title, $parserOptions, false )->getText();
					$caption = self::unwrapParsedTextFromParagraph( $caption );
				}

				$linkHref = isset( $image['linkhref'] ) ? $image['linkhref'] : null;
				$mediaObj = self::createMediaObject( $details, $image['name'], $caption, $linkHref );
				$mediaObj['galleryRef'] = $index;
				$media[] = $mediaObj;
			}

			if ( !empty( $media ) ) {
				$out = self::createMarker( $media, true );
			} else {
				$out = '';
			}

			ParserPool::release( $parser );

			return false;
		}

		return true;
	}

	public static function onExtendPortableInfoboxImageData($title, $data, &$media ) {
		if ( $title ) {
			$details = self::getMediaDetailWithSizeFallback( $title, self::$mediaDetailConfig );
			$details['context'] = $data['context'];
			$mediaObj = self::createMediaObject( $details, $title->getText(), $data['caption'] );
			$media = $mediaObj;

			if ( $details['context'] == 'infobox-hero-image' && empty( self::$heroImage ) ) {
				self::$heroImage = $mediaObj;

				$height = PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH * 5 / 4;

				if ( VignetteRequest::isVignetteUrl( $mediaObj['url'] ) ) {
					$height = PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH * 5 / 4;
					$thumbnail4by5 = VignetteRequest::fromUrl( $mediaObj['url'] )
						->topCrop()
						->width( PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH )
						->height( $height )
						->url();

					$thumbnail4by5x2 = VignetteRequest::fromUrl( $mediaObj['url'] )
						->topCrop()
						->width( PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH * 2 )
						->height( $height * 2)
						->url();

					$thumbnail1by1 = VignetteRequest::fromUrl( $mediaObj['url'] )
						->topCrop()
						->width( PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH )
						->height( PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH )
						->url();

				} else {
					$file = wfFindFile( $title );

					$thumbnail4by5 = self::getThumbUrl(
						$file,
						PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH,
						$height
					);

					$thumbnail4by5x2 = self::getThumbUrl(
						$file,
						PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH * 2,
						$height * 2
					);

					$thumbnail1by1 = self::getThumbUrl(
						$file,
						PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH,
						PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH
					);
				}

				self::$heroImage['thumbnail4by5'] = $thumbnail4by5;
				self::$heroImage['thumbnail4by52x'] = $thumbnail4by5x2;
				self::$heroImage['thumbnail4by5Width'] = PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH;
				self::$heroImage['thumbnail4by5Height'] = $height;
				self::$heroImage['thumbnail1by1'] = $thumbnail1by1;
				self::$heroImage['thumbnail1by1Size'] = PortableInfoboxMobileRenderService::MOBILE_THUMBNAIL_WIDTH;
			}
		}

		return true;
	}

	/**
	 * @param File $file
	 * @param int $width
	 * @param null $height
	 * @return string
	 */
	private static function getThumbUrl( $file, int $width, $height = null ): string {
		if ( $file ) {
			$params = array_filter( [ 'width' => $width, 'height' => $height ] );

			$thumb = $file->transform( $params );

			if ( $thumb ) {
				return $thumb->getUrl();
			}
		}

		return '';
	}

	public static function onImageBeforeProduceHTML(
		&$dummy,
		Title &$title,
		&$file,
		&$frameParams,
		&$handlerParams,
		&$time,
		&$res
	) {
		global $wgArticleAsJson;

		if ( $wgArticleAsJson ) {
			$linkHref = '';

			if ( isset( $frameParams['link-title'] ) && $frameParams['link-title'] instanceof Title ) {
				$linkHref = $frameParams['link-title']->getLocalURL();
			} else if ( !empty( $frameParams['link-url'] ) ) {
				$linkHref = $frameParams['link-url'];
			}

			$details = self::getMediaDetailWithSizeFallback( $title, self::$mediaDetailConfig );

			if ( $details['exists'] === false ) {
				// Skip media when it doesn't exist

				$res = '';

				return false;
			}

			//information for mobile skins how they should display small icons
			$details['context'] = self::isIconImage( $details, $handlerParams ) ? self::MEDIA_CONTEXT_ICON :
				self::MEDIA_CONTEXT_ARTICLE_IMAGE;

			$caption = $frameParams['caption'] ?? null;
			$media = self::createMediaObject( $details, $title->getText(), $caption, $linkHref );
			$media['srcset'] = self::getSrcset( $media['url'], intval( $media['width'] ), $file );
			$media['thumbnail'] = self::getThumbnailUrlForWidth( $media['url'], 340, $file );

			$res = self::createMarker( $media );

			return false;
		}

		return true;
	}

	/**
	 * @param string $url
	 * @param int $originalWidth
	 * @param File $file
	 * @return string
	 */
	public static function getSrcset( string $url, int $originalWidth, $file ): string {
		$widths = [ 284, 340, 732, 985 ];
		$srcSetItems = [];

		foreach ( $widths as $width ) {
			if ( $width <= $originalWidth ) {
				$thumb = self::getThumbnailUrlForWidth( $url, $width, $file );
				$srcSetItems[] = "${thumb} ${width}w";
			}
		}

		return implode( ',', $srcSetItems );
	}

	/**
	 * @param string $url
	 * @param int $requestedWidth
	 * @param File $file
	 * @return string
	 * @throws Exception
	 */
	public static function getThumbnailUrlForWidth( string $url, int $requestedWidth, $file ) {
		if ( VignetteRequest::isVignetteUrl( $url ) ) {
			return VignetteRequest::fromUrl( $url )
				->scaleToWidth( $requestedWidth )
				->url();
		}

		// XF-741: Handle foreign image repositories, such as Wikimedia Commons
		return self::getThumbUrl( $file, $requestedWidth );
	}

	public static function onPageRenderingHash( &$confstr ) {
		global $wgArticleAsJson;

		if ( $wgArticleAsJson ) {
			$confstr .= '!ArticleAsJson:' . self::CACHE_VERSION;
		}

		return true;
	}

	public static function onParserAfterTidy( Parser $parser, &$text ): bool {
		global $wgArticleAsJson;

		if ( $wgArticleAsJson && !is_null( $parser->getRevisionId() ) ) {

			Hooks::run( 'ArticleAsJsonBeforeEncode', [ &$text ] );

			$text = json_encode(
				[
					'content' => $text,
					'heroImage' => self::$heroImage
				]
			);
		}

		return true;
	}

	public static function onShowEditLink( Parser $parser, &$showEditLink ): bool {
		global $wgArticleAsJson;

		//We don't have editing in this version
		if ( $wgArticleAsJson ) {
			$showEditLink = false;
		}

		return true;
	}

	/**
	 * Remove any limit report, we don't need that in json
	 *
	 * @param $parser Parser
	 * @param $report
	 *
	 * @return bool
	 */
	public static function reportLimits( $parser, &$report ) {
		global $wgArticleAsJson;

		if ( $wgArticleAsJson ) {
			$report = '';

			return false;
		}

		return true;
	}

	/**
	 * Copied from \Message::toString()
	 *
	 * @param $text
	 *
	 * @return string
	 */
	private static function unwrapParsedTextFromParagraph( $text ) {
		$matches = [ ];

		if ( preg_match( '/^<p>(.*)\n?<\/p>\n?$/sU', $text, $matches ) ) {
			$text = $matches[1];
		}

		return $text;
	}

	/**
	 * Safely get property from an array with an optional default
	 *
	 * @param array $array
	 * @param string $key
	 * @param bool $default
	 *
	 * @return bool
	 */
	private static function getWithDefault( $array, $key, $default = false ) {
		if ( array_key_exists( $key, $array ) ) {
			return $array[$key];
		}

		return $default;
	}

	/**
	 * @desc Determines if image is a small image used by users on desktop
	 * as an icon. Users to it by explicitly adding
	 * '{width}px' or 'x{height}px' to image wikitext or uploading a small image.
	 *
	 * @param $details - media details
	 * @param $handlerParams
	 *
	 * @return bool true if one of the image sizes is smaller than ICON_MAX_SIZE
	 */
	private static function isIconImage( $details, $handlerParams ) {
		$smallFixedWidth = self::isIconSize( $handlerParams, 'width' );
		$smallFixedHeight = self::isIconSize( $handlerParams, 'height' );
		$smallWidth = self::isIconSize( $details, 'width' );
		$smallHeight = self::isIconSize( $details, 'height' );
		$isInfoIcon = self::isInfoIcon( self::getWithDefault( $handlerParams, 'template-type' ) );

		return $smallFixedWidth || $smallFixedHeight || $smallWidth || $smallHeight || $isInfoIcon;
	}

	/**
	 * @desc Checks if passed property is set and if it's value is smaller than ICON_MAX_SIZE
	 *
	 * @param array $param an array with data
	 * @param string $key
	 *
	 * @return bool true if size is smaller than ICON_MAX_SIZE
	 * and returns false if $param[$key] does not exist
	 */
	private static function isIconSize( $param, $key ) {
		$value = self::getWithDefault( $param, $key );

		return $value ? $value <= self::ICON_MAX_SIZE : false;
	}

	private static function isInfoIcon( $templateType ) {
		return $templateType == TemplateClassificationService::TEMPLATE_INFOICON;
	}

	/**
	 * @param $originalHeight
	 * @param $originalWidth
	 *
	 * @return array
	 */
	private static function scaleIconSize( $originalHeight, $originalWidth ) {
		$height = $originalHeight;
		$width = $originalWidth;
		$maxHeight = self::ICON_SCALE_TO_MAX_HEIGHT;

		if ( $originalHeight > $maxHeight ) {
			$height = $maxHeight;
			$width = intval( $maxHeight * $originalWidth / $originalHeight );
		}

		return [
			'height' => $height,
			'width' => $width
		];
	}

	/**
	 * For some media WikiaFileHelper::getMediaDetail returns size 0 (width or height).
	 * Instead of showing broken image we want to show the image
	 * and as the fallback size we use the maximum content width handled by Mercury
	 *
	 * @param Title $title
	 * @param array $mediaDetailConfig
	 * @param int $fallbackSize
	 *
	 * @return array
	 */
	private static function getMediaDetailWithSizeFallback(
		$title,
		$mediaDetailConfig,
		$fallbackSize = self::MAX_MERCURY_CONTENT_WIDTH
	) {
		$mediaDetail = WikiaFileHelper::getMediaDetail( $title, $mediaDetailConfig );

		if ( $mediaDetail['exists'] === true ) {
			if ( empty( $mediaDetail['width'] ) ) {
				$mediaDetail['width'] = $fallbackSize;

				\Wikia\Logger\WikiaLogger::instance()->notice(
					'ArticleAsJson - Media width was empty - fallback to fallbackSize',
					[
						'media_details' => json_encode( $mediaDetail ),
						'fallback_size' => $fallbackSize
					]
				);
			}

			if ( empty( $mediaDetail['height'] ) ) {
				$mediaDetail['height'] = $fallbackSize;

				\Wikia\Logger\WikiaLogger::instance()->notice(
					'ArticleAsJson - Media height was empty - fallback to fallbackSize',
					[
						'media_details' => json_encode( $mediaDetail ),
						'fallback_size' => $fallbackSize
					]
				);
			}
		}

		return $mediaDetail;
	}
}
