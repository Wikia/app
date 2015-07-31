<?php

class ArticleAsJson extends WikiaService {
	static $media = [];
	static $users = [];
	static $mediaDetailConfig = [
		'imageMaxWidth' => false
	];

	const ICON_MAX_SIZE = 48;
	const CACHE_VERSION = '0.0.3';

	const MEDIA_CONTEXT_ARTICLE_IMAGE = 'article-image';
	const MEDIA_CONTEXT_ARTICLE_VIDEO = 'article-video';
	const MEDIA_CONTEXT_GALLERY_IMAGE = 'gallery-image';
	const MEDIA_CONTEXT_ICON = 'icon';
	const MEDIA_CONTEXT_INFOBOX = 'infobox';

	private static function createMarker( $width = 0, $height = 0, $isGallery = false ){
		$blankImgUrl = '//:0';
		$id = count( self::$media ) - 1;
		$classes = 'article-media' . ($isGallery ? ' gallery' : '');
		$width = !empty( $width ) ? " width='{$width}'" : '';
		$height = !empty( $height ) ? " height='{$height}'": '';

		return "<img src='{$blankImgUrl}' class='{$classes}' data-ref='{$id}'{$width}{$height} />";
	}

	public static function createMediaObject( $details, $imageName, $caption = null, $link = null ) {
		wfProfileIn( __METHOD__ );

		$context = '';
		$media = [
			'type' => $details['mediaType'],
			'url' => $details['rawImageUrl'],
			'fileUrl' => $details['fileUrl'],
			'title' => $imageName,
			'user' => $details['userName']
		];

		if ( is_string( $link ) && $link !== '' ) {
			$media['link'] = $link;
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

		wfProfileOut( __METHOD__ );
		return $media;
	}

	private static function addUserObj( $details ){
		wfProfileIn( __METHOD__ );

		$userTitle = Title::newFromText( $details['userName'], NS_USER );

		self::$users[$details['userName']] = [
			'id' => (int) $details['userId'],
			'avatar' => $details['userThumbUrl'],
			'url' => $userTitle instanceof Title ? $userTitle->getLocalURL() : ''
		];

		wfProfileOut( __METHOD__ );
	}

	public static function onGalleryBeforeProduceHTML( $data, &$out ){
		global $wgArticleAsJson;

		wfProfileIn( __METHOD__ );

		if ( $wgArticleAsJson ) {
			$parser = ParserPool::get();
			$parserOptions = new ParserOptions();
			$title = F::app()->wg->Title;
			$media = [];

			foreach($data['images'] as $image) {
				$details = WikiaFileHelper::getMediaDetail(
					Title::newFromText( $image['name'], NS_FILE ),
					self::$mediaDetailConfig
				);
				$details['context'] = self::MEDIA_CONTEXT_GALLERY_IMAGE;

				$caption = $image['caption'];

				if ( !empty( $caption ) ) {
					$caption = $parser->parse( $caption, $title, $parserOptions, false )->getText();
				}
				$linkHref = isset( $image['linkhref'] ) ? $image['linkhref'] : null;
				$media[] = self::createMediaObject( $details, $image['name'], $caption, $linkHref );

				self::addUserObj($details);
			}

			self::$media[] = $media;

			if ( !empty( $media ) ) {
				$out = self::createMarker( $media[0]['width'], $media[0]['height'], true );
			} else {
				$out = '';
			}

			ParserPool::release( $parser );
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onPortableInfoboxNodeImageGetData( $title, &$ref, $alt ) {

		wfProfileIn( __METHOD__ );
		if ( $title ) {
			$details = WikiaFileHelper::getMediaDetail( $title, self::$mediaDetailConfig );
			$details['context'] = self::MEDIA_CONTEXT_INFOBOX;
			self::$media[] = self::createMediaObject( $details, $title->getText(), $alt );
			$ref = count( self::$media ) - 1;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onImageBeforeProduceHTML( &$dummy, Title &$title, &$file, &$frameParams, &$handlerParams, &$time, &$res ) {
		global $wgArticleAsJson;

		wfProfileIn( __METHOD__ );

		if ( $wgArticleAsJson ) {
			$linkHref = '';

			if ( isset( $frameParams['link-title'] ) && $frameParams['link-title'] instanceof Title ) {
				$linkHref = $frameParams['link-title']->getLocalURL();
			} else if ( !empty( $frameParams['link-url'] ) ) {
				$linkHref = $frameParams['link-url'];
			}

			$details = WikiaFileHelper::getMediaDetail( $title, self::$mediaDetailConfig );

			//information for mobile skins how they should display small icons
			$details['context'] = self::isIconImage($handlerParams) ? self::MEDIA_CONTEXT_ICON : self::MEDIA_CONTEXT_ARTICLE_IMAGE;

			self::$media[] = self::createMediaObject( $details, $title->getText(), $frameParams['caption'], $linkHref );

			self::addUserObj($details);

			$res = self::createMarker( $details['width'], $details['height'] );

			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onPageRenderingHash( &$confstr ) {
		global $wgArticleAsJson;

		wfProfileIn( __METHOD__ );
		if ( $wgArticleAsJson ) {
			$confstr .= '!ArticleAsJson:' . self::CACHE_VERSION;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onParserAfterTidy( Parser &$parser, &$text ) {
		global $wgArticleAsJson;

		wfProfileIn( __METHOD__ );

		if ( $wgArticleAsJson && !is_null( $parser->getRevisionId() ) ) {

			$userName = $parser->getRevisionUser();

			if ( !empty( $userName ) ) {
				if ( User::isIP( $userName ) ) {

					self::addUserObj( [
						'userId' => 0,
						'userName' => $userName,
						'userThumbUrl' => AvatarService::getAvatarUrl( $userName, AvatarService::AVATAR_SIZE_MEDIUM ),
						'userPageUrl' => Title::newFromText( $userName )->getLocalURL()
					] );
				} else {
					$user = User::newFromName( $userName );
					if ( $user instanceof User ) {
						self::addUserObj( [
							'userId' => $user->getId(),
							'userName' => $user->getName(),
							'userThumbUrl' => AvatarService::getAvatarUrl( $user, AvatarService::AVATAR_SIZE_MEDIUM ),
							'userPageUrl' => $user->getUserPage()->getLocalURL()
						] );
					}
				}
			}

			foreach ( self::$media as &$media ) {
				self::linkifyMediaCaption( $parser, $media );
			}

			$text = json_encode( [
				'content' => $text,
				'media' => self::$media,
				'users' => self::$users
			] );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onShowEditLink( Parser &$this, &$showEditLink ) {
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
		$caption = $media['caption'];
		if (
			!empty( $caption ) &&
			is_string( $caption ) &&
			(
				strpos( $caption, '<!--LINK' ) !== false ||
				strpos( $caption, '<!--IWLINK' ) !== false
			)
		) {
			$parser->replaceLinkHolders( $media['caption'] );
		}
	}

	/**
	 * @desc Determines if image is a small image used by users on desktop
	 * as an icon. They to it by explicitly adding
	 * '{width}px' or 'x{height}px' to image wikitext
	 *
	 * @param $handlerParams
	 *
	 * @return bool true if one of the image sizes is smaller than ICON_MAX_SIZE
	*/
	private static function isIconImage( $handlerParams ) {
		$fixedWidth = isset($handlerParams['width']) ? $handlerParams['width'] < self::ICON_MAX_SIZE : false;
		$fixedHeight = isset($handlerParams['height']) ? $handlerParams['height'] < self::ICON_MAX_SIZE : false;
		return $fixedWidth || $fixedHeight;
	}
}
