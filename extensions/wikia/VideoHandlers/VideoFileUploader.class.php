<?php

/**
 * Class VideoFileUploader
 */
class VideoFileUploader {
	
	protected static $ILLEGAL_TITLE_CHARS = array( '/', ':', '#' );
	protected static $IMAGE_NAME_MAX_LENGTH = 255;
	
	const SANITIZE_MODE_FILENAME = 1;
	const SANITIZE_MODE_ARTICLETITLE = 2;

	protected $sTargetTitle;
	protected $sDescription;
	protected $bUndercover;
	protected $aOverrideMetadata;
	protected $sExternalUrl;
	protected $sVideoId;
	protected $sProvider;
	protected $oApiWrapper;

	public function setTargetTitle( $sTitle ) {			
		$this->sTargetTitle = $sTitle;
	}
	public function setDescription( $sDescription )          { $this->sDescription = $sDescription; }
	public function hideAction( )                            { $this->bUndercover = true; }
	public function overrideMetadata( $aMetadata = array() ) { $this->aOverrideMetadata = $aMetadata; }
	public function setExternalUrl( $sUrl )                  { $this->sExternalUrl = $sUrl; }
	public function setProvider( $sProvider )                { $this->sProvider = $sProvider; }
	public function setVideoId( $sVideoId )                  { $this->sVideoId = $sVideoId; }

	public function setProviderFromId( $iProviderId ) {
		wfProfileIn( __METHOD__ );
		$sProvider = ApiWrapperFactory::getInstance()->getProviderNameFromId( $iProviderId );
		if ( empty( $sProvider ) ) {
			wfProfileOut( __METHOD__ );
			throw new Exception( 'No provider name mapped to ' . $iProviderId );
		}
		wfProfileOut( __METHOD__ );
		$this->sProvider = $sProvider;
	}

	public function __construct( ) {
		$this->sTargetTitle = '';
		$this->sDescription = '';
		$this->bUndercover = false;
		$this->aOverrideMetadata = array();
		$this->sExternalUrl = null;
		$this->sVideoId = '';
		$this->sProvider = '';
		$this->oApiWrapper = null;
	}

	protected function tmpUpload( $urlFrom ) {
		wfProfileIn( __METHOD__ );
		$data = array(
			'wpUpload' => 1,
			'wpSourceType' => 'web',
			'wpUploadFileURL' => $urlFrom
		);

		$upload = (new UploadFromUrl); /* @var $upload UploadFromUrl */
		$upload->initializeFromRequest( new FauxRequest( $data, true ) );
		wfProfileOut( __METHOD__ );
		return $upload;
	}

