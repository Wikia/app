<?php

class VideoFileUploader {
	
	protected static $ILLEGAL_TITLE_CHARS = array( '/', ':', '#' );
	protected static $IMAGE_NAME_MAX_LENGTH = 255;
	
	const SANITIZE_MODE_FILENAME = 1;
	const SANITIZE_MODE_ARTICLETITLE = 2;
	const VIDEOS_CATEGORY = 'Videos';

	protected $sTargetTitle;
	protected $sDescription;
	protected $bUndercover;
	protected $aOverrideMetadata;
	protected $sExternalUrl;
	protected $sVideoId;
	protected $sProvider;
	protected $oApiWrapper;

	public function setTargetTitle( $sTitle ){			
		$this->sTargetTitle = $sTitle;
	}
	public function setDescription( $sDescription ){		$this->sDescription = $sDescription; }
	public function hideAction(){					$this->bUndercover = true; }
	public function overrideMetadata( $aMetadata = array() ){	$this->aOverrideMetadata = $aMetadata; }
	public function setExternalUrl ( $sUrl ){			$this->sExternalUrl = $sUrl; }
	public function setProvider( $sProvider ){			$this->sProvider = $sProvider; }
	public function setVideoId( $sVideoId ){			$this->sVideoId = $sVideoId; }

	public function setProviderFromId( $iProviderId ){
		$sProvider = ApiWrapperFactory::getInstance()->getProviderNameFromId( $iProviderId );
		if ( empty( $sProvider ) ) {
			throw new Exception( 'No provider name mapped to ' . $iProviderId );
		}
		$this->sProvider = $sProvider;
	}

	public function  __construct() {
		$this->sTargetTitle = '';
		$this->sDescription = '';
		$this->bUndercover = false;
		$this->aOverrideMetadata = array();
		$this->sExternalUrl = null;
		$this->sVideoId = '';
		$this->sProvider = '';
		$this->oApiWrapper = null;
	}

	public function upload( &$oTitle ){

		if( !$this->getApiWrapper() ) {
			/* can't upload without proper ApiWrapper */
			return;
		}

		/* prepare temporary file */
		$data = array(
			'wpUpload' => 1,
			'wpSourceType' => 'web',
			'wpUploadFileURL' => $this->getApiWrapper()->getThumbnailUrl()
		);

		$upload = F::build( 'UploadFromUrl' );
		$upload->initializeFromRequest( F::build( 'FauxRequest', array( $data, true ) ) );
		$upload->fetchFile();
		$upload->verifyUpload();

		$this->adjustThumbnailToVideoRatio( $upload );

		/* create a reference to article that will contain uploaded file */
		$titleText = self::sanitizeTitle( $this->getDestinationTitle() );
		$oTitle = Title::newFromText( $titleText, NS_FILE );

		$file = F::build( !empty( $this->bUndercover ) ? 'WikiaNoArticleLocalFile' : 'WikiaLocalFile',
				array(
					$oTitle,
					RepoGroup::singleton()->getLocalRepo()
				)
			);

		/* override thumbnail metadata with video metadata */
		$file->forceMime( $this->getApiWrapper()->getMimeType() );
		$file->setVideoId( $this->getVideoId() );

		/* real upload */
		$result = $file->upload(
				$upload->getTempPath(),
				'created video',
				$this->getDescription(),
				File::DELETE_SOURCE
			);

		return $result;
	}

	protected function adjustThumbnailToVideoRatio( $upload ){

		$data = file_get_contents( $upload->getTempPath() );
		$src = imagecreatefromstring( $data );

		$orgWidth = $upload->mFileProps['width'];
		$orgHeight = $upload->mFileProps['height'];
		$finalWidth = $upload->mFileProps['width'];
		$finalHeight = $finalWidth / $this->getApiWrapper()->getAspectRatio();

		$dest = imagecreatetruecolor ( $finalWidth, $finalHeight );
		imagecopy( $dest, $src, 0, 0, 0, ( $orgHeight - $finalHeight ) / 2 , $finalWidth, $finalHeight );

		$sTmpPath = $upload->getTempPath();
		switch ( $upload->mFileProps['minor_mime'] ) {
			case 'jpeg':	imagejpeg( $dest, $sTmpPath ); break;
			case 'gif':	imagegif ( $dest, $sTmpPath ); break;
			case 'png':	imagepng ( $dest, $sTmpPath ); break;
		}

		imagedestroy( $src );
		imagedestroy( $dest );
		
	}

