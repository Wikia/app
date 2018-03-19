<?php

class ArticleAsJson {
	// TODO: remove it and all usages with XW-4719
	const SIMPLYFY_RENDERING_QP = 'simplifyRendering';
	const SIMPLYFY_RENDERING_QP_VALUE = 'true';

	static $media = [ ];
	static $users = [ ];
	static $heroImage = null;
	static $mediaDetailConfig = [
		'imageMaxWidth' => false
	];

	const CACHE_VERSION = 3.26;

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
	const MEDIA_LINKED_GALLERY_TEMPLATE = 'extensions/wikia/ArticleAsJson/templates/media-linked-gallery.mustache';

	// TODO: remove these, all usages and mentioned templates with XW-4719
	const MEDIA_THUMBNAIL_TEMPLATE_OLD = 'extensions/wikia/ArticleAsJson/templates/media-thumbnail-old.mustache';
	const MEDIA_GALLERY_TEMPLATE_OLD = 'extensions/wikia/ArticleAsJson/templates/media-gallery-old.mustache';

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

	// TODO: remove it and all usages with XW-4719
	public static function simplifyRendering(): bool {
		return RequestContext::getMain()->getRequest()->getVal(self::SIMPLYFY_RENDERING_QP, "false") === self::SIMPLYFY_RENDERING_QP_VALUE;
	}

	private static function renderImage( $media, $id ) {
		if ( self::simplifyRendering() ) {
			return self::removeNewLines(
				\MustacheService::getInstance()->render(
					self::MEDIA_THUMBNAIL_TEMPLATE,
					[
						'media' => $media,
						'mediaAttrs' => json_encode( $media ),
						'downloadIcon' => DesignSystemHelper::renderSvg( 'wds-icons-download', 'wds-icon' ),
						'chevronIcon' => DesignSystemHelper::renderSvg('wds-icons-menu-control-tiny', 'wds-icon wds-icon-tiny chevron')
					]
				)
			);
		} else {
			return self::removeNewLines(
				\MustacheService::getInstance()->render(
					self::MEDIA_THUMBNAIL_TEMPLATE_OLD,
					[
						'mediaAttrs' => json_encode( [ 'ref' => $id ] ),
						'media' => $media,
						'width' => $media['width'],
						'height' => $media['height'],
						'url' => $media['url'],
						'title' => $media['title'],
						'fileUrl' => $media['fileUrl'],
						'caption' => $media['caption'] ?? '',
						'href' => $media['href'],
						'isLinkedByUser' => $media['isLinkedByUser'],
						/**
						 * data-ref has to be set for now because it's read in
						 * extensions/wikia/PortableInfobox/services/Parser/Nodes/NodeImage.php:getGalleryData
						 * and in
						 * extensions/wikia/PortableInfobox/services/Parser/Nodes/NodeImage.php:getTabberData.
						 * Base on presence of data-ref element is classified as an image
						 * - without that service would return null
						 *
						 * @TODO XW-1460 fix the regex and remove this attribute
						 */
						'ref' => $id
					]
				)
			);
		}

	}

