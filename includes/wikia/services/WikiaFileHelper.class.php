<?php
/**
 * Helper service to maintain new video logic / old video logic
 */
class WikiaFileHelper extends Service {

	const maxWideoWidth = 1200;

	/**
	 * Checks if given File is video
	 * @param File|Title $file object or Title object eventually
	 * @return boolean
	 */
	public static function isFileTypeVideo( $file ) {
		// File can be video only when new video logic is enabled for the wiki
		if ( $file instanceof Title ) {
			$file = wfFindFile( $file );
		}
		return self::isVideoFile( $file );
	}

	/**
	 * Check if the file is video
	 * @param File $file
	 * @return boolean
	 */
	public static function isVideoFile( $file ) {
		return ( $file instanceof LocalFile && $file->getHandler() instanceof VideoHandler );
	}

	/**
	 * Checks if given Title is video
	 * @deprecated use isFileTypeVideo instead
	 * @param $title
	 * @param bool $allowOld
	 * @return boolean
	 */
	public static function isTitleVideo( $title, $allowOld = true ) {
		$title = self::getTitle( $title );

		if ( empty( $title ) ) {
			return false;
		}

		// video-as-file logic
		return self::isFileTypeVideo( $title );
	}


	public static function getTitle( $mTitle ) {
		if ( !( $mTitle instanceof Title ) ) {

			$mTitle = Title::newFromText( $mTitle );
			if ( !( $mTitle instanceof Title ) ) {
				return false;
			}
		}

		return $mTitle;
	}

