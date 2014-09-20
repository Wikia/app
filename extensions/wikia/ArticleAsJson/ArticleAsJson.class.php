<?php

class ArticleAsJson extends WikiaService {
	static $media = [];
	static $users = [];
	static $mediaDetailConfig = [
		'imageMaxWidth' => false
	];

	const CACHE_VERSION = '0.0.1';

	private static function createMarker( $width = 0, $height = 0, $isGallery = false ){
		$blankImgUrl = F::app()->wg->blankImgUrl;
		$id = count( self::$media ) - 1;
		$classes = 'article-media' . ($isGallery ? ' gallery' : '');
		$width = !empty( $width ) ? " width='{$width}'" : '';
		$height = !empty( $height ) ? " height='{$height}'": '';

		return "<img src='{$blankImgUrl}' class='{$classes}' data-ref='{$id}'{$width}{$height} />";
	}

	private static function createMediaObj( $details, $imageName, $caption = "" ) {
		wfProfileIn( __METHOD__ );

		static $parserOptions = null;

		if ( is_null($parserOptions ) ) {
			$parserOptions = new ParserOptions();
		}

		$media = [
			'type' => $details['mediaType'],
			'url' => $details['rawImageUrl'],
			'fileUrl' => $details['fileUrl'],
			'title' => $imageName,
			'caption' => ParserPool::parse(
					$caption,
					RequestContext::getMain()->getTitle(),
					$parserOptions,
					false
				)->getText(),
			'user' => $details['userName']
		];

		if ( !empty( $details['width'] ) ) {
			$media['width'] = (int) $details['width'];
		}

		if ( !empty( $details['height'] ) ) {
			$media['height'] = (int) $details['height'];
		}

		if ( $details['mediaType'] == 'video' ) {
			$media['views'] = (int) $details['videoViews'];
			$media['embed'] = $details['videoEmbedCode'];
			$media['provider'] = $details['providerName'];
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
			$media = [];

			foreach($data['images'] as $image) {
				$details = WikiaFileHelper::getMediaDetail(
					Title::newFromText( $image['name'], NS_FILE ),
					self::$mediaDetailConfig
				);

				$media[] = self::createMediaObj( $details, $image['name'], $image['caption'] );

				self::addUserObj($details);
			}

			self::$media[] = $media;

			if ( !empty( $media ) ) {
				$out = self::createMarker( $media[0]['width'], $media[0]['height'], true );
			} else {
				$out = '';
			}

			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onImageBeforeProduceHTML( &$dummy,Title &$title, &$file, &$frameParams, &$handlerParams, &$time, &$res ){
		global $wgArticleAsJson;

		wfProfileIn( __METHOD__ );

		if ( $wgArticleAsJson ) {
			$details = WikiaFileHelper::getMediaDetail( $title, self::$mediaDetailConfig );

			self::$media[] = self::createMediaObj( $details, $title->getText(), $frameParams['caption'] );

			self::addUserObj($details);

			$res = self::createMarker( $details['width'], $details['height'] );

			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onPageRenderingHash( &$confstr ){
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

			if ( User::isIP( $userName ) ) {

				self::addUserObj( [
					'userId' => 0,
					'userName' => $userName,
					'userThumbUrl' => AvatarService::getAvatarUrl( $userName, AvatarService::AVATAR_SIZE_MEDIUM ),
					'userPageUrl' => Title::newFromText( $userName )->getLocalURL()
				] );
			} else {
				$user = User::newFromName( $userName );

				self::addUserObj( [
					'userId' => $user->getId(),
					'userName' => $user->getName(),
					'userThumbUrl' => AvatarService::getAvatarUrl( $user, AvatarService::AVATAR_SIZE_MEDIUM ),
					'userPageUrl' => $user->getUserPage()->getLocalURL()
				] );
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
}