	private static function renderGallery( $media, $id, $hasLinkedImages ) {
		if ( self::simplifyRendering() ) {
			if ( $hasLinkedImages ) {
				return self::removeNewLines(
					\MustacheService::getInstance()->render(
						self::MEDIA_LINKED_GALLERY_TEMPLATE,
						[
							'galleryAttrs' => json_encode( $media ),
							'media' => $media,
							'downloadIcon' => DesignSystemHelper::renderSvg( 'wds-icons-download', 'wds-icon' ),
							'viewMoreLabel' => wfMessage('communitypage-view-more')->escaped(), // TODO:  XW-4793
							'linkedGalleryViewMoreVisible' => $hasLinkedImages && count($media) > 4,
							'chevronIcon' => DesignSystemHelper::renderSvg('wds-icons-menu-control-tiny', 'wds-icon wds-icon-tiny chevron')
						]
					)
				);
			} else {
				return self::removeNewLines(
					\MustacheService::getInstance()->render(
						self::MEDIA_GALLERY_TEMPLATE,
						[
							'galleryAttrs' => json_encode( $media ),
							'media' => $media,
							'downloadIcon' => DesignSystemHelper::renderSvg( 'wds-icons-download', 'wds-icon' ),
						]
					)
				);
			}
		} else {
			return self::removeNewLines(
				\MustacheService::getInstance()->render(
					self::MEDIA_GALLERY_TEMPLATE_OLD,
					[
						'galleryAttrs' => json_encode( [ 'ref' => $id ] ),
						/**    +                    'hasLinkedImages' => $hasLinkedImages,
						 * data-ref has to be set for now because it's read in
						 * extensions/wikia/PortableInfobox/services/Parser/Nodes/NodeImage.php::getGalleryData
						 * and in
						 * extensions/wikia/PortableInfobox/services/Parser/Nodes/NodeImage.php::getTabberData
						 * Base on presence of data-ref element is classified as an image
						 * - without that service would return null
						 *
						 * !!! Important note - data-ref inside template has ' instead of "
						 * because this is how regex in
						 * extensions/wikia/PortableInfobox/services/Parser/Nodes/NodeImage.php::getGalleryData
						 * works
						 *
						 * @TODO XW-1460 fix the regex and remove this attribute
						 */
						'ref' => $id,
						'media' => $media,
						'hasLinkedImages' => $hasLinkedImages
					]
				)
			);
		}
	}

	private static function removeNewLines( $string ) {
		return trim( preg_replace( '/\s+/', ' ', $string ) );
	}

