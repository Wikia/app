<?php

class VideoHandlersUploader {
	
	protected static $ILLEGAL_TITLE_CHARS = array( '/', ':', '#', '?' );
	protected static $IMAGE_NAME_MAX_LENGTH = 255;
	
	const SANITIZE_MODE_FILENAME = 1;
	const SANITIZE_MODE_ARTICLETITLE = 2;
	
	/**
	 * Create a video using LocalFile framework
	 * @param string $provider provider whose API will be used to fetch video data
	 * @param string $videoId id of video, assigned by provider
	 * @param Title $title Title object stemming from name of video
	 * @param string $description description of video
	 * @param boolean $undercover upload a video without creating the associated article
	 * @return FileRepoStatus On success, the value member contains the
	 *     archive name, or an empty string if it was a new file. 
	 */
	public static function uploadVideo($provider, $videoId, &$title, $description=null, $undercover=false) {
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
		$title = Title::newFromText( $titleText, NS_FILE );

		$file = F::build( !empty( $undercover ) ? 'WikiaNoArticleLocalFile' : 'WikiaLocalFile',
				array(
					$title,
					RepoGroup::singleton()->getLocalRepo()
				)
			);

		/* override thumbnail metadata with video metadata */
		$file->forceMime( 'video/'.$provider );
		$file->setVideoId( $videoId );  
		
		if (empty($description)) {
			$description = '[[Category:Video]]'.$apiWrapper->getDescription();
		}
		
		/* real upload */
		$result = $file->upload(
				$upload->getTempPath(),
				'created video',
				$description,
				File::DELETE_SOURCE
			);
		
		return $result;		
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