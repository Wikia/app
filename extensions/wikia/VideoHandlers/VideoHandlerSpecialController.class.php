<?php

/**
 * @author Jakub
 */
class VideoHandlerSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'VideoHandler' );
	}

	public function index() {

		if ( $this->wg->user->isBlocked() ) {
			$this->wg->out->blockedPage();
			return false;	// skip rendering
		}
		if ( !$this->wg->user->isAllowed( 'specialvideohandler' ) ) {
			$this->displayRestrictionError();
			return false;
		}
		if ( wfReadOnly() && !wfAutomaticReadOnly() ) {
			$this->wg->out->readOnlyPage();
			return false;
		}

		$videoId = $this->getVal( 'videoid', null );
		$provider = strtolower( $this->getVal( 'provider', null ) );
		$undercover = $this->getVal( 'undercover', false );
		
		if ( $videoId && $provider ) {
			$apiWrapper = F::build( ucfirst( $provider ) . 'ApiWrapper', array( $videoId ) );

			/* prepare temporary file */
			$url = $apiWrapper->getThumbnailUrl();
			$data = array(
				'wpUpload' => 1,
				'wpSourceType' => 'web',
				'wpUploadFileURL' => $url
			);
			$upload = F::build( 'UploadFromUrl' );
			$upload->initializeFromRequest( F::build( 'FauxRequest', array( $data, true ) ) );
			$upload->fetchFile();
			$upload->verifyUpload();

			/* create a reference to article that will contain uploaded file */
			$titleText = self::sanitizeTitle( $apiWrapper->getTitle() );
			$title = Title::makeTitleSafe( NS_FILE, $titleText );
            
			$file = F::build( !empty( $undercover ) ? 'WikiaNoArticleLocalFile' : 'WikiaLocalFile',
					array(
						$title,
						RepoGroup::singleton()->getLocalRepo()
					)
				);

			/* override thumbnail metadata with video metadata */
			$file->forceMime( 'video/'.$provider );
			$file->setVideoId( $videoId );      

			/* real upload */
			$result = $file->upload(
					$upload->getTempPath(),
					'created video',
					'[[Category:New Video]]'.$apiWrapper->getDescription(),
					File::DELETE_SOURCE
				);
        
			$this->setVal( 'uploadStatus', $result->ok );
			$this->setVal( 'isNewFile', empty( $result->value ) );
			$this->setVal( 'title', $title->getText() );
			$this->setVal( 'url', $title->getFullURL() );
		}
	}
	
	protected static function sanitizeTitle( $titleText ) {
		//@todo titles that end with right paren somehow interfere with
		// file uploader. Figure out the bug so that we can use right
		// parens again
		$illegalChars = array( '/', '#', ':', '(', ')', '[', ']', '|', '"' );
		//$illegalChars = array( '/' );
		foreach ( $illegalChars as $char ) {
			$titleText = str_replace( $char, ' ', $titleText );
		}
		
		$titleText = str_replace( '  ', ' ', $titleText );

		return $titleText;		
	}
}