	protected function getApiWrapper(){

		if( !empty( $this->oApiWrapper ) ) return $this->oApiWrapper;

		if( !empty( $this->sExternalUrl ) ){
			$apiWF = ApiWrapperFactory::getInstance();
			$this->oApiWrapper = $apiWF->getApiWrapper( $this->sExternalUrl );

			if ( !empty( $this->oApiWrapper ) ) return $this->oApiWrapper;
		}

		if ( !empty($this->sProvider ) ) {
			$this->oApiWrapper = F::build(
				ucfirst( $this->sProvider ) . 'ApiWrapper',
				array(
					$this->sVideoId,
					$this->aOverrideMetadata
				)
			);
		}

		return $this->oApiWrapper;
	}

	protected function getDestinationTitle(){

		if ( empty( $this->sTargetTitle ) ) {
			$this->sTargetTitle = $this->getApiWrapper()->getTitle();
		}

		return $this->sTargetTitle;
	}

	protected function getDescription(){
		if ( empty( $this->sDescription ) ) {
			$this->sDescription = '[[Category:'.self::VIDEOS_CATEGORY.']]'.$this->getApiWrapper()->getDescription();
		}
		
		return $this->sDescription;
	}
	
	public function getVideoId(){
		if ( empty( $this->sVideoId ) ) {
			$this->sVideoId = $this->getApiWrapper()->getVideoId();
		}

		return $this->sVideoId;
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
	public static function uploadVideo( $provider, $videoId, &$title, $description=null, $undercover=false, $overrideMetadata=array()) {

		$oUploader = new self();
		$oUploader->setProvider( $provider );
		$oUploader->setVideoId( $videoId );
		$oUploader->setDescription( $description );
		if( !empty( $undercover ) ) $oUploader->hideAction();
		$oUploader->overrideMetadata( $overrideMetadata );

		return $oUploader->upload( $title );

	}

	/**
	 * Translate URL to Title object
	 * can transparently upload new video if it doesn't exist
	 * @param $requestedTitle if new Video will be created you can optionally request
	 *  it's title (otherwise Video name from provider is used)
	 */
	public static function URLtoTitle( $url, $sTitle = '' ) {

		$oTitle = null;
		$oUploader = new self();
		$oUploader->setExternalUrl( $url );
		$oUploader->setTargetTitle( $sTitle );
		if ( $oUploader->upload( $oTitle ) ) {
			return $oTitle;
		}
		return null;
	}

	/**
	 * Sanitize text for use as filename and article title
	 * @param string $titleText title to sanitize
	 * @param string $replaceChar character to replace illegal characters with
	 * @return string sanitized title 
	 */
	public static function sanitizeTitle( $titleText, $replaceChar=' ' ) {

		/*
		 * OK, guys. I talked to Eloy, and he said that all characters that
		 * are correct for Title should be also correct for Files (!) 
		 * this means that if we fail to create thumbnail for some invalid
		 * titles, we should delegate this problem to ops. 
		 * 
		 */
		
		foreach (self::$ILLEGAL_TITLE_CHARS as $illegalChar) {
			$titleText = str_replace( $illegalChar, $replaceChar, $titleText );
		}
		
		$titleText = preg_replace(Title::getTitleInvalidRegex(), $replaceChar, $titleText);
		
		// remove multiple spaces
		$aTitle = explode( $replaceChar, $titleText );
		$sTitle = implode( $replaceChar, array_filter( $aTitle ) );    // array_filter() removes null elements

		$sTitle = substr($sTitle, 0, self::$IMAGE_NAME_MAX_LENGTH);     // DB column Image.img_name has size 255
		
		return trim($sTitle);
		
		/*
		// remove all characters that are not alphanumeric.
		$sanitized = preg_replace( '/[^[:alnum:]]{1,}/', $replaceChar, $titleText );
		
		return $sanitized;
		*/
	}
	
	public static function hasForbiddenCharacters( $text ) {
		foreach (self::$ILLEGAL_TITLE_CHARS as $illegalChar) {
			if (strpos($text, $illegalChar) !== FALSE) {
				return true;
			}
		}
		
		return false;
	}
}
