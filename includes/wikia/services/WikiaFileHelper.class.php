<?php
/**
 * Helper service to maintain new video logic / old video logic
 */
class WikiaFileHelper extends Service {

	const maxWideoWidth = 1200;

	/**
	 * Checks if videos on the wiki are converted to new format (File namespace)
	 * @return boolean
	 */
	public static function isVideoStoredAsFile() {
		// all videos are already converted and stored as a file
		return true;
	}

	/**
	 * Checks if given File is video
	 * @param $file WikiaLocalFile object or Title object eventually
	 * @return boolean
	 */
	public static function isFileTypeVideo( $file ) {
		if ( self::isVideoStoredAsFile() ) {
			// File can be video only when new video logic is enabled for the wiki
			if ( $file instanceof Title ) {
				$file = wfFindFile( $file );
			}
			return self::isVideoFile( $file );
		}
		return false;
	}

	public static function isVideoFile( $file ) {
		return ( $file instanceof LocalFile && $file->getHandler() instanceof VideoHandler);
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

		if ( empty($title) ) {
			return false;
		}

		if ( self::isVideoStoredAsFile() ) {

			// video-as-file logic
			if ( self::isFileTypeVideo($title) ) {

				return true;
			}
			return false;

		} elseif ( ( $title->getNamespace() == NS_VIDEO ) && $allowOld ) {

			return true;
		}

		return false;
	}


	public static function getTitle( $mTitle ){

		if ( !( $mTitle instanceof Title ) ) {

			$mTitle = Title::newFromText( $mTitle );
			if ( !($mTitle instanceof Title) ) {
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
		//print "Looking for duplicaes of $provider $videoId\n";
		$dbr = wfGetDB(DB_MASTER); // has to be master otherwise there's a chance of getting duplicates

		// for remote asset, $videoId is string even if it is numeric
		if ( is_numeric( $videoId ) && !$isRemoteAsset ) {
			$videoStr = 'i:'.$videoId;
		} else {
			$videoId = (string) $videoId;
			$videoStr = 's:'.strlen($videoId).':"'.$videoId.'"';
		}

		if ( strstr($provider, '/') ) {
			$providers = explode( '/', $provider );
			$provider = $providers[0];
		}

		$conds = array( 'img_media_type' => 'VIDEO' );
		if ( $isRemoteAsset ) {
			$providerStr = 's:6:"source";s:'.strlen($provider).':"'.$provider.'";';
			$conds[] = "img_metadata LIKE '%$providerStr%'";
			$conds[] = "img_metadata LIKE '%s:8:\"sourceId\";".$videoStr.";%'";
		} else {
			$conds['img_minor_mime'] = $provider;
			$conds[] = "img_metadata LIKE '%s:7:\"videoId\";".$videoStr.";%'";
		}

		$rows = $dbr->select(
			'image',
			'*',
			$conds,
			__METHOD__
		);

		$result = array();

		while($row = $dbr->fetchRow($rows)) {
			$result[] = $row;
		}

		$dbr->freeResult($rows);

		return $result;
	}

	/**
	 * get html for video play button overlay
	 * @global string $wgBlankImgUrl
	 * @param integer $width
	 * @param integer $height
	 * @return string
	 */
	public static function videoPlayButtonOverlay( $width, $height ) {
		global $wgBlankImgUrl;

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
			'src' => $wgBlankImgUrl,
		));

		$html .= Xml::closeElement( 'div' );

		return $html;
	}

	/**
	 * get html for video info overlay
	 * @param integer $width
	 * @param Title|string $title
	 * @return string
	 */
	public static function videoInfoOverlay( $width, $title = null ) {
		$html = '';
		if ( $width > 230 && !empty( $title ) ) {
			$file = self::getFileFromTitle( $title );
			if ( !empty( $file ) ) {
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
						$duration = self::formatDuration( $fileMetadata['duration'] );
						$isoDuration = self::getISO8601Duration( $duration );
						$content .= '<meta itemprop="duration" content="'.$isoDuration.'">';
					}
				}

				$content .= self::videoOverlayDuration( $duration );
				$content .= '<br />';

				// video views
				$videoTitle = $title->getDBKey();
				$views = MediaQueryService::getTotalVideoViewsByTitle( $videoTitle );
				$content .= self::videoOverlayViews( $views );
				$content .= '<meta itemprop="interactionCount" content="UserPlays:'.$views.'" />';

				// info
				$attribs = array(
					"class" => "info-overlay",
					"style" => "width: {$width}px;"
				);

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
		$app = F::app();

		$attribs = array(
			'class' => 'info-overlay-views',
		);
		$views = wfMsgExt( 'videohandler-video-views', array( 'parsemag' ), $app->wg->Lang->formatNum($views) );

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
		return static::isVideoStoredAsFile() || !empty(F::app()->wg->ingestVideosUseVideoHandlersExt);
	}

	/**
	 * Can VideoHandlers extension be used to embed video
	 * @return boolean
	 */
	public static function useWikiaVideoExtForEmbed() {
		return !static::isVideoStoredAsFile() && !empty(F::app()->wg->embedVideosUseWikiaVideoExt);
	}

	/**
	 * Can VideoHandlers extension be used to embed video
	 * @return boolean
	 */
	public static function useVideoHandlersExtForEmbed() {
		return static::isVideoStoredAsFile() || !empty(F::app()->wg->embedVideosUseVideoHandlersExt);
	}