	/**
	 * Start the upload.  Note that this method always returns an object, even when it fails.
	 * Make sure to check that the return value with:
	 *
	 *   $status->isOK()
	 *
	 * @param $oTitle - A title object that will be set if this call is successful
	 * @return FileRepoStatus|Status - A status object representing the result of this call
	 */
	public function upload( &$oTitle ) {

		wfProfileIn(__METHOD__);

		// The getApiWrapper method makes an HTTP request which can result
		// in some thrown exceptions
		$wrapper = null;
		try {
			$wrapper = $this->getApiWrapper();
		} catch ( Exception $e ) {
			// If we get an error here, just print it and let the following
			// code return a Status::newFatal
			Wikia::Log(__METHOD__, false, $e->getMessage());
		}

		if ( !$wrapper ) {
			/* can't upload without proper ApiWrapper */
			wfProfileOut(__METHOD__);
			return Status::newFatal("Can't get ApiWrapper");
		}

		$retries = 3;

		for ( $i = 0; $i < $retries; $i++ ) {
			if ( $i > 0 ) sleep( 3 );
			/* prepare temporary file */
			$upload = $this->tmpUpload( $this->getApiWrapper()->getThumbnailUrl() );
			$fetchStatus = $upload->fetchFile();
			if ( $fetchStatus->isGood() ) {
				$status = $upload->verifyUpload();
				if ( isset( $status['status'] ) && ( $status['status'] != UploadBase::EMPTY_FILE ) ) {
					break;
				}
			}
		}

		if ( $i == $retries ) {
			for ( $i = 0; $i < $retries; $i++ ) {
				if ( $i > 0 ) sleep( 3 );
				/* prepare temporary file with default thumbnail */
				$upload = $this->tmpUpload( LegacyVideoApiWrapper::$THUMBNAIL_URL );
				$fetchStatus = $upload->fetchFile();
				if ( $fetchStatus->isGood() ) {
					break;
				}
			}

			if ( $i == $retries ) {
				wfProfileOut(__METHOD__);
				return Status::newFatal('');
			}

			$status = $upload->verifyUpload();
			if ( isset( $status['status'] ) && ( $status['status'] == UploadBase::EMPTY_FILE ) ) {
				wfProfileOut(__METHOD__);
				return Status::newFatal('');
			};
		}

		$this->adjustThumbnailToVideoRatio( $upload );

		/* create a reference to article that will contain uploaded file */
		$titleText =  $this->getDestinationTitle();
		if ( !($this->getApiWrapper()->isIngestion() ) ) {
			// only sanitize name for external uploads
			// video ingestion handles sanitization by itself
			$titleText = self::sanitizeTitle( $titleText );
		}
		$oTitle = Title::newFromText( $titleText, NS_FILE );

		if ( $oTitle->exists() ) {
			// @TODO
			// if video already exists make sure that we are in fact changing something
			// before generating upload (for now this only works for edits)
			$article = Article::newFromID( $oTitle->getArticleID() );
			$content = $article->getContent();
			$newcontent = $this->getDescription();
			if ( $content != $newcontent ) {
				$article->doEdit( $newcontent, 'update' );
			}
		}

		$class = !empty( $this->bUndercover ) ? 'WikiaNoArticleLocalFile' : 'WikiaLocalFile';
		$file = new $class(
				$oTitle,
				RepoGroup::singleton()->getLocalRepo()
		);

		/* override thumbnail metadata with video metadata */
		$file->forceMime( $this->getApiWrapper()->getMimeType() );
		$file->setVideoId( $this->getVideoId() );

		/* ingestion video won't be able to load anything so we need to spoon feed it the correct data */
		if ( $this->getApiWrapper()->isIngestion() ) {
			$meta = $this->getApiWrapper()->getNonemptyMetadata();
			$file->forceMetadata( serialize($meta) );
		}

		/* real upload */
		$result = $file->upload(
			$upload->getTempPath(),
			wfMsgForContent( 'videos-initial-upload-edit-summary' ),
			$this->getDescription(),
			File::DELETE_SOURCE
		);

		wfRunHooks('AfterVideoFileUploaderUpload', array($file, $result));

		wfProfileOut(__METHOD__);
		return $result;
	}

	protected function adjustThumbnailToVideoRatio( $upload ) {

		wfProfileIn( __METHOD__ );
		
		$sTmpPath = $upload->getTempPath();
		
		$props = getimagesize( $sTmpPath );
		$orgWidth = $props[0];
		$orgHeight = $props[1];
		$finalWidth = $props[0];
		$finalHeight = $finalWidth / $this->getApiWrapper()->getAspectRatio();
		
		if ( $orgHeight == $finalHeight ) {
			// no need to resize, we're lucky :)
			wfProfileOut( __METHOD__ );
			return;
		}
		
		$data = file_get_contents( $sTmpPath );
		$src = imagecreatefromstring( $data );

		$dest = imagecreatetruecolor ( $finalWidth, $finalHeight );
		imagecopy( $dest, $src, 0, 0, 0, ( $orgHeight - $finalHeight ) / 2 , $finalWidth, $finalHeight );

		
		switch ( $props[2] ) {
			case 2:	imagejpeg( $dest, $sTmpPath ); break;
			case 1:	imagegif ( $dest, $sTmpPath ); break;
			case 3:	imagepng ( $dest, $sTmpPath ); break;
		}
		imagedestroy( $src );
		imagedestroy( $dest );
		wfProfileOut( __METHOD__ );
		
	}

