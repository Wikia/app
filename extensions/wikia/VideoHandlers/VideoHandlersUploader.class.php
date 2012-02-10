<?php

class VideoHandlersUploader {
	
	protected static $ILLEGAL_TITLE_CHARS = array( '/', ':', '#' );
	protected static $IMAGE_NAME_MAX_LENGTH = 255;
	
	/**
	 * Create a video using LocalFile framework
	 * @param string $provider provider whose API will be used to fetch video data
	 * @param string $videoId id of video, assigned by provider
	 * @param Title $title Title object stemming from name of video
	 * @param string $videoName name of video and associated article
	 * @param string $description description of video
	 * @param boolean $undercover upload a video without creating the associated article
	 * @return FileRepoStatus On success, the value member contains the
	 *     archive name, or an empty string if it was a new file. 
	 */
	public static function uploadVideo($provider, $videoId, &$title, $videoName=null, $description=null, $undercover=false) {
		$apiWrapper = F::build( ucfirst( $provider ) . 'ApiWrapper', array( $videoId, array('videoName'=>$videoName) ) );

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

	public static function sanitizeTitle( $titleText, $replaceChar=' ' ) {

		// We need more strict sanitizing because the commented code below 
		// isn't clearing all illegal characters for files. 
		// So we decided to remove all characters that are not alphanumeric.
		
		$sanitized = preg_replace('/[^[:alnum:]]{1,}/', $replaceChar, $titleText);

		return trim($sanitized);
		
		/*

		$titleText = preg_replace(Title::getTitleInvalidRegex(), $replaceChar, $titleText);
		
		foreach (self::$ILLEGAL_TITLE_CHARS as $illegalChar) {
			$titleText = str_replace( $illegalChar, $replaceChar, $titleText );
		}
		
		// remove multi _
		$aTitle = explode( $replaceChar, $titleText );
		$sTitle = implode ( $replaceChar, array_filter( $aTitle ) );	// array_filter() removes null elements

		$sTitle = substr($sTitle, 0, self::$IMAGE_NAME_MAX_LENGTH);	// DB column Image.img_name has size 255
		
		// this method is cruching if you use [, ] :
		//$title = Title::makeTitleSafe( NS_FILE, $sTitle );

		if ($replaceChar == ' ') {
			return $title->getText();
		}
		
		return $title->getDBkey();
		 
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