	/**
	 * Looks up videos with same provider and videoId
	 * as specified inside currently uploaded videos on wiki
	 * (searches Image table)
	 * @param string $provider
	 * @param string $videoId
	 * @param boolean $isRemoteAsset
	 * @return array $result
	 */
	public static function findVideoDuplicates( $provider, $videoId, $isRemoteAsset = false ) {
		wfProfileIn( __METHOD__ );

		//print "Looking for duplicaes of $provider $videoId\n";
		$db = wfGetDB( DB_MASTER ); // has to be master otherwise there's a chance of getting duplicates

		// for remote asset, $videoId is string even if it is numeric
		if ( is_numeric( $videoId ) && !$isRemoteAsset ) {
			$videoStr = 'i:'.$videoId;
		} else {
			$videoId = (string) $videoId;
			$videoStr = 's:'.strlen( $videoId ).':"'.$videoId.'"';
		}

		if ( strstr($provider, '/') ) {
			$providers = explode( '/', $provider );
			$provider = $providers[0];
		}

		$conds = array( 'img_media_type' => 'VIDEO' );
		if ( $isRemoteAsset ) {
			$providerStr = 's:6:"source";s:'.strlen( $provider ).':"'.$provider.'";';
			$conds[] = "img_metadata LIKE '%$providerStr%'";
			$conds[] = "img_metadata LIKE '%s:8:\"sourceId\";".$videoStr.";%'";
		} else {
			$conds['img_minor_mime'] = $provider;
			$conds[] = "img_metadata LIKE '%s:7:\"videoId\";".$videoStr.";%'";
		}

		$rows = $db->select(
			'image',
			'*',
			$conds,
			__METHOD__
		);

		$result = array();

		while ( $row = $db->fetchRow( $rows ) ) {
			$result[] = $row;
		}

		$db->freeResult( $rows );

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Get duplicate videos (from video_info table)
	 * @param string $provider
	 * @param string $videoId
	 * @param integer $limit
	 * @return array $videos
	 */
	public static function getDuplicateVideos( $provider, $videoId, $limit = 1 ) {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_MASTER );

		$result = $db->select(
			'video_info',
			'*',
			array(
				'video_id' => $videoId,
				'provider' => $provider,
			),
			__METHOD__,
			array( 'LIMIT' => $limit )
		);

		$videos = array();
		while ( $row = $db->fetchRow( $result ) ) {
			$videos[] = $row;
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * get html for video play button overlay
	 * @global string $wgBlankImgUrl
	 * @param integer $width
	 * @param integer $height
	 * @return string
	 */
	public static function videoPlayButtonOverlay( $width, $height ) {
		$sizeClass = '';
		if ( $width <= 170 ) {
			$sizeClass = 'small';
		}
		if ( $width > 360 ) {
			$sizeClass = 'large';
		}

		$html = Xml::openElement( 'div', array(
			'class' => 'Wikia-video-play-button',
			'style' => 'line-height:' . $height . 'px;width:' . $width . 'px;',
		));

		$html .= Xml::element( 'img', array(
			'class' => 'sprite play ' . $sizeClass,
			'src' => F::app()->wg->BlankImgUrl,
		));

		$html .= Xml::closeElement( 'div' );

		return $html;
	}

	/**
	 * get html for video info overlay
	 * @param integer $width
	 * @param Title|string $title
	 * @param Boolean $showViews
	 * @return string
	 */
	public static function videoInfoOverlay( $width, $title = null, $showViews = false ) {
		$html = '';
		if ( $width > 230 && !empty( $title ) ) {
			$file = self::getFileFromTitle( $title );
			if ( !empty( $file ) ) {
				// info
				$attribs = [
					"class" => "info-overlay",
					"style" => "width: {$width}px;"
				];

				// video title
				$contentWidth = $width - 60;
				$videoTitle = $title->getText();
				$content = self::videoOverlayTitle( $videoTitle, $contentWidth );

				// video duration
				$duration = '';
				$fileMetadata = $file->getMetadata();
				if ( $fileMetadata ) {
					$fileMetadata = unserialize( $fileMetadata );
					if ( array_key_exists( 'duration', $fileMetadata ) ) {
						$duration = $fileMetadata['duration'];
						$isoDuration = self::formatDurationISO8601( $duration );
						$content .= '<meta itemprop="duration" content="'.$isoDuration.'">';
					}
				}

				$content .= self::videoOverlayDuration( self::formatDuration( $duration ) );
				$content .= '<br />';

				// video views
				$videoTitle = $title->getDBKey();
				if ( $showViews ) {
					$views = MediaQueryService::getTotalVideoViewsByTitle( $videoTitle );
					$content .= self::videoOverlayViews( $views );
					$attribs['class'] .= " info-overlay-with-views";
					$content .= '<meta itemprop="interactionCount" content="UserPlays:'.$views.'" />';
				}

				$html = Xml::tags( 'span', $attribs, $content );
			}
		}

		return $html;
	}

	/**
	 * get html for title for video overlay
	 * @param $title
	 * @param $width
	 * @return string
	 */
	public static function videoOverlayTitle( $title, $width ) {
		$attribs = array(
			'class' => 'info-overlay-title',
			'style' => 'max-width:'.$width.'px;',
			'itemprop' => 'name',
		);

		return Xml::element( 'span', $attribs, $title, false );
	}

	/**
	 * get html for duration for video overlay
	 * @param $duration
	 * @return string
	 */
	public static function videoOverlayDuration( $duration ) {
		$html = '';
		if ( !empty($duration) ) {
			$attribs = array(
				'class' => 'info-overlay-duration',
				'itemprop' => 'duration',
			);

			$html = Xml::element( 'span', $attribs, "($duration)", false );
		}

		return $html;
	}

	/**
	 * get html for views for video overlay
	 * @param $views
	 * @return string
	 */
	public static function videoOverlayViews( $views ) {
		$attribs = array(
			'class' => 'info-overlay-views',
		);
		$views = wfMessage( 'videohandler-video-views', F::app()->wg->Lang->formatNum( $views ) )->text();

		return Xml::element( 'span', $attribs, $views, false );
	}

	/**
	 * Checks if user wants to have old image bahaviour
	 * @return boolean
	 */
	public static function preserveOldImageBehaviour() {
		return false;
	}

	/**
	 * Can WikiaVideo extension be used to ingest video
	 * @return boolean
	 */
	public static function useWikiaVideoExtForIngestion() {
		return !empty(F::app()->wg->ingestVideosUseWikiaVideoExt);
	}

	/**
	 * Can VideoHandlers extensions be used to ingest video
	 * @return boolean
	 */
	public static function useVideoHandlersExtForIngestion() {
		return !empty( F::app()->wg->ingestVideosUseVideoHandlersExt );
	}

	/**
	 * Can VideoHandlers extension be used to embed video
	 * @return boolean
	 */
	public static function useVideoHandlersExtForEmbed() {
		return !empty( F::app()->wg->embedVideosUseVideoHandlersExt );
	}

	/**
	 * Could the given URL exist on this wiki? Does not actually check if
	 * video exists.
	 * @param string $url
	 * @return boolean
	 */
	public static function isUrlMatchThisWiki( $url ) {
		return stripos( $url, F::app()->wg->server ) !== false;
	}

	/**
	 * Could the given URL exist on the Wikia video repository? Does not
	 * actually check if video exists.
	 * @param string $url
	 * @return boolean
	 */
	public static function isUrlMatchWikiaVideoRepo( $url ) {
		return stripos( $url, F::app()->wg->wikiaVideoRepoPath ) !== false;
	}

	/**
	 * Get media config (for MediaDetail() function)
	 * @param array $config
	 * @return array $config
	 */
	public static function getMediaDetailConfig( $config = array() ) {
		$configDefaults = array(
			'contextWidth'          => false,
			'contextHeight'         => false,
			'imageMaxWidth'         => 1000,
			'userAvatarWidth'       => 16
		);

		foreach ( $configDefaults as $key => $val ) {
			if ( empty( $config[$key] ) ) {
				$config[$key] = $val;
			}
		}

		return $config;
	}

	/**
	 * Get a new instance of the file page based on skin and if wgEnableVideoPageRedesign is enabled
	 *
	 * @param Title $fileTitle
	 * @return WikiaMobileFilePage|FilePageTabbed|WikiaFilePage
	 */
	public static function getMediaPage( $fileTitle ) {
		$app = F::app();

		if ( $app->checkSkin( 'oasis' ) && !empty( $app->wg->EnableVideoPageRedesign ) ) {
			$cls = 'FilePageTabbed';
		} else if ( $app->checkSkin( 'wikiamobile' ) ) {
			$cls = 'WikiaMobileFilePage';
		} else {
			$cls = 'WikiaFilePage';
		}
		return new $cls( $fileTitle );
	}

	/**
	 * @static
	 * @param Title $fileTitle
	 * @param array $config ( contextWidth, contextHeight, imageMaxWidth, userAvatarWidth )
	 * TODO - this method is very specific to lightbox.  This needs to be refactored back out to lightbox, and return just the basic objects (file, user, tect)
	 * @return array
	 */
	public static function getMediaDetail( $fileTitle, $config = array() ) {
		$data = array(
			'mediaType' => '',
			'videoEmbedCode' => '',
			'playerAsset' => '',
			'imageUrl' => '',
			'fileUrl' => '',
			'rawImageUrl' => '',
			'description' => '',
			'userThumbUrl' => '',
			'userId' => '',
			'userName' => '',
			'userPageUrl' => '',
			'articles' => array(),
			'providerName' => '',
			'videoViews' => 0,
			'exists' => false,
			'isAdded' => true,
		);

		if ( !empty( $fileTitle ) ) {
			if ( $fileTitle->getNamespace() != NS_FILE ) {
				$fileTitle = Title::newFromText( $fileTitle->getDBKey(), NS_FILE );
			}

			$file = wfFindFile( $fileTitle );

			if ( !empty( $file ) ) {
				$config = self::getMediaDetailConfig( $config );

				$data['exists'] = true;
				$data['mediaType'] = self::isFileTypeVideo( $file ) ? 'video' : 'image';

				$width = $file->getWidth();
				$height = $file->getHeight();

				if ( $data['mediaType'] == 'video' ) {
					$width  = $config['contextWidth']  ? $config['contextWidth']  : $width;
					$height = $config['contextHeight'] ? $config['contextHeight'] : $height;
					if ( isset( $config['maxHeight'] ) ) {
						$file->setEmbedCodeMaxHeight( $config['maxHeight'] );
					}
					$data['videoEmbedCode'] = $file->getEmbedCode( $width, true, true );
					$data['playerAsset'] = $file->getPlayerAssetUrl();
					$data['videoViews'] = MediaQueryService::getTotalVideoViewsByTitle( $fileTitle->getDBKey() );
					$data['providerName'] = $file->getProviderName();
					$data['isAdded'] = self::isAdded( $file );
					$mediaPage = self::getMediaPage( $fileTitle );
				} else {
					$width = $width > $config['imageMaxWidth'] ? $config['imageMaxWidth'] : $width;
					$mediaPage = new ImagePage( $fileTitle );
				}

				$thumb = $file->transform( array('width'=>$width, 'height'=>$height), 0 );
				$user = User::newFromId( $file->getUser('id') );

				// get article list
				$mediaQuery =  new ArticlesUsingMediaQuery( $fileTitle );
				$articleList = $mediaQuery->getArticleList();

				if ( $data['isAdded'] ) {
					$data['fileUrl'] = $fileTitle->getFullUrl();
				} else {
					$data['fileUrl'] = self::getFullUrlPremiumVideo( $fileTitle->getDBkey() );
				}

				$data['imageUrl'] = $thumb->getUrl();
				$data['rawImageUrl'] = $file->getUrl();
				$data['userId'] = $user->getId();
				$data['userName'] = $user->getName();
				$data['userThumbUrl'] = AvatarService::getAvatarUrl( $user, $config['userAvatarWidth'] );
				$data['userPageUrl'] = $user->getUserPage()->getFullURL();
				$data['description']  = $mediaPage->getContent();
				$data['articles'] = $articleList;
			}
		}

		return $data;
	}

	/**
	 * Truncate article list
	 * @param array $articles
	 * @param integer $limit
	 * @return array
	 */
	public static function truncateArticleList( $articles, $limit = 2 ) {
		$isTruncated = 0;
		$truncatedList = array();
		if ( !empty( $articles ) ) {
			foreach ( $articles as $article ) {
				// Create truncated list
				if ( count( $truncatedList ) < $limit ) {
					$article['titleText'] = preg_replace( '/\/@comment-.*/', '', $article['titleText'] );
					$truncatedList[] = $article;
				} else {
					$isTruncated = 1;
					break;
				}
			}
		}

		return array( $truncatedList, $isTruncated );
	}

	public static function inflateArrayWithVideoData( &$arr, Title $title, $width=150, $height=75, $force16x9Ratio=false ) {
		$arr['ns'] = $title->getNamespace();
		$arr['nsText'] = $title->getNsText();
		$arr['dbKey'] = $title->getDbKey();
		$arr['title'] = $title->getText();

		if ( $title instanceof GlobalTitle ) { //wfFindFile works with Title only
			$oTitle = Title::newFromText( $arr['nsText'].':'.$arr['dbKey'] );
		} else {
			$oTitle = $title;
		}
		$arr['url'] = $oTitle->getFullURL();

		$file = wfFindFile( $oTitle );
		if ( !empty( $file ) ) {
			$thumb = $file->transform( array( 'width'=>$width, 'height'=>$height ) );

			$htmlParams = array(
				'custom-title-link' => $oTitle,
				'duration' => true,
				'linkAttribs' => array( 'class' => 'video-thumbnail' )
			);
			if ( $force16x9Ratio ) {
				$htmlParams['src'] = self::thumbUrl2thumbUrl( $thumb->getUrl(), 'video', $width, $height );
				$thumb->width = $width;
				$thumb->height = $height;
			}

			$arr['thumbnail'] = $thumb->toHtml( $htmlParams );
		}
	}

	/**
	 * @param Title $title
	 * @param int $width
	 * @param int $height
	 * @param bool $force16x9Ratio
	 * @return string|false
	 */
	public static function getVideoThumbnailHtml( Title $title, $width=150, $height=75, $force16x9Ratio=false ) {
		$arr = [];
		self::inflateArrayWithVideoData( $arr, $title, $width, $height, $force16x9Ratio );
		if ( !empty( $arr['thumbnail'] ) ) {
			return $arr['thumbnail'];
		} else {
			return false;
		}
	}

	/**
	 * Convert thumbnail to different size.
	 *
	 * This is just a PHP port of JS Wikia.Thumbnailer.getThumbURL(), see thumbnailer.js for more details
	 *
	 * @todo consider implementing that logic inside ThumbnailVideo::toHtmml() directly
	 * @author ADi
	 */
	public static function thumbUrl2thumbUrl( $thumbUrl, $type, $width = 50, $height = 0 ) {
		$width .= ( $height ? '' : 'px' );

		// URL points to a thumbnail, remove crop and size
		//The URL of a thumbnail is in the following format:
		//http://domain/image_path/image.ext/thumbnail_options.ext
		//so return the URL till the last / to remove the options
		$thumbUrl = substr( $thumbUrl, 0, strripos( $thumbUrl, '/' ) );

		$tokens = explode( '/', $thumbUrl );
		$last = $tokens[count($tokens)-1];
		$tokens[] = $width . ( $height ? 'x' . $height : '-' ) . ( ( $type == 'video' || $type == 'nocrop' ) ? '-' : 'x2-' ) . $last . '.png';

		return implode( '/', $tokens );
	}

	/**
	 * Format duration from second to h:m:s
	 * @param integer $sec
	 * @return string $hms
	 */
	public static function formatDuration( $sec ) {
		$sec = intval( $sec );

		$format = ( $sec >= 3600 ) ? 'H:i:s' : 'i:s';
		$hms = gmdate( $format, $sec );

		return $hms;
	}

	/**
	 * Format duration from second to ISO 8601 format for meta tag
	 * @param integer $sec
	 * @return string $result
	 */
	public static function formatDurationISO8601( $sec ) {
		if ( empty( $sec ) ) {
			$result = '';
		} else {
			$sec = intval( $sec );

			$format = ( $sec >= 3600 ) ? '\P\TH\Hi\Ms\S' : '\P\Ti\Ms\S';
			$result = gmdate( $format, $sec );
		}

		return $result;
	}

	/**
	 * Get videos category [Category:Videos]
	 * @return string
	 */
	public static function getVideosCategory() {
		$cat = F::app()->wg->ContLang->getFormattedNsText( NS_CATEGORY );
		return ucfirst( $cat ) . ':' . wfMessage( 'videohandler-category' )->inContentLanguage()->text();
	}

	/**
	 * Get file from title (Please be careful when using $force)
	 *
	 * Note: this method turns a string $title into an object, affecting the calling code version
	 * of this variable
	 *
	 * @param Title|string $title
	 * @param bool $force
	 * @return File|null $file
	 */
	public static function getFileFromTitle( &$title, $force = false ) {
		if ( is_string( $title ) ) {
			$title = Title::newFromText( $title, NS_FILE );
		}

		if ( $title instanceof Title ) {
			// clear cache for file object
			if ( $force ) {
				RepoGroup::singleton()->clearCache( $title );
			}

			$file = wfFindFile( $title );
			if ( $file instanceof File && $file->exists() ) {
				return $file;
			}
		}

		return null;
	}

	/**
	 * Get video file from title (Please be careful when using $force)
	 *
	 * Note: this method calls getFileFromTitle which converts a string $title into a Title object.  This
	 * conversion is propagated up to the calling code.
	 *
	 * @param Title|string $title
	 * @param bool $force
	 * @return File|null $file
	 */
	public static function getVideoFileFromTitle( &$title, $force = false ) {
		$file = self::getFileFromTitle( $title, $force );
		if ( !empty( $file ) && self::isFileTypeVideo( $file ) ) {
			return $file;
		}

		return null;
	}

	/**
	 * Check if a url is a wikia file by parsing it for 'File' (or i18n'ed namespace).
	 * Return the title if found, otherwise null.
	 *
	 * @param $url String The URL of a video
	 * @return string|null
	 */
	public static function getWikiaFilename( $url ) {
		$nsFileTranslated = F::app()->wg->ContLang->getNsText( NS_FILE );
		$pattern = '/(File|'.$nsFileTranslated.'):(.+)$/';
		if ( preg_match( $pattern, urldecode( $url ), $matches ) ) {
			return $matches[2];
		}
		return null;
	}

	/**
	 * Check if the premium video is added to the wiki
	 * @param File $file
	 * @return boolean $isAdded
	 */
	public static function isAdded( $file ) {
		$isAdded = true;
		if ( $file instanceof File && !$file->isLocal()
			&& F::app()->wg->WikiaVideoRepoDBName == $file->getRepo()->getWiki() ) {
			$info = VideoInfo::newFromTitle( $file->getTitle()->getDBkey() );
			if ( empty( $info ) ) {
				$isAdded = false;
			}
		}
		return $isAdded;
	}

	/**
	 * Get full url for premium video
	 * @param string $fileTitle
	 * @return string $fullUrl
	 */
	public static function getFullUrlPremiumVideo( $fileTitle ) {
		return self::getFullUrlFromDBName( $fileTitle, F::app()->wg->WikiaVideoRepoDBName );
	}

	/**
	 * Get full url from dbname
	 * @param string $fileTitle
	 * @param string $dbName
	 * @return string $fullUrl
	 */
	public static function getFullUrlFromDBName( $fileTitle, $dbName ) {
		$wikiId = WikiFactory::DBtoID( $dbName );
		$globalTitle = GlobalTitle::newFromText( $fileTitle, NS_FILE, $wikiId );
		$fullUrl = $globalTitle->getFullURL();

		return $fullUrl;
	}

	/**
	 * Get thumbnail size. Mainly used for the class name that determines the size of the play button.
	 * @param integer $width
	 * @return string $size
	 */
	public static function getThumbnailSize( $width = 0 ) {
		if ( $width < 200 ) {
			$size = 'xsmall';
		} else if ( $width < 270 ) {
			$size = 'small';
		} else if ( $width < 470 ) {
			$size = 'medium';
		} else if ( $width < 720 ) {
			$size = 'large';
		} else {
			$size = 'xlarge';
		}

		return $size;
	}
}