	/**
	 * Could the given URL exist on this wiki? Does not actually check if
	 * video exists.
	 * @param string $url
	 * @return boolean
	 */
	public static function isUrlMatchThisWiki($url) {
		return stripos( $url, F::app()->wg->server ) !== false;
	}

	/**
	 * Could the given URL exist on the Wikia video repository? Does not
	 * actually check if video exists.
	 * @param string $url
	 * @return boolean
	 */
	public static function isUrlMatchWikiaVideoRepo($url) {
		return stripos( $url, F::app()->wg->wikiaVideoRepoPath ) !== false;
	}

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
		global $wgEnableVideoPageRedesign;

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
			'exists' => false
		);

		if ( !empty($fileTitle) ) {
			if ( $fileTitle->getNamespace() != NS_FILE ) {
				$fileTitle = Title::newFromText($fileTitle->getDBKey(), NS_FILE);
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
					$data['videoEmbedCode'] = $file->getEmbedCode( $width, true, true);
					$data['playerAsset'] = $file->getPlayerAssetUrl();
					$data['videoViews'] = MediaQueryService::getTotalVideoViewsByTitle( $fileTitle->getDBKey() );
					$data['providerName'] = $file->getProviderName();
					$mediaPage = self::getMediaPage( $fileTitle );
				} else {
					$width = $width > $config['imageMaxWidth'] ? $config['imageMaxWidth'] : $width;
					$mediaPage = new ImagePage($fileTitle);
				}

				$thumb = $file->transform( array('width'=>$width, 'height'=>$height), 0 );
				$user = User::newFromId( $file->getUser('id') );

				// get article list
				$mediaQuery =  new ArticlesUsingMediaQuery($fileTitle);
				$articleList = $mediaQuery->getArticleList();

				$data['imageUrl'] = $thumb->getUrl();
				$data['fileUrl'] = $fileTitle->getLocalUrl();
				$data['rawImageUrl'] = $file->getUrl();
				$data['userId'] = $user->getId();
				$data['userName'] = $user->getName();
				$data['userThumbUrl'] = AvatarService::getAvatarUrl($user, $config['userAvatarWidth'] );
				$data['userPageUrl'] = $user->getUserPage()->getFullURL();
				$data['description']  = $mediaPage->getContent();
				$data['articles'] = $articleList;
			}
		}

		return $data;
	}

	// truncate article list
	public static function truncateArticleList( $articles, $limit = 2 ) {
		$isTruncated = 0;
		$truncatedList = array();
		if( !empty( $articles ) ) {
			foreach( $articles as $article ) {
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
			if( $force16x9Ratio ) {
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
	public static function  getVideoThumbnailHtml( Title $title, $width=150, $height=75, $force16x9Ratio=false ) {
		$arr = [];
		self::inflateArrayWithVideoData( $arr, $title, $width, $height, $force16x9Ratio );
		if( !empty($arr['thumbnail']) ) {
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
		$width .= ($height ? '' : 'px');

		// URL points to a thumbnail, remove crop and size
		//The URL of a thumbnail is in the following format:
		//http://domain/image_path/image.ext/thumbnail_options.ext
		//so return the URL till the last / to remove the options
		$thumbUrl = substr($thumbUrl, 0, strripos($thumbUrl, '/'));

		$tokens = explode('/', $thumbUrl);
		$last = $tokens[count($tokens)-1];
		$tokens[] = $width . ($height ? 'x' . $height : '-') . ( ($type == 'video' || $type == 'nocrop') ? '-' : 'x2-' ) . $last . '.png';

		return implode('/', $tokens);
	}

	// format duration from second to h:m:s
	public static function formatDuration( $sec ) {
		$hms = "";
		$hours = intval(intval($sec) / 3600);
		if ($hours > 0) {
			$hms .= str_pad($hours, 2, "0", STR_PAD_LEFT). ":";
		}

		$minutes = intval(($sec / 60) % 60);
		$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

		$seconds = intval($sec % 60);
		$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

		return $hms;
	}

	/**
	 * Get the duration in ISO 8601 format for meta tag
	 * @param $hms
	 * @return string
	 */
	public static function getISO8601Duration( $hms ) {
		if ( !empty($hms) ) {
			$segments = explode(':', $hms);
			$ret = "PT";
			if(count($segments) == 3) {
				$ret .= array_shift($segments) . 'H';
			}
			$ret .= array_shift($segments) . 'M';
			$ret .= array_shift($segments) . 'S';

			return $ret;
		}
		return '';
	}

	public static function getVideosCategory() {
		$cat = F::app()->wg->ContLang->getFormattedNsText( NS_CATEGORY );
		return ucfirst($cat) . ':' . wfMsgForContent( 'videohandler-category' );
	}

	/**
	 * get file from title
	 * @param Title|string $title
	 * @return File|null $file
	 */
	public static function getFileFromTitle( &$title ) {
		if ( is_string( $title ) ) {
			$title = Title::newFromText( $title, NS_FILE );
		}

		if ( $title instanceof Title ) {
			$file = wfFindFile( $title );
			if ( $file instanceof File && $file->exists() ) {
				return $file;
			}
		}

		return null;
	}

	/**
	 * get video file from title
	 * @param Title|string $title
	 * @return File|null $file
	 */
	public static function getVideoFileFromTitle( &$title ) {
		$file = self::getFileFromTitle( $title );
		if ( !empty( $file ) && self::isFileTypeVideo( $file ) ) {
			return $file;
		}

		return null;
	}

}