	private static function createMarker( $media, $isGallery = false ) {
		$id = count( self::$media ) - 1;

		if ( $isGallery ) {
			$hasLinkedImages = false;

			if ( count(
				array_filter(
					$media,
					function ( $item ) {
						return $item['isLinkedByUser'];
					}
				)
			) ) {
				$hasLinkedImages = true;
			}

			return self::renderGallery( $media, $id, $hasLinkedImages );
		} else if ( $media['context'] === self::MEDIA_CONTEXT_ICON ) {
			return self::renderIcon( $media );
		} else {
			return self::renderImage( $media, $id );
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

	private static function addUserObj( $details ) {
		$userTitle = Title::newFromText( $details['userName'], NS_USER );

		self::$users[$details['userName']] = [
			'id' => (int) $details['userId'],
			'avatar' => $details['userThumbUrl'],
			'url' => $userTitle instanceof Title ? $userTitle->getLocalURL() : ''
		];
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
				$mediaObj['mediaAttr'] = json_encode( $mediaObj );
				$mediaObj['galleryRef'] = $index;
				$mediaObj['thumbnailUrl'] = VignetteRequest::fromUrl( $mediaObj['url'] )
					->zoomCrop()
					->width( 195 )
					->height( 195 )
					->url();

				$media[] = $mediaObj;

				self::addUserObj( $details );
			}

			self::$media[] = $media;

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

	public static function onExtendPortableInfoboxImageData( $data, &$ref, &$dataAttrs ) {
		$title = Title::newFromText( $data['name'] );
		if ( $title ) {
			$details = self::getMediaDetailWithSizeFallback( $title, self::$mediaDetailConfig );
			$details['context'] = $data['context'];
			$mediaObj = self::createMediaObject( $details, $title->getText(), $data['caption'] );
			self::$media[] = $mediaObj;
			$dataAttrs = $mediaObj;

			if ( $details['context'] == 'infobox-hero-image' && empty( self::$heroImage ) ) {
				self::$heroImage = $mediaObj;
			}
			$ref = count( self::$media ) - 1;
		}

		return true;
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
			$media['srcset'] = self::getSrcset( $media['url'], intval( $media['width'] ) );
			$media['thumbnail'] = self::getThumbnailUrlForWidth( $media['url'], 340 );

			self::$media[] = $media;

			self::addUserObj( $details );

			$res = self::createMarker( $media );

			return false;
		}

		return true;
	}

	private static function getSrcset( string $url, int $originalWidth ): string {
		$widths = [ 284, 340, 732, 985 ];
		$srcSetItems = [];

		foreach ( $widths as $width ) {
			if ( $width <= $originalWidth ) {
				$thumb = self::getThumbnailUrlForWidth( $url, $width );
				$srcSetItems[] = "${thumb} ${width}w";
			}
		}

		return implode( ',', $srcSetItems );
	}

	private static function getThumbnailUrlForWidth( string $url, int $requestedWidth ) {
		return VignetteRequest::fromUrl( $url )
			->scaleToWidth( $requestedWidth )
			->url();
	}

	public static function onPageRenderingHash( &$confstr ) {
		global $wgArticleAsJson;

		if ( $wgArticleAsJson ) {
			$confstr .= '!ArticleAsJson:' . self::CACHE_VERSION;

			// this is pseudo-versioning query param for collapsible sections (XW-4393)
			// should be removed after all App caches are invalidated
			if ( !empty( RequestContext::getMain()
				->getRequest()
				->getVal( 'collapsibleSections' ) )
			) {
				$confstr .= ':collapsibleSections';
			}

			if ( self::simplifyRendering() ) {
				$confstr .= ':simplifyRendering';
			}
		}

		return true;
	}

	public static function onParserAfterTidy( Parser $parser, &$text ): bool {
		global $wgArticleAsJson;

		if ( $wgArticleAsJson && !is_null( $parser->getRevisionId() ) ) {

			$userName = $parser->getRevisionUser();

			if ( !empty( $userName ) ) {
				if ( User::isIP( $userName ) ) {

					self::addUserObj(
						[
							'userId' => 0,
							'userName' => $userName,
							'userThumbUrl' => AvatarService::getAvatarUrl(
								$userName,
								AvatarService::AVATAR_SIZE_MEDIUM
							),
							'userPageUrl' => Title::newFromText( $userName )->getLocalURL()
						]
					);
				} else {
					$user = User::newFromName( $userName );
					if ( $user instanceof User ) {
						self::addUserObj(
							[
								'userId' => $user->getId(),
								'userName' => $user->getName(),
								'userThumbUrl' => AvatarService::getAvatarUrl(
									$user,
									AvatarService::AVATAR_SIZE_MEDIUM
								),
								'userPageUrl' => $user->getUserPage()->getLocalURL()
							]
						);
					}
				}
			}

			foreach ( self::$media as &$media ) {
				self::linkifyMediaCaption( $parser, $media );
			}

			Hooks::run( 'ArticleAsJsonBeforeEncode', [ &$text ] );

			$text = json_encode(
				[
					'content' => $text,
					'media' => self::$media,
					'users' => self::$users,
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
	 * Because we take captions out of main parser flow we have to replace links manually
	 *
	 * @param Parser $parser
	 * @param $media
	 */
	private static function linkifyMediaCaption( Parser $parser, &$media ) {
		if ( array_key_exists( 'caption', $media ) ) {
			$caption = $media['caption'];

			if ( is_string( $caption ) &&
				( strpos( $caption, '<!--LINK' ) !== false || strpos( $caption, '<!--IWLINK' ) !== false )
			) {
				$parser->replaceLinkHolders( $media['caption'] );
			}
		}
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
						'media_details' => $mediaDetail,
						'fallback_size' => $fallbackSize
					]
				);
			}

			if ( empty( $mediaDetail['height'] ) ) {
				$mediaDetail['height'] = $fallbackSize;

				\Wikia\Logger\WikiaLogger::instance()->notice(
					'ArticleAsJson - Media height was empty - fallback to fallbackSize',
					[
						'media_details' => $mediaDetail,
						'fallback_size' => $fallbackSize
					]
				);
			}
		}

		return $mediaDetail;
	}
}
