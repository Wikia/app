<?php

class VideoHandlersUploader {
	
	protected static $ILLEGAL_TITLE_CHARS = array( '/', ':', '#' );
	
	public static function uploadVideo($provider, $videoId, $undercover=false, &$title) {
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
		
		return $result;		
	}

	public static function sanitizeTitle( $titleText, $replaceChar=' ' ) {
		foreach (self::$ILLEGAL_TITLE_CHARS as $illegalChar) {
			$titleText = str_replace( $illegalChar, $replaceChar, $titleText );
		}
		// remove multi _
		$aTitle = explode( $replaceChar, $titleText );
		$sTitle = implode ( $replaceChar, array_filter( $aTitle ) );	// array_filter() removes null elements
		$title = Title::makeTitleSafe( NS_FILE, $sTitle );
		
		if ($replaceChar == ' ') {
			return $title->getText();
		}
		
		return $title->getDBkey();
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