<?php

/**
 * Helper service to maintain new video logic / old video logic
 */
class WikiaFileHelper {

	const maxWideoWidth = 1200;

	// For images smaller than the requested thumb size determines how close an images area (width x height) must be
	// to the requested thumbnail area before it will be enlarged.  For example a value of 0.8 means that images
	// who's area is 80% the area of the requested thumb or larger should be scaled up to the thumb dimensions.
	const thumbEnlargeThreshold = 0.5;

	/**
	 * Ogg files are the only video file type we allow upload.  As such we treat them differently
	 * than other video, externally stored video.  It would be best if this functionality could be
	 * incorporated into our VideoHandlers extension but given the OGG usage this is low priority.
	 *
	 * @param Title|File $file
	 *
	 * @return bool
	 */
	public static function isFileTypeOgg( $file ) {
		// File can be video only when new video logic is enabled for the wiki
		if ( $file instanceof Title ) {
			$file = wfFindFile( $file );
		}
		return self::isOggFile( $file );
	}

	/**
	 * Checks whether this file is an OGG file or not
	 * @param File $file
	 *
	 * @return bool
	 */
	public static function isOggFile( $file ) {
		return ( $file instanceof LocalFile && $file->getHandler() instanceof OggHandler );
	}

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
	 * Checks if user wants to have old image bahaviour
	 * @return boolean
	 */
	public static function preserveOldImageBehaviour() {
		return false;
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

		return array_merge($configDefaults, $config);
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
			'mime' => '',
			'videoEmbedCode' => '',
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
			'extraHeight' => 0,
			'externalUrl' => '',
		);

		if ( !empty( $fileTitle ) ) {
			if ( $fileTitle->getNamespace() != NS_FILE ) {
				$fileTitle = Title::newFromText( $fileTitle->getDBKey(), NS_FILE );
			}

			$file = self::getFileFromTitle( $fileTitle, true );

			if ( !empty( $file ) ) {
				/** @var WikiaLocalFile|WikiaLocalFileShared $file */
				$config = self::getMediaDetailConfig( $config );

				$data['exists'] = true;
				$data['mediaType'] = self::isFileTypeVideo( $file ) ? 'video' : 'image';
				$data['mime'] = $file->getMimeType();

				$width = (int) $file->getWidth();
				$height = (int) $file->getHeight();

				if ( $data['mediaType'] == 'video' ) {
					$width  = $config['contextWidth']  ? $config['contextWidth']  : $width;
					$height = $config['contextHeight'] ? $config['contextHeight'] : $height;
					if ( isset( $config['maxHeight'] ) ) {
						$file->setEmbedCodeMaxHeight( $config['maxHeight'] );
					}
					$options = [
						'autoplay' => true,
						'isAjax' => true,
						'isInline' => !empty( $config['isInline'] ),
					];
					$data['videoEmbedCode'] = $file->getEmbedCode( $width, $options );
					$data['videoViews'] = MediaQueryService::getTotalVideoViewsByTitle( $fileTitle->getDBKey() );
					$data['providerName'] = $file->getProviderName();
					$data['duration'] = $file->getMetadataDuration();
					$data['isAdded'] = self::isAdded( $file );
					$mediaPage = self::getMediaPage( $fileTitle );
				} else {
					$width = !empty( $config[ 'imageMaxWidth' ] ) ? min( $config[ 'imageMaxWidth' ], $width ) : $width;
					$mediaPage = new ImagePage( $fileTitle );
				}

				$thumb = $file->transform( array('width'=>$width, 'height'=>$height), 0 );
				$user = User::newFromId( $file->getUser('id') );

				// get article list
				$mediaQuery =  new ArticlesUsingMediaQuery( $fileTitle );
				$articleList = $mediaQuery->getArticleList();

				$data['fileUrl'] = $fileTitle->getFullUrl();
				$data['imageUrl'] = $thumb->getUrl();
				$data['rawImageUrl'] = $file->getUrl();
				$data['userId'] = $user->getId();
				$data['userName'] = $user->getName();
				$data['userThumbUrl'] = AvatarService::getAvatarUrl( $user, $config['userAvatarWidth'] );
				$data['userPageUrl'] = $user->getUserPage()->getFullURL();
				$data['description']  = $mediaPage->getContent();
				$data['articles'] = $articleList;
				$data['width'] = $width;
				$data['height'] = $height;

				// this covers eg. images added via InstantCommons
				if ( !$file->isLocal() ) {
					$data['externalUrl'] = $file->getDescriptionUrl();
				}
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

	/**
	 * Gathers information about a video
	 *
	 * @deprecated Use VideoHandlerHelper::getVideoDetailFromWiki or VideoHandlerHelper::getVideoDetail instead
	 *
	 * @param $arr
	 * @param Title $title
	 * @param int $width
	 * @param int $height
	 * @param bool $force16x9Ratio
	 */
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
	 * @return File|WikiaLocalFileShared|null $file
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
		if ( $file instanceof File && !$file->isLocal() ) {
			$repo = $file->getRepo();
			// When repo is an instance of ForeignAPIRepo
			// file comes from MediaWiki and isn't stored on any wikia.
			return !( $repo instanceof ForeignAPIRepo );
		}
		return true;
	}

	/**
	 * Get message for by user section
	 * @param string $userName
	 * @param string $addedAt
	 * @return string $addedBy
	 */
	public static function getByUserMsg( $userName, $addedAt ) {
		// get link to user page
		$link = AvatarService::renderLink( $userName );
		$addedBy = wfMessage( 'thumbnails-added-by' )
			->rawParams( $link )
			->params( wfTimeFormatAgo( $addedAt, false ) )
			->escaped();

		return $addedBy;
	}

	/**
	 * Return a URL that displays $file scaled and/or cropped to fill the entire square thumbnail dimensions with
	 * no whitespace if possible.  Images smaller than the thumbnail size will be enlarged if their image area (L x W)
	 * is above a certain threshold.  This threshold is expressed as a percentage of the requested thumb area and
	 * given by:
	 *
	 *   self::thumbEnlargeThreshold
	 *
	 * Small images that do not meet this threshold will be centered within the thumb container and padded with a
	 * transparent background.
	 *
	 * @param File $file
	 * @param int $dimension
	 * @return string The URL of the image
	 */
	public static function getSquaredThumbnailUrl( File $file, $dimension ) {
		// Create a new url generator
		$gen = $file->getUrlGenerator();

		// Determine if this image falls into a small image category.  We compare the area of the image with the
		// area of the requested thumb and use self::thumbEnlargeThreshold as the threshold for enlarging
		$height = $file->getHeight();
		$width = $file->getWidth();
		$isSmallImage = $height < $dimension || $width < $dimension;
		$imageBelowThreshold = ( $height * $width ) <= ( self::thumbEnlargeThreshold * $dimension * $dimension );

		// If height or width is less than a side of our square target thumbnail, we need to decide whether we're
		// going to enlarge it or not
		if ( $isSmallImage && $imageBelowThreshold ) {
			// Leave the (small) full sized image as is, but put within the requested container with transparent fill
			$gen->fixedAspectRatioDown()->backgroundFill( 'transparent' );
		} else {
			if ( $height > $width ) {
				// Portrait mode, crop at the top
				$gen->topCrop();
			} else {
				// Landscape mode, crop in the middle
				$gen->zoomCrop();
			}
		}

		$url = $gen->width( $dimension )->height( $dimension )->url();

		return $url;
	}
}
