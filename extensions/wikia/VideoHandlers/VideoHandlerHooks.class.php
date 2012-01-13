<?php
class VideoHandlerHooks extends WikiaObject{

	function __construct(){
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}

	/**
	 * returns VideoPage if file is video
	 */
	public function onArticleFromTitle( &$oTitle, &$oArticle ){

		if ( ( $oTitle instanceof Title ) && ( $oTitle->getNamespace() == NS_FILE ) ){
			$oFile = wfFindFile( $oTitle );
			if ( ( $oFile instanceof WikiaLocalFile ) && ( $oFile->isVideo() ) ){
				$oArticle = new WikiaVideoPage( $oTitle );
			}
		}

		return true;
	}

	/*
	 * Preserves video mime types. Needed to fix MW 1.16 bug
	 */
	public function onFileRevertFormBeforeUpload( $oFile, $oOldFile ){

		if ( $oOldFile->isVideo() ){
			$oFile->forceMime( $oOldFile->mime );
			$oFile->setVideoId( $oOldFile->getVideoId() );
		}
		return true;
	}
}