	protected function getApiWrapper( ) {
		wfProfileIn( __METHOD__ );
		if ( !empty( $this->oApiWrapper ) ) {
			wfProfileOut( __METHOD__ );
			return $this->oApiWrapper;
		}

		if ( !empty( $this->sExternalUrl ) ) {
			$apiWF = ApiWrapperFactory::getInstance();
			$this->oApiWrapper = $apiWF->getApiWrapper( $this->sExternalUrl );

			if ( !empty( $this->oApiWrapper ) ) {
				wfProfileOut( __METHOD__ );
				return $this->oApiWrapper;
			}
		}

		if ( !empty($this->sProvider ) ) {
			if ( strstr( $this->sProvider, '/' ) ) {
				$provider = explode( '/', $this->sProvider );
				$apiWrapperPrefix = $provider[0];
			} else {
				$apiWrapperPrefix = $this->sProvider;
			}

			$class = ucfirst( $apiWrapperPrefix ) . 'ApiWrapper';
			$this->oApiWrapper = new $class(
					$this->sVideoId,
					$this->aOverrideMetadata
			);
		}
		wfProfileOut( __METHOD__ );
		return $this->oApiWrapper;
	}

	protected function getDestinationTitle( ) {

		if ( empty( $this->sTargetTitle ) ) {
			$this->sTargetTitle = $this->getApiWrapper()->getTitle();
		}

		return $this->sTargetTitle;
	}

	protected function getDescription( ) {

		wfProfileIn( __METHOD__ );
		if ( empty( $this->sDescription ) ) {
			$headerText = wfMessage( 'videohandler-description' );
			$this->sDescription = "\n== $headerText ==\n" .
								  $this->getApiWrapper()->getDescription() . "\n" .
								  $this->getCategoryVideosWikitext();
		}
		wfProfileOut( __METHOD__ );

		return $this->sDescription;
	}
	
	/**
	 * gets wiki text for the "Videos" category. For example, on English
	 * wikis: [[Category:Videos]]. i18n-compatible
	 * @return string
	 */
	public function getCategoryVideosWikitext( ) {
		$cat = F::app()->wg->ContLang->getFormattedNsText( NS_CATEGORY );
		return '[[' . $cat . ':' . wfMessage( 'videohandler-category' )->inContentLanguage()->text() . ']]';
	}
	
	public function getVideoId( ) {
		wfProfileIn( __METHOD__ );
		if ( empty( $this->sVideoId ) ) {
			$this->sVideoId = $this->getApiWrapper()->getVideoId();
		}
		wfProfileOut( __METHOD__ );
		return $this->sVideoId;
	}

	/**
	 * Generates unique Title for new video
	 * The function checks if given title exists and if so, it's adding a postfix
	 * @param string $title
	 * @param int $level
	 * @return Title $oTitle
	 */
	public function getUniqueTitle( $title, $level=0 ) {

		$numRetry = 3;

		$oTitle = Title::newFromText( $title, NS_FILE );

		if ( !empty( $oTitle ) && $oTitle->exists() ) {

			for ( $r = 0; $r <= $numRetry; $r++ ) {
				$newTitleText = $oTitle->getBaseText() . '-' . $r;
				$newTitleObject = Title::newFromText( $newTitleText, NS_FILE );
				if ( !empty( $newTitleObject ) && $newTitleObject->exists() ) {

					if ( $r == $numRetry ) { // stop checking and fallback to timestamp
						$newTitleText = $oTitle->getBaseText() . '-' . time();
						$newTitleObject = Title::newFromText( $newTitleText, NS_FILE );
					}
					continue;

				} else {
					break;
				}
			}

			return $newTitleObject;
		}
		return $oTitle;
	}


	/**
	 * Create a video using LocalFile framework
	 * @param string $provider provider whose API will be used to fetch video data
	 * @param string $videoId id of video, assigned by provider
	 * @param Title $title Title object stemming from name of video
	 * @param string $description description of video
	 * @param boolean $undercover upload a video without creating the associated article
	 * @param array $overrideMetadata one or more metadata fields that override API response
	 * @return FileRepoStatus On success, the value member contains the
	 *     archive name, or an empty string if it was a new file. 
	 */
	public static function uploadVideo( $provider, $videoId, &$title, $description=null, $undercover=false, $overrideMetadata=array() ) {

		wfProfileIn( __METHOD__ );
		$oUploader = new self();
		$oUploader->setProvider( $provider );
		$oUploader->setVideoId( $videoId );
		$oUploader->setDescription( $description );
		if ( !empty( $undercover ) ) $oUploader->hideAction();
		$oUploader->overrideMetadata( $overrideMetadata );

		$r = $oUploader->upload( $title );
		wfProfileOut( __METHOD__ );
		return $r;

	}

	/**
	 * Translate URL to Title object.  Can transparently upload new video if it doesn't exist
	 * @param string $url
	 * @param string $sTitle - if $requestedTitle new Video will be created you can optionally request
	 *  it's title (otherwise Video name from provider is used)
	 * @param string $sDescription
	 * @return null|Title
	 */
	public static function URLtoTitle( $url, $sTitle = '', $sDescription = '' ) {

		wfProfileIn( __METHOD__ );
		$oTitle = null;
		$oUploader = new self();
		$oUploader->setExternalUrl( $url );
		$oUploader->setTargetTitle( $sTitle );
		if ( !empty($sDescription) ) {
			$categoryVideosTxt = self::getCategoryVideosWikitext();
			if ( strpos( $sDescription, $categoryVideosTxt ) === false ) {
				$sDescription .= $categoryVideosTxt;
			}
			$oUploader->setDescription( $sDescription );
		}

		$status = $oUploader->upload( $oTitle );
		if ( $status->isOK() ) {
			wfProfileOut( __METHOD__ );
			return $oTitle;
		}
		wfProfileOut( __METHOD__ );
		return null;
	}

	/**
	 * Sanitize text for use as filename and article title
	 * @param string $titleText title to sanitize
	 * @param string $replaceChar character to replace illegal characters with
	 * @return string sanitized title 
	 */
	public static function sanitizeTitle( $titleText, $replaceChar=' ' ) {

		wfProfileIn( __METHOD__ );
		
		foreach ( self::$ILLEGAL_TITLE_CHARS as $illegalChar ) {
			$titleText = str_replace( $illegalChar, $replaceChar, $titleText );
		}
		
		$titleText = preg_replace(Title::getTitleInvalidRegex(), $replaceChar, $titleText);
		
		// remove multiple spaces
		$aTitle = explode( $replaceChar, $titleText );
		$sTitle = implode( $replaceChar, array_filter( $aTitle ) );    // array_filter() removes null elements

		$sTitle = substr($sTitle, 0, self::$IMAGE_NAME_MAX_LENGTH);     // DB column Image.img_name has size 255

		wfProfileOut( __METHOD__ );

		return trim($sTitle);
		
		/*
		// remove all characters that are not alphanumeric.
		$sanitized = preg_replace( '/[^[:alnum:]]{1,}/', $replaceChar, $titleText );
		
		return $sanitized;
		*/
	}
	
	public static function hasForbiddenCharacters( $text ) {
		foreach ( self::$ILLEGAL_TITLE_CHARS as $illegalChar ) {
			if ( strpos($text, $illegalChar) !== FALSE ) {
				return true;
			}
		}
		
		return false;
	}
